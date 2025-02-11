<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package blogpanda
 */

?>

<footer id="colophon" class="site-footer">
    <div class="site-info container text-center py-4">
        <a href="<?php echo esc_url( __( 'https://wordpress.org/', 'blogpanda' ) ); ?>" class="footer-link">
            <?php
            /* translators: %s: CMS name, i.e. WordPress. */
            printf( esc_html__( 'Proudly powered by %s', 'blogpanda' ), 'WordPress' );
            ?>
        </a>
        <span class="sep mx-2">|</span>
        <?php
        /* translators: 1: Theme name, 2: Theme author. */
        printf( esc_html__( 'Theme: %1$s by %2$s.', 'blogpanda' ), 'blogpanda', '<a href="http://underscores.me/" class="footer-link">Underscores.me</a>' );
        ?>
    </div><!-- .site-info -->
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
