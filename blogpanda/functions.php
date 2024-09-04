<?php
/**
 * blogpanda functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package blogpanda
 */

if (!defined('_S_VERSION')) {
    // Replace the version number of the theme on each release.
    define('_S_VERSION', '1.0.2');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function blogpanda_setup()
{
    /*
        * Make theme available for translation.
        * Translations can be filed in the /languages/ directory.
        * If you're building a theme based on blogpanda, use a find and replace
        * to change 'blogpanda' to the name of your theme in all the template files.
        */
    load_theme_textdomain('blogpanda', get_template_directory() . '/languages');

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    /*
        * Let WordPress manage the document title.
        * By adding theme support, we declare that this theme does not use a
        * hard-coded <title> tag in the document head, and expect WordPress to
        * provide it for us.
        */
    add_theme_support('title-tag');

    /*
        * Enable support for Post Thumbnails on posts and pages.
        *
        * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
        */
    add_theme_support('post-thumbnails');

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus(
        array(
            'menu-1' => esc_html__('Primary', 'blogpanda'),
        )
    );

    /*
        * Switch default core markup for search form, comment form, and comments
        * to output valid HTML5.
        */
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );

    // Set up the WordPress core custom background feature.
    add_theme_support(
        'custom-background',
        apply_filters(
            'blogpanda_custom_background_args',
            array(
                'default-color' => 'ffffff',
                'default-image' => '',
            )
        )
    );

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Add support for core custom logo.
     *
     * @link https://codex.wordpress.org/Theme_Logo
     */
    add_theme_support(
        'custom-logo',
        array(
            'height' => 250,
            'width' => 250,
            'flex-width' => true,
            'flex-height' => true,
        )
    );
}

add_action('after_setup_theme', 'blogpanda_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function blogpanda_content_width()
{
    $GLOBALS['content_width'] = apply_filters('blogpanda_content_width', 640);
}

add_action('after_setup_theme', 'blogpanda_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function blogpanda_widgets_init()
{
    register_sidebar(
        array(
            'name' => esc_html__('Sidebar', 'blogpanda'),
            'id' => 'sidebar-1',
            'description' => esc_html__('Add widgets here.', 'blogpanda'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        )
    );
}

add_action('widgets_init', 'blogpanda_widgets_init');

/**
 * Enqueue scripts and styles.
 */


function blogpanda_scripts()
{
    wp_enqueue_style('blogpanda-style', get_stylesheet_uri(), array(), _S_VERSION);
    wp_enqueue_style('blogpanda-bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css', array(), _S_VERSION);
    wp_style_add_data('blogpanda-style', 'rtl', 'replace');

    wp_enqueue_script('blogpanda-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);
    wp_enqueue_script('blogpanda-boostrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', array(), _S_VERSION, true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

add_action('wp_enqueue_scripts', 'blogpanda_scripts');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
    require get_template_directory() . '/inc/jetpack.php';
}

function enqueue_jquery_script()
{
    wp_enqueue_script('jquery');
}

add_action('wp_enqueue_scripts', 'enqueue_jquery_script');


// Добавляем поле "Логотип автора" в профиль пользователя
function add_author_logo_field($user)
{ ?>
    <h3><?php _e("Дополнительная информация", "blank"); ?></h3>
    <table class="form-table">
        <tr>
            <th><label for="author_logo"><?php _e("Логотип автора"); ?></label></th>
            <td>
                <input type="text" name="author_logo" id="author_logo"
                       value="<?php echo esc_attr(get_the_author_meta('author_logo', $user->ID)); ?>"
                       class="regular-text"/><br/>
                <span class="description"><?php _e("Пожалуйста, введите URL логотипа автора."); ?></span>
            </td>
        </tr>
    </table>
<?php }

add_action('show_user_profile', 'add_author_logo_field');
add_action('edit_user_profile', 'add_author_logo_field');

// Сохраняем значение мета-поля
function save_author_logo_field($user_id)
{
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }
    update_user_meta($user_id, 'author_logo', $_POST['author_logo']);
}

add_action('personal_options_update', 'save_author_logo_field');
add_action('edit_user_profile_update', 'save_author_logo_field');

function filter_posts()
{
    $tag_id = isset($_POST['tag_id']) ? intval($_POST['tag_id']) : '';

    // Параметры запроса
    $query_args = array(
        'posts_per_page' => 6, // Количество выводимых записей
        'post_status' => 'publish' // Только опубликованные записи
    );

    // Если передан тег, добавляем его в параметры запроса
    if ($tag_id) {
        $query_args['tag_id'] = $tag_id;
    }

    $query = new WP_Query($query_args);

    // Если записи найдены
    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            ?>
            <div class="col">
                <div class="card card-custom">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <img src="<?php the_post_thumbnail_url('large'); ?>" class="card-img-top"
                                 alt="<?php the_title(); ?>">
                        </a>
                    <?php else : ?>
                        <a href="<?php the_permalink(); ?>">
                            <img src="<?php echo get_template_directory_uri(); ?>/inc/assets/placeholder-image.jpeg"
                                 class="card-img-top" alt="<?php the_title(); ?>">
                        </a>
                    <?php endif; ?>

                    <div class="card-body">
                        <span class="badge bg-light text-dark"><?php echo get_the_date(); ?></span>
                        <h5 class="card-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h5>

                        <p class="card-text">
                            <?php echo mb_strimwidth(get_the_excerpt(), 0, 218, "..."); ?>
                        </p>
                    </div>
                    <div class="card-footer">
                        <div class="stats">

<span><svg width="18" height="12" viewBox="0 0 18 12" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M17.9265 6.34786C17.8997 6.40571 17.264 7.795 15.8598 9.17714C13.981 11.0236 11.613 12 9.00054 12C6.38806 12 4.02013 11.0236 2.1435 9.17714C0.739287 7.795 0.103582 6.40571 0.0745547 6.34786C0.0253915 6.23815 0 6.11955 0 5.99964C0 5.87973 0.0253915 5.76114 0.0745547 5.65143C0.101405 5.59286 0.73711 4.20429 2.14205 2.82214C4.02013 0.975714 6.38806 -9.53674e-07 9.00054 -9.53674e-07C11.613 -9.53674e-07 13.981 0.975714 15.8569 2.82214C17.2618 4.20429 17.8975 5.59286 17.9244 5.65143C17.9739 5.76099 17.9996 5.87951 18 5.99942C18.0004 6.11933 17.9753 6.238 17.9265 6.34786ZM14.584 3.99071C13.0259 2.48071 11.1479 1.71428 9.00054 1.71428C6.85323 1.71428 4.97514 2.48071 3.41926 3.99143C2.80703 4.58769 2.28039 5.26346 1.85395 6C2.28051 6.73624 2.80714 7.41176 3.41926 8.00786C4.97586 9.51929 6.85323 10.2857 9.00054 10.2857C11.1479 10.2857 13.0252 9.51929 14.5818 8.00786C15.194 7.41181 15.7206 6.73629 16.1471 6C15.7206 5.26351 15.194 4.58775 14.5818 3.99143L14.584 3.99071ZM9.00054 9.14286C8.36902 9.14286 7.75168 8.95853 7.22659 8.61319C6.70149 8.26785 6.29223 7.777 6.05056 7.20272C5.80889 6.62844 5.74566 5.99651 5.86886 5.38686C5.99206 4.7772 6.29617 4.2172 6.74272 3.77766C7.18928 3.33813 7.75822 3.0388 8.37761 2.91753C8.997 2.79626 9.63901 2.8585 10.2225 3.09638C10.8059 3.33425 11.3046 3.73708 11.6555 4.25392C12.0063 4.77076 12.1936 5.3784 12.1936 6C12.1926 6.83325 11.8559 7.6321 11.2573 8.22129C10.6587 8.81049 9.84709 9.14191 9.00054 9.14286ZM9.00054 4.57143C8.71349 4.57143 8.43288 4.65521 8.1942 4.81219C7.95552 4.96916 7.76949 5.19227 7.65964 5.45331C7.54979 5.71435 7.52105 6.00158 7.57705 6.2787C7.63305 6.55582 7.77128 6.81036 7.97426 7.01015C8.17724 7.20994 8.43585 7.346 8.71739 7.40112C8.99893 7.45624 9.29076 7.42795 9.55596 7.31983C9.82117 7.2117 10.0478 7.0286 10.2073 6.79367C10.3668 6.55874 10.4519 6.28254 10.4519 6C10.4519 5.62112 10.299 5.25776 10.0268 4.98985C9.75463 4.72194 9.38547 4.57143 9.00054 4.57143Z"
      fill="#B4B8C4"/>
</svg><span class="value">
                                    <?php

                                    $view = get_post_meta(get_the_ID(), "view", true);
                                    $view = !empty($view) ? $view : "0";
                                    echo $view;


                                    ?>
                                </span></span>

                            <span><svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                       xmlns="http://www.w3.org/2000/svg">
<path d="M8 16C3.5816 16 0 12.4184 0 8C0 3.5816 3.5816 0 8 0C12.4184 0 16 3.5816 16 8C16 12.4184 12.4184 16 8 16ZM8 14.4C9.69739 14.4 11.3253 13.7257 12.5255 12.5255C13.7257 11.3253 14.4 9.69739 14.4 8C14.4 6.30261 13.7257 4.67475 12.5255 3.47452C11.3253 2.27428 9.69739 1.6 8 1.6C6.30261 1.6 4.67475 2.27428 3.47452 3.47452C2.27428 4.67475 1.6 6.30261 1.6 8C1.6 9.69739 2.27428 11.3253 3.47452 12.5255C4.67475 13.7257 6.30261 14.4 8 14.4ZM8.8 8H12V9.6H7.2V4H8.8V8Z"
      fill="#B4B8C4"/>
</svg><span class="value">
                                <?php
                                $word_count = str_word_count(strip_tags(get_the_content()));
                                $reading_time = ceil($word_count / 200); // Среднее время чтения: 200 слов в минуту
                                echo $reading_time . ' хв.';
                                ?>
                            </span>
                            </span>
                        </div>
                        <div>
                            <?php
                            $author_logo = get_the_author_meta('author_logo', get_the_author_meta('ID'));
                            if ($author_logo) {
                                echo '<img src="' . esc_url($author_logo) . '" alt="' . get_the_author() . '" style="width: 30px; height: 30px; border-radius: 50%;">';
                            }
                            ?>
                            <span><?php the_author_nickname(); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        endwhile;
    else :
        echo '<p>Записей не найдено.</p>';
    endif;
    wp_reset_postdata();

    die(); // Прекращаем выполнение скрипта, чтобы вернуть результат AJAX
}

add_action('wp_ajax_filter_posts', 'filter_posts');
add_action('wp_ajax_nopriv_filter_posts', 'filter_posts');


function contact_form_shortcode()
{
    ob_start();
    ?>
    <form id="contactForm" method="post" class="contact-form">
        <div class="mb-3">
            <label for="userName" class="form-label">Имя</label>
            <input type="text" class="form-control" id="userName" name="userName" required>
        </div>
        <div class="mb-3">
            <label for="userEmail" class="form-label">Email</label>
            <input type="email" class="form-control" id="userEmail" name="userEmail" required>
        </div>
        <div class="mb-3">
            <label for="userMessage" class="form-label">Сообщение</label>
            <textarea class="form-control" id="userMessage" name="userMessage" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Отправить</button>
        <div id="formResponse" class="mt-3"></div>
    </form>

    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $('#contactForm').on('submit', function (e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    type: 'POST',
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    data: formData + '&action=submit_contact_form',
                    success: function (response) {
                        $('#formResponse').html(response);
                        $('#contactForm').fadeOut();
                    },
                    error: function () {
                        $('#formResponse').html('<div class="alert alert-danger">Произошла ошибка при отправке сообщения.</div>');
                    }
                });
            });
        });
    </script>
    <?php
    return ob_get_clean();
}

add_shortcode('contact_form', 'contact_form_shortcode');

function handle_contact_form_submission()
{
    if (isset($_POST['userName'], $_POST['userEmail'], $_POST['userMessage'])) {
        $user_name = sanitize_text_field($_POST['userName']);
        $user_email = sanitize_email($_POST['userEmail']);
        $message = wp_kses_post($_POST['userMessage']);

        // Применяем фильтр the_content к сообщению
        $filtered_message = apply_filters('the_content', $message);

        // Формируем текст письма
        $email_content = sprintf(
            "New application\nUser: %s <%s>\n\n%s",
            $user_name,
            $user_email,
            $filtered_message
        );

        // Отправка письма администратору
        $admin_email = get_option('admin_email');
        $subject = 'New Application';
        $headers = array('Content-Type: text/html; charset=UTF-8');

        $mail_sent = wp_mail($admin_email, $subject, nl2br($email_content), $headers);

        if ($mail_sent) {
            echo '<div class="alert alert-success">Сообщение отправлено.</div>';
        } else {
            echo '<div class="alert alert-danger">Ошибка при отправке сообщения. Попробуйте позже.</div>';
        }
    } else {
        echo '<div class="alert alert-danger">Пожалуйста, заполните все поля.</div>';
    }

    wp_die(); // Останавливаем выполнение скрипта
}

add_action('wp_ajax_submit_contact_form', 'handle_contact_form_submission');
add_action('wp_ajax_nopriv_submit_contact_form', 'handle_contact_form_submission');