<?php
/**
 * The template for displaying the front page.
 *
 * @package Zoon_Theme
 */

// If visitor explicitly asks for blog, delegate to index.php
if ( isset( $_GET['blog'] ) ) {
    include get_query_template( 'index' );
    return;
}

get_header();

// Fetch customizer options
$hero_title = get_theme_mod( 'zoon_hero_title', 'Sewa, Shiksha aur Swasthya Ka Sankalp' );
$hero_desc  = get_theme_mod( 'zoon_hero_desc', 'Zoon Charitable Trust (Z.C.T) Azamgarh (U.P.) ke zariye samaj ke sabhi yateem, besahara, aur zarooratmand bhai-behnoko unki buniyadi zarooraten aur behtar mustaqbil (future) dene ki ek choti si koshish.' );
$reg_num    = get_theme_mod( 'zoon_reg_num', 'ZCT Reg: 04-63-025' );

$phone_1      = get_theme_mod( 'zoon_phone_1', '9795371007' );
$phone_2      = get_theme_mod( 'zoon_phone_2', '9278371007' );
$phone_office = get_theme_mod( 'zoon_phone_office', '7860671007' );
$email_addr   = get_theme_mod( 'zoon_email', 'zooncharitabletrust@gmail.com' );
$address      = get_theme_mod( 'zoon_address', 'Railway Station Road, Sarai Mir, Azamgarh, Uttar Pradesh, PIN: 276305' );
$fb_url       = get_theme_mod( 'zoon_facebook_url', 'https://www.facebook.com/zctbillionin1' );

$pdf_url = get_theme_mod( 'zoon_pdf_url' );
if ( empty( $pdf_url ) ) {
    $pdf_url = get_template_directory_uri() . '/Activities/zoon-objectives.pdf';
}

$journey_milestone = get_theme_mod( 'zoon_journey_milestone', '5 Members to 7 States' );
$journey_desc      = get_theme_mod( 'zoon_journey_desc', 'Ye safar hum 5 logon ne milkar shuru kiya tha. Is samay hum lagbhag 07 rajyon mein kaam kar rahe hain. Har zarooratmand ka sapna saakaar hoga aur samaj kalyan ke saath hi ek naye samaj ka nirman bhi hoga.' );
$journey_img       = get_theme_mod( 'zoon_journey_image' );
if ( empty( $journey_img ) ) {
    $journey_img = get_template_directory_uri() . '/Activities/zoon-dream-universe.png';
}

$bank_holder = get_theme_mod( 'zoon_bank_holder', 'Zoon Charitable Trust' );
$bank_name   = get_theme_mod( 'zoon_bank_name', 'State Bank of India' );
$bank_acc    = get_theme_mod( 'zoon_bank_acc_num', '44326838004' );
$bank_ifsc   = get_theme_mod( 'zoon_bank_ifsc', 'SBIN0011190' );
$upi_id      = get_theme_mod( 'zoon_upi_id', '9795371007zoon@sbi' );
$upi_qr      = get_theme_mod( 'zoon_upi_qr' );
if ( empty( $upi_qr ) ) {
    $upi_qr = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=upi://pay?pa=' . urlencode( $upi_id ) . '%26pn=ZOON%20CHARITABLE%20TRUST%26mc=8641%26cu=INR';
}
?>

    <!-- Hero Section -->
    <section id="hero" class="hero-section">
        <div class="hero-container">
            <div class="hero-content reveal-left">
                <div class="hero-tag" data-i18n="hero-tag">
                    <i class="fas fa-shield-halved"></i> Govt. Registered NGO (Reg: 04-63-025)
                </div>
                <h1 class="hero-title" data-i18n="hero-title">
                    <?php echo wp_kses_post( $hero_title ); ?>
                </h1>
                <p class="hero-description" data-i18n="hero-desc">
                    <?php echo esc_html( $hero_desc ); ?>
                </p>
                <div class="hero-btns">
                    <a href="#calculator" class="btn-cta" data-i18n="btn-madad">
                        <i class="fas fa-heart"></i> Madad Karein
                    </a>
                    <a href="<?php echo esc_url( $pdf_url ); ?>" target="_blank" class="btn-secondary" data-i18n="btn-pdf">
                        <i class="fas fa-file-pdf"></i> View Objectives PDF
                    </a>
                </div>

                <!-- Counter Numbers -->
                <div class="hero-stats">
                    <div class="stat-item">
                        <span class="stat-num" data-target="1500" data-suffix="+">0</span>
                        <span class="stat-label" data-i18n="stat-fed-lbl">Families Fed</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-num" data-target="500" data-suffix="+">0</span>
                        <span class="stat-label" data-i18n="stat-edu-lbl">Kids Educated</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-num" data-target="50" data-suffix="+">0</span>
                        <span class="stat-label" data-i18n="stat-health-lbl">Health Camps</span>
                    </div>
                </div>
            </div>

            <!-- 3D Interactive Canvas -->
            <div class="hero-canvas-container reveal-right">
                <canvas id="canvas-3d"></canvas>
            </div>
        </div>
    </section>

    <!-- Trust Banner -->
    <section id="about" class="trust-banner-section reveal">
        <div class="trust-banner">
            <div class="trust-badge-container">
                <div class="official-seal">
                    <i class="fas fa-award"></i>
                    <span data-i18n="seal-lbl">GOVT REG</span>
                </div>
                <div class="trust-info">
                    <div class="trust-reg-num" data-i18n="reg-num">
                        <?php echo esc_html( $reg_num ); ?>
                        <span class="badge" data-i18n="reg-badge">Official Trust</span>
                    </div>
                    <div class="trust-office-hq" data-i18n="hq-addr">
                        <i class="fas fa-location-dot"></i>
                        National Office: <?php echo esc_html( $address ); ?>
                    </div>
                </div>
            </div>
            <div class="trust-banner-actions">
                <a href="tel:<?php echo esc_attr( $phone_1 ); ?>" class="btn-secondary" data-i18n="btn-call">
                    <i class="fas fa-phone"></i> Call HQ
                </a>
                <a href="<?php echo esc_url( $pdf_url ); ?>" target="_blank" class="btn-cta" data-i18n="btn-pdf-banner">
                    <i class="fas fa-file-pdf"></i> Official PDF
                </a>
            </div>
        </div>
    </section>

    <!-- Our Journey Section -->
    <section id="journey" class="section-padding journey-section">
        <div class="journey-container">
            <div class="journey-content reveal-left">
                <span class="section-subtitle" data-i18n="journey-sub">Hamara Safar</span>
                <h2 class="section-title" data-i18n="journey-title">Our <span class="accent">Journey</span></h2>
                <h4 class="journey-milestone" data-i18n="journey-subtitle"><?php echo esc_html( $journey_milestone ); ?></h4>
                <p class="section-desc" data-i18n="journey-desc">
                    <?php echo esc_html( $journey_desc ); ?>
                </p>
                <div class="journey-stats-grid">
                    <div class="j-stat-item">
                        <i class="fas fa-users-line"></i>
                        <div>
                            <span class="j-stat-num">5</span>
                            <span class="j-stat-lbl" data-i18n="journey-stat-founders">Founding Members</span>
                        </div>
                    </div>
                    <div class="j-stat-item">
                        <i class="fas fa-map-location-dot"></i>
                        <div>
                            <span class="j-stat-num">7+</span>
                            <span class="j-stat-lbl" data-i18n="journey-stat-states">Active States</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="journey-visual reveal-right">
                <div class="journey-img-wrapper">
                    <img src="<?php echo esc_url( $journey_img ); ?>" alt="Zoon Trust Dream Universe Map" class="journey-img" loading="lazy" width="600" height="400">
                    <div class="journey-img-glow"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Pillars Section -->
    <section id="pillars" class="section-padding">
        <div class="section-header reveal">
            <span class="section-subtitle" data-i18n="sec-sub">Hamare Karyakshetra</span>
            <h2 class="section-title" data-i18n="sec-title">Focus <span class="accent">Sectors</span></h2>
            <p class="section-desc" data-i18n="sec-desc">Zoon Charitable Trust samaj ke teen sabse ahem kshetron mein musalsal sargarmi (activity) se kaam kar rahi hai:</p>
        </div>

        <div class="pillars-grid">
            <!-- Education -->
            <div class="pillar-card-wrapper reveal">
                <div class="pillar-card">
                    <div class="pillar-img-container">
                        <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/Activities/awareness-campaign.jpg" alt="ZCT Education Campaign" loading="lazy" width="400" height="250">
                        <div class="pillar-img-overlay"></div>
                        <div class="pillar-icon-badge">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                    </div>
                    <div class="pillar-content">
                        <h3 class="pillar-title" data-i18n="sec1-title">Education (Taleem)</h3>
                        <p class="pillar-desc" data-i18n="sec1-desc">
                            Humara maqsad hai ki koi bhi bacha paise ki tangi ki wajah se taleem se mehroom na rahe. Iske liye hum nishulk shiksha ke saath buniyadi cheezein distribute karte hain.
                        </p>
                        <ul class="pillar-list">
                            <li data-i18n="sec1-l1"><i class="fas fa-chevron-right"></i> Gareeb & yateem bachon ki school fees support</li>
                            <li data-i18n="sec1-l2"><i class="fas fa-chevron-right"></i> Bags, Books aur Stationery distribution</li>
                            <li data-i18n="sec1-l3"><i class="fas fa-chevron-right"></i> Career counseling camps gaon-dehat mein</li>
                        </ul>
                    </div>
                </div>
            </div>
 
            <!-- Healthcare -->
            <div class="pillar-card-wrapper reveal" style="transition-delay: 0.1s;">
                <div class="pillar-card">
                    <div class="pillar-img-container">
                        <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/Activities/medical-campaign.jpg" alt="ZCT Medical Camp" loading="lazy" width="400" height="250">
                        <div class="pillar-img-overlay"></div>
                        <div class="pillar-icon-badge">
                            <i class="fas fa-briefcase-medical"></i>
                        </div>
                    </div>
                    <div class="pillar-content">
                        <h3 class="pillar-title" data-i18n="sec2-title">Healthcare (Sehat)</h3>
                        <p class="pillar-desc" data-i18n="sec2-desc">
                            ZCT rural areas aur gareeb bastiyon mein swasthya sevaen (medical facilities) pahunchane aur logon ko bimariyon se bachane ke liye camps aayojit karti hai.
                        </p>
                        <ul class="pillar-list">
                            <li data-i18n="sec2-l1"><i class="fas fa-chevron-right"></i> Free Health checkup & consultation camps</li>
                            <li data-i18n="sec2-l2"><i class="fas fa-chevron-right"></i> Zarooratmand logon ko muft dawaiyan</li>
                            <li data-i18n="sec2-l3"><i class="fas fa-chevron-right"></i> Emergency medical financial support</li>
                        </ul>
                    </div>
                </div>
            </div>
 
            <!-- Social Welfare -->
            <div class="pillar-card-wrapper reveal" style="transition-delay: 0.2s;">
                <div class="pillar-card">
                    <div class="pillar-img-container">
                        <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/Activities/kambal-vitran-samaroh.jpeg" alt="ZCT Blanket Distribution" loading="lazy" width="400" height="250">
                        <div class="pillar-img-overlay"></div>
                        <div class="pillar-icon-badge">
                            <i class="fas fa-hands-holding"></i>
                        </div>
                    </div>
                    <div class="pillar-content">
                        <h3 class="pillar-title" data-i18n="sec3-title">Social Welfare (Kalyan)</h3>
                        <p class="pillar-desc" data-i18n="sec3-desc">
                            Gareeb parivaron ke jeewan star ko sudharne, aapaatkalin sthitiyon (disasters) mein turant rahat aur thand ke mausam mein bachav ke ahem karyakram.
                        </p>
                        <ul class="pillar-list">
                            <li data-i18n="sec3-l1"><i class="fas fa-chevron-right"></i> Sardiyon mein kambal (blanket) distribution</li>
                            <li data-i18n="sec3-l2"><i class="fas fa-chevron-right"></i> Ration kits distribution (Gareeb parivaron ko)</li>
                            <li data-i18n="sec3-l3"><i class="fas fa-chevron-right"></i> Disaster Relief (Baadh/Aafat ke waqt madad)</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 14 Main Objectives Section -->
    <section id="objectives" class="section-padding">
        <div class="section-header reveal">
            <span class="section-subtitle" data-i18n="obj-sub">Hamare 14 Mukhy Uddeshya</span>
            <h2 class="section-title" data-i18n="obj-title">Core <span class="accent">Objectives</span></h2>
            <p class="section-desc" data-i18n="obj-desc">Zoon Charitable Trust ke 14 pramukh lakshya (goals) jinpar hamari poori team lagatar din-raat kaam karti hai:</p>
        </div>

        <div class="objectives-container">
            <?php 
            $obj_list = array(
                array('01', 'fas fa-users', 'Samaj Kalyan', 'Social Welfare', 'Shiksha, health aur gareebi unmulan ke liye samagrah roop se kaam karna.'),
                array('02', 'fas fa-book-open', 'Nishulk Shiksha', 'Free Education', 'Gareeb aur kamzor bachon ko scholarships aur padhai ke liye financial help dena.'),
                array('03', 'fas fa-heart-pulse', 'Swasthya Seva', 'Healthcare Services', 'Medical camps lagana, bimariyon se bachav ke liye jagrukta (awareness) failana.'),
                array('04', 'fas fa-cookie-bite', 'Buniyadi Zarooraten', 'Basic Needs Support', 'Zarooratmand logon ko khana, chath (shelter), aur kapde pradan karna.'),
                array('05', 'fas fa-wheelchair', 'Samudaayik Kalyan', 'Community Care', 'Anath, buzurg, divyang aur beghar logon ki dekhbhal aur ashray ka prabandh karna.'),
                array('06', 'fas fa-tree', 'Paryavaran Sanrakshan', 'Environment Care', 'Ped lagana (plantation), pradushan kam karna, aur prakriti ki suraksha.'),
                array('07', 'fas fa-masks-theater', 'Sanskritik Karyakram', 'Cultural Events', 'Art, music, aur theater ke zariye samajik sandesh failana aur culture badhava dena.'),
                array('08', 'fas fa-scale-balanced', 'Manvadhikar', 'Human Rights', 'Har aam aur kamzor nagrik ke kanooni aur samajik adhikaaron ki hifazat karna.'),
                array('09', 'fas fa-seedling', 'Aarthik Vikas', 'Rural Development', 'Gaon dehat mein vikas, sinchai (irrigation), aur bijli/paani ki suvidha.'),
                array('10', 'fas fa-handshake-angle', 'Samajik Nyay', 'Social Justice', 'Jaati, dharam, ling ya naxl ke aadhar par hone wale bhedbhav ko samaj se mitana.'),
                array('11', 'fas fa-kit-medical', 'Aapaat Relief', 'Disaster Relief', 'Baadh, bhookamp aur toofan jaisi aafat ke waqt peediton tak turant rahat pahunchana.'),
                array('12', 'fas fa-broom', 'Samajik Seva', 'Social Service', 'Swachhta abhiyan (cleanliness drive) aur blood donation camps lagana.'),
                array('13', 'fas fa-gavel', 'Kanooni Sahayata', 'Free Legal Aid', 'Gareeb aur peedit logon ko muft kanooni salah aur nayayilay mein madad dena.'),
                array('14', 'fas fa-chart-line', 'Shodh & Vikas', 'Research & Dev.', 'Gareebi door karne aur samaj ko unnat banane ke liye naye tareeqon par shodh.')
            );
            foreach ($obj_list as $o) {
                ?>
                <div class="objective-card-wrapper reveal">
                    <div class="objective-card">
                        <span class="obj-num"><?php echo $o[0]; ?></span>
                        <div class="obj-icon"><i class="<?php echo $o[1]; ?>"></i></div>
                        <div class="obj-content">
                            <span class="obj-title-hi" data-i18n="obj-<?php echo intval($o[0]); ?>-title-hi"><?php echo $o[2]; ?></span>
                            <span class="obj-title-en" data-i18n="obj-<?php echo intval($o[0]); ?>-title-en"><?php echo $o[3]; ?></span>
                            <p class="obj-desc" data-i18n="obj-<?php echo intval($o[0]); ?>-desc"><?php echo $o[4]; ?></p>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </section>

    <!-- Donation Impact Calculator Section -->
    <section id="calculator" class="section-padding calculator-section">
        <div class="calc-container">
            <div class="calc-info reveal-left">
                <span class="section-subtitle" data-i18n="calc-sub">Interactive Impact Simulator</span>
                <h2 class="section-title" data-i18n="calc-title">Aapki Choti Si Madad, <br><span class="accent">Bada Badlav</span></h2>
                <p class="section-desc" data-i18n="calc-desc">
                    Zoon Charitable Trust ke transparent impact calculator se dekhein ki aapka ek chota sa yogdan kitne logon ke jeewan mein khushiyan la sakta hai.
                </p>
                <p data-i18n="calc-more-desc">
                    Hamare dwara distribute kiye jaane wale har kit ki audit reporting public hoti hai. Aap apni donation ka status aur distribution videos WhatsApp ke zariye mangwa sakte hain.
                </p>
                <div class="contact-info-item">
                    <div class="ci-icon"><i class="fas fa-circle-check"></i></div>
                    <div class="ci-content">
                        <span class="ci-value" style="font-weight:700; color:var(--text-primary);" data-i18n="calc-badge-title">100% Direct Impact Verification</span>
                        <p class="obj-desc" style="margin:0;" data-i18n="calc-badge-desc">Jahan aapka paisa sidhe zarooratmand tak pahunchta hai.</p>
                    </div>
                </div>
            </div>

            <!-- Interactive Calculator Box -->
            <div class="calc-box reveal-right">
                <h3 class="pillar-title" style="margin-bottom: 0.5rem; text-align:center;" data-i18n="calc-box-title">Impact Simulator</h3>
                <p class="obj-desc" style="text-align: center; margin-bottom: 1.5rem;" data-i18n="calc-box-desc">Select program & scroll multiplier to view impact</p>

                <div class="calc-types">
                    <button class="calc-type-btn active" data-type="ration" data-i18n="calc-ration-lbl">
                        <i class="fas fa-bowl-food"></i>
                        <span>Ration Kit</span>
                    </button>
                    <button class="calc-type-btn" data-type="blanket" data-i18n="calc-blanket-lbl">
                        <i class="fas fa-bed"></i>
                        <span>Blanket Kit</span>
                    </button>
                    <button class="calc-type-btn" data-type="school" data-i18n="calc-school-lbl">
                        <i class="fas fa-pencil"></i>
                        <span>School Kit</span>
                    </button>
                </div>

                <div class="calc-input-group">
                    <div class="calc-label-row">
                        <span class="calc-label" data-i18n="calc-mult-lbl">Donation Multiplier</span>
                        <span class="calc-amt-display">₹7,500</span>
                    </div>
                    <div class="range-slider-wrapper">
                        <input type="range" class="calc-slider" min="1" max="30" value="5">
                    </div>
                </div>

                <div class="calc-output">
                    <div class="calc-metric">
                        <span id="calc-people" class="calc-metric-num">25</span>
                        <span id="calc-label-people" class="calc-metric-label">Logon ko Khana</span>
                    </div>
                    <div class="calc-metric">
                        <span id="calc-days" class="calc-metric-num">5</span>
                        <span id="calc-label-units" class="calc-metric-label">Parivaron ko Ration</span>
                    </div>
                </div>

                <button class="btn-cta" data-i18n="calc-output-btn">
                    <i class="fas fa-heart-pulse"></i> Proceed to Donate / Support
                </button>
            </div>
        </div>
    </section>

    <!-- Latest Blog Feed Grid Section (NEW Premium Feature) -->
    <section id="blog-feed" class="section-padding" style="background: rgba(13, 20, 38, 0.4); border-top: 1px solid var(--border-color); border-bottom: 1px solid var(--border-color);">
        <div class="section-header reveal">
            <span class="section-subtitle">Khabrein aur Sandesh</span>
            <h2 class="section-title">Latest <span class="accent">Updates</span></h2>
            <p class="section-desc">Zoon Charitable Trust ki navintam gatividhiyon aur blogs ki updates yahan dekhein:</p>
        </div>

        <div class="latest-feed-grid reveal" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(320px, 1fr)); gap:2.5rem; max-width:1250px; margin:0 auto; padding:0 1.5rem;">
            <?php
            $feed_query = new WP_Query( array(
                'post_type'      => 'post',
                'posts_per_page' => 3,
                'ignore_sticky_posts' => true
            ) );

            if ( $feed_query->have_posts() ) {
                while ( $feed_query->have_posts() ) {
                    $feed_query->the_post();
                    ?>
                    <div class="team-card" style="display:flex; flex-direction:column; justify-content:space-between; height:100%; border:1px solid var(--border-glow); border-radius:var(--radius-md); padding:1.5rem; text-align:left; background:var(--bg-card); transition:transform var(--transition-normal);">
                        <div>
                            <?php if ( has_post_thumbnail() ) { ?>
                                <div class="blog-thumbnail" style="border-radius:var(--radius-sm); overflow:hidden; margin-bottom:1rem; aspect-ratio:16/9;">
                                    <?php the_post_thumbnail('zoon-blog-grid', array('style' => 'width:100%; height:100%; object-fit:cover;')); ?>
                                </div>
                            <?php } ?>
                            <span class="team-member-role" style="display:inline-block; font-size:0.75rem; margin-bottom:0.5rem;"><?php the_category(', '); ?></span>
                            <h3 class="pillar-title" style="font-size:1.2rem; margin:0.5rem 0; line-height:1.4;"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <p class="obj-desc" style="font-size:0.85rem; line-height:1.5; margin-bottom:1rem;"><?php echo wp_trim_words( get_the_excerpt(), 18 ); ?></p>
                        </div>
                        <div class="blog-meta-footer" style="display:flex; justify-content:space-between; align-items:center; border-top:1px solid var(--border-color); padding-top:0.75rem; font-size:0.75rem; color:var(--text-muted);">
                            <span><i class="fas fa-calendar-alt"></i> <?php echo get_the_date(); ?></span>
                            <a href="<?php the_permalink(); ?>" style="color:var(--color-primary-light); font-weight:700;">Read More <i class="fas fa-angle-right"></i></a>
                        </div>
                    </div>
                    <?php
                }
                wp_reset_postdata();
            } else {
                // Placeholder posts to preserve layout beauty out-of-the-box
                for($i=1; $i<=3; $i++) {
                    ?>
                    <div class="team-card" style="display:flex; flex-direction:column; justify-content:space-between; height:100%; border:1px solid var(--border-glow); border-radius:var(--radius-md); padding:1.5rem; text-align:left; background:var(--bg-card);">
                        <div>
                            <div class="placeholder-thumbnail" style="margin-bottom:1rem;">
                                <i class="fas fa-blog"></i>
                                <span style="font-size:0.8rem;">WordPress Blog Post Land Here</span>
                            </div>
                            <span class="team-member-role" style="font-size:0.75rem;">Sample Category</span>
                            <h3 class="pillar-title" style="font-size:1.2rem; margin:0.5rem 0;">Sample Blog Post Title #<?php echo $i; ?></h3>
                            <p class="obj-desc" style="font-size:0.85rem; line-height:1.5;">Humare official campaigns, relief drives aur trust ki nayi initiatives ki information yahan publish hogi.</p>
                        </div>
                        <div class="blog-meta-footer" style="display:flex; justify-content:space-between; align-items:center; border-top:1px solid var(--border-color); padding-top:0.75rem; font-size:0.75rem; color:var(--text-muted);">
                            <span><i class="fas fa-calendar-alt"></i> June 15, 2026</span>
                            <a href="#" style="color:var(--color-primary-light); font-weight:700;">Read More <i class="fas fa-angle-right"></i></a>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </section>

    <!-- Activities Gallery Section -->
    <section id="gallery" class="section-padding">
        <div class="section-header reveal">
            <span class="section-subtitle" data-i18n="gal-sub">Hamare Kaam Tasveeron Mein</span>
            <h2 class="section-title" data-i18n="gal-title">Campaign <span class="accent">Gallery</span></h2>
            <p class="section-desc" data-i18n="gal-desc">Zoon Charitable Trust ke alag-alag karyakramon ki kuch jhalakiyan jo hamari transparency ko darshati hain:</p>
        </div>

        <div class="gallery-filters reveal">
            <button class="filter-btn active" data-filter="all" data-i18n="f-all">All Activities</button>
            <button class="filter-btn" data-filter="welfare" data-i18n="f-welfare">Welfare & Relief</button>
            <button class="filter-btn" data-filter="health" data-i18n="f-health">Healthcare</button>
            <button class="filter-btn" data-filter="education" data-i18n="f-education">Education</button>
            <button class="filter-btn" data-filter="environment" data-i18n="f-environment">Environment</button>
            <button class="filter-btn" data-filter="office" data-i18n="f-office">HQ & Meetings</button>
        </div>

        <div class="gallery-grid reveal">
            <?php 
            $gallery_items = array(
                array('office', 'national-office.jpg', 'Office', 'cap-office', 'ZCT National Office HQ, Sarai Mir, Azamgarh, UP'),
                array('office', 'team-collage.jpg', 'Team Collage', 'cap-team-collage', 'Hamari Team Ki Ek Jhalak - Board & Committee Members'),
                array('welfare', 'punjab-flood-relief-and-women-wing.png', 'Welfare & Relief', 'cap-punjab-relief', 'Punjab Flood Relief Support (₹51,000) & Women\'s Wing Leadership'),
                array('office', 'team-patrons-and-meeting.png', 'HQ & Patrons', 'cap-patrons-meeting', 'Mohammad Jabir Azmi and Ajay Kumar Mishra at National Office'),
                array('health', 'medical-campaign.jpg', 'Healthcare', 'cap-health', 'Nishulk Swasthya Seva aur Muft Dawai Vitran Camp'),
                array('welfare', 'kambal-vitran-samaroh.jpeg', 'Social Welfare', 'cap-blanket', 'Thand Ke Mausam Mein Kambal (Blankets) Vitran Samaroh'),
                array('welfare', 'floodcampaign.jpeg', 'Disaster Relief', 'cap-flood', 'Baadh (Flood) Relief Campaign - Peediton ki Sahayata'),
                array('welfare', 'womenempowerment-honoring.jpg', 'Social Welfare', 'cap-felicit', 'Gulista Salmani ko Prashasti Patra se Honoring at ZCT Office'),
                array('education', 'awareness-campaign.jpg', 'Education', 'cap-awareness', 'Gareeb Basti Mein Shiksha Jagrukta aur Bags Distribution'),
                array('environment', 'paryavaran.jpg', 'Environment', 'cap-plant', 'Paryavaran Sanrakshan - Ped Lagao Abhiyan'),
                array('environment', 'vishva-paryavaran-divas-5-june-2026.jpeg', 'Environment', 'cap-env-day', 'World Environment Day Celebration - 5 June 2026'),
                array('office', 'meeting.jpg', 'HQ & Meetings', 'cap-meeting', 'Trust ke Ahem Uddeshya aur Future Projects par Meeting'),
                array('welfare', 'womenempowerment.jpg', 'Social Welfare', 'cap-sewing', 'Mahila Sashaktikaran - Silai/Kadhai Center Development')
            );
            foreach ($gallery_items as $item) {
                ?>
                <div class="gallery-item" data-category="<?php echo $item[0]; ?>">
                    <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/Activities/<?php echo $item[1]; ?>" alt="<?php echo esc_attr($item[2]); ?>" loading="lazy" width="400" height="300" style="width:100%; height:100%; object-fit:cover;">
                    <div class="gallery-overlay">
                        <span class="gallery-tag"><?php echo esc_html($item[2]); ?></span>
                        <span class="gallery-caption" data-i18n="<?php echo $item[3]; ?>"><?php echo esc_html($item[4]); ?></span>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </section>

    <!-- National Team Section -->
    <section id="team" class="section-padding">
        <div class="section-header reveal">
            <span class="section-subtitle" data-i18n="team-sub">Hamari Rashtriya Karyakarini</span>
            <h2 class="section-title" data-i18n="team-title">National <span class="accent">Team</span></h2>
            <p class="section-desc" data-i18n="team-desc">Zoon Charitable Trust ke karyakari sadasya jo trust ki nitiyon ko zameen par utarne mein madad karte hain:</p>
        </div>

        <div class="team-container">
            <!-- Focus Card 1 -->
            <div class="leader-focus-card reveal">
                <div class="leader-img-wrapper">
                    <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/National%20Team/Raj%20Bahadur%20Yadav%20(National%20President).jpeg" alt="Raj Bahadur" loading="lazy" width="300" height="300">
                    <span class="leader-badge" data-i18n="lead1-badge">National Executive</span>
                </div>
                <div class="leader-info">
                    <div class="leader-title-row">
                        <span class="leader-role" data-i18n="lead1-role">National President</span>
                        <span class="leader-role-hi" data-i18n="lead1-role-hi">राष्ट्रीय अध्यक्ष</span>
                        <h3 class="leader-name" data-i18n="lead1-name">Raj Bahadur</h3>
                    </div>
                    <p class="leader-quote" data-i18n="lead1-quote">
                        "Samajik utthan tabhi sambhav hai jab shiksha aur swasthya suvidhaen har nagrik tak bina kisi bhedbhav ke pahunchein."
                    </p>
                    <p class="leader-bio" data-i18n="lead1-bio">
                        Raj Bahadur, Zoon Charitable Trust (Z.C.T) ke National President hain. Unke netritva mein trust samaj ke pichhde, anath, aur besahara vargon ko aarthik aur samajik roop se sashakt banane ke liye lagatar prayasrat hai.
                    </p>
                    <div class="leader-contacts">
                        <a href="https://wa.me/91<?php echo esc_attr( $phone_1 ); ?>" target="_blank" class="leader-contact-item">
                            <i class="fab fa-whatsapp"></i> <?php echo esc_html( $phone_1 ); ?>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Focus Card 2 -->
            <div class="leader-focus-card reveal">
                <div class="leader-img-wrapper">
                    <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/National%20Team/Noorulain%20Firozy%20(National%20Secretary%20and%20Treasurer.jpeg" alt="Noorulain Firozy" loading="lazy" width="300" height="300">
                    <span class="leader-badge" data-i18n="lead2-badge">National Executive</span>
                </div>
                <div class="leader-info">
                    <div class="leader-title-row">
                        <span class="leader-role" data-i18n="lead2-role">Chief National General Secretary & Treasurer</span>
                        <span class="leader-role-hi" data-i18n="lead2-role-hi">प्रमुख राष्ट्रीय महासचिव और कोषाध्यक्ष</span>
                        <h3 class="leader-name" data-i18n="lead2-name">Noorulain Firozy</h3>
                    </div>
                    <p class="leader-quote" data-i18n="lead2-quote">
                        "Mera aur mere doston ka ek hi khwab hai ki hum apne ilake Azamgarh aur poore desh se gareebi aur taleem ki kami ko door kar sakein. Z.C.T isi disha me ek prayaas hai."
                    </p>
                    <p class="leader-bio" data-i18n="lead2-bio">
                        Noorulain Firozy (Frozy), Sarai Mir (Azamgarh) ke nivasi hain. Unhone samajik vikas aur gareebon ki aarthik madad ke liye doston ke sath milkar Zoon Charitable Trust ki sthapna ki. Wo lagatar trust ke national operations aur finance ko lead kar rahe hain.
                    </p>
                    <div class="leader-contacts">
                        <a href="https://wa.me/91<?php echo esc_attr( $phone_1 ); ?>" target="_blank" class="leader-contact-item">
                            <i class="fab fa-whatsapp"></i> <?php echo esc_html( $phone_1 ); ?>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Team Members Grid -->
            <div class="team-grid-header reveal">
                <h4 class="pillar-title" style="margin-bottom: 2rem;" data-i18n="team-grid-title">Executive Board & Working Committee</h4>
            </div>

            <div class="team-grid reveal">
                <?php 
                $team_members = array(
                    array('m3', 'Mohd.%20Jabir%20Azmi%20(National%20Patron).jpeg', 'Mohammad Jabir Azmi', 'National Patron'),
                    array('m4', 'Ajay%20Kumar%20Mishra%20(National%20Patron).jpeg', 'Ajay Kumar Mishra', 'National Patron'),
                    array('m5', 'pending', 'Mohammad Tariq Badar', 'Central Joint In-charge'),
                    array('m6', 'Heeralal%20Yadav%20-%20National%20Executive%20Chairman.jpeg', 'Hiralal Yadav', 'National Executive Pres.'),
                    array('m7', 'Haidar%20Ali%20Azmi%20-%20National%20Spokeperson.jpeg', 'Haider Ali Azmi', 'National Spokesperson'),
                    array('m8', 'Rowaifa%20Jamal%20-%20National%20Vicee%20President.jpeg', 'Rovaifa Jamal', 'National Vice President'),
                    array('m9', 'Rahul%20Singh%20(National%20Vice%20President).jpeg', 'Rahul Singh', 'National Vice President'),
                    array('m10', 'Waseem%20Quraishi%20-%20National%20Organisation%20Minister.jpeg', 'Waseem Qureshi', 'National Org. Secretary'),
                    array('m11', 'Mohd%20Yasir%20Arafat%20-%20National%20Media%20Incharge.jpeg', 'Mohammad Yasir', 'National Media In-charge'),
                    array('m12', 'Zarar%20Ahmad%20(National%20Councillor).jpeg', 'Zarar Ahmad', 'National Exec. Member'),
                    array('m13', 'pending', 'Naseem Ahmad', 'National Exec. Member'),
                    array('m14', 'pending', 'Junaid Ahmad', 'National Exec. Member'),
                    array('m15', '1%20(15).jpeg', 'Abu Qasim', 'National Exec. Member'),
                    array('m16', 'pending', 'Kuldeep Singh', 'National Exec. Member'),
                    array('m17', '1%20(17).jpeg', 'Abhay Chandra Gupta', 'National Exec. Member'),
                    array('m18', 'pending', 'Ram Sevak Yadav', 'National Exec. Member'),
                    array('m19', 'pending', 'Mohammad Faisal', 'Working Committee Member'),
                    array('m20', 'pending', 'Dr. Anjum Ara', 'Working Committee Member'),
                    array('m21', 'pending', 'Mohd Danish', 'Working Committee Member')
                );
                foreach ($team_members as $m) {
                    ?>
                    <div class="team-card">
                        <?php if ($m[1] === 'pending') { ?>
                            <div class="placeholder-thumbnail">
                                <i class="fas fa-id-card"></i>
                                <span data-i18n="cert-pending">Appointment Card Pending</span>
                            </div>
                        <?php } else { ?>
                            <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/National%20Team/<?php echo $m[1]; ?>" alt="<?php echo esc_attr($m[2]); ?>" class="team-member-img" loading="lazy" width="200" height="200">
                        <?php } ?>
                        <span class="team-member-name" data-i18n="team-<?php echo $m[0]; ?>-name"><?php echo $m[2]; ?></span>
                        <span class="team-member-role" data-i18n="team-<?php echo $m[0]; ?>-role"><?php echo $m[3]; ?></span>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Contact & Volunteer Tabs Section -->
    <section id="contact" class="section-padding contact-section">
        <div class="contact-grid">
            <div class="contact-details reveal-left">
                <div class="contact-card-info">
                    <div>
                        <span class="section-subtitle" data-i18n="con-sub">Humse Judhein</span>
                        <h3 class="pillar-title" style="margin-top:0.5rem; font-size:1.6rem;" data-i18n="con-title">Zoon Charitable Trust</h3>
                        <p class="obj-desc" data-i18n="con-desc">Aap call, WhatsApp, ya national office par direct aakar humari team se rabta kar sakte hain.</p>
                    </div>

                    <div class="contact-info-list">
                        <!-- Phone -->
                        <div class="contact-info-item">
                            <div class="ci-icon"><i class="fas fa-phone"></i></div>
                            <div class="ci-content">
                                <span class="ci-label" data-i18n="con-lbl-phone">Mobile / Call Support</span>
                                <span class="ci-value"><?php echo esc_html( "$phone_1, $phone_2" ); ?></span>
                            </div>
                        </div>

                        <!-- WhatsApp -->
                        <div class="contact-info-item">
                            <div class="ci-icon"><i class="fab fa-whatsapp"></i></div>
                            <div class="ci-content">
                                <span class="ci-label" data-i18n="con-lbl-wa">WhatsApp Helpline</span>
                                <a href="https://wa.me/91<?php echo esc_attr( $phone_1 ); ?>" target="_blank" class="ci-value" style="color:var(--color-primary-light);" data-i18n="con-val-wa">
                                    Click here to Chat on WhatsApp
                                </a>
                            </div>
                        </div>

                        <!-- Office -->
                        <div class="contact-info-item">
                            <div class="ci-icon"><i class="fas fa-building-flag"></i></div>
                            <div class="ci-content">
                                <span class="ci-label" data-i18n="con-lbl-off">Office Contact Number</span>
                                <span class="ci-value"><?php echo esc_html( $phone_office ); ?></span>
                            </div>
                        </div>

                        <!-- Location -->
                        <div class="contact-info-item">
                            <div class="ci-icon"><i class="fas fa-location-dot"></i></div>
                            <div class="ci-content">
                                <span class="ci-label" data-i18n="con-lbl-addr">National Office Address</span>
                                <span class="ci-value" data-i18n="con-val-addr"><?php echo esc_html( $address ); ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Social Icons -->
                    <div>
                        <span class="ci-label" style="display:block; margin-bottom:0.5rem;" data-i18n="con-lbl-follow">Follow Official Channels</span>
                        <div class="social-links-grid" style="margin-bottom: 0.5rem;">
                            <a href="<?php echo esc_url( $fb_url ); ?>" target="_blank" class="social-circle-link" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-circle-link" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-circle-link" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                            <a href="#" class="social-circle-link" aria-label="Twitter"><i class="fab fa-x-twitter"></i></a>
                        </div>
                        <span class="obj-desc" style="display: block; font-size: 0.75rem; color: var(--color-primary-light); font-weight: 600;" data-i18n="con-fb-info">
                            <i class="fab fa-facebook" style="margin-right:0.25rem;"></i> Followed by 2,290+ on Facebook &bull; "We Work For Humanity"
                        </span>
                    </div>

                    <!-- Helpline Banner Visual -->
                    <div style="margin-top: 1.5rem; border-radius: var(--radius-md); overflow: hidden; border: 1px solid var(--border-glow); box-shadow: var(--shadow-sm);">
                        <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/Activities/helpline-contact-banner.png" alt="ZCT Contact Helpline Info" style="width: 100%; height: auto; display: block; background: #fff; padding: 5px;">
                    </div>
                </div>
            </div>

            <!-- Dynamic Tabbed Forms -->
            <div class="form-card reveal-right">
                <div class="form-tabs">
                    <button class="form-tab-btn active" data-tab="contact" data-i18n="tab-contact">Sandesh (Contact)</button>
                    <button class="form-tab-btn" data-tab="volunteer" data-i18n="tab-volunteer">Sadasya (Volunteer)</button>
                    <button class="form-tab-btn" data-tab="donation" data-i18n="tab-donation">Bank Details</button>
                </div>

                <!-- Tab 1: Contact Form -->
                <form id="contact-form" class="form-content active">
                    <div class="form-group">
                        <input type="text" class="form-input" id="c-name" placeholder=" " required>
                        <label for="c-name" class="form-label" data-i18n="form-c-name">Aapka Naam (Your Name)</label>
                    </div>
                    <div class="form-group">
                        <input type="tel" class="form-input" id="c-phone" placeholder=" " required>
                        <label for="c-phone" class="form-label" data-i18n="form-c-phone">Phone/WhatsApp Number</label>
                    </div>
                    <div class="form-group">
                        <textarea class="form-input" id="c-msg" placeholder=" " required></textarea>
                        <label for="c-msg" class="form-label" data-i18n="form-c-msg">Sandesh / Question (Message)</label>
                    </div>
                    <button type="submit" class="btn-cta" style="margin-top:0.5rem;" data-i18n="form-c-btn">
                        <i class="fas fa-paper-plane"></i> Send Message
                    </button>
                </form>

                <!-- Tab 2: Volunteer Form -->
                <form id="volunteer-form" class="form-content">
                    <div class="form-group">
                        <input type="text" class="form-input" id="v-name" placeholder=" " required>
                        <label for="v-name" class="form-label" data-i18n="form-v-name">Aapka Naam (Full Name)</label>
                    </div>
                    <div class="form-group">
                        <input type="tel" class="form-input" id="v-phone" placeholder=" " required>
                        <label for="v-phone" class="form-label" data-i18n="form-v-phone">Phone/WhatsApp Number</label>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-input" id="v-city" placeholder=" " required>
                        <label for="v-city" class="form-label" data-i18n="form-v-city">City / Village Address</label>
                    </div>
                    <div class="form-group">
                        <textarea class="form-input" id="v-skill" placeholder=" " required></textarea>
                        <label for="v-skill" class="form-label" data-i18n="form-v-skill">Aap kis tarah se madad karna chahte hain?</label>
                    </div>
                    <button type="submit" class="btn-cta" style="margin-top:0.5rem;" data-i18n="form-v-btn">
                        <i class="fas fa-user-plus"></i> Register as Volunteer
                    </button>
                </form>

                <!-- Tab 3: Donation / Bank Info -->
                <div id="donation-form" class="form-content">
                    <p class="obj-desc" style="margin-bottom:1rem;" data-i18n="form-d-desc">
                        Zoon Charitable Trust ke ahem kshetron mein financial madad pahunchane ke liye aap direct bank transfer ya UPI ka upyog kar sakte hain. Transfer ke baad screenshot zaroor share karein.
                    </p>

                    <!-- UPI Details & QR Grid -->
                    <div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 1.5rem; margin-top: 1rem; align-items: center;">
                        <div class="contact-info-item" style="background:rgba(60, 181, 76, 0.08); border-radius:12px; padding:1.25rem; border: 1px solid var(--border-glow); height:100%; display:flex; flex-direction:column; justify-content:center; gap:0.5rem;">
                            <div style="display:flex; gap:0.75rem; align-items:center;">
                                <div class="ci-icon" style="color:var(--color-primary-light); background:rgba(60,181,76,0.15); margin:0;"><i class="fas fa-qrcode"></i></div>
                                <div>
                                    <span class="ci-label" data-i18n="form-d-upi-lbl">UPI ID</span>
                                    <span class="ci-value" style="font-family:var(--font-heading); color:var(--text-primary); font-size:1.1rem; display:block;"><?php echo esc_html( $upi_id ); ?></span>
                                </div>
                            </div>
                            <p class="obj-desc" style="font-size:0.75rem; margin:0; line-height:1.4;" data-i18n="form-d-upi-desc">
                                PhonePe, Google Pay, ya Paytm se is ID par direct transfer kar sakte hain. Transfer ke baad screenshot WhatsApp par zaroor share karein.
                            </p>
                        </div>

                        <!-- 3D QR Code Card -->
                        <div class="qr-card">
                            <div class="qr-image-wrapper">
                                <div class="qr-scanner-line"></div>
                                <img src="<?php echo esc_url( $upi_qr ); ?>" alt="UPI Scan QR Code">
                            </div>
                            <span class="qr-label" data-i18n="form-d-qr-lbl"><i class="fas fa-qrcode"></i> Scan to Donate</span>
                        </div>
                    </div>

                    <!-- Bank Details Box -->
                    <div class="bank-details-box">
                        <div class="bank-details-title" data-i18n="bank-sec-title">
                            <i class="fas fa-bank"></i> Official Bank Accounts
                        </div>
                        <div class="bank-grid">
                            <div class="bank-info-cell">
                                <span class="bank-info-label" data-i18n="bank-acc-h">Account Holder</span>
                                <span class="bank-info-val"><?php echo esc_html( $bank_holder ); ?></span>
                            </div>
                            <div class="bank-info-cell">
                                <span class="bank-info-label" data-i18n="bank-acc-n">Bank Name</span>
                                <span class="bank-info-val"><?php echo esc_html( $bank_name ); ?></span>
                            </div>
                            <div class="bank-info-cell">
                                <span class="bank-info-label" data-i18n="bank-acc-num">Account Number</span>
                                <span class="bank-info-val"><?php echo esc_html( $bank_acc ); ?></span>
                            </div>
                            <div class="bank-info-cell">
                                <span class="bank-info-label" data-i18n="bank-acc-ifsc">IFSC Code</span>
                                <span class="bank-info-val"><?php echo esc_html( $bank_ifsc ); ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Direct message option linked with calc -->
                    <form id="calc-direct-donation-form">
                        <div class="form-group" style="margin-top: 1.5rem;">
                            <textarea class="form-input" id="d-msg" placeholder=" " required>Zoon Charitable Trust ki educational/healthcare activities mein support karne ka ichhuk hoon. Bank transfer details confirm karne ke liye aage sampark karein.</textarea>
                            <label for="d-msg" class="form-label" data-i18n="form-d-notes">Donation Notes / Message</label>
                        </div>
                        <button type="submit" class="btn-cta" style="margin-top:0.5rem; width:100%; justify-content:center;" data-i18n="form-d-btn">
                            <i class="fab fa-whatsapp"></i> Confirm Donation Details on WA
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

<?php
get_footer();
