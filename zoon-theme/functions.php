<?php
/**
 * Zoon Theme functions and definitions
 *
 * @package Zoon_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Setup Theme features.
 */
function zoon_theme_setup() {
    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support( 'post-thumbnails' );

    // Register navigation menus.
    register_nav_menus( array(
        'primary' => esc_html__( 'Primary Menu', 'zoon-theme' ),
        'footer'  => esc_html__( 'Footer Menu', 'zoon-theme' ),
        'social'  => esc_html__( 'Social Links Menu', 'zoon-theme' ),
    ) );

    // Switch default core markup for search form, comment form, etc. to HTML5.
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    // Enable support for custom logo
    add_theme_support( 'custom-logo', array(
        'height'      => 80,
        'width'       => 80,
        'flex-height' => true,
        'flex-width'  => true,
    ) );

    // Enable title tag support
    add_theme_support( 'title-tag' );

    // Custom cropped image sizes for optimization
    add_image_size( 'zoon-blog-grid', 600, 400, true ); // Grid card thumbnail
    add_image_size( 'zoon-single-hero', 1200, 600, true ); // Single post full header
}
add_action( 'after_setup_theme', 'zoon_theme_setup' );

/**
 * Enqueue scripts and styles.
 */
function zoon_theme_scripts() {
    // Enqueue FontAwesome
    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0' );

    // Theme main stylesheet
    wp_enqueue_style( 'zoon-style', get_stylesheet_uri(), array(), '1.0.0' );

    // Enqueue Translations Mapping JS
    wp_enqueue_script( 'zoon-translations', get_template_directory_uri() . '/translations.js', array(), '4.0.0', false );

    // Enqueue Theme main interactive JS
    wp_enqueue_script( 'zoon-script', get_template_directory_uri() . '/script.js', array('zoon-translations'), '7.0.0', true );

    // Localize theme scripts to pass the theme directory URI to JS (so assets inside script.js load correctly)
    wp_localize_script( 'zoon-script', 'zoonThemeSettings', array(
        'themeUri' => get_template_directory_uri()
    ) );
}
add_action( 'wp_enqueue_scripts', 'zoon_theme_scripts' );

/**
 * Register widget areas.
 */
function zoon_theme_widgets_init() {
    register_sidebar( array(
        'name'          => esc_html__( 'Blog Sidebar', 'zoon-theme' ),
        'id'            => 'sidebar-1',
        'description'   => esc_html__( 'Add widgets here to appear in your blog sidebar.', 'zoon-theme' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s card-outer" style="margin-bottom:2rem;">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title" style="font-size:1.2rem; margin-bottom:1rem; border-left:4px solid var(--color-primary); padding-left:0.5rem;">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'zoon_theme_widgets_init' );

/**
 * Customizer Controls for Zoon Theme options.
 */
function zoon_customize_register( $wp_customize ) {

    // ==========================================
    // Section: General Office & Contact details
    // ==========================================
    $wp_customize->add_section( 'zoon_contact_section', array(
        'title'       => esc_html__( 'Zoon Office & Contact Info', 'zoon-theme' ),
        'description' => esc_html__( 'Manage general trust contact details used across header, footer and sections.', 'zoon-theme' ),
        'priority'    => 30,
    ) );

    // Contact Number 1
    $wp_customize->add_setting( 'zoon_phone_1', array(
        'default'           => '9795371007',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'zoon_phone_1', array(
        'label'    => esc_html__( 'Primary Phone Number', 'zoon-theme' ),
        'section'  => 'zoon_contact_section',
        'type'     => 'text',
    ) );

    // Contact Number 2
    $wp_customize->add_setting( 'zoon_phone_2', array(
        'default'           => '9278371007',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'zoon_phone_2', array(
        'label'    => esc_html__( 'Secondary Phone Number', 'zoon-theme' ),
        'section'  => 'zoon_contact_section',
        'type'     => 'text',
    ) );

    // Office Contact
    $wp_customize->add_setting( 'zoon_phone_office', array(
        'default'           => '7860671007',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'zoon_phone_office', array(
        'label'    => esc_html__( 'Office Landline/Contact Number', 'zoon-theme' ),
        'section'  => 'zoon_contact_section',
        'type'     => 'text',
    ) );

    // Email
    $wp_customize->add_setting( 'zoon_email', array(
        'default'           => 'zooncharitabletrust@gmail.com',
        'sanitize_callback' => 'sanitize_email',
    ) );
    $wp_customize->add_control( 'zoon_email', array(
        'label'    => esc_html__( 'Official Email Address', 'zoon-theme' ),
        'section'  => 'zoon_contact_section',
        'type'     => 'email',
    ) );

    // Address
    $wp_customize->add_setting( 'zoon_address', array(
        'default'           => 'Railway Station Road, Sarai Mir, Azamgarh, Uttar Pradesh, PIN: 276305',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'zoon_address', array(
        'label'    => esc_html__( 'Office Headquarters Address', 'zoon-theme' ),
        'section'  => 'zoon_contact_section',
        'type'     => 'textarea',
    ) );

    // PDF objectives URL
    $wp_customize->add_setting( 'zoon_pdf_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'zoon_pdf_url', array(
        'label'       => esc_html__( 'Official Objectives PDF File Link', 'zoon-theme' ),
        'description' => esc_html__( 'Paste the link of the PDF file uploaded in media gallery.', 'zoon-theme' ),
        'section'     => 'zoon_contact_section',
        'type'        => 'url',
    ) );

    // Facebook Page URL
    $wp_customize->add_setting( 'zoon_facebook_url', array(
        'default'           => 'https://www.facebook.com/zctbillionin1',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'zoon_facebook_url', array(
        'label'    => esc_html__( 'Facebook Page Link', 'zoon-theme' ),
        'section'  => 'zoon_contact_section',
        'type'     => 'url',
    ) );


    // ==========================================
    // Section: Hero Configuration
    // ==========================================
    $wp_customize->add_section( 'zoon_hero_section', array(
        'title'    => esc_html__( 'Homepage: Hero Section', 'zoon-theme' ),
        'priority' => 40,
    ) );

    $wp_customize->add_setting( 'zoon_hero_title', array(
        'default'           => 'Sewa, Shiksha aur Swasthya Ka Sankalp',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'zoon_hero_title', array(
        'label'    => esc_html__( 'Hero Title text', 'zoon-theme' ),
        'section'  => 'zoon_hero_section',
        'type'     => 'text',
    ) );

    $wp_customize->add_setting( 'zoon_hero_desc', array(
        'default'           => 'Zoon Charitable Trust (Z.C.T) Azamgarh (U.P.) ke zariye samaj ke sabhi yateem, besahara, aur zarooratmand bhai-behnoko unki buniyadi zarooraten aur behtar mustaqbil (future) dene ki ek choti si koshish.',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'zoon_hero_desc', array(
        'label'    => esc_html__( 'Hero Description', 'zoon-theme' ),
        'section'  => 'zoon_hero_section',
        'type'     => 'textarea',
    ) );


    // ==========================================
    // Section: Trust Banner Configuration
    // ==========================================
    $wp_customize->add_section( 'zoon_banner_section', array(
        'title'    => esc_html__( 'Homepage: Govt Reg Banner', 'zoon-theme' ),
        'priority' => 50,
    ) );

    $wp_customize->add_setting( 'zoon_reg_num', array(
        'default'           => 'ZCT Reg: 04-63-025',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'zoon_reg_num', array(
        'label'    => esc_html__( 'Trust Registration Number Text', 'zoon-theme' ),
        'section'  => 'zoon_banner_section',
        'type'     => 'text',
    ) );


    // ==========================================
    // Section: Journey Configuration
    // ==========================================
    $wp_customize->add_section( 'zoon_journey_section', array(
        'title'    => esc_html__( 'Homepage: Our Journey', 'zoon-theme' ),
        'priority' => 60,
    ) );

    $wp_customize->add_setting( 'zoon_journey_milestone', array(
        'default'           => '5 Members to 7 States',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'zoon_journey_milestone', array(
        'label'    => esc_html__( 'Journey Milestone Sub-Heading', 'zoon-theme' ),
        'section'  => 'zoon_journey_section',
        'type'     => 'text',
    ) );

    $wp_customize->add_setting( 'zoon_journey_desc', array(
        'default'           => 'Ye safar hum 5 logon ne milkar shuru kiya tha. Is samay hum lagbhag 07 rajyon mein kaam kar rahe hain. Har zarooratmand ka sapna saakaar hoga aur samaj kalyan ke saath hi ek naye samaj ka nirman bhi hoga.',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'zoon_journey_desc', array(
        'label'    => esc_html__( 'Journey Description text', 'zoon-theme' ),
        'section'  => 'zoon_journey_section',
        'type'     => 'textarea',
    ) );

    $wp_customize->add_setting( 'zoon_journey_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'zoon_journey_image', array(
        'label'    => esc_html__( 'Journey Right Side Image', 'zoon-theme' ),
        'section'  => 'zoon_journey_section',
    ) ) );


    // ==========================================
    // Section: Bank Details & QR Settings
    // ==========================================
    $wp_customize->add_section( 'zoon_bank_section', array(
        'title'    => esc_html__( 'Homepage: Bank & Donation QR', 'zoon-theme' ),
        'priority' => 70,
    ) );

    $wp_customize->add_setting( 'zoon_bank_holder', array(
        'default'           => 'Zoon Charitable Trust',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'zoon_bank_holder', array(
        'label'    => esc_html__( 'Account Holder Name', 'zoon-theme' ),
        'section'  => 'zoon_bank_section',
        'type'     => 'text',
    ) );

    $wp_customize->add_setting( 'zoon_bank_name', array(
        'default'           => 'State Bank of India',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'zoon_bank_name', array(
        'label'    => esc_html__( 'Bank Name', 'zoon-theme' ),
        'section'  => 'zoon_bank_section',
        'type'     => 'text',
    ) );

    $wp_customize->add_setting( 'zoon_bank_acc_num', array(
        'default'           => '44326838004',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'zoon_bank_acc_num', array(
        'label'    => esc_html__( 'Account Number', 'zoon-theme' ),
        'section'  => 'zoon_bank_section',
        'type'     => 'text',
    ) );

    $wp_customize->add_setting( 'zoon_bank_ifsc', array(
        'default'           => 'SBIN0011190',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'zoon_bank_ifsc', array(
        'label'    => esc_html__( 'IFSC Code', 'zoon-theme' ),
        'section'  => 'zoon_bank_section',
        'type'     => 'text',
    ) );

    $wp_customize->add_setting( 'zoon_upi_id', array(
        'default'           => '9795371007zoon@sbi',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'zoon_upi_id', array(
        'label'    => esc_html__( 'UPI ID', 'zoon-theme' ),
        'section'  => 'zoon_bank_section',
        'type'     => 'text',
    ) );

    $wp_customize->add_setting( 'zoon_upi_qr', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'zoon_upi_qr', array(
        'label'       => esc_html__( 'Custom Donation QR Code Image', 'zoon-theme' ),
        'description' => esc_html__( 'Leave blank to use the default API-generated QR code based on UPI ID.', 'zoon-theme' ),
        'section'     => 'zoon_bank_section',
    ) ) );


    // ==========================================
    // Section: Footer Copyright
    // ==========================================
    $wp_customize->add_section( 'zoon_footer_section', array(
        'title'    => esc_html__( 'Footer Settings', 'zoon-theme' ),
        'priority' => 80,
    ) );

    $wp_customize->add_setting( 'zoon_footer_copy', array(
        'default'           => '&copy; 2026 Zoon Charitable Trust. All Rights Reserved. Reg No. 04-63-025.',
        'sanitize_callback' => 'wp_kses_post',
    ) );
    $wp_customize->add_control( 'zoon_footer_copy', array(
        'label'    => esc_html__( 'Copyright Bar Text', 'zoon-theme' ),
        'section'  => 'zoon_footer_section',
        'type'     => 'text',
    ) );

    // ==========================================
    // Section: SEO Settings
    // ==========================================
    $wp_customize->add_section( 'zoon_seo_section', array(
        'title'       => esc_html__( 'SEO Settings', 'zoon-theme' ),
        'description' => esc_html__( 'Manage search engine metadata and social sharing parameters.', 'zoon-theme' ),
        'priority'    => 90,
    ) );

    // SEO Meta Description
    $wp_customize->add_setting( 'zoon_seo_desc', array(
        'default'           => 'Zoon Charitable Trust Azamgarh (U.P.) - Sewa, Shiksha aur Swasthya Ka Sankalp. A government registered NGO working for social welfare.',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'zoon_seo_desc', array(
        'label'       => esc_html__( 'Global Meta Description', 'zoon-theme' ),
        'description' => esc_html__( 'Appears in search engine snippets. Fallback for posts/pages without excerpts.', 'zoon-theme' ),
        'section'     => 'zoon_seo_section',
        'type'        => 'textarea',
    ) );

    // SEO Meta Keywords
    $wp_customize->add_setting( 'zoon_seo_keywords', array(
        'default'           => 'zoon trust, zoon charitable trust, azamgarh ngo, up ngo, charity, welfare trust, education helper',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'zoon_seo_keywords', array(
        'label'       => esc_html__( 'Global Meta Keywords', 'zoon-theme' ),
        'description' => esc_html__( 'Comma separated list of keywords describing the trust.', 'zoon-theme' ),
        'section'     => 'zoon_seo_section',
        'type'        => 'text',
    ) );

    // SEO Default Social Share Image
    $wp_customize->add_setting( 'zoon_seo_og_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'zoon_seo_og_image', array(
        'label'       => esc_html__( 'Default Social Image (Open Graph)', 'zoon-theme' ),
        'description' => esc_html__( 'This image displays when the site homepage is shared on Facebook, WhatsApp, etc.', 'zoon-theme' ),
        'section'     => 'zoon_seo_section',
    ) ) );

    // ==========================================
    // Section: Theme Styling & Colors
    // ==========================================
    $wp_customize->add_section( 'zoon_color_section', array(
        'title'       => esc_html__( 'Theme Colors & Styling', 'zoon-theme' ),
        'description' => esc_html__( 'Customize the primary and secondary branding accent colors.', 'zoon-theme' ),
        'priority'    => 100,
    ) );

    // Primary Color (Green default)
    $wp_customize->add_setting( 'zoon_color_primary', array(
        'default'           => '#3cb54c',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zoon_color_primary', array(
        'label'    => esc_html__( 'Primary Color (Brand Green)', 'zoon-theme' ),
        'section'  => 'zoon_color_section',
    ) ) );

    // Primary Light Color
    $wp_customize->add_setting( 'zoon_color_primary_light', array(
        'default'           => '#54cc63',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zoon_color_primary_light', array(
        'label'    => esc_html__( 'Primary Light Color (Glow/Hover)', 'zoon-theme' ),
        'section'  => 'zoon_color_section',
    ) ) );

    // Secondary Color (Orange default)
    $wp_customize->add_setting( 'zoon_color_secondary', array(
        'default'           => '#f36523',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zoon_color_secondary', array(
        'label'    => esc_html__( 'Secondary Color (Brand Orange)', 'zoon-theme' ),
        'section'  => 'zoon_color_section',
    ) ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zoon_color_secondary_light', array(
        'label'    => esc_html__( 'Secondary Light Color (Glow/Hover)', 'zoon-theme' ),
        'section'  => 'zoon_color_section',
    ) ) );

    // ==========================================
    // Translation Settings (Hinglish/Roman defaults to standard customizer settings)
    // ==========================================
    
    // Hero Title Translations
    foreach ( array( 'hindi' => 'Hindi', 'english' => 'English', 'marathi' => 'Marathi' ) as $lang_key => $lang_label ) {
        $wp_customize->add_setting( "zoon_hero_title_{$lang_key}", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control( "zoon_hero_title_{$lang_key}", array(
            'label'    => sprintf( esc_html__( 'Hero Title (%s)', 'zoon-theme' ), $lang_label ),
            'section'  => 'zoon_hero_section',
            'type'     => 'text',
        ) );
    }

    // Hero Description Translations
    foreach ( array( 'hindi' => 'Hindi', 'english' => 'English', 'marathi' => 'Marathi' ) as $lang_key => $lang_label ) {
        $wp_customize->add_setting( "zoon_hero_desc_{$lang_key}", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control( "zoon_hero_desc_{$lang_key}", array(
            'label'    => sprintf( esc_html__( 'Hero Description (%s)', 'zoon-theme' ), $lang_label ),
            'section'  => 'zoon_hero_section',
            'type'     => 'textarea',
        ) );
    }

    // Journey Milestone Translations
    foreach ( array( 'hindi' => 'Hindi', 'english' => 'English', 'marathi' => 'Marathi' ) as $lang_key => $lang_label ) {
        $wp_customize->add_setting( "zoon_journey_milestone_{$lang_key}", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control( "zoon_journey_milestone_{$lang_key}", array(
            'label'    => sprintf( esc_html__( 'Journey Milestone (%s)', 'zoon-theme' ), $lang_label ),
            'section'  => 'zoon_journey_section',
            'type'     => 'text',
        ) );
    }

    // Journey Description Translations
    foreach ( array( 'hindi' => 'Hindi', 'english' => 'English', 'marathi' => 'Marathi' ) as $lang_key => $lang_label ) {
        $wp_customize->add_setting( "zoon_journey_desc_{$lang_key}", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control( "zoon_journey_desc_{$lang_key}", array(
            'label'    => sprintf( esc_html__( 'Journey Description (%s)', 'zoon-theme' ), $lang_label ),
            'section'  => 'zoon_journey_section',
            'type'     => 'textarea',
        ) );
    }

    // Address Translations
    foreach ( array( 'hindi' => 'Hindi', 'english' => 'English', 'marathi' => 'Marathi' ) as $lang_key => $lang_label ) {
        $wp_customize->add_setting( "zoon_address_{$lang_key}", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control( "zoon_address_{$lang_key}", array(
            'label'    => sprintf( esc_html__( 'Address (%s)', 'zoon-theme' ), $lang_label ),
            'section'  => 'zoon_contact_section',
            'type'     => 'textarea',
        ) );
    }

    // Copyright Translations
    foreach ( array( 'hindi' => 'Hindi', 'english' => 'English', 'marathi' => 'Marathi' ) as $lang_key => $lang_label ) {
        $wp_customize->add_setting( "zoon_footer_copy_{$lang_key}", array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post',
        ) );
        $wp_customize->add_control( "zoon_footer_copy_{$lang_key}", array(
            'label'    => sprintf( esc_html__( 'Copyright Text (%s)', 'zoon-theme' ), $lang_label ),
            'section'  => 'zoon_footer_section',
            'type'     => 'text',
        ) );
    }
}
add_action( 'customize_register', 'zoon_customize_register' );

/**
 * Automaticaly generate Main Menu, Footer Menu, and Social links on theme switch.
 */
function zoon_theme_auto_create_menus() {
    // 1. Primary / Main Menu
    $primary_menu_name = 'Main Menu';
    $primary_menu_exists = wp_get_nav_menu_object( $primary_menu_name );

    if ( ! $primary_menu_exists ) {
        $primary_menu_id = wp_create_nav_menu( $primary_menu_name );
        
        if ( ! is_wp_error( $primary_menu_id ) ) {
            $items = array(
                array( 'title' => 'Home', 'url' => '/#hero' ),
                array( 'title' => 'Reg & Info', 'url' => '/#about' ),
                array( 'title' => 'Sectors', 'url' => '/#pillars' ),
                array( 'title' => 'Objectives', 'url' => '/#objectives' ),
                array( 'title' => 'Impact', 'url' => '/#calculator' ),
                array( 'title' => 'Activities', 'url' => '/#gallery' ),
                array( 'title' => 'Team', 'url' => '/#team' ),
                array( 'title' => 'Contact', 'url' => '/#contact' ),
                array( 'title' => 'Blog Feed', 'url' => '/?blog=1' ),
            );

            foreach ( $items as $item ) {
                wp_update_nav_menu_item( $primary_menu_id, 0, array(
                    'menu-item-title'   =>  $item['title'],
                    'menu-item-url'     => home_url( $item['url'] ),
                    'menu-item-status'  => 'publish',
                    'menu-item-type'    => 'custom',
                ) );
            }

            $locations = get_theme_mod( 'nav_menu_locations' );
            if ( ! is_array( $locations ) ) {
                $locations = array();
            }
            $locations['primary'] = $primary_menu_id;
            set_theme_mod( 'nav_menu_locations', $locations );
        }
    }

    // 2. Footer Menu
    $footer_menu_name = 'Footer Menu';
    $footer_menu_exists = wp_get_nav_menu_object( $footer_menu_name );

    if ( ! $footer_menu_exists ) {
        $footer_menu_id = wp_create_nav_menu( $footer_menu_name );

        if ( ! is_wp_error( $footer_menu_id ) ) {
            $items = array(
                array( 'title' => 'Home', 'url' => '/#hero' ),
                array( 'title' => 'HQ Registration', 'url' => '/#about' ),
                array( 'title' => 'Core Sectors', 'url' => '/#pillars' ),
                array( 'title' => '14 Objectives', 'url' => '/#objectives' ),
                array( 'title' => 'Impact Simulator', 'url' => '/#calculator' ),
                array( 'title' => 'Campaign Gallery', 'url' => '/#gallery' ),
                array( 'title' => 'Executive Board', 'url' => '/#team' ),
                array( 'title' => 'Contact Us', 'url' => '/#contact' ),
            );

            foreach ( $items as $item ) {
                wp_update_nav_menu_item( $footer_menu_id, 0, array(
                    'menu-item-title'   =>  $item['title'],
                    'menu-item-url'     => home_url( $item['url'] ),
                    'menu-item-status'  => 'publish',
                    'menu-item-type'    => 'custom',
                ) );
            }

            $locations = get_theme_mod( 'nav_menu_locations' );
            if ( ! is_array( $locations ) ) {
                $locations = array();
            }
            $locations['footer'] = $footer_menu_id;
            set_theme_mod( 'nav_menu_locations', $locations );
        }
    }

    // 3. Social Menu
    $social_menu_name = 'Social Links Menu';
    $social_menu_exists = wp_get_nav_menu_object( $social_menu_name );

    if ( ! $social_menu_exists ) {
        $social_menu_id = wp_create_nav_menu( $social_menu_name );

        if ( ! is_wp_error( $social_menu_id ) ) {
            $items = array(
                array( 'title' => 'Facebook', 'url' => 'https://www.facebook.com/zctbillionin1' ),
                array( 'title' => 'WhatsApp', 'url' => 'https://wa.me/919795371007' ),
                array( 'title' => 'Email', 'url' => 'mailto:zooncharitabletrust@gmail.com' ),
            );

            foreach ( $items as $item ) {
                wp_update_nav_menu_item( $social_menu_id, 0, array(
                    'menu-item-title'   =>  $item['title'],
                    'menu-item-url'     => $item['url'],
                    'menu-item-status'  => 'publish',
                    'menu-item-type'    => 'custom',
                ) );
            }

            $locations = get_theme_mod( 'nav_menu_locations' );
            if ( ! is_array( $locations ) ) {
                $locations = array();
            }
            $locations['social'] = $social_menu_id;
            set_theme_mod( 'nav_menu_locations', $locations );
        }
    }
}
add_action( 'after_switch_theme', 'zoon_theme_auto_create_menus' );

/**
 * Output Customizer translation variables as json in footer to sync client language switchers.
 */
function zoon_output_custom_translations_json() {
    $data = array(
        'roman' => array(
            'hero-title'       => get_theme_mod( 'zoon_hero_title', 'Sewa, Shiksha aur Swasthya Ka Sankalp' ),
            'hero-desc'        => get_theme_mod( 'zoon_hero_desc', 'Zoon Charitable Trust (Z.C.T) Azamgarh (U.P.) ke zariye samaj ke sabhi yateem, besahara, aur zarooratmand bhai-behnoko unki buniyadi zarooraten aur behtar mustaqbil (future) dene ki ek choti si koshish.' ),
            'reg-num'          => get_theme_mod( 'zoon_reg_num', 'ZCT Reg: 04-63-025' ),
            'journey-subtitle' => get_theme_mod( 'zoon_journey_milestone', '5 Members to 7 States' ),
            'journey-desc'     => get_theme_mod( 'zoon_journey_desc', 'Ye safar hum 5 logon ne milkar shuru kiya tha. Is samay hum lagbhag 07 rajyon mein kaam kar rahe hain. Har zarooratmand ka sapna saakaar hoga aur samaj kalyan ke saath hi ek naye samaj ka nirman bhi hoga.' ),
            'foot-addr'        => get_theme_mod( 'zoon_address', 'Railway Station Road, Sarai Mir, Azamgarh, Uttar Pradesh, PIN: 276305' ),
            'foot-copy'        => get_theme_mod( 'zoon_footer_copy', '&copy; 2026 Zoon Charitable Trust. All Rights Reserved. Reg No. 04-63-025.' ),
        ),
        'hindi' => array(
            'hero-title'       => get_theme_mod( 'zoon_hero_title_hindi', '' ),
            'hero-desc'        => get_theme_mod( 'zoon_hero_desc_hindi', '' ),
            'journey-subtitle' => get_theme_mod( 'zoon_journey_milestone_hindi', '' ),
            'journey-desc'     => get_theme_mod( 'zoon_journey_desc_hindi', '' ),
            'foot-addr'        => get_theme_mod( 'zoon_address_hindi', '' ),
            'foot-copy'        => get_theme_mod( 'zoon_footer_copy_hindi', '' ),
        ),
        'english' => array(
            'hero-title'       => get_theme_mod( 'zoon_hero_title_english', '' ),
            'hero-desc'        => get_theme_mod( 'zoon_hero_desc_english', '' ),
            'journey-subtitle' => get_theme_mod( 'zoon_journey_milestone_english', '' ),
            'journey-desc'     => get_theme_mod( 'zoon_journey_desc_english', '' ),
            'foot-addr'        => get_theme_mod( 'zoon_address_english', '' ),
            'foot-copy'        => get_theme_mod( 'zoon_footer_copy_english', '' ),
        ),
        'marathi' => array(
            'hero-title'       => get_theme_mod( 'zoon_hero_title_marathi', '' ),
            'hero-desc'        => get_theme_mod( 'zoon_hero_desc_marathi', '' ),
            'journey-subtitle' => get_theme_mod( 'zoon_journey_milestone_marathi', '' ),
            'journey-desc'     => get_theme_mod( 'zoon_journey_desc_marathi', '' ),
            'foot-addr'        => get_theme_mod( 'zoon_address_marathi', '' ),
            'foot-copy'        => get_theme_mod( 'zoon_footer_copy_marathi', '' ),
        ),
    );
    echo "\n" . '<script id="zoon-custom-translations" type="application/json">' . json_encode( $data ) . '</script>' . "\n";
}
add_action( 'wp_footer', 'zoon_output_custom_translations_json' );

/**
 * Register Title Visibility metabox on Posts & Pages.
 */
function zoon_add_title_visibility_meta_box() {
    $screens = array( 'post', 'page' );
    foreach ( $screens as $screen ) {
        add_meta_box(
            'zoon_title_visibility_meta',
            esc_html__( 'Title Visibility Settings', 'zoon-theme' ),
            'zoon_title_visibility_meta_box_callback',
            $screen,
            'side',
            'default'
        );
    }
}
add_action( 'add_meta_boxes', 'zoon_add_title_visibility_meta_box' );

/**
 * Metabox Callback.
 */
function zoon_title_visibility_meta_box_callback( $post ) {
    wp_nonce_field( 'zoon_save_title_visibility_meta', 'zoon_title_visibility_meta_nonce' );
    $value = get_post_meta( $post->ID, '_zoon_hide_title', true );
    ?>
    <p>
        <label for="zoon_hide_title_field">
            <input type="checkbox" id="zoon_hide_title_field" name="zoon_hide_title_field" value="yes" <?php checked( $value, 'yes' ); ?> />
            <strong><?php esc_html_e( 'Hide title on frontend', 'zoon-theme' ); ?></strong>
        </label>
    </p>
    <p class="description">
        <?php esc_html_e( 'Checking this will hide the title header from rendering on the single post/page view.', 'zoon-theme' ); ?>
    </p>
    <?php
}

/**
 * Save Metabox Value.
 */
function zoon_save_title_visibility_meta( $post_id ) {
    if ( ! isset( $_POST['zoon_title_visibility_meta_nonce'] ) ) {
        return;
    }
    if ( ! wp_verify_nonce( $_POST['zoon_title_visibility_meta_nonce'], 'zoon_save_title_visibility_meta' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['zoon_hide_title_field'] ) && $_POST['zoon_hide_title_field'] === 'yes' ) {
        update_post_meta( $post_id, '_zoon_hide_title', 'yes' );
    } else {
        delete_post_meta( $post_id, '_zoon_hide_title' );
    }
}
add_action( 'save_post', 'zoon_save_title_visibility_meta' );

/**
 * Performance: Clean WP Header of redundant tags & scripts.
 */
function zoon_clean_wp_header() {
    // Remove RSD link
    remove_action( 'wp_head', 'rsd_link' );
    // Remove Windows Live Writer link
    remove_action( 'wp_head', 'wlwmanifest_link' );
    // Remove Shortlinks
    remove_action( 'wp_head', 'wp_shortlink_wp_head', 10 );
    // Remove WordPress Generator info
    remove_action( 'wp_head', 'wp_generator' );
    // Remove DNS Prefetch for emojis
    remove_filter( 'wp_resource_hints', 'wp_resource_hints_detect_emoji', 10 );
    // Remove emoji support styles and scripts
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
}
add_action( 'init', 'zoon_clean_wp_header' );
