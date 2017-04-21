<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Broadsword
 */
?>

</div><!-- #content -->

<footer id="colophon" class="site-footer" role="contentinfo">
    <div class="site-info container">
        <div id="footer-widget-area" class="row col-sm-12">
            <div class="footer-widgets-1 col-sm-4">
                <?php dynamic_sidebar( 'footer-1' ); ?>
            </div>
            <div class="footer-widgets-2 col-sm-4">
                <?php dynamic_sidebar( 'footer-2' ); ?>
            </div>
            <div class="footer-widgets-3 col-sm-4">
                <?php dynamic_sidebar( 'footer-3' ); ?>
            </div>
        </div>
        <!-- footer-widget-area ends -->
        <div class="copyright row col-sm-12">
            <?php
            if ( get_theme_mod( 'woc_show_copyright', 1 ) == 1 ) {
                printf( __( 'Copyright %1$s.', 'woc_broadsword' ), date( 'Y' ) );
            }

            echo get_theme_mod( 'woc_footer_text', sprintf( __( ' Built by yours truly, %1s', 'woc_broadsword' ), '<a href="' . esc_url( 'http://www.warriorsofcode.com' ) . '">The Warriors.</a>' ) );
            ?>
        </div>
    </div>
    <!-- .site-info -->
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
