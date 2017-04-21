<?php
/**
 * Broadsword functions and definitions
 *
 * @package Broadsword
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( !isset( $content_width ) ) {
    $content_width = 1140; /* pixels */
}

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once dirname( __FILE__ ) . '/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'woc_broadsword_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 */
function woc_broadsword_register_required_plugins() {

    $plugins = array(
        array(
            'name'     => 'WP Tiles',
            'slug'     => 'wp-tiles',
            'source'   => get_template_directory_uri() . '/assets/plugins/wp-tiles.zip',
            'required' => false,
        ),
        array(
            'name'     => 'Wordpress Retina 2x',
            'slug'     => 'wp-retina-2x',
            'required' => true,
        ),
        array(
            'name'     => 'Responsive Lightbox',
            'slug'     => 'responsive-lightbox',
            'required' => false,
        ),
    );

    $theme_text_domain = 'woc_broadsword';

    /**
     * Array of configuration settings. Uncomment and amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * uncomment the strings and domain.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'domain'       => $theme_text_domain,
        'menu'         => 'install-my-theme-plugins',
        'has_notices'  => true,
        // Show admin notices
        'dismissable'  => false,
        // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',
        // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,
        // Automatically activate plugins after installation or not.
        'strings'      => array(
            'page_title'             => __( 'Install Recommended Plugins', $theme_text_domain ),
            'menu_title'             => __( 'Install Plugins', $theme_text_domain ),
            'instructions_install'   => __( 'The %1$s plugin is recommended for this theme. Click on the big blue button below to install and activate %1$s.', $theme_text_domain ),
            'instructions_activate'  => __( 'The %1$s is installed but currently inactive. Please go to the <a href="%2$s">plugin administration page</a> page to activate it.', $theme_text_domain ),
            'button'                 => __( 'Install %s Now', $theme_text_domain ),
            'installing'             => __( 'Installing Plugin: %s', $theme_text_domain ),
            'oops'                   => __( 'Something went wrong with the plugin API.', $theme_text_domain ),
            'notice_can_install'     => __( 'This theme recommends the use of the %1$s plugin. <a href="%2$s"><strong>Click here to begin the installation process</strong></a>. You may be asked for FTP credentials based on your server setup.', $theme_text_domain ),
            'notice_cannot_install'  => __( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', $theme_text_domain ),
            'notice_can_activate'    => __( 'This theme recommends the use of the %1$s plugin. That plugin is currently inactive, so please go to the <a href="%2$s">plugin administration page</a> to activate it.', $theme_text_domain ),
            'notice_cannot_activate' => __( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', $theme_text_domain ),
            'return'                 => __( 'Return to Plugins Installer', $theme_text_domain ),
        ),
    );

    tgmpa( $plugins, $config );
}

if ( !function_exists( 'woc_broadsword_setup' ) ) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function woc_broadsword_setup() {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on Broadsword, use a find and replace
         * to change 'woc_broadsword' to the name of your theme in all the template files
         */
        load_theme_textdomain( 'woc_broadsword', get_template_directory() . '/languages' );

        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
         */
        add_theme_support( 'post-thumbnails' );

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus( array(
            'primary'   => __( 'Primary Menu', 'woc_broadsword' ),
            'secondary' => __( 'Secondary Menu', 'woc_broadsword' )
        ) );

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support( 'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ) );

        /*
         * Enable support for Post Formats.
         * See http://codex.wordpress.org/Post_Formats
         */
        add_theme_support( 'post-formats', array(
            'aside',
            'image',
            'video',
            'quote',
            'link',
        ) );

        // Setup the WordPress core custom background feature.
        add_theme_support( 'custom-background', apply_filters( 'woc_broadsword_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        ) ) );

        // New as of Wordpress 4.1 - add title support
        add_theme_support( 'title-tag' );

        // Allow custom thumbnail size
        add_image_size( 'broadsword_thumbnail', 175, 175, true );

        // Set an excerpt length for post summaries
        function woc_broadsword_custom_excerpt_length( $length ) {
            return 20;
        }

        add_filter( 'excerpt_length', 'woc_broadsword_custom_excerpt_length', 999 );

    }
endif; // woc_broadsword_setup
add_action( 'after_setup_theme', 'woc_broadsword_setup' );



/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function woc_broadsword_widgets_init() {

    register_sidebar( array(
        'name'          => __( 'Footer 1', 'woc_broadsword' ),
        'id'            => 'footer-1',
        'before_widget' => '<aside class="widget well %2$s" id="%1$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer 2', 'woc_broadsword' ),
        'id'            => 'footer-2',
        'before_widget' => '<aside class="widget well %2$s" id="%1$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer 3', 'woc_broadsword' ),
        'id'            => 'footer-3',
        'before_widget' => '<aside class="widget well %2$s" id="%1$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    $active_widgets = get_option( 'sidebars_widgets' );

    $footer1 = $active_widgets[ 'footer-1' ];
    if ( count( $footer1 ) == 0 ) {
        $active_widgets[ 'footer-1' ] = array( 'text-1' );
        $text_content[ 1 ] = array(
            'title' => __( 'The Broadsword', 'woc_broadsword' ),
            'text' => __( 'The Broadsword is a modern, full screen Wordpress theme with a ton of personality for creative bloggers.', 'woc_broadsword' )
        );
        update_option( 'widget_text', $text_content );
    }

    $footer2 = $active_widgets[ 'footer-2' ];
    if ( count( $footer2 ) == 0 ) {
        $active_widgets[ 'footer-2' ] = array( 'pages-1' );
        $pages_content[ 1 ] = array(
            'title' => __( 'Pages', 'woc_broadsword' )
        );
        update_option( 'widget_pages', $pages_content );
    }

    $footer3 = $active_widgets[ 'footer-3' ];
    if ( count( $footer3 ) == 0 ) {
        $active_widgets[ 'footer-3' ] = array( 'search-1' );
        $search_content[ 1 ] = array(
            'title' => __( 'Search', 'woc_broadsword' )
        );
        update_option( 'widget_search', $search_content );
    }

    update_option( 'sidebars_widgets', $active_widgets );

}

add_action( 'widgets_init', 'woc_broadsword_widgets_init' );


/**
 * Enqueue scripts and styles.
 */
function woc_broadsword_scripts() {
    global $post;

    wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/bootstrap/css/bootstrap.min.css' );
    wp_enqueue_style( 'woc_broadsword-style', get_stylesheet_uri() );
    wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css' );
    wp_enqueue_style( 'jscrollpane', get_template_directory_uri() . '/assets/js/jscrollpane/jquery.jscrollpane.css' );
    wp_enqueue_style( 'broadsword-scroll', get_template_directory_uri() . '/assets/js/jscrollpane/jquery.jscrollpane.broadsword.css' );
    wp_enqueue_style( 'swipe', get_template_directory_uri() . '/assets/js/swipe/swiper.min.css' );

    wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/assets/bootstrap/js/bootstrap.min.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'woc_broadsword-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), '20120206', true );
    wp_enqueue_script( 'woc_broadsword-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20130115', true );
    wp_enqueue_script( 'broadsword-js', get_template_directory_uri() . '/assets/js/broadsword.min.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/assets/js/modernizr.custom.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'classie', get_template_directory_uri() . '/assets/js/classie.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'fullscreen-overlay', get_template_directory_uri() . '/assets/js/fullscreen-overlay.min.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'jscrollpane', get_template_directory_uri() . '/assets/js/jscrollpane/jquery.jscrollpane.min.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'mousewheel', get_template_directory_uri() . '/assets/js/jscrollpane/jquery.mousewheel.min.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'swipe', get_template_directory_uri() . '/assets/js/swipe/swiper.jquery.min.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'buggyfill', get_template_directory_uri() . '/assets/js/viewport-units-buggyfill.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'validate', get_template_directory_uri() . '/assets/js/jquery.validate.min.js', array( 'jquery' ), '', true );

    wp_register_script( 'home', get_template_directory_uri() . '/assets/js/broadsword-home.min.js', array( 'jquery' ), '', true );
    wp_register_script( 'singular', get_template_directory_uri() . '/assets/js/broadsword-single.min.js', array( 'jquery' ), '', true );
    wp_register_script( 'contact', get_template_directory_uri() . '/assets/js/broadsword-contact.min.js', array( 'jquery' ), '', true );
    wp_register_script( '404', get_template_directory_uri() . '/assets/js/broadsword-404.min.js', array( 'jquery' ), '', true );

    if ( is_home() ) {
        $fp_style = get_theme_mod( 'woc_front_page_style' );
        if ( isset( $_GET[ 'fp_style' ] ) ) {
            $fp_style = $_GET[ 'fp_style' ];
        }
        wp_enqueue_script( 'home' );
        wp_localize_script( 'home', 'home_script_vars', array( 'page_bg_image'    => get_theme_mod( 'woc_page_bg_image' ),
            'front_page_style' => $fp_style ) );
    }

    if ( is_singular() || is_archive() || is_search() ) {
        wp_enqueue_script( 'singular' );

        if ( isset( $post ) ) {
            $header_bg = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
            if ( count( $header_bg ) > 0 ) {
                $header_bg = $header_bg[ 0 ];
            }
        }
        if ( is_search() ) {
            // Search page defaults to the site background image
            $header_bg = get_theme_mod( 'woc_page_bg_image' );
        }
        wp_localize_script( 'singular', 'singular_script_vars', array( 'header_bg_image' => $header_bg != null
            ? $header_bg
            : "" ) );
    }

    if ( is_page_template( 'contact-page.php' ) ) {
        wp_enqueue_script( 'contact' );
    }

    if ( is_404() ) {
        $header_bg = get_theme_mod( 'woc_404_page_bg_image' );
        wp_localize_script( '404', 'pg_404_script_vars', array( 'header_bg_image' => $header_bg != null
            ? $header_bg
            : "" ) );
        wp_enqueue_script( '404' );
    }

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}

add_action( 'wp_enqueue_scripts', 'woc_broadsword_scripts' );

/**
 * Custom comments layout callback
 */
function woc_comment_layout( $comment, $args, $depth ) {
    $GLOBALS[ 'comment' ] = $comment;
    extract( $args, EXTR_SKIP );

    if ( 'div' == $args[ 'style' ] ) {
        $tag       = 'div';
        $add_below = 'comment';
    } else {
        $tag       = 'li';
        $add_below = 'div-comment';
    }
    ?>

    <<?php echo $tag ?> <?php comment_class( empty( $args[ 'has_children' ] )
        ? ''
        : 'parent' ) ?> id="comment-<?php comment_ID() ?>">

    <?php if ( 'div' != $args[ 'style' ] ) : ?>
        <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
    <?php endif; ?>

    <div class="row">
        <div class="col-sm-2">
            <?php if ( $args[ 'avatar_size' ] != 0 ) {
                echo get_avatar( $comment, $args[ 'avatar_size' ] );
            } ?>
        </div>
        <div class="col-sm-10">
            <div class="row comment-author-row">
                <div class="comment-author vcard col-sm-6">
                    <?php printf( __( '<cite class="fn">%s</cite>' ), get_comment_author_link() ); ?>
                </div>

                <div class="comment-meta commentmetadata col-sm-6">
                    <div class="pull-right">
                        <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
                            <?php
                            printf( '%1$s', get_comment_date() ); ?></a><?php edit_comment_link( __( '(Edit)', 'woc_broadsword' ), '  ', '' );
                        ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <?php if ( $comment->comment_approved == '0' ) : ?>
                        <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'woc_broadsword' ); ?></em>
                        <br/>
                    <?php endif; ?>

                    <?php comment_text(); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="reply">
        <?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below,
            'depth'     => $depth,
            'max_depth' => $args[ 'max_depth' ] ) ) ); ?>
    </div>
    <?php if ( 'div' != $args[ 'style' ] ) : ?>
        </div>
    <?php endif; ?>
<?php
}

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Google fonts
 */
function load_fonts() {
    // Set the protocol
    $protocol = is_ssl()
        ? 'https'
        : 'http';

    $primary_font   = is_serialized( get_theme_mod( 'woc_primary_font' ) )
        ? unserialize( get_theme_mod( 'woc_primary_font' ) )
        : array( 'default'     => true,
            'font-family' => '"Merriweather", serif' );
    $secondary_font = is_serialized( get_theme_mod( 'woc_secondary_font' ) )
        ? unserialize( get_theme_mod( 'woc_secondary_font' ) )
        : array( 'default'     => true,
            'font-family' => '"Lato", sans-serif' );
    $tertiary_font  = is_serialized( get_theme_mod( 'woc_tertiary_font' ) )
        ? unserialize( get_theme_mod( 'woc_tertiary_font' ) )
        : array( 'default'     => true,
            'font-family' => '"Vollkorn", serif' );

    // Enqueue the font if it's not one of the defaults
    if ( !isset( $primary_font[ 'default' ] ) ) {
        wp_enqueue_style( $primary_font[ 'css-name' ], "$protocol://fonts.googleapis.com/css?family=" . $primary_font[ 'css-name' ] . ":300,400,400italic,500,600,700,700italic,800,900" );
    }

    if ( !isset( $secondary_font[ 'default' ] ) ) {
        wp_enqueue_style( $secondary_font[ 'css-name' ], "$protocol://fonts.googleapis.com/css?family=" . $secondary_font[ 'css-name' ] . ":300,400,400italic,500,600,700,700italic,800,900" );
    }

    // Load the defaults
    wp_enqueue_style( "Merriweather", "$protocol://fonts.googleapis.com/css?family=Merriweather:300,300italic,400,400italic,500,600,700,700italic,800,900" );
    wp_enqueue_style( "Lato", "$protocol://fonts.googleapis.com/css?family=Lato:300,300italic,400,400italic,500,600,700,700italic,800,900" );
    wp_enqueue_style( "Vollkorn", "$protocol://fonts.googleapis.com/css?family=Vollkorn:300,300italic,400,400italic,500,600,700,700italic,800,900" );

    $primary_font_family = $primary_font[ 'font-family' ];
    $primary_font_family = rtrim( $primary_font_family, ";" );

    $secondary_font_family = $secondary_font[ 'font-family' ];
    $secondary_font_family = rtrim( $secondary_font_family, ";" );

    $tertiary_font_family = $tertiary_font[ 'font-family' ];
    $tertiary_font_family = rtrim( $tertiary_font_family, ";" );
    ?>
    <style type="text/css">
        .form-control,
        .site-main,
        body.archive .entry-header .entry-meta h3,
        body.archive .entry-header .entry-meta a,
        body.search-results .entry-header .entry-meta h3,
        body.search-results .entry-header .entry-meta a,
        .entry-content,
        .blockquote footer,
        .comment-body {
            font-family: <?php echo $primary_font_family; ?> !important;
        }

        body,
        h1,
        h2,
        .btn-default,
        .post-details,
        .page-details,
        body.archive .entry-summary a,
        body.archive .entry-header a,
        body.search-results .entry-summary a,
        body.search-results .entry-header a,
        .comment-notes,
        .form-submit input[type="submit"],
        .comments-title,
        .comment-author,
        .comment-meta,
        .home footer, .single footer,
        .view-more {
            font-family: <?php echo $secondary_font_family; ?> !important;
        }

        h3,
        .entry-summary,
        .contact-icons .icon-details,
        #footer-widget-area .well a {
            font-family: <?php echo $tertiary_font_family; ?> !important;
        }
    </style>
<?php
}

add_action( 'wp_print_styles', 'load_fonts' );

/**
 * This function adds some styles to the WordPress Customizer
 */
function woc_broadsword_customizer_styles() { ?>
    <style>
        .customize-control {
            padding: 5px;
            margin-bottom: 30px;
            border: 1px solid #ccc;
        }

        .customize-control .actions {
            margin-bottom: 0;
        }
    </style>
<?php

}

add_action( 'customize_controls_print_styles', 'woc_broadsword_customizer_styles', 999 );

function woc_broadsword_fb_opengraph() {
    global $post;

    if(is_single()) {
        if(has_post_thumbnail($post->ID)) {
            $img_src = wp_get_attachment_image_src(get_post_thumbnail_id( $post->ID ), 'medium');
            $img_src = $img_src[0]; //url
        } else {
            $img_src = get_stylesheet_directory_uri() . '/assets/img/opengraph_image.jpg';
        }

        $excerpt = wp_trim_words( $post->post_content );
        if($post->post_excerpt) {
            $excerpt = strip_tags($post->post_excerpt);
            $excerpt = str_replace("", "'", $excerpt);
        }
        ?>

        <meta property="og:title" content="<?php echo the_title(); ?>"/>
        <meta property="og:description" content="<?php echo $excerpt; ?>"/>
        <meta property="og:type" content="article"/>
        <meta property="og:url" content="<?php echo the_permalink(); ?>"/>
        <meta property="og:site_name" content="<?php echo get_bloginfo(); ?>"/>
        <meta property="og:image" content="<?php echo $img_src; ?>"/>

    <?php
    } else if (is_front_page()) {
        if(get_theme_mod('woc_page_bg_image')) {
            $img_src = get_theme_mod('woc_page_bg_image');
        } else {
            $img_src = get_stylesheet_directory_uri() . '/assets/img/opengraph_image.jpg';
        }
        ?>
        <meta property="og:title" content="<?php echo get_bloginfo(); ?>"/>
        <meta property="og:description" content="<?php echo get_bloginfo('description'); ?>"/>
        <meta property="og:type" content="article"/>
        <meta property="og:url" content="<?php echo get_bloginfo('url'); ?>"/>
        <meta property="og:site_name" content="<?php echo get_bloginfo(); ?>"/>
        <meta property="og:image" content="<?php echo $img_src; ?>"/>
    <?php } else {
        return;
    }
}
add_action('wp_head', 'woc_broadsword_fb_opengraph', 5);

function woc_home_category( $query ) {
    if ( $query->is_home() && $query->is_main_query() ) {
        // Check to see if a custom category has been set in the customizer
        if (get_theme_mod( 'woc_fp_post_category') != 'all') {
            $query->set('cat', get_theme_mod( 'woc_fp_post_category'));
        }
    }
}
add_action( 'pre_get_posts', 'woc_home_category' );