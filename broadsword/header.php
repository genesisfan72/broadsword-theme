<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Broadsword
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php
if ( ! function_exists( '_wp_render_title_tag' ) ) :
    function woc_broadsword_render_title() {
?>
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php
    }
add_action( 'wp_head', 'woc_broadsword_render_title' );
endif;
?>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class('cbp-spmenu-push'); ?>>

<nav class="cbp-spmenu cbp-spmenu-right cbp-spmenu-vertical" id="header_nav_menu">
    <h1 class="menu-title"><?php echo __( 'MENU', 'woc_broadsword' ); ?></h1>
    <?php
        wp_nav_menu( array(
                 'container' => '',
                 'depth' => 1,
                 'theme_location' => 'primary',
                 'link_before' => '<span>',
                 'link_after' => '</span>' )
        );

        // If we have a submenu to show we first need to insert a divider
        $menu_to_count = wp_nav_menu( array( 'theme_location' => 'secondary', 'echo' => 0, 'fallback_cb' => false ) );
        $menu_items = substr_count( $menu_to_count, '<li' );

        if ( $menu_items > 0 ) {

            echo '<span class="menu-divider"></span>';

            wp_nav_menu( array(
                     'container' => '',
                     'depth' => 1,
                     'theme_location' => 'secondary',
                     'link_before' => '<span>',
                     'link_after' => '</span>' )
            );
        }
    ?>
    <button type="button" class="nav-close"></button>
</nav>

<div id="page" class="hfeed site">

	<!-- open/close -->
	<div class="fullscreen-overlay overlay-hugeinc">
		<button type="button" id="featured-close" class="overlay-close">Close</button>
		<div class="overlay-content">
            <div class="content-container">
                <div class="page-content overlay-featured">
                    <?php
                        $featured_id = get_theme_mod( 'woc_featured_page' );
                        if ($featured_id) {
                            $featured_page = get_post( $featured_id );

                            if ( $featured_page )
                            {
                                echo apply_filters( 'the_content', '<h1 class="featured-title">' . $featured_page->post_title . '</h1>' );
                                echo apply_filters( 'the_content', $featured_page->post_content );
                            }
                        }
                    ?>
                </div>
            </div>
		</div>
	</div>

	<header id="masthead" class="hideme site-header cbp-spmenu-push" role="banner">
		<div class="about hidden-xs">
            <?php
                $featured_id = get_theme_mod( 'woc_featured_page' );
                if ($featured_id) {
                    $featured_page = get_post( $featured_id );

                    if ( isset( $featured_page ) ) {
                        $title = $featured_page->post_title;
            ?>
                    <a id="trigger-overlay-featured" href="#"><?php if ( $title ) echo $title; ?></a>
            <?php
                    }
                }
            ?>
	    </div>

	    <div class="logo">
            <a href="<?php echo esc_url( home_url() ); ?>"><img src="<?php echo get_theme_mod( 'woc_broadsword_logo', get_template_directory_uri() . '/assets/img/broadsword-logo.png' ); ?>" alt="<?php echo get_bloginfo( 'name' ) . ' - ' . get_bloginfo( 'description' ); ?>" /></a>
        </div>

        <div class="menu">
        	<a id="showRightPush" href="#"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/menu-icon.png" alt="<?php echo __( 'Menu', 'woc_broadsword' ); ?>"></a>
        </div>

	</header><!-- #masthead -->

	<div id="content" class="site-content" >
