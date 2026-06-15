/* ==========================================================================
   ZOON CHARITABLE TRUST (Z.C.T) - Interactive JavaScript
   Includes: 3D Canvas Globe, 3D Card Tilt, Calculator, Gallery, and Animations
   ========================================================================== */

document.addEventListener('DOMContentLoaded', () => {
    const initSubsystem = (name, fn) => {
        try {
            fn();
            console.log(`Subsystem initialized: ${name}`);
        } catch (e) {
            console.error(`Error initializing subsystem ${name}:`, e);
        }
    };

    // Initialize All Subsystems safely
    initSubsystem('Theme', initTheme);
    initSubsystem('Language', initLanguage);
    initSubsystem('MobileNav', initMobileNav);
    initSubsystem('ScrollReveal', initScrollReveal);
    initSubsystem('StatsCounter', initStatsCounter);
    initSubsystem('3DGlobe', init3DGlobe);
    initSubsystem('3DTilt', init3DTilt);
    initSubsystem('MouseParallax', initMouseParallax);
    initSubsystem('ImpactCalculator', initImpactCalculator);
    initSubsystem('Gallery', initGallery);
    initSubsystem('FormTabs', initFormTabs);
    initSubsystem('ContactForms', initContactForms);
    initSubsystem('DocModal', initDocModal);
});

/* ==========================================================================
   1. Theme Management (Dark / Light Mode)
   ========================================================================== */
function initTheme() {
    const themeBtn = document.querySelector('.theme-toggle-btn');
    if (!themeBtn) return;

    // Check saved theme or system preference
    const savedTheme = localStorage.getItem('zoon-theme');
    const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

    if (savedTheme === 'light' || (!savedTheme && !systemPrefersDark)) {
        document.body.classList.add('light-theme');
        document.body.classList.remove('dark-theme');
    } else {
        document.body.classList.add('dark-theme');
        document.body.classList.remove('light-theme');
    }

    themeBtn.addEventListener('click', () => {
        if (document.body.classList.contains('light-theme')) {
            document.body.classList.remove('light-theme');
            document.body.classList.add('dark-theme');
            localStorage.setItem('zoon-theme', 'dark');
        } else {
            document.body.classList.remove('dark-theme');
            document.body.classList.add('light-theme');
            localStorage.setItem('zoon-theme', 'light');
        }
    });
}

/* ==========================================================================
   1b. Language & Translation Management
   ========================================================================== */
function initLanguage() {
    const langBtn = document.querySelector('.lang-btn');
    const langDropdown = document.querySelector('.lang-dropdown');
    const currentLangText = document.querySelector('.current-lang');
    const langOptions = document.querySelectorAll('.lang-dropdown button');

    if (!langBtn || !langDropdown) return;

    const langLabelMap = {
        roman: 'Roman',
        hindi: 'हिन्दी',
        english: 'English',
        marathi: 'मराठी'
    };

    // --- Region-based auto language detection ---
    // Hindi-speaking states in India (based on browser locale / language tag)
    function detectRegionLang() {
        // Get browser locale e.g. 'hi-IN', 'mr-IN', 'en-US', 'en-IN', 'hi'
        const locale = (navigator.language || navigator.userLanguage || 'en').toLowerCase();
        const langs = (navigator.languages || [locale]).map(l => l.toLowerCase());

        // Check all declared browser languages in priority order
        for (const l of langs) {
            if (l.startsWith('mr')) return 'marathi';   // Marathi (Maharashtra)
            if (l.startsWith('hi')) return 'hindi';     // Hindi
        }

        // Try timezone + locale heuristic for Indian users without explicit lang tag
        try {
            const tz = Intl.DateTimeFormat().resolvedOptions().timeZone || '';
            // Timezone regions for Maharashtra
            if (locale.includes('in') || tz.startsWith('Asia/')) {
                // Default Indian English users to English (not Roman)
                return 'english';
            }
        } catch (e) { }

        return 'english';
    }

    // Translate Page function
    const translatePage = (lang) => {
        const translations = window.translations[lang] || window.translations['roman'];

        // Update all elements with data-i18n attribute
        const elementsToTranslate = document.querySelectorAll('[data-i18n]');
        elementsToTranslate.forEach(el => {
            const key = el.getAttribute('data-i18n');
            if (translations[key]) {
                el.innerHTML = translations[key];
            }
        });

        // Trigger calculator re-render with new language strings
        const sliderInput = document.querySelector('.calc-slider');
        if (sliderInput) {
            sliderInput.dispatchEvent(new Event('input'));
        }
    };

    // Toggle Dropdown
    langBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        langDropdown.classList.toggle('active');
    });

    // Close dropdown on click outside
    document.addEventListener('click', (e) => {
        if (!langDropdown.contains(e.target) && !langBtn.contains(e.target)) {
            langDropdown.classList.remove('active');
        }
    });

    // Handle manual Language Selection
    langOptions.forEach(option => {
        option.addEventListener('click', () => {
            const selectedLang = option.getAttribute('data-lang');
            // Mark as manually chosen — this overrides auto-detect on every future visit
            localStorage.setItem('zoon-lang', selectedLang);
            localStorage.setItem('zoon-lang-manual', '1');

            if (currentLangText) {
                currentLangText.textContent = langLabelMap[selectedLang] || 'English';
            }

            translatePage(selectedLang);
            langDropdown.classList.remove('active');

            showToast(`Bhasha badli gayi: ${langLabelMap[selectedLang]}`);
        });
    });

    // --- Determine language to use on load ---
    // Rule 1: If user has ever manually chosen a language, always use that
    // Rule 2: Otherwise, auto-detect from browser region
    //         - Marathi region → marathi
    //         - Hindi region   → hindi
    //         - Others         → english
    //         (Roman Hindi is NEVER set automatically — only on manual choice)
    let activeLang;
    const wasManuallySet = localStorage.getItem('zoon-lang-manual') === '1';
    if (wasManuallySet) {
        activeLang = localStorage.getItem('zoon-lang') || 'english';
    } else {
        activeLang = detectRegionLang();
        // Save for consistency within session, but do NOT set manual flag
        localStorage.setItem('zoon-lang', activeLang);
    }

    if (currentLangText) {
        currentLangText.textContent = langLabelMap[activeLang] || 'English';
    }

    // Apply initial translation on load
    translatePage(activeLang);
}

/* ==========================================================================
   1c. Mouse Parallax Background (Premium 3D Visuals)
   ========================================================================== */
function initMouseParallax() {
    const bgWrapper = document.querySelector('.background-wrapper');
    const orbs = document.querySelectorAll('.glow-orb');
    if (!bgWrapper || 'ontouchstart' in window || navigator.maxTouchPoints > 0) return;

    window.addEventListener('mousemove', (e) => {
        const mouseX = e.clientX / window.innerWidth - 0.5;
        const mouseY = e.clientY / window.innerHeight - 0.5;

        // Move background grid slightly
        bgWrapper.style.transform = `translate(${mouseX * 15}px, ${mouseY * 15}px)`;

        // Move individual orbs at different rates for 3D depth
        if (orbs[0]) orbs[0].style.transform = `translate(${mouseX * -30}px, ${mouseY * -30}px)`;
        if (orbs[1]) orbs[1].style.transform = `translate(${mouseX * 40}px, ${mouseY * -20}px)`;
        if (orbs[2]) orbs[2].style.transform = `translate(${mouseX * -15}px, ${mouseY * 45}px)`;
    });
}

/* ==========================================================================
   2. Mobile Navigation & Scroll Header
   ========================================================================== */
function initMobileNav() {
    const header = document.querySelector('header');
    const hamburger = document.querySelector('.hamburger');
    const nav = document.querySelector('nav');
    const navLinks = document.querySelectorAll('.nav-links a');

    // Sticky Header on Scroll
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

    // Mobile Menu Toggle
    if (hamburger && nav) {
        hamburger.addEventListener('click', () => {
            hamburger.classList.toggle('active');
            nav.classList.toggle('active');
        });

        // Close Menu when link is clicked
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                hamburger.classList.remove('active');
                nav.classList.remove('active');
            });
        });
    }

    // Scroll active link highlight
    const sections = document.querySelectorAll('section');
    window.addEventListener('scroll', () => {
        let current = '';
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;
            if (window.scrollY >= (sectionTop - 200)) {
                current = section.getAttribute('id');
            }
        });

        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === `#${current}`) {
                link.classList.add('active');
            }
        });
    });
}

/* ==========================================================================
   3. Scroll Reveal Animations
   ========================================================================== */
function initScrollReveal() {
    const revealElements = document.querySelectorAll('.reveal, .reveal-left, .reveal-right');

    const revealOnScroll = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
                observer.unobserve(entry.target); // Reveal only once
            }
        });
    }, {
        threshold: 0.15,
        rootMargin: '0px 0px -50px 0px'
    });

    revealElements.forEach(el => {
        revealOnScroll.observe(el);
    });
}

/* ==========================================================================
   4. Statistics Dynamic Number Counter
   ========================================================================== */
function initStatsCounter() {
    const statNums = document.querySelectorAll('.stat-num');

    const countUp = (element) => {
        const target = +element.getAttribute('data-target');
        const suffix = element.getAttribute('data-suffix') || '';
        const duration = 2000; // ms
        const startTime = performance.now();

        const updateCount = (timestamp) => {
            const progress = Math.min((timestamp - startTime) / duration, 1);
            // Ease out quad
            const easeProgress = progress * (2 - progress);
            const currentVal = Math.floor(easeProgress * target);

            element.textContent = currentVal.toLocaleString() + suffix;

            if (progress < 1) {
                requestAnimationFrame(updateCount);
            } else {
                element.textContent = target.toLocaleString() + suffix;
            }
        };

        requestAnimationFrame(updateCount);
    };

    const statsObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                countUp(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    statNums.forEach(num => statsObserver.observe(num));
}

/* ==========================================================================
   5. Interactive 3D Canvas Particle Globe
   ========================================================================== */
function init3DGlobe() {
    const canvas = document.getElementById('canvas-3d');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    let width = canvas.width = canvas.offsetWidth;
    let height = canvas.height = canvas.offsetHeight;

    // Handle Resize
    window.addEventListener('resize', () => {
        if (!canvas) return;
        width = canvas.width = canvas.offsetWidth;
        height = canvas.height = canvas.offsetHeight;
    });

    // Globe parameters
    const particleCount = 120;
    const sphereRadius = Math.min(width, height) * 0.38;
    const particles = [];

    // Define 10 tags corresponding to logo colors and core sectors/values
    const tags = [
        { key: 'shiksha', text: 'Shiksha', phi: 0.8, theta: 1.2, x: 0, y: 0, z: 0, color: '#00d2ff' }, // Cyan
        { key: 'swasthya', text: 'Swasthya', phi: 1.5, theta: 2.5, x: 0, y: 0, z: 0, color: '#3cb54c' }, // Green
        { key: 'sewa', text: 'Sewa', phi: 2.2, theta: 0.5, x: 0, y: 0, z: 0, color: '#ff3333' }, // Red
        { key: 'azamgarh', text: 'Azamgarh', phi: 1.1, theta: 4.2, x: 0, y: 0, z: 0, color: '#f36523' }, // Orange
        { key: 'ekta', text: 'Ekta', phi: 2.8, theta: 5.1, x: 0, y: 0, z: 0, color: '#a855f7' }, // Purple
        { key: 'kambal', text: 'Kambal Vitran', phi: 1.8, theta: 1.8, x: 0, y: 0, z: 0, color: '#f36523' }, // Orange
        { key: 'ration', text: 'Ration Kits', phi: 1.3, theta: 0.2, x: 0, y: 0, z: 0, color: '#ff3333' }, // Red
        { key: 'silai', text: 'Silai Center', phi: 2.0, theta: 3.2, x: 0, y: 0, z: 0, color: '#a855f7' }, // Purple
        { key: 'paryavaran', text: 'Ped Lagao', phi: 0.5, theta: 3.0, x: 0, y: 0, z: 0, color: '#3cb54c' }, // Green
        { key: 'rahat', text: 'Baadh Rahat', phi: 2.5, theta: 2.2, x: 0, y: 0, z: 0, color: '#00d2ff' } // Cyan
    ];

    // Initialize initial 3D positions of the tags
    tags.forEach(tag => {
        tag.x = sphereRadius * Math.sin(tag.phi) * Math.cos(tag.theta);
        tag.y = sphereRadius * Math.sin(tag.phi) * Math.sin(tag.theta);
        tag.z = sphereRadius * Math.cos(tag.phi);
    });

    // Camera settings
    const fov = 400;

    // Rotation angles
    let angleY = 0.002; // auto-spin velocity around Y
    let angleX = 0.001; // auto-spin velocity around X

    // Drag control states
    let isDragging = false;
    let previousMousePosition = { x: 0, y: 0 };

    // Mouse hover highlight
    let mousePos = { x: 0, y: 0 };
    let hoverDistanceThreshold = 50;

    // Hologram image declarations and rotation accumulators
    let totalRotationY = 0;
    let totalRotationX = 0;
    let logoLoaded = false;
    let mapLoaded = false;
    let processedLogoCanvas = null;
    let processedMapCanvas = null;

    const themeUri = typeof zoonThemeSettings !== 'undefined' ? zoonThemeSettings.themeUri : '';

    const logoImg = new Image();
    logoImg.src = themeUri ? themeUri + '/logo/logo.png?v=2' : 'logo/logo.png?v=2';
    logoImg.onload = () => {
        processedLogoCanvas = processLogoHands(logoImg);
        logoLoaded = true;
    };

    const mapImg = new Image();
    mapImg.src = themeUri ? themeUri + '/logo/india_hologram.png' : 'logo/india_hologram.png';
    mapImg.onload = () => {
        processedMapCanvas = processMap(mapImg);
        mapLoaded = true;
    };

    function processLogoHands(img) {
        const offCanvas = document.createElement('canvas');
        const size = 300;
        offCanvas.width = size;
        offCanvas.height = size;
        const oCtx = offCanvas.getContext('2d');

        // Draw a circular clipping mask in the offscreen canvas
        oCtx.beginPath();
        oCtx.arc(size / 2, size / 2, size / 2 - 2, 0, Math.PI * 2);
        oCtx.clip();

        // Draw the entire logo.png which is already cropped to the hands monogram
        oCtx.drawImage(
            img,
            0,
            0,
            img.width,
            img.height,
            0,
            0,
            size,
            size
        );

        return offCanvas;
    }

    function processMap(img) {
        const offCanvas = document.createElement('canvas');
        const size = 350;
        offCanvas.width = size;
        offCanvas.height = size;
        const oCtx = offCanvas.getContext('2d');

        oCtx.drawImage(img, 0, 0, size, size);

        // Make black background transparent
        try {
            const imgData = oCtx.getImageData(0, 0, size, size);
            const data = imgData.data;
            for (let i = 0; i < data.length; i += 4) {
                const r = data[i];
                const g = data[i + 1];
                const b = data[i + 2];
                const brightness = (r + g + b) / 3;
                if (brightness < 40) {
                    data[i + 3] = Math.min(255, Math.max(0, (brightness - 20) * 5));
                }
            }
            oCtx.putImageData(imgData, 0, 0);
        } catch (e) {
            console.error("Failed to key out black pixels", e);
        }
        return offCanvas;
    }

    // Generate random points on a 3D Sphere (using Fibonacci Lattice for even distribution)
    for (let i = 0; i < particleCount; i++) {
        const phi = Math.acos(-1 + (2 * i) / particleCount);
        const theta = Math.sqrt(particleCount * Math.PI) * phi;

        particles.push({
            x: sphereRadius * Math.sin(phi) * Math.cos(theta),
            y: sphereRadius * Math.sin(phi) * Math.sin(theta),
            z: sphereRadius * Math.cos(phi),
            baseSize: Math.random() * 2 + 1.5,
            colorIndex: i % 5 // 0: Green, 1: Orange, 2: Red, 3: Cyan, 4: Purple
        });
    }

    // Drag listeners
    canvas.addEventListener('mousedown', (e) => {
        isDragging = true;
        previousMousePosition = { x: e.clientX, y: e.clientY };
    });

    window.addEventListener('mouseup', () => {
        isDragging = false;
    });

    window.addEventListener('mousemove', (e) => {
        const rect = canvas.getBoundingClientRect();
        mousePos.x = e.clientX - rect.left;
        mousePos.y = e.clientY - rect.top;

        if (isDragging) {
            const deltaX = e.clientX - previousMousePosition.x;
            const deltaY = e.clientY - previousMousePosition.y;

            // Adjust rotation velocity based on drag (increased sensitivity)
            angleY += deltaX * 0.0008;
            angleX += deltaY * 0.0008;

            previousMousePosition = { x: e.clientX, y: e.clientY };
        }
    });

    // Support Mobile Touch Dragging
    canvas.addEventListener('touchstart', (e) => {
        if (e.touches.length === 1) {
            isDragging = true;
            previousMousePosition = { x: e.touches[0].clientX, y: e.touches[0].clientY };
        }
    });

    window.addEventListener('touchend', () => {
        isDragging = false;
    });

    window.addEventListener('touchmove', (e) => {
        if (isDragging && e.touches.length === 1) {
            const deltaX = e.touches[0].clientX - previousMousePosition.x;
            const deltaY = e.touches[0].clientY - previousMousePosition.y;

            angleY += deltaX * 0.001;
            angleX += deltaY * 0.001;

            previousMousePosition = { x: e.touches[0].clientX, y: e.touches[0].clientY };
        }
    });

    // Rotation helper functions
    function rotateY(point, radians) {
        const cos = Math.cos(radians);
        const sin = Math.sin(radians);
        const x = point.x * cos - point.z * sin;
        const z = point.x * sin + point.z * cos;
        point.x = x;
        point.z = z;
    }

    function rotateX(point, radians) {
        const cos = Math.cos(radians);
        const sin = Math.sin(radians);
        const y = point.y * cos - point.z * sin;
        const z = point.y * sin + point.z * cos;
        point.y = y;
        point.z = z;
    }

    // Animation Loop
    function animate() {
        ctx.clearRect(0, 0, width, height);

        // Fetch colors based on theme
        const isLightTheme = document.body.classList.contains('light-theme');
        const primaryColorStr = isLightTheme ? '31, 117, 42' : '60, 181, 76';    // Logo Green
        const secondaryColorStr = isLightTheme ? '184, 65, 12' : '243, 101, 35';  // Logo Orange

        // Logo-themed RGB strings (0: Green, 1: Orange, 2: Red, 3: Cyan, 4: Purple)
        const colors = [
            primaryColorStr,      // Green
            secondaryColorStr,    // Orange
            isLightTheme ? '180, 15, 15' : '234, 67, 53',        // Red
            isLightTheme ? '0, 120, 180' : '0, 210, 255',        // Cyan
            isLightTheme ? '120, 30, 180' : '168, 85, 247'       // Purple
        ];

        // Auto decay drag rotation velocity back to gentle spin (retains momentum longer)
        if (!isDragging) {
            angleY *= 0.98; // slower speed decay for natural momentum
            angleX *= 0.98;
            // Constant base rotation + mouse hover parallax response (smoother interpolation)
            const targetAngleY = 0.002 + (mousePos.x / width - 0.5) * 0.004;
            const targetAngleX = 0.0008 + (mousePos.y / height - 0.5) * 0.003;
            angleY += (targetAngleY - angleY) * 0.02; // smoother return to base/parallax spin
            angleX += (targetAngleX - angleX) * 0.02;
        }

        // Accumulate total rotation for hologram sync
        totalRotationY += angleY;
        totalRotationX += angleX;

        // Apply rotation to all points
        particles.forEach(p => {
            rotateY(p, angleY);
            rotateX(p, angleX);
        });

        // Rotate Tags
        tags.forEach(tag => {
            rotateY(tag, angleY);
            rotateX(tag, angleX);
        });

        // Sort particles by Z-depth for correct overlapping draw order (painter's algorithm)
        // positive z is background (further away, smaller scale)
        // negative z is foreground (closer, larger scale)
        const sortedParticles = [...particles].sort((a, b) => b.z - a.z);

        // Split sorted particles into background (z > 0) and foreground (z <= 0)
        const backParticles = sortedParticles.filter(p => p.z > 0);
        const frontParticles = sortedParticles.filter(p => p.z <= 0);

        // Particle drawing helper function
        function drawParticle(p) {
            const scale = fov / (fov + p.z);
            const projX = p.x * scale + width / 2;
            const projY = p.y * scale + height / 2;

            // Calculate distance to mouse pointer for mouse interaction
            const dx = projX - mousePos.x;
            const dy = projY - mousePos.y;
            const distToMouse = Math.sqrt(dx * dx + dy * dy);

            // Size changes based on projection depth and mouse distance
            let size = p.baseSize * scale;
            let glow = 0;
            if (distToMouse < hoverDistanceThreshold) {
                const hoverFactor = (1 - distToMouse / hoverDistanceThreshold);
                size += hoverFactor * 4;
                glow = hoverFactor * 8;
            }

            // Correct alpha transparency based on true depth (negative z is foreground, should have higher alpha)
            const alpha = Math.max(0.15, (sphereRadius - p.z) / (2 * sphereRadius));

            // Decide color palette
            const rgb = colors[p.colorIndex] || primaryColorStr;

            // Draw glowing outer aura
            if (glow > 0) {
                ctx.fillStyle = `rgba(${rgb}, ${alpha * 0.25})`;
                ctx.beginPath();
                ctx.arc(projX, projY, size + glow, 0, Math.PI * 2);
                ctx.fill();
            }

            // Draw particle core
            ctx.fillStyle = `rgba(${rgb}, ${alpha * (glow > 0 ? 0.9 : 0.65)})`;
            ctx.beginPath();
            ctx.arc(projX, projY, size, 0, Math.PI * 2);
            ctx.fill();
        }

        // Draw Hologram Core (centered at z = 0, placed between background and foreground)
        function drawHolographicCore() {
            if (!logoLoaded && !mapLoaded) return;

            ctx.save();
            ctx.translate(width / 2, height / 2);

            // Keep images UPRIGHT, no mirror flip.
            // Math.abs ensures scaleX never goes negative (which causes flipping).
            // The squish-to-zero-and-back effect still gives the 3D disc illusion.
            const scaleX = Math.abs(Math.cos(totalRotationY));
            ctx.scale(scaleX, 1); // squish only, no flip

            // Pulsing light influence oscillation
            const time = Date.now() * 0.002;
            const pulse = Math.sin(time) * 0.05 + 1.0;

            // Glow core radius (slightly smaller than sphere)
            const coreRadius = sphereRadius * 0.58;

            // Draw glowing radial gradient background
            const glowGrad = ctx.createRadialGradient(0, 0, coreRadius * 0.2, 0, 0, coreRadius * 1.25 * pulse);
            if (isLightTheme) {
                glowGrad.addColorStop(0, 'rgba(0, 210, 255, 0.12)'); // Cyan glow
                glowGrad.addColorStop(0.5, 'rgba(60, 181, 76, 0.06)'); // Green glow
                glowGrad.addColorStop(1, 'rgba(0, 0, 0, 0)');
            } else {
                glowGrad.addColorStop(0, 'rgba(0, 210, 255, 0.22)'); // Cyan glow
                glowGrad.addColorStop(0.5, 'rgba(60, 181, 76, 0.09)'); // Green glow
                glowGrad.addColorStop(1, 'rgba(0, 0, 0, 0)');
            }
            ctx.fillStyle = glowGrad;
            ctx.beginPath();
            ctx.arc(0, 0, coreRadius * 1.3, 0, Math.PI * 2);
            ctx.fill();

            // Set screen blending for holographic look
            ctx.globalCompositeOperation = 'screen';
            ctx.shadowBlur = 18;
            ctx.shadowColor = isLightTheme ? 'rgba(0, 120, 180, 0.65)' : 'rgba(0, 210, 255, 0.85)';

            // Draw India Map (Base Layer) — bigger size, no flip
            if (mapLoaded && processedMapCanvas) {
                ctx.globalAlpha = isLightTheme ? 0.18 : 0.30;
                const mapSize = coreRadius * 1.9 * pulse;
                ctx.drawImage(
                    processedMapCanvas,
                    -mapSize / 2,
                    -mapSize / 2,
                    mapSize,
                    mapSize
                );
            }

            // Draw Zoon Holding Hands Logo (Foreground Layer) — upright, no extra rotation
            if (logoLoaded && processedLogoCanvas) {
                ctx.globalAlpha = isLightTheme ? 0.25 : 0.38;
                const logoSize = coreRadius * 0.95 * (1.08 - 0.08 * Math.sin(time));
                ctx.drawImage(
                    processedLogoCanvas,
                    -logoSize / 2,
                    -logoSize / 2,
                    logoSize,
                    logoSize
                );
            }

            ctx.restore();
        }

        // 1. Draw connections for background particles (where midpoint z > 0)
        ctx.lineWidth = 0.5;
        for (let i = 0; i < backParticles.length; i++) {
            const p1 = backParticles[i];

            // Skip connecting points that are far in the background
            if (p1.z > sphereRadius * 0.8) continue;

            const scale1 = fov / (fov + p1.z);
            const projX1 = p1.x * scale1 + width / 2;
            const projY1 = p1.y * scale1 + height / 2;

            for (let j = i + 1; j < backParticles.length; j++) {
                const p2 = backParticles[j];
                const dx = p1.x - p2.x;
                const dy = p1.y - p2.y;
                const dz = p1.z - p2.z;
                const dist = Math.sqrt(dx * dx + dy * dy + dz * dz);

                // Draw connection if close enough
                if (dist < sphereRadius * 0.45) {
                    const scale2 = fov / (fov + p2.z);
                    const projX2 = p2.x * scale2 + width / 2;
                    const projY2 = p2.y * scale2 + height / 2;

                    const alpha = (1 - dist / (sphereRadius * 0.45)) * 0.12 * (scale1 + scale2) / 2;
                    ctx.strokeStyle = `rgba(${colors[p1.colorIndex] || primaryColorStr}, ${alpha})`;
                    ctx.beginPath();
                    ctx.moveTo(projX1, projY1);
                    ctx.lineTo(projX2, projY2);
                    ctx.stroke();
                }
            }
        }

        // 2. Draw background particles
        backParticles.forEach(p => {
            drawParticle(p);
        });

        // 3. Draw Holographic Core (placed exactly between back and front elements)
        drawHolographicCore();

        // 4. Draw connections for foreground particles (where midpoint z <= 0)
        ctx.lineWidth = 0.5;
        for (let i = 0; i < frontParticles.length; i++) {
            const p1 = frontParticles[i];
            const scale1 = fov / (fov + p1.z);
            const projX1 = p1.x * scale1 + width / 2;
            const projY1 = p1.y * scale1 + height / 2;

            for (let j = i + 1; j < frontParticles.length; j++) {
                const p2 = frontParticles[j];
                const dx = p1.x - p2.x;
                const dy = p1.y - p2.y;
                const dz = p1.z - p2.z;
                const dist = Math.sqrt(dx * dx + dy * dy + dz * dz);

                // Draw connection if close enough
                if (dist < sphereRadius * 0.45) {
                    const scale2 = fov / (fov + p2.z);
                    const projX2 = p2.x * scale2 + width / 2;
                    const projY2 = p2.y * scale2 + height / 2;

                    const alpha = (1 - dist / (sphereRadius * 0.45)) * 0.22 * (scale1 + scale2) / 2;
                    ctx.strokeStyle = `rgba(${colors[p1.colorIndex] || primaryColorStr}, ${alpha})`;
                    ctx.beginPath();
                    ctx.moveTo(projX1, projY1);
                    ctx.lineTo(projX2, projY2);
                    ctx.stroke();
                }
            }
        }

        // 5. Draw foreground particles
        frontParticles.forEach(p => {
            drawParticle(p);
        });

        // Outer glow rim of the globe (subtle)
        const gradient = ctx.createRadialGradient(width / 2, height / 2, sphereRadius * 0.9, width / 2, height / 2, sphereRadius * 1.05);
        gradient.addColorStop(0, 'rgba(5, 150, 105, 0)');
        gradient.addColorStop(0.8, `rgba(${primaryColorStr}, ${isLightTheme ? '0.04' : '0.08'})`);
        gradient.addColorStop(1, 'rgba(5, 150, 105, 0)');
        ctx.fillStyle = gradient;
        ctx.beginPath();
        ctx.arc(width / 2, height / 2, sphereRadius * 1.1, 0, Math.PI * 2);
        ctx.fill();

        // Draw 3D Tags
        tags.forEach(tag => {
            // Draw tag only if it is in the front hemisphere
            if (tag.z > -sphereRadius * 0.15) {
                const scale = fov / (fov + tag.z);
                const projX = tag.x * scale + width / 2;
                const projY = tag.y * scale + height / 2;

                // Opacity fades slightly as it moves towards the sides/back
                const depthAlpha = Math.max(0.2, (tag.z + sphereRadius * 0.15) / (sphereRadius * 1.15));

                // Draw connecting line from globe dot to text pill
                ctx.beginPath();
                ctx.strokeStyle = `${tag.color}${Math.floor(depthAlpha * 255).toString(16).padStart(2, '0')}`;
                ctx.lineWidth = 1;
                ctx.setLineDash([2, 3]); // dashed line for cool tech look
                ctx.moveTo(projX, projY);
                ctx.lineTo(projX + 15 * scale, projY - 15 * scale);
                ctx.stroke();
                ctx.setLineDash([]); // reset

                // Draw small glowing coordinates dot on the globe surface
                ctx.fillStyle = tag.color;
                ctx.shadowColor = tag.color;
                ctx.shadowBlur = 10;
                ctx.beginPath();
                ctx.arc(projX, projY, 4 * scale, 0, Math.PI * 2);
                ctx.fill();
                ctx.shadowBlur = 0; // reset blur

                // Fetch translation or fallback
                const currentLang = localStorage.getItem('zoon-lang') || 'roman';
                const trans = window.translations[currentLang] || window.translations['roman'];
                const labelText = trans[`gtag-${tag.key}`] || tag.text;

                // Set font style
                ctx.font = `bold ${Math.max(10, Math.floor(11 * scale))}px var(--font-heading)`;
                const textWidth = ctx.measureText(labelText).width;
                const paddingX = 8 * scale;
                const paddingY = 4 * scale;

                const rectX = projX + 15 * scale;
                const rectY = projY - 25 * scale;
                const rectWidth = textWidth + paddingX * 2;
                const rectHeight = (12 + paddingY * 2) * scale;

                // Draw glassmorphic pill background
                ctx.fillStyle = isLightTheme ? 'rgba(255, 255, 255, 0.85)' : 'rgba(13, 20, 38, 0.85)';
                ctx.strokeStyle = `${tag.color}${Math.floor(depthAlpha * 200).toString(16).padStart(2, '0')}`;
                ctx.lineWidth = 1.5;

                ctx.beginPath();
                if (typeof ctx.roundRect === 'function') {
                    ctx.roundRect(rectX, rectY, rectWidth, rectHeight, 6 * scale);
                } else {
                    const radius = 6 * scale;
                    ctx.moveTo(rectX + radius, rectY);
                    ctx.lineTo(rectX + rectWidth - radius, rectY);
                    ctx.quadraticCurveTo(rectX + rectWidth, rectY, rectX + rectWidth, rectY + radius);
                    ctx.lineTo(rectX + rectWidth, rectY + rectHeight - radius);
                    ctx.quadraticCurveTo(rectX + rectWidth, rectY + rectHeight, rectX + rectWidth - radius, rectY + rectHeight);
                    ctx.lineTo(rectX + radius, rectY + rectHeight);
                    ctx.quadraticCurveTo(rectX, rectY + rectHeight, rectX, rectY + rectHeight - radius);
                    ctx.lineTo(rectX, rectY + radius);
                    ctx.quadraticCurveTo(rectX, rectY, rectX + radius, rectY);
                }
                ctx.fill();
                ctx.stroke();

                // Draw Text
                ctx.fillStyle = isLightTheme ? '#0f172a' : '#ffffff';
                ctx.fillText(labelText, rectX + paddingX, rectY + 12 * scale + paddingY / 2);
            }
        });

        requestAnimationFrame(animate);
    }

    animate();
}

/* ==========================================================================
   6. Custom 3D Tilt Effect on Cards
   ========================================================================== */
function init3DTilt() {
    // Combine cards that should have a 3D tilt interaction
    const elements = document.querySelectorAll('.pillar-card, .objective-card, .leader-focus-card, .team-card');

    // Detect mobile touch devices (we disable tilt on touchscreen to avoid jerky movements)
    if ('ontouchstart' in window || navigator.maxTouchPoints > 0) return;

    elements.forEach(el => {
        el.addEventListener('mousemove', (e) => {
            const rect = el.getBoundingClientRect();

            // Mouse coordinates relative to card center
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const centerX = rect.width / 2;
            const centerY = rect.height / 2;

            // Normalize tilt values (-1 to 1)
            const percentX = (x - centerX) / centerX;
            const percentY = (y - centerY) / centerY;

            // Maximum tilt angle (degrees)
            const maxTilt = el.classList.contains('leader-focus-card') ? 5 : 12;

            const tiltY = percentX * maxTilt;
            const tiltX = -percentY * maxTilt; // Invert Y axis tilt

            // Dynamic rotation matrix
            el.style.transform = `rotateY(${tiltY.toFixed(2)}deg) rotateX(${tiltX.toFixed(2)}deg) scale(1.02)`;
            el.style.transition = 'transform 0.05s ease';

            // Add subtle shadow offset shifts
            const shadowX = -percentX * 15;
            const shadowY = -percentY * 15;
            const isDark = !document.body.classList.contains('light-theme');
            const shadowColor = isDark ? 'rgba(5, 150, 105, 0.25)' : 'rgba(0, 0, 0, 0.15)';
            el.style.boxShadow = `${shadowX.toFixed(1)}px ${shadowY.toFixed(1)}px 30px ${shadowColor}`;
        });

        el.addEventListener('mouseleave', () => {
            // Smoothly snap back to origin
            el.style.transform = 'rotateY(0deg) rotateX(0deg) scale(1)';
            el.style.transition = 'transform 0.5s cubic-bezier(0.16, 1, 0.3, 1)';
            el.style.boxShadow = '';
        });
    });
}

/* ==========================================================================
   7. Interactive Donation Impact Calculator
   ========================================================================== */
function initImpactCalculator() {
    const slider = document.querySelector('.calc-slider');
    const amtDisplay = document.querySelector('.calc-amt-display');
    const metricPeople = document.querySelector('#calc-people');
    const metricDuration = document.querySelector('#calc-days');
    const typeButtons = document.querySelectorAll('.calc-type-btn');
    const actionBtn = document.querySelector('.calc-box .btn-cta');

    if (!slider) return;

    // Define donation types & parameters
    // costPerUnit: price for 1 kit
    // labelName: plural display text
    const config = {
        ration: {
            costPerUnit: 1500,
            beneficiariesPerUnit: 5, // Family size of 5
            metricName: 'Logon ko Khana',
            unitText: 'Parivaron ko Ration'
        },
        blanket: {
            costPerUnit: 300,
            beneficiariesPerUnit: 1, // 1 Elder
            metricName: 'Sardi se Hifazat',
            unitText: 'Gareebon ko Kambal'
        },
        school: {
            costPerUnit: 500,
            beneficiariesPerUnit: 1, // 1 Child
            metricName: 'Bachon ki Taleem',
            unitText: 'Bachon ko School Kits'
        }
    };

    let activeType = 'ration';

    // Handle Type Selection
    typeButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            typeButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            activeType = btn.getAttribute('data-type');

            // Adjust slider ranges based on cost
            if (activeType === 'ration') {
                slider.min = 1;
                slider.max = 30;
                slider.value = 5;
            } else if (activeType === 'blanket') {
                slider.min = 5;
                slider.max = 150;
                slider.value = 25;
            } else if (activeType === 'school') {
                slider.min = 2;
                slider.max = 100;
                slider.value = 15;
            }

            updateCalculator();
        });
    });

    // Handle Slider Input
    slider.addEventListener('input', updateCalculator);

    function updateCalculator() {
        const units = parseInt(slider.value);
        const typeConfig = config[activeType];

        const totalAmount = units * typeConfig.costPerUnit;
        const totalBeneficiaries = units * typeConfig.beneficiariesPerUnit;

        // Render values
        amtDisplay.textContent = `₹${totalAmount.toLocaleString()}`;

        // Populate metric counters with a nice visual transition
        metricPeople.textContent = totalBeneficiaries;
        metricDuration.textContent = units;

        // Fetch active language translations
        const currentLang = localStorage.getItem('zoon-lang') || 'roman';
        const trans = window.translations[currentLang] || window.translations['roman'];
        const metricName = trans[`calc-${activeType}-metric`] || typeConfig.metricName;
        const unitText = trans[`calc-${activeType}-unit`] || typeConfig.unitText;

        // Update label text in elements
        document.querySelector('#calc-label-people').textContent = metricName;
        document.querySelector('#calc-label-units').textContent = unitText;

        // Update slider track background color fill
        const percent = ((slider.value - slider.min) / (slider.max - slider.min)) * 100;
        const primaryColor = document.body.classList.contains('light-theme') ? '#1f752a' : '#3cb54c';
        const trackColor = document.body.classList.contains('light-theme') ? '#cbd5e1' : 'rgba(255,255,255,0.08)';
        slider.style.background = `linear-gradient(to right, ${primaryColor} 0%, ${primaryColor} ${percent}%, ${trackColor} ${percent}%, ${trackColor} ${percent}%)`;
    }

    // Connect slider calculator with the contact form tab transition
    if (actionBtn) {
        actionBtn.addEventListener('click', () => {
            const contactSection = document.querySelector('#contact');
            if (contactSection) {
                contactSection.scrollIntoView({ behavior: 'smooth' });

                // Programmatically switch tabs in forms to 'Donation Info'
                const donationTab = document.querySelector('.form-tab-btn[data-tab="donation"]');
                if (donationTab) {
                    donationTab.click();

                    // Autofill donation details in description field
                    const donationTextarea = document.getElementById('d-msg');
                    if (donationTextarea) {
                        const units = slider.value;
                        const typeConfig = config[activeType];
                        const totalAmount = units * typeConfig.costPerUnit;

                        // Fetch active language translation for message template
                        const currentLang = localStorage.getItem('zoon-lang') || 'roman';
                        const trans = window.translations[currentLang] || window.translations['roman'];
                        const unitTextTranslated = trans[`calc-${activeType}-unit`] || typeConfig.unitText;

                        let messageTemplate = trans['calc-autofill-msg'] || "Main Zoon Charitable Trust ko {amount} ki madad (Donation) dena chahta hoon, jisse {units} {unitText} distributed honge. Kripya aage ka procedure batayein.";

                        // Replace placeholders in the template
                        const formattedMessage = messageTemplate
                            .replace('{amount}', `₹${totalAmount.toLocaleString()}`)
                            .replace('{units}', units)
                            .replace('{unitText}', unitTextTranslated);

                        donationTextarea.value = formattedMessage;
                    }
                }
            }
        });
    }

    // Initial run
    updateCalculator();
}

/* ==========================================================================
   8. Interactive Activity Media Gallery (Filter + Lightbox)
   ========================================================================== */
function initGallery() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const galleryItems = document.querySelectorAll('.gallery-item');
    const lightbox = document.querySelector('.lightbox');
    const lightboxImg = document.querySelector('.lightbox-img');
    const lightboxClose = document.querySelector('.lightbox-close');
    const lightboxCaption = document.querySelector('.lightbox-caption');

    if (!galleryItems.length) return;

    // Filter Items
    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            filterButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const filterValue = btn.getAttribute('data-filter');

            galleryItems.forEach(item => {
                const category = item.getAttribute('data-category');

                if (filterValue === 'all' || category === filterValue) {
                    item.style.display = 'block';
                    // Trigger entry transition
                    setTimeout(() => {
                        item.style.opacity = '1';
                        item.style.transform = 'scale(1)';
                    }, 50);
                } else {
                    item.style.opacity = '0';
                    item.style.transform = 'scale(0.8)';
                    setTimeout(() => {
                        item.style.display = 'none';
                    }, 300);
                }
            });
        });
    });

    // Helper function to open lightbox
    const openLightbox = (src, captionText) => {
        if (lightbox && lightboxImg && lightboxCaption) {
            lightboxImg.src = src;
            lightboxCaption.textContent = captionText;
            lightbox.classList.add('active');
            document.body.style.overflow = 'hidden'; // Lock scrolling
        }
    };

    // Lightbox Open for Gallery
    galleryItems.forEach(item => {
        item.addEventListener('click', () => {
            const img = item.querySelector('img');
            const caption = item.querySelector('.gallery-caption').textContent;
            openLightbox(img.src, caption);
        });
    });

    // Lightbox Open for Leader Focus Certificates
    const leaderImgs = document.querySelectorAll('.leader-img-wrapper img');
    leaderImgs.forEach(img => {
        img.style.cursor = 'zoom-in';
        img.addEventListener('click', () => {
            const leaderCard = img.closest('.leader-focus-card');
            const name = leaderCard.querySelector('.leader-name').textContent;
            const role = leaderCard.querySelector('.leader-role').textContent;
            openLightbox(img.src, `${name} - ${role} (Official Appointment Certificate)`);
        });
    });

    // Lightbox Open for Team Grid Certificates
    const teamCards = document.querySelectorAll('.team-card');
    teamCards.forEach(card => {
        card.style.cursor = 'zoom-in';
        card.addEventListener('click', () => {
            const img = card.querySelector('img');
            const name = card.querySelector('.team-member-name').textContent;
            const role = card.querySelector('.team-member-role').textContent;
            openLightbox(img.src, `${name} - ${role} (Official Appointment Certificate)`);
        });
    });

    // Lightbox Close
    if (lightboxClose && lightbox) {
        const closeLightbox = () => {
            lightbox.classList.remove('active');
            document.body.style.overflow = ''; // Unlock scrolling
        };

        lightboxClose.addEventListener('click', closeLightbox);

        lightbox.addEventListener('click', (e) => {
            if (e.target === lightbox) {
                closeLightbox();
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && lightbox.classList.contains('active')) {
                closeLightbox();
            }
        });
    }
}

/* ==========================================================================
   9. Form Tabs switcher (Contact vs Volunteer vs Donation Info)
   ========================================================================== */
function initFormTabs() {
    const tabButtons = document.querySelectorAll('.form-tab-btn');
    const formContents = document.querySelectorAll('.form-content');

    tabButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            tabButtons.forEach(b => b.classList.remove('active'));
            formContents.forEach(c => c.classList.remove('active'));

            btn.classList.add('active');
            const activeTabId = btn.getAttribute('data-tab');
            const activeForm = document.getElementById(`${activeTabId}-form`);
            if (activeForm) {
                activeForm.classList.add('active');
            }
        });
    });
}

/* ==========================================================================
   10. Interactive Contact & Submit Handling (No Refresh)
   ========================================================================== */
function initContactForms() {
    const forms = document.querySelectorAll('.form-card form');
    const modal = document.getElementById('channel-modal');
    const modalContent = document.getElementById('channel-modal-content');
    const btnWhatsapp = document.getElementById('btn-send-whatsapp');
    const btnTelegram = document.getElementById('btn-send-telegram');
    const btnEmail = document.getElementById('btn-send-email');
    const btnCancel = document.getElementById('btn-close-channel-modal');

    if (!forms.length || !modal) return;

    let pendingMessage = '';
    let activeForm = null;

    forms.forEach(form => {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            activeForm = form;

            // Formulate message based on input
            if (form.id === 'contact-form') {
                const name = document.getElementById('c-name').value;
                const phone = document.getElementById('c-phone').value;
                const msg = document.getElementById('c-msg').value;
                pendingMessage = `*ZOON CHARITABLE TRUST (Z.C.T) - Website Contact Request*\n\n` +
                    `*Name:* ${name}\n` +
                    `*Phone/WhatsApp:* ${phone}\n` +
                    `*Message:* ${msg}`;
            } else if (form.id === 'volunteer-form') {
                const name = document.getElementById('v-name').value;
                const phone = document.getElementById('v-phone').value;
                const city = document.getElementById('v-city').value;
                const skill = document.getElementById('v-skill').value;
                pendingMessage = `*ZOON CHARITABLE TRUST (Z.C.T) - Volunteer Registration*\n\n` +
                    `*Name:* ${name}\n` +
                    `*Phone/WhatsApp:* ${phone}\n` +
                    `*Address:* ${city}\n` +
                    `*Willing to help via:* ${skill}`;
            } else if (form.id === 'calc-direct-donation-form') {
                const msg = document.getElementById('d-msg').value;
                pendingMessage = `*ZOON CHARITABLE TRUST (Z.C.T) - Donation Details Request*\n\n` +
                    `*Message:* ${msg}`;
            }

            // Open Modal and populate editable textarea
            const modalTextarea = document.getElementById('modal-message-edit');
            if (modalTextarea) {
                modalTextarea.value = pendingMessage;
            }
            modal.classList.add('active');

            // Add a temporary 3D perspective mouse tilt to modal card
            if (!('ontouchstart' in window || navigator.maxTouchPoints > 0)) {
                modalContent.addEventListener('mousemove', handleModal3DTilt);
            }
        });
    });

    // Modal Actions
    const closeModal = () => {
        modal.classList.remove('active');
        modalContent.style.transform = '';
        modalContent.removeEventListener('mousemove', handleModal3DTilt);
    };

    const handleModal3DTilt = (e) => {
        const rect = modalContent.getBoundingClientRect();
        const x = e.clientX - rect.left - rect.width / 2;
        const y = e.clientY - rect.top - rect.height / 2;
        const tiltX = -(y / (rect.height / 2)) * 6;
        const tiltY = (x / (rect.width / 2)) * 6;
        modalContent.style.transform = `rotateX(${tiltX.toFixed(2)}deg) rotateY(${tiltY.toFixed(2)}deg) translateZ(0)`;
    };

    btnCancel.addEventListener('click', closeModal);

    const getFinalMessage = () => {
        const modalTextarea = document.getElementById('modal-message-edit');
        return modalTextarea ? modalTextarea.value : pendingMessage;
    };

    btnWhatsapp.addEventListener('click', () => {
        const msgText = getFinalMessage();
        const url = `https://wa.me/919795371007?text=${encodeURIComponent(msgText)}`;
        window.open(url, '_blank');
        finishFormSubmission();
    });

    btnTelegram.addEventListener('click', () => {
        // Share text and link on telegram
        const msgText = getFinalMessage();
        const url = `https://t.me/share/url?url=https://www.facebook.com/zctbillionin1&text=${encodeURIComponent(msgText)}`;
        window.open(url, '_blank');
        finishFormSubmission();
    });

    btnEmail.addEventListener('click', () => {
        const msgText = getFinalMessage();
        const mailtoLink = `mailto:zooncharitabletrust@gmail.com?subject=Zoon%20Trust%20Website%20Message&body=${encodeURIComponent(msgText)}`;
        window.location.href = mailtoLink;
        finishFormSubmission();
    });

    function finishFormSubmission() {
        closeModal();
        if (activeForm) {
            const submitBtn = activeForm.querySelector('button[type="submit"]');
            if (submitBtn) {
                const originalHtml = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-check-circle"></i> Opening App...';

                setTimeout(() => {
                    activeForm.reset();
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalHtml;
                }, 3000);
            }
        }
        showToast('Aapka message app par open ho gaya hai. Dhanyawad!');
    }
}

// Simple dynamic Toast notification
function showToast(message) {
    let toast = document.querySelector('.toast-notification');
    if (!toast) {
        toast = document.createElement('div');
        toast.className = 'toast-notification';

        // Style toast dynamically
        Object.assign(toast.style, {
            position: 'fixed',
            bottom: '30px',
            right: '30px',
            background: 'var(--gradient-accent)',
            color: '#fff',
            padding: '1rem 2rem',
            borderRadius: '12px',
            boxShadow: '0 10px 30px rgba(5,150,105,0.4)',
            zIndex: '9999',
            fontFamily: 'var(--font-heading)',
            fontWeight: '600',
            fontSize: '0.9rem',
            opacity: '0',
            transform: 'translateY(20px)',
            transition: 'opacity 0.4s ease, transform 0.4s ease',
            display: 'flex',
            alignItems: 'center',
            gap: '0.75rem'
        });

        document.body.appendChild(toast);
    }

    toast.innerHTML = `<i class="fas fa-check-circle" style="font-size: 1.2rem;"></i> ${message}`;

    // Animate In
    setTimeout(() => {
        toast.style.opacity = '1';
        toast.style.transform = 'translateY(0)';
    }, 100);

    // Animate Out
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(20px)';
    }, 4000);
}

/* ==========================================================================
   11. Interactive Policy & Document Modal Viewer
   ========================================================================== */
function initDocModal() {
    const modal = document.getElementById('document-modal');
    const modalTitle = document.getElementById('doc-modal-title');
    const modalBody = document.getElementById('doc-modal-body');
    const closeBtn = document.querySelector('.doc-modal-close');

    if (!modal || !modalTitle || !modalBody) return;

    const links = {
        'foot-privacy': { titleKey: 'foot-privacy', bodyKey: 'doc-privacy-body' },
        'foot-terms': { titleKey: 'foot-terms', bodyKey: 'doc-terms-body' },
        'foot-audits': { titleKey: 'foot-audits', bodyKey: 'doc-audits-body' }
    };

    // Attach click listeners to footer links
    Object.keys(links).forEach(key => {
        const el = document.querySelector(`[data-i18n="${key}"]`);
        if (el) {
            el.addEventListener('click', (e) => {
                e.preventDefault();
                const currentLang = localStorage.getItem('zoon-lang') || 'roman';
                const trans = window.translations[currentLang] || window.translations['roman'];

                const titleText = trans[links[key].titleKey] || el.textContent;
                const bodyText = trans[links[key].bodyKey] || "Content loading...";

                modalTitle.textContent = titleText;
                modalBody.innerHTML = bodyText;

                modal.classList.add('active');
            });
        }
    });

    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            modal.classList.remove('active');
        });

        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.remove('active');
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modal.classList.contains('active')) {
                modal.classList.remove('active');
            }
        });
    }
}

