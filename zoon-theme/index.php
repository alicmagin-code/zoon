<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @package Zoon_Theme
 */

get_header();
?>

    <!-- Main Content wrapper with padding to push below floating header -->
    <main style="padding: 10rem 5% 5rem 5%; min-height: 80vh; max-width: 1300px; margin: 0 auto; z-index: 5; position: relative;">
        
        <!-- Header -->
        <div class="section-header reveal active" style="margin-bottom: 4rem; text-align: center;">
            <span class="section-subtitle">Zoon Updates & Articles</span>
            <h2 class="section-title">Blog <span class="accent">Feed</span></h2>
            <p class="section-desc">Trust ke regular campaigns, relief drives aur social welfare updates yahan read karein.</p>
        </div>

        <div class="blog-layout-grid" style="display: grid; grid-template-columns: 2.2fr 0.8fr; gap: 3rem; align-items: start;">
            
            <!-- Feed Grid Column -->
            <div class="blog-feed-column">
                <?php if ( have_posts() ) : ?>
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 2.5rem; margin-bottom: 3.5rem;">
                        <?php 
                        while ( have_posts() ) :
                            the_post();
                            ?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class( 'team-card' ); ?> style="display:flex; flex-direction:column; justify-content:space-between; height:100%; border:1px solid var(--border-glow); border-radius:var(--radius-md); padding:1.5rem; text-align:left; background:var(--bg-card); transition:transform var(--transition-normal);">
                                <div>
                                    <?php if ( has_post_thumbnail() ) { ?>
                                        <div class="blog-thumbnail" style="border-radius:var(--radius-sm); overflow:hidden; margin-bottom:1rem; aspect-ratio:16/9;">
                                            <?php the_post_thumbnail('medium_large', array('style' => 'width:100%; height:100%; object-fit:cover;')); ?>
                                        </div>
                                    <?php } else { ?>
                                        <div class="placeholder-thumbnail" style="margin-bottom:1rem;">
                                            <i class="fas fa-image" style="font-size:1.5rem; color:var(--color-primary-light); opacity:0.6;"></i>
                                            <span style="font-size:0.8rem;">No Featured Image</span>
                                        </div>
                                    <?php } ?>

                                    <div class="blog-meta-header" style="font-size: 0.75rem; color: var(--color-primary-light); margin-bottom: 0.5rem; font-weight: 600;">
                                        <?php the_category(', '); ?>
                                    </div>
                                    
                                    <h3 class="pillar-title" style="font-size: 1.25rem; margin: 0.5rem 0; line-height: 1.4;">
                                        <a href="<?php the_permalink(); ?>" style="color:var(--text-primary); transition:color var(--transition-fast);"><?php the_title(); ?></a>
                                    </h3>
                                    
                                    <p class="obj-desc" style="font-size: 0.85rem; line-height: 1.5; margin-bottom: 1.5rem; color:var(--text-secondary);">
                                        <?php echo wp_trim_words( get_the_excerpt(), 22 ); ?>
                                    </p>
                                </div>
                                
                                <div class="blog-meta-footer" style="display:flex; justify-content:space-between; align-items:center; border-top:1px solid var(--border-color); padding-top:0.75rem; font-size:0.75rem; color:var(--text-muted);">
                                    <span><i class="fas fa-calendar-alt" style="margin-right:0.25rem;"></i> <?php echo get_the_date(); ?></span>
                                    <a href="<?php the_permalink(); ?>" style="color:var(--color-primary-light); font-weight:700; display:flex; align-items:center; gap:0.25rem;">Read Full <i class="fas fa-angle-right"></i></a>
                                </div>
                            </article>
                            <?php
                        endwhile;
                        ?>
                    </div>

                    <!-- Dynamic Pagination -->
                    <div class="blog-pagination" style="display:flex; justify-content:center; gap:0.75rem; margin-top:2rem;">
                        <?php
                        echo paginate_links( array(
                            'prev_text' => '<i class="fas fa-chevron-left"></i>',
                            'next_text' => '<i class="fas fa-chevron-right"></i>',
                            'type'      => 'plain',
                        ) );
                        ?>
                    </div>

                <?php else : ?>
                    <div class="card-outer" style="padding:4rem 2rem; text-align:center; border: 1px dashed var(--border-glow); border-radius:var(--radius-md);">
                        <i class="fas fa-folder-open" style="font-size:3rem; color:var(--color-primary-light); margin-bottom:1rem; opacity:0.6;"></i>
                        <h3 class="pillar-title">No Posts Found</h3>
                        <p class="obj-desc">Humare pass is samay koi blog post available nahi hai. Kripya baad mein check karein.</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar Column -->
            <aside class="blog-sidebar-column" style="background:var(--bg-card); border:1px solid var(--border-color); border-radius:var(--radius-md); padding:2rem;">
                <?php 
                if ( is_active_sidebar( 'sidebar-1' ) ) {
                    dynamic_sidebar( 'sidebar-1' );
                } else {
                    // Out-of-the-box fallback sidebar
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
