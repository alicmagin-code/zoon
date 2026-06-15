<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @package Zoon_Theme
 */

get_header();
?>

    <main style="padding: 10rem 5% 5rem 5%; min-height: 80vh; max-width: 1300px; margin: 0 auto; z-index: 5; position: relative;">
        
        <div class="blog-layout-grid" style="display: grid; grid-template-columns: 2.2fr 0.8fr; gap: 3rem; align-items: start;">
            
            <!-- Page Content Column -->
            <div class="page-content-column">
                <?php
                while ( have_posts() ) :
                    the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'card-outer' ); ?> style="border:1px solid var(--border-glow); border-radius:var(--radius-lg); padding:3rem; background:var(--bg-card); box-shadow:var(--shadow-lg);">
                        
                        <!-- Page Title -->
                        <h1 class="hero-title" style="font-size: clamp(1.8rem, 3.5vw, 2.8rem); line-height:1.2; margin-bottom:2rem; color:var(--text-primary); border-bottom:1px solid var(--border-color); padding-bottom:1rem;">
                            <?php the_title(); ?>
                        </h1>

                        <!-- Featured Image -->
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="page-featured-image" style="border-radius:var(--radius-md); overflow:hidden; margin-bottom:2.5rem; box-shadow:var(--shadow-md); border:1px solid var(--border-color);">
                                <?php the_post_thumbnail( 'large', array( 'style' => 'width:100%; height:auto; display:block;' ) ); ?>
                            </div>
                        <?php endif; ?>

                        <!-- Page Content Body -->
                        <div class="page-content-body" style="font-size:1.05rem; line-height:1.8; color:var(--text-secondary); display:flex; flex-direction:column; gap:1.5rem;">
                            <?php 
                            the_content();
                            
                            wp_link_pages( array(
                                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'zoon-theme' ),
                                'after'  => '</div>',
                            ) );
                            ?>
                        </div>

                    </article>
                    <?php
                endwhile; // End of the loop.
                ?>
            </div>

            <!-- Sidebar Column -->
            <aside class="blog-sidebar-column" style="background:var(--bg-card); border:1px solid var(--border-color); border-radius:var(--radius-md); padding:2rem;">
                <?php 
                if ( is_active_sidebar( 'sidebar-1' ) ) {
                    dynamic_sidebar( 'sidebar-1' );
                } else {
                    ?>
                    <section class="widget" style="margin-bottom:2.5rem;">
                        <h3 class="widget-title" style="font-size:1.15rem; margin-bottom:1rem; border-left:4px solid var(--color-primary); padding-left:0.5rem; font-family:var(--font-heading);">About ZCT</h3>
                        <p class="obj-desc" style="font-size:0.85rem; line-height:1.5;">Zoon Charitable Trust (Reg No: 04-63-025) Azamgarh (U.P.) ke under run hone wali ek social organization hai jo shiksha, health aur social welfare areas me help karti hai.</p>
                    </section>

                    <section class="widget" style="margin-bottom:2.5rem;">
                        <h3 class="widget-title" style="font-size:1.15rem; margin-bottom:1rem; border-left:4px solid var(--color-primary); padding-left:0.5rem; font-family:var(--font-heading);">Helplines</h3>
                        <div style="display:flex; flex-direction:column; gap:0.5rem; font-size:0.85rem;">
                            <span><i class="fab fa-whatsapp" style="color:#25D366; margin-right:0.5rem;"></i> +91 9795371007</span>
                            <span><i class="fas fa-envelope" style="color:var(--color-primary-light); margin-right:0.5rem;"></i> zooncharitabletrust@gmail.com</span>
                        </div>
                    </section>
                    <?php
                }
                ?>
            </aside>

        </div>

    </main>

<?php
get_footer();
