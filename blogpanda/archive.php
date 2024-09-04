<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package blogpanda
 */

get_header();
?>

    <main id="primary" class="site-main container my-5">
<div class="row">
        <?php if ( have_posts() ) : ?>

            <header class="page-header mb-4">
                <?php
                the_archive_title( '<h1 class="page-title">', '</h1>' );
                the_archive_description( '<div class="archive-description lead">', '</div>' );
                ?>
            </header><!-- .page-header -->

            <div class="row">
                <?php
                /* Start the Loop */
                while ( have_posts() ) :
                    the_post();
                    ?>
                    <div class="col-md-4 mb-4">
                        <?php
                        /*
                         * Include the Post-Type-specific template for the content.
                         * If you want to override this in a child theme, then include a file
                         * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                         */
                        get_template_part( 'template-parts/content', get_post_type() );
                        ?>
                    </div>
                <?php
                endwhile;
                ?>
            </div> <!-- .row -->


        <?php endif; ?>
</div>
    </main><!-- #main -->

<?php
get_footer();
