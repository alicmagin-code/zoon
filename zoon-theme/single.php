<?php
/**
 * The template for displaying all single posts.
 *
 * @package Zoon_Theme
 */

get_header();
?>

    <main style="padding: 10rem 5% 5rem 5%; min-height: 80vh; max-width: 1300px; margin: 0 auto; z-index: 5; position: relative;">
        
        <div class="blog-layout-grid" style="display: grid; grid-template-columns: 2.2fr 0.8fr; gap: 3rem; align-items: start;">
            
            <!-- Post Detail Column -->
            <div class="post-detail-column">
                <?php
                while ( have_posts() ) :
                    the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'card-outer' ); ?> style="border:1px solid var(--border-glow); border-radius:var(--radius-lg); padding:3rem; background:var(--bg-card); box-shadow:var(--shadow-lg);">
                        
                        <!-- Post Meta Header -->
                        <div class="post-meta-header" style="font-size:0.8rem; font-weight:600; color:var(--color-primary-light); margin-bottom:1rem; text-transform:uppercase; display:flex; gap:1rem; align-items:center;">
                            <span><?php the_category(', '); ?></span>
                            <span>&bull;</span>
                            <span><?php echo get_the_date(); ?></span>
                        </div>

                        <!-- Post Title -->
                        <h1 class="hero-title" style="font-size: clamp(1.8rem, 3.5vw, 2.8rem); line-height:1.2; margin-bottom:1.5rem; color:var(--text-primary);">
                            <?php the_title(); ?>
                        </h1>

                        <!-- Author Card Info -->
                        <div class="author-meta-row" style="display:flex; align-items:center; gap:0.75rem; margin-bottom:2.5rem; border-bottom:1px solid var(--border-color); padding-bottom:1.5rem;">
                            <div class="author-avatar" style="width:36px; height:36px; border-radius:50%; background:var(--gradient-accent); display:flex; align-items:center; justify-content:center; color:#fff; font-weight:700; font-size:0.9rem;">
                                <?php echo esc_html( strtoupper( substr( get_the_author(), 0, 1 ) ) ); ?>
                            </div>
                            <div style="font-size:0.85rem;">
                                <span class="ci-label" style="display:block; font-size:0.7rem; color:var(--text-muted);">WRITTEN BY</span>
                                <span style="font-weight:700; color:var(--text-primary);"><?php the_author(); ?></span>
                            </div>
                        </div>

                        <!-- Featured Image -->
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="post-featured-image" style="border-radius:var(--radius-md); overflow:hidden; margin-bottom:2.5rem; box-shadow:var(--shadow-md); border:1px solid var(--border-color);">
                                <?php the_post_thumbnail( 'large', array( 'style' => 'width:100%; height:auto; display:block;' ) ); ?>
                            </div>
                        <?php endif; ?>

                        <!-- Post Content Body -->
                        <div class="post-content-body" style="font-size:1.05rem; line-height:1.8; color:var(--text-secondary); display:flex; flex-direction:column; gap:1.5rem;">
                            <?php 
                            the_content();
                            
                            wp_link_pages( array(
                                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'zoon-theme' ),
                                'after'  => '</div>',
                            ) );
                            ?>
                        </div>

                        <!-- Post Tags / Share -->
                        <?php if ( has_tag() ) : ?>
                            <div class="post-tags-row" style="margin-top:3rem; padding-top:1.5rem; border-top:1px solid var(--border-color); display:flex; flex-wrap:wrap; gap:0.5rem; align-items:center;">
                                <span class="ci-label" style="font-size:0.8rem; margin-right:0.5rem;"><i class="fas fa-tags"></i> Tags:</span>
                                <?php the_tags( '', ' ' ); ?>
                            </div>
                        <?php endif; ?>

                    </article>

                    <!-- Post Navigation -->
                    <div class="post-navigation-links" style="display:flex; justify-content:space-between; margin-top:3rem; gap:1.5rem;">
                        <div class="nav-prev" style="max-width:48%;">
                            <?php previous_post_link( '%link', '<i class="fas fa-arrow-left" style="margin-right:0.5rem;"></i> %title' ); ?>
                        </div>
                        <div class="nav-next" style="max-width:48%; text-align:right;">
                            <?php next_post_link( '%link', '%title <i class="fas fa-arrow-right" style="margin-left:0.5rem;"></i>' ); ?>
                        </div>
                    </div>

                    <!-- Comments Section -->
                    <?php
                    if ( comments_open() || get_comments_number() ) :
                        comments_template();
                    endif;

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
