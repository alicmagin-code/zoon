<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="<?php echo esc_url( get_template_directory_uri() ); ?>/logo/favicon.png?v=2">
    
    <?php
    // Dynamic SEO Metadata
    $seo_desc = '';
    $seo_keywords = '';
    $seo_image = '';
    $seo_title = wp_get_document_title();
    $seo_url = esc_url( home_url( $_SERVER['REQUEST_URI'] ) );
    $seo_type = 'website';

    if ( is_singular() ) {
        $seo_type = 'article';
        $post_obj = get_queried_object();
        if ( $post_obj ) {
            $seo_url = get_permalink( $post_obj->ID );
            // Description
            if ( has_excerpt( $post_obj->ID ) ) {
                $seo_desc = get_the_excerpt( $post_obj->ID );
            } else {
                $content = strip_shortcodes( $post_obj->post_content );
                $content = wp_strip_all_tags( $content );
                $seo_desc = wp_trim_words( $content, 25 );
            }
            // Keywords
            $tags = get_the_tags( $post_obj->ID );
            $cats = get_the_category( $post_obj->ID );
            $keyword_array = array();
            if ( $tags ) {
                foreach ( $tags as $tag ) {
                    $keyword_array[] = $tag->name;
                }
            }
            if ( $cats ) {
                foreach ( $cats as $cat ) {
                    $keyword_array[] = $cat->name;
                }
            }
            $seo_keywords = implode( ', ', $keyword_array );
            
            // Image
            if ( has_post_thumbnail( $post_obj->ID ) ) {
                $seo_image = get_the_post_thumbnail_url( $post_obj->ID, 'zoon-single-hero' );
            }
        }
    } else {
        // Homepage / Archives
        $seo_desc = get_theme_mod( 'zoon_seo_desc', 'Zoon Charitable Trust Azamgarh (U.P.) - Sewa, Shiksha aur Swasthya Ka Sankalp. A government registered NGO working for social welfare.' );
        $seo_keywords = get_theme_mod( 'zoon_seo_keywords', 'zoon trust, zoon charitable trust, azamgarh ngo, up ngo, charity, welfare trust, education helper' );
    }

    // Fallbacks
    if ( empty( $seo_desc ) ) {
        $seo_desc = get_bloginfo( 'description' );
    }
    if ( empty( $seo_keywords ) ) {
        $seo_keywords = 'zoon trust, zoon charitable trust, azamgarh, ngo';
    }
    if ( empty( $seo_image ) ) {
        $custom_og = get_theme_mod( 'zoon_seo_og_image' );
        if ( ! empty( $custom_og ) ) {
            $seo_image = $custom_og;
        } else {
            // Check custom logo fallback
            $logo_id = get_theme_mod( 'custom_logo' );
            if ( $logo_id ) {
                $logo_data = wp_get_attachment_image_src( $logo_id, 'full' );
                if ( $logo_data ) {
                    $seo_image = $logo_data[0];
                }
            }
            // Hard fallback to theme folder logo
            if ( empty( $seo_image ) ) {
                $seo_image = get_template_directory_uri() . '/logo/logo.png';
            }
        }
    }
    ?>
    <meta name="description" content="<?php echo esc_attr( $seo_desc ); ?>">
    <meta name="keywords" content="<?php echo esc_attr( $seo_keywords ); ?>">

    <!-- Open Graph (Facebook / WhatsApp) -->
    <meta property="og:title" content="<?php echo esc_attr( $seo_title ); ?>">
    <meta property="og:description" content="<?php echo esc_attr( $seo_desc ); ?>">
    <meta property="og:type" content="<?php echo esc_attr( $seo_type ); ?>">
    <meta property="og:url" content="<?php echo esc_url( $seo_url ); ?>">
    <meta property="og:image" content="<?php echo esc_url( $seo_image ); ?>">
    <meta property="og:site_name" content="<?php bloginfo( 'name' ); ?>">

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo esc_attr( $seo_title ); ?>">
    <meta name="twitter:description" content="<?php echo esc_attr( $seo_desc ); ?>">
    <meta name="twitter:image" content="<?php echo esc_url( $seo_image ); ?>">

    <?php
    // Theme Accent Colors Dynamic Customizer Injection
    $primary_color = get_theme_mod( 'zoon_color_primary', '#3cb54c' );
    $primary_light = get_theme_mod( 'zoon_color_primary_light', '#54cc63' );
    $secondary_color = get_theme_mod( 'zoon_color_secondary', '#f36523' );
    $secondary_light = get_theme_mod( 'zoon_color_secondary_light', '#f58249' );

    // Calculate glow or opacity colors if hex is passed
    if ( ! function_exists( 'zoon_hex2rgba' ) ) {
        function zoon_hex2rgba( $color, $opacity = false ) {
            $default = 'rgb(0,0,0)';
            if ( empty( $color ) ) {
                return $default; 
            }
            if ( $color[0] == '#' ) {
                $color = substr( $color, 1 );
            }
            if ( strlen( $color ) == 6 ) {
                $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
            } elseif ( strlen( $color ) == 3 ) {
                $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
            } else {
                return $default;
            }
            $rgb = array_map( 'hexdec', $hex );
            if ( $opacity !== false ) {
                if ( abs( $opacity ) > 1 ) {
                    $opacity = 1.0;
                }
                $output = 'rgba(' . implode( ',', $rgb ) . ',' . $opacity . ')';
            } else {
                $output = 'rgb(' . implode( ',', $rgb ) . ')';
            }
            return $output;
        }
    }

    $border_glow = zoon_hex2rgba( $primary_color, 0.3 );
    $primary_glow = zoon_hex2rgba( $primary_color, 0.5 );
    $secondary_glow = zoon_hex2rgba( $secondary_color, 0.4 );
    $primary_orb = zoon_hex2rgba( $primary_color, 0.25 );
    $secondary_orb = zoon_hex2rgba( $secondary_color, 0.25 );
    ?>
    <style type="text/css">
        :root, body, body.dark-theme, body.light-theme {
            --color-primary: <?php echo esc_html( $primary_color ); ?> !important;
            --color-primary-light: <?php echo esc_html( $primary_light ); ?> !important;
            --color-primary-glow: <?php echo esc_html( $primary_glow ); ?> !important;
            --color-secondary: <?php echo esc_html( $secondary_color ); ?> !important;
            --color-secondary-light: <?php echo esc_html( $secondary_light ); ?> !important;
            --color-secondary-glow: <?php echo esc_html( $secondary_glow ); ?> !important;
            --border-glow: <?php echo esc_html( $border_glow ); ?> !important;
            --glow-effect: 0 0 25px <?php echo esc_html( $primary_glow ); ?> !important;
            --glow-secondary: 0 0 25px <?php echo esc_html( $secondary_glow ); ?> !important;
        }
        /* Update orb colors dynamically too */
        .orb-1 { background: <?php echo esc_html( $primary_orb ); ?> !important; }
        .orb-2 { background: <?php echo esc_html( $secondary_orb ); ?> !important; }
        .orb-3 { background: <?php echo esc_html( $primary_orb ); ?> !important; }
        
        /* Interactive dynamic scrollbar thumb */
        body::-webkit-scrollbar-thumb {
            background-color: <?php echo esc_html( $primary_color ); ?>;
        }
        body::-webkit-scrollbar-thumb:hover {
            background-color: <?php echo esc_html( $primary_light ); ?>;
        }
    </style>

    <?php wp_head(); ?>
</head>
<body <?php body_class( 'dark-theme' ); ?>>
    <?php wp_body_open(); ?>

    <!-- Glowing Orbs Background (Theme Responsive) -->
    <div class="background-wrapper">
        <div class="grid-overlay"></div>
        <div class="glow-orb orb-1"></div>
        <div class="glow-orb orb-2"></div>
        <div class="glow-orb orb-3"></div>
    </div>

    <!-- Glassmorphic Header -->
    <header>
        <div class="logo-container">
            <?php 
            if ( has_custom_logo() ) {
                the_custom_logo();
            } else {
                ?>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/logo/logo.png?v=2" alt="<?php bloginfo( 'name' ); ?>" class="logo-img">
                </a>
                <?php
            }
            ?>
            <div class="logo-text">
                <span class="logo-title"><?php bloginfo( 'name' ); ?></span>
                <span class="logo-subtitle"><?php bloginfo( 'description' ); ?></span>
            </div>
        </div>

        <nav>
            <?php 
            $has_primary = has_nav_menu( 'primary' );
            $menus = wp_get_nav_menus();
            
            if ( $has_primary ) {
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'container'      => 'div',
                    'container_class'=> 'nav-links',
                    'fallback_cb'    => false,
                    'depth'          => 1,
                ) );
            } elseif ( ! empty( $menus ) ) {
                // Auto-fallback: use the first menu registered in the DB
                wp_nav_menu( array(
                    'menu'           => $menus[0]->term_id,
                    'container'      => 'div',
                    'container_class'=> 'nav-links',
                    'fallback_cb'    => false,
                    'depth'          => 1,
                ) );
            } else {
                // Out-of-the-box fallback navigation matching the static site sections
                ?>
                <div class="nav-links">
                    <a href="<?php echo is_front_page() ? '#hero' : esc_url( home_url( '/#hero' ) ); ?>" class="active" data-i18n="nav-home">Home</a>
                    <a href="<?php echo is_front_page() ? '#about' : esc_url( home_url( '/#about' ) ); ?>" data-i18n="nav-reg">Reg & Info</a>
                    <a href="<?php echo is_front_page() ? '#pillars' : esc_url( home_url( '/#pillars' ) ); ?>" data-i18n="nav-sectors">Sectors</a>
                    <a href="<?php echo is_front_page() ? '#objectives' : esc_url( home_url( '/#objectives' ) ); ?>" data-i18n="nav-objectives">Objectives</a>
                    <a href="<?php echo is_front_page() ? '#calculator' : esc_url( home_url( '/#calculator' ) ); ?>" data-i18n="nav-impact">Impact</a>
                    <a href="<?php echo is_front_page() ? '#gallery' : esc_url( home_url( '/#gallery' ) ); ?>" data-i18n="nav-gallery">Activities</a>
                    <a href="<?php echo is_front_page() ? '#team' : esc_url( home_url( '/#team' ) ); ?>" data-i18n="nav-team">Team</a>
                    <a href="<?php echo is_front_page() ? '#contact' : esc_url( home_url( '/#contact' ) ); ?>" data-i18n="nav-contact">Contact</a>
                    <?php 
                    $posts_page_id = get_option( 'page_for_posts' );
                    $blog_url = $posts_page_id ? get_permalink( $posts_page_id ) : esc_url( home_url( '/?blog=1' ) );
                    ?>
                    <a href="<?php echo esc_url( $blog_url ); ?>">Blog Feed</a>
                </div>
                <?php
            }
            ?>
            <div class="header-actions">
                <!-- Translation Dropdown -->
                <div class="lang-selector-container">
                    <button class="lang-btn" aria-label="Select Language">
                        <i class="fas fa-language"></i>
                        <span class="current-lang">Roman</span>
                        <i class="fas fa-chevron-down" style="font-size: 0.6rem;"></i>
                    </button>
                    <div class="lang-dropdown">
                        <button data-lang="roman">Roman (Hinglish)</button>
                        <button data-lang="hindi">हिन्दी (Hindi)</button>
                        <button data-lang="english">English</button>
                        <button data-lang="marathi">मराठी (Marathi)</button>
                    </div>
                </div>
                <!-- Theme Toggle -->
                <button class="theme-toggle-btn" aria-label="Toggle Theme">
                    <i class="fas fa-moon"></i>
                    <i class="fas fa-sun"></i>
                </button>
                <!-- CTA Button -->
                <a href="<?php echo is_front_page() ? '#calculator' : esc_url( home_url( '/#calculator' ) ); ?>" class="btn-cta">
                    <i class="fas fa-heart"></i> Donate Now
                </a>
            </div>
        </nav>

        <button class="hamburger" aria-label="Open Menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </header>
