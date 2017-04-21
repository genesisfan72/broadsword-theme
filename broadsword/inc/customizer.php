<?php
/**
 * Broadsword Theme Customizer
 *
 * @package Broadsword
 */


/**
 * Text sanitizer
 */
function woc_broadsword_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}

/**
 * Front page layout sanitizer
 */
function woc_broadsword_sanitize_layout( $input ) {
    $valid = array(
        'default'       => 'Vertical Full Background',
        'imaged'        => 'Vertical Column Background',
        'horizontal-bg' => 'Horizontal Full Background',
        'horizontal'    => 'Horizontal Row Background',
    );

    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

/**
 * Sanitize text with html tags - no script tags allowed
 * @param $input
 * @return mixed
 */
function woc_broadsword_sanitize_text_with_link( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}

/**
 * Sanitize checkboxes
 * @param $input
 * @return int|string
 */
function woc_broadsword_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
        return 1;
    } else {
        return '';
    }
}

/**
 * Return true if either of the full page layouts are displayed
 * @param $control
 * @return bool
 */
function woc_broadsword_is_fullpage( $control ) {
    $option = $control->manager->get_setting( 'woc_front_page_style' );

    return ( $option->value() == 'default' || $option->value() == 'horizontal-bg' );
}

/**
 * Build the Broadsword customizer.
 */
function woc_broadsword_customizer_build( $wp_customize ) {

    /* General Section */
    $wp_customize->add_section( 'woc_layout_section', array(
        'title'    => __( 'Homepage Options', 'woc_broadsword' ),
        'priority' => 1,
    ) );

    // Front page layout style
    require_once 'layout-picker-custom-control.php';
    $wp_customize->add_setting( 'woc_front_page_style', array(
        'default'           => __( 'default', 'woc_broadsword' ),
        'sanitize_callback' => 'woc_broadsword_sanitize_layout'
    ) );

    $wp_customize->add_control( new Layout_Picker_Custom_Control( $wp_customize, 'woc_front_page_style', array(
        'label'    => __( 'Select Homepage Layout:', 'woc_broadsword' ),
        'section'  => 'woc_layout_section',
        'settings' => 'woc_front_page_style',
        'priority' => 1
    ) ) );

    // Page background image
    $wp_customize->add_setting( 'woc_page_bg_image', array( 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( new WP_Customize_Image_Control (
                                    $wp_customize,
                                    'woc_page_bg_image',
                                    array(
                                        'label'           => __( 'The background image for your site if you choose the full sized image layout.', 'woc_broadsword' ),
                                        'section'         => 'woc_layout_section',
                                        'settings'        => 'woc_page_bg_image',
                                        'active_callback' => 'woc_broadsword_is_fullpage',
                                        'priority'        => 2
                                    )
                                ) );

    // Front page data source
    $wp_customize->add_setting( 'woc_loop_source', array(
        'default'           => __( 'posts', 'woc_broadsword' ),
        'sanitize_callback' => 'woc_broadsword_sanitize_text',
        'transport'         => 'refresh'
    ) );

    $wp_customize->add_control( 'woc_loop_source',
                                array(
                                    'label'    => __( 'Select Homepage Source (posts or pages):', 'woc_broadsword' ),
                                    'section'  => 'woc_layout_section',
                                    'settings' => 'woc_loop_source',
                                    'type'     => 'select',
                                    'choices'  => array( 'posts' => __( 'posts', 'woc_broadsword' ),
                                                         'pages' => __( 'pages', 'woc_broadsword' ) ),
                                    'priority' => 3
                                )
    );

    $wp_customize->add_setting( 'woc_fp_post_category', array(
        'default'           => __( 'All', 'woc_broadsword' ),
        'sanitize_callback' => 'woc_broadsword_sanitize_text',
        'transport'         => 'refresh'
    ) );

    $cats = get_categories();
    $cat_array['all'] = __('All', 'woc_broadsword');

    foreach ($cats as $cat) {
        $cat_array[$cat->cat_ID] = $cat->name;
    }
    $wp_customize->add_control( 'woc_fp_post_category',
        array(
            'label'    => __( 'When showing posts on the front page, use the following category:', 'woc_broadsword' ),
            'section'  => 'woc_layout_section',
            'settings' => 'woc_fp_post_category',
            'type'     => 'select',
            'choices'  => $cat_array,
            'priority' => 4
        )
    );

    // Featured page
    require_once 'post-picker-custom-control.php';
    $wp_customize->add_setting( 'woc_featured_page', array(
        'default'           => __( '', 'woc_broadsword' ),
        'sanitize_callback' => 'woc_broadsword_sanitize_text',
        'transport'         => 'refresh'
    ) );

    $wp_customize->add_control( new Post_Dropdown_Custom_Control( $wp_customize, 'woc_featured_page', array(
        'label'    => __( 'Select Top Left Corner Page:', 'woc_broadsword' ),
        'section'  => 'woc_layout_section',
        'settings' => 'woc_featured_page',
        'priority' => 5
    ) ) );


    // Show or hide the post/page meta data
    require_once 'checkbox-custom-control.php';
    $wp_customize->add_setting( 'woc_show_date_line', array(
        'default'           => 1,
        'transport'         => 'refresh' ) );

    $wp_customize->add_control( new Checkbox_Custom_Control( $wp_customize, 'woc_show_date_line', array(
        'label'    => __( 'Post/Page Byline:', 'woc_broadsword' ),
        'section'  => 'woc_layout_section',
        'checkbox_label'    => __( 'Show the post/page date line on hover.', 'woc_broadsword' ),
        'settings' => 'woc_show_date_line',
        'priority' => 6
    ) ) );

    /* Posts/Pages Section */
    $wp_customize->add_section( 'woc_posts_pages_section', array(
        'title'    => __( 'Posts and Pages', 'woc_broadsword' ),
        'priority' => 2,
    ) );

    $wp_customize->add_setting( 'woc_post_byline', array(
        'default'           => __( 'Show', 'woc_broadsword' ),
        'transport'         => 'refresh' ) );

    $wp_customize->add_control( 'woc_post_byline',
        array(
            'label'    => __( 'Show or hide the post byline:', 'woc_broadsword' ),
            'section'  => 'woc_posts_pages_section',
            'settings' => 'woc_post_byline',
            'type'     => 'select',
            'choices'  => array( 'show' => __( 'Show', 'woc_broadsword' ), 'hide' => __( 'Hide', 'woc_broadsword' ) ),
            'priority' => 7
        )
    );

    $wp_customize->add_setting( 'woc_display_name', array(
        'default'           => __( 'Login Name', 'woc_broadsword' ),
        'transport'         => 'refresh' ) );

    $wp_customize->add_control( 'woc_display_name',
        array(
            'label'    => __( 'When displaying the post byline, use the following for the author name:', 'woc_broadsword' ),
            'section'  => 'woc_posts_pages_section',
            'settings' => 'woc_display_name',
            'type'     => 'select',
            'choices'  => array( 'user_nicename' => __( 'Login Name', 'woc_broadsword' ), 'display_name' => __( 'Display Name', 'woc_broadsword' ) ),
            'priority' => 8
        )
    );


    /* Logo Section */
    $wp_customize->add_section( 'woc_logo_section', array(
        'title'    => __( 'Logo', 'woc_broadsword' ),
        'priority' => 3,
    ) );


    // Logo
    $wp_customize->add_setting( 'woc_broadsword_logo', array(
        'default'           => get_template_directory_uri() . '/assets/img/broadsword-logo.png',
        'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( new WP_Customize_Image_Control (
                                    $wp_customize,
                                    'woc_broadsword_logo',
                                    array(
                                        'label'    => __( 'The logo for your site. Suggested size of roughly 200px by 30px.', 'woc_broadsword' ),
                                        'section'  => 'woc_logo_section',
                                        'settings' => 'woc_broadsword_logo',
                                        'priority' => 3
                                    )
                                ) );


    /* Typography Section */
    $wp_customize->add_section( 'woc_typography_section', array(
        'title'    => __( 'Typography', 'woc_broadsword' ),
        'priority' => 4,
    ) );

    // Set up Google Fonts
    include 'google-fonts.php';

    $wp_customize->add_setting( 'woc_primary_font', array(
        'sanitize_callback' => 'woc_broadsword_sanitize_text',
        'default'           => serialize( array(
                                              'font-family' => "'Merriweather', serif;",
                                              'css-name'    => 'Merriweather'
                                          ) ),
        'transport'         => 'refresh'
    ) );

    $wp_customize->add_control( 'woc_primary_font',
                                array(
                                    'label'    => __( 'Select your primary font. Used primarily for post and page content text.', 'woc_broadsword' ),
                                    'section'  => 'woc_typography_section',
                                    'settings' => 'woc_primary_font',
                                    'type'     => 'select',
                                    'choices'  => $google_fonts
                                )
    );


    // Secondary font
    $wp_customize->add_setting( 'woc_secondary_font', array(
        'sanitize_callback' => 'woc_broadsword_sanitize_text',
        'default'           => serialize( array(
                                              'font-family' => "'Lato', sans-serif;",
                                              'css-name'    => 'Lato'
                                          ) ),
        'transport'         => 'refresh'
    ) );

    $wp_customize->add_control( 'woc_secondary_font',
                                array(
                                    'label'    => __( 'Select your secondary font. Used primarily for headers and titles.', 'woc_broadsword' ),
                                    'section'  => 'woc_typography_section',
                                    'settings' => 'woc_secondary_font',
                                    'type'     => 'select',
                                    'choices'  => $google_fonts
                                )
    );

    // Tertiary font
    $wp_customize->add_setting( 'woc_tertiary_font', array(
        'sanitize_callback' => 'woc_broadsword_sanitize_text',
        'default'           => serialize( array(
                                              'font-family' => "'Vollkorn', serif;",
                                              'css-name'    => 'Vollkorn'
                                          ) ),
        'transport'         => 'refresh'
    ) );

    $wp_customize->add_control( 'woc_tertiary_font',
                                array(
                                    'label'    => __( 'Select your third level font. Used primarily for h3 tags such as post bylines.', 'woc_broadsword' ),
                                    'section'  => 'woc_typography_section',
                                    'settings' => 'woc_tertiary_font',
                                    'type'     => 'select',
                                    'choices'  => $google_fonts
                                )
    );

    /* Social Media & Contact Section */
    $wp_customize->add_section( 'woc_social_media_contact_section', array(
        'title'       => __( 'Social Media & Contact Options', 'woc_broadsword' ),
        'priority'    => 5,
        'description' => __( 'Enter the account names for any of the following social media networks you wish to link on your site.', 'woc_broadsword' )
    ) );

    $wp_customize->add_setting( 'woc_facebook', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url'
    ) );

    $wp_customize->add_control( 'woc_facebook', array(
        'label'    => __( 'Facebook', 'woc_broadsword' ),
        'section'  => 'woc_social_media_contact_section',
        'type'     => 'text',
        'priority' => 1
    ) );

    $wp_customize->add_setting( 'woc_twitter', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url'
    ) );

    $wp_customize->add_control( 'woc_twitter', array(
        'label'    => __( 'Twitter', 'woc_broadsword' ),
        'section'  => 'woc_social_media_contact_section',
        'type'     => 'text',
        'priority' => 2
    ) );

    $wp_customize->add_setting( 'woc_googleplus', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url'
    ) );

    $wp_customize->add_control( 'woc_googleplus', array(
        'label'    => __( 'Google+', 'woc_broadsword' ),
        'section'  => 'woc_social_media_contact_section',
        'type'     => 'text',
        'priority' => 3
    ) );

    $wp_customize->add_setting( 'woc_linkedin', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url'
    ) );

    $wp_customize->add_control( 'woc_linkedin', array(
        'label'    => __( 'LinkedIn', 'woc_broadsword' ),
        'section'  => 'woc_social_media_contact_section',
        'type'     => 'text',
        'priority' => 4
    ) );

    $wp_customize->add_setting( 'woc_pinterest', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url'
    ) );

    $wp_customize->add_control( 'woc_pinterest', array(
        'label'    => __( 'Pinterest', 'woc_broadsword' ),
        'section'  => 'woc_social_media_contact_section',
        'type'     => 'text',
        'priority' => 4
    ) );

    $wp_customize->add_setting( 'woc_phone', array(
        'default'           => __( '', 'woc_broadsword' ),
        'sanitize_callback' => 'woc_broadsword_sanitize_text'
    ) );

    $wp_customize->add_control( 'woc_phone', array(
        'label'    => __( 'Enter the phone number you can be reached at. Don\'t forget to include your country and area code', 'woc_broadsword' ),
        'section'  => 'woc_social_media_contact_section',
        'type'     => 'text',
        'priority' => 5
    ) );

    $wp_customize->add_setting( 'woc_google_map', array(
        'default'           => __( '', 'woc_broadsword' ),
        'sanitize_callback' => 'woc_broadsword_sanitize_text'
    ) );

    $wp_customize->add_control( 'woc_google_map', array(
        'label'    => __( 'Enter the <iframe> code generated by Google Maps.', 'woc_broadsword' ),
        'section'  => 'woc_social_media_contact_section',
        'type'     => 'text',
        'priority' => 6
    ) );

    /* 404 Section */
    $wp_customize->add_section( 'woc_404_bg_image_section', array(
        'title'    => __( '404 Background Image', 'woc_broadsword' ),
        'priority' => 6,
    ) );

    // Page background image
    $wp_customize->add_setting( 'woc_404_page_bg_image', array( 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( new WP_Customize_Image_Control (
                                    $wp_customize,
                                    'woc_404_page_bg_image',
                                    array(
                                        'label'    => __( 'The background image for your 404 page header.', 'woc_broadsword' ),
                                        'section'  => 'woc_404_bg_image_section',
                                        'settings' => 'woc_404_page_bg_image',
                                        'priority' => 1
                                    )
                                ) );

    /* Footer Section */
    $wp_customize->add_section( 'woc_footer_section', array(
        'title'    => __( 'Footer', 'woc_broadsword' ),
        'priority' => 7,
    ) );

    // Show copyright date
    $wp_customize->add_setting( 'woc_show_copyright', array(
        'default'           => 1,
        'sanitize_callback' => 'woc_broadsword_sanitize_text_with_link' ) );

    $wp_customize->add_control(
        'woc_show_copyright',
        array(
            'type'     => 'checkbox',
            'label'    => __( 'Show copyright text', 'woc_broadsword' ),
            'section'  => 'woc_footer_section',
            'priority' => 1
        )
    );

    // Footer text
    $wp_customize->add_setting( 'woc_footer_text', array(
        'default'           => sprintf( __( ' Built by yours truly, %1$s.', 'woc_broadsword' ), '<a href=' . esc_url( "http://warriorsofcode.com" ) . '>the warriors</a>' ),
        'sanitize_callback' => 'woc_broadsword_sanitize_text_with_link' ) );

    $wp_customize->add_control( new WP_Customize_Control (
                                    $wp_customize,
                                    'woc_footer_text',
                                    array(
                                        'label'    => __( 'The text you would like to see in your footer.', 'woc_broadsword' ),
                                        'section'  => 'woc_footer_section',
                                        'settings' => 'woc_footer_text',
                                        'priority' => 3
                                    )
                                ) );

    // Remove some of the standard customizer sections that aren't needed
    $wp_customize->remove_section( 'header_image' );
    $wp_customize->remove_section( 'background_image' );
    $wp_customize->remove_section( 'static_front_page' );
    $wp_customize->remove_section( 'colors' );
}

add_action( 'customize_register', 'woc_broadsword_customizer_build' );

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function woc_broadsword_customize_register( $wp_customize ) {
    $wp_customize->get_setting( 'blogname' )->transport          = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport   = 'postMessage';
    $wp_customize->get_setting( 'header_textcolor' )->transport  = 'postMessage';
    $wp_customize->get_setting( 'woc_facebook' )->transport      = 'postMessage';
    $wp_customize->get_setting( 'woc_twitter' )->transport       = 'postMessage';
    $wp_customize->get_setting( 'woc_googleplus' )->transport    = 'postMessage';
    $wp_customize->get_setting( 'woc_linkedin' )->transport      = 'postMessage';
    $wp_customize->get_setting( 'woc_pinterest' )->transport     = 'postMessage';
    $wp_customize->get_setting( 'woc_featured_page' )->transport = 'postMessage';
    $wp_customize->get_setting( 'woc_phone' )->transport         = 'postMessage';
}

add_action( 'customize_register', 'woc_broadsword_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function woc_broadsword_customize_preview_js() {
    wp_enqueue_script( 'woc_broadsword_customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}

add_action( 'customize_preview_init', 'woc_broadsword_customize_preview_js' );
