<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package blogpanda
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('mb-4'); ?>>
    <header class="entry-header mb-4">
        <?php the_title( '<h1 class="entry-title display-4">', '</h1>' ); ?>
    </header><!-- .entry-header -->

    <?php if ( has_post_thumbnail() ) : ?>
        <div class="mb-4">
            <?php blogpanda_post_thumbnail( 'large', array( 'class' => 'img-fluid rounded' ) ); ?>
        </div>
    <?php endif; ?>

    <div class="entry-content">
        <?php
        the_content();?>

    </div><!-- .entry-content -->


</article>
