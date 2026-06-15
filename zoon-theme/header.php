<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php bloginfo( 'description' ); ?>">
    <link rel="icon" type="image/png" href="<?php echo esc_url( get_template_directory_uri() ); ?>/logo/favicon.png?v=2">
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
            if ( has_nav_menu( 'primary' ) ) {
                wp_nav_menu( array(
                    'theme_location' => 'primary',
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
