    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-column">
                <div class="footer-logo-title"><?php bloginfo( 'name' ); ?></div>
                <div class="footer-logo-subtitle"><?php bloginfo( 'description' ); ?></div>
                <p data-i18n="foot-desc">
                    Azamgarh UP ke Sarai Mir se shuru hui yeh koshish aaj rashtriya star par zarooratmand logon ki madad
                    kar rahi hai. Shiksha aur swasthya ko har shakhs tak pahunchana hamara vishwas hai.
                </p>
            </div>

            <div class="footer-column">
                <h4 class="footer-title" data-i18n="foot-quick">Quick Links</h4>
                <?php 
                if ( has_nav_menu( 'footer' ) ) {
                    wp_nav_menu( array(
                        'theme_location' => 'footer',
                        'container'      => 'div',
                        'container_class'=> 'footer-links',
                        'fallback_cb'    => false,
                        'depth'          => 1,
                    ) );
                } else {
                    ?>
                    <div class="footer-links">
                        <a href="<?php echo is_front_page() ? '#hero' : esc_url( home_url( '/#hero' ) ); ?>"><i class="fas fa-angle-right"></i> Home</a>
                        <a href="<?php echo is_front_page() ? '#about' : esc_url( home_url( '/#about' ) ); ?>"><i class="fas fa-angle-right"></i> HQ Registration</a>
                        <a href="<?php echo is_front_page() ? '#pillars' : esc_url( home_url( '/#pillars' ) ); ?>"><i class="fas fa-angle-right"></i> Core Sectors</a>
                        <a href="<?php echo is_front_page() ? '#objectives' : esc_url( home_url( '/#objectives' ) ); ?>"><i class="fas fa-angle-right"></i> 14 Objectives</a>
                        <a href="<?php echo is_front_page() ? '#calculator' : esc_url( home_url( '/#calculator' ) ); ?>"><i class="fas fa-angle-right"></i> Impact Simulator</a>
                    </div>
                    <?php
                }
                ?>
            </div>

            <div class="footer-column">
                <h4 class="footer-title" data-i18n="foot-help">Help Links</h4>
                <div class="footer-links">
                    <a href="<?php echo is_front_page() ? '#gallery' : esc_url( home_url( '/#gallery' ) ); ?>"><i class="fas fa-angle-right"></i> Campaign Gallery</a>
                    <a href="<?php echo is_front_page() ? '#team' : esc_url( home_url( '/#team' ) ); ?>"><i class="fas fa-angle-right"></i> Executive Board</a>
                    <a href="<?php echo is_front_page() ? '#contact' : esc_url( home_url( '/#contact' ) ); ?>"><i class="fas fa-angle-right"></i> Contact Us</a>
                    <a href="<?php echo is_front_page() ? '#contact' : esc_url( home_url( '/#contact' ) ); ?>"><i class="fas fa-angle-right"></i> Volunteer Register</a>
                    <a href="<?php echo is_front_page() ? '#contact' : esc_url( home_url( '/#contact' ) ); ?>"><i class="fas fa-angle-right"></i> Donation Methods</a>
                </div>
            </div>

            <div class="footer-column">
                <h4 class="footer-title" data-i18n="foot-hq">HQ Office</h4>
                <div class="footer-contact-list">
                    <div class="footer-contact-item">
                        <i class="fas fa-location-dot"></i>
                        <span><?php echo esc_html( get_theme_mod( 'zoon_address', 'Railway Station Road, Sarai Mir, Azamgarh, Uttar Pradesh, PIN: 276305' ) ); ?></span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="fas fa-phone"></i>
                        <span><?php 
                            $p1 = get_theme_mod( 'zoon_phone_1', '9795371007' );
                            $p2 = get_theme_mod( 'zoon_phone_2', '9278371007' );
                            echo esc_html( "$p1, $p2" ); 
                        ?></span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="fas fa-building-flag"></i>
                        <span>Office Contact: <?php echo esc_html( get_theme_mod( 'zoon_phone_office', '7860671007' ) ); ?></span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="fas fa-envelope"></i>
                        <?php $email = get_theme_mod( 'zoon_email', 'zooncharitabletrust@gmail.com' ); ?>
                        <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div>
                <?php echo wp_kses_post( get_theme_mod( 'zoon_footer_copy', '&copy; 2026 Zoon Charitable Trust. All Rights Reserved. Reg No. 04-63-025.' ) ); ?>
            </div>
            <div class="footer-bottom-links">
                <a href="#" data-i18n="foot-privacy">Privacy Policy</a>
                <a href="#" data-i18n="foot-terms">Terms of Use</a>
                <a href="#" data-i18n="foot-audits">HQ Audits</a>
            </div>
        </div>
    </footer>

    <!-- Document Modal (Privacy, Terms, Audits) -->
    <div class="document-modal" id="document-modal">
        <div class="doc-modal-content">
            <button class="doc-modal-close" aria-label="Close Document Modal">&times;</button>
            <h3 class="doc-modal-title" id="doc-modal-title">Document Title</h3>
            <div class="doc-modal-body" id="doc-modal-body">
                <!-- Injected dynamically -->
            </div>
        </div>
    </div>

    <!-- 3D Lightbox Modal -->
    <div class="lightbox">
        <div class="lightbox-content">
            <button class="lightbox-close" aria-label="Close Lightbox">&times;</button>
            <img src="" alt="Zoomed Activity" class="lightbox-img">
            <div class="lightbox-caption">Zoomed Activity Detail</div>
        </div>
    </div>

    <!-- 3D Channel Selector Modal -->
    <div class="channel-modal" id="channel-modal">
        <div class="channel-modal-content" id="channel-modal-content">
            <h3 class="channel-modal-title" data-i18n="mod-title">Send Message</h3>
            <p class="channel-modal-desc" data-i18n="mod-desc">Aap apna sandesh kis madhyam se bhejna chahte hain?</p>
            <div class="channel-modal-textarea-wrap">
                <label for="modal-message-edit" data-i18n="mod-review-lbl">Review / Edit Message</label>
                <textarea id="modal-message-edit" class="channel-modal-textarea"
                    placeholder="Aapka sandesh..."></textarea>
            </div>
            <div class="channel-btns-grid">
                <button class="channel-btn btn-channel-whatsapp" id="btn-send-whatsapp" data-i18n="mod-btn-wa">
                    <i class="fab fa-whatsapp"></i> WhatsApp Direct
                </button>
                <button class="channel-btn btn-channel-telegram" id="btn-send-telegram" data-i18n="mod-btn-tg">
                    <i class="fab fa-telegram"></i> Telegram Chat
                </button>
                <button class="channel-btn btn-channel-email" id="btn-send-email" data-i18n="mod-btn-em">
                    <i class="fas fa-envelope"></i> Email (Mailto)
                </button>
            </div>
            <button class="close-channel-modal" id="btn-close-channel-modal" data-i18n="mod-btn-cancel">Cancel</button>
        </div>
    </div>

    <?php wp_footer(); ?>
</body>
</html>
