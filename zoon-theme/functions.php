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

    // Register primary navigation menu.
    register_nav_menus( array(
        'primary' => esc_html__( 'Primary Menu', 'zoon-theme' ),
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
}
add_action( 'customize_register', 'zoon_customize_register' );
