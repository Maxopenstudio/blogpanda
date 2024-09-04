<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package blogpanda
 */

get_header();
$view = get_post_meta(get_the_ID(), "view", true);
$view = $view ? intval($view) : 0;
$view++;
update_post_meta(get_the_ID(), "view", $view);
?>

    <main id="primary" class="site-main container">

        <?php
        while ( have_posts() ) :
            the_post();

            get_template_part( 'template-parts/content', 'page' );


        endwhile; // End of the loop.
        ?>

    </main><!-- #main -->

<?php

get_footer();
