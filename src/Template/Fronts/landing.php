<style>
.landing-page {
    --lp-blue: #2889c8;
    --lp-blue-dark: #1b4762;
    --lp-blue-soft: #e4edf4;
    --lp-gold: #f4c400;
    --lp-ink: #1a4860;
    --lp-muted: #536f8c;
    --lp-white: #ffffff;
    --lp-radius: 16px;
    --lp-shadow: 0 8px 28px rgba(27, 71, 98, 0.1);
    --lp-ease: cubic-bezier(0.22, 1, 0.36, 1);
    --lp-ease-spring: cubic-bezier(0.34, 1.56, 0.64, 1);
    font-family: Raleway, "Segoe UI", system-ui, -apple-system, sans-serif;
}
@keyframes lpKenBurns {
    from { transform: scale(1); }
    to { transform: scale(1.06); }
}
@keyframes lpShimmer {
    0% { background-position: 200% center; }
    100% { background-position: -200% center; }
}
@keyframes lpFloat {
    0%, 100% { transform: translate(0, 0); }
    50% { transform: translate(12px, -18px); }
}
@keyframes lpFadeUp {
    from { opacity: 0; transform: translateY(36px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes lpScaleIn {
    from { opacity: 0; transform: scale(0.92) translateY(24px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
}
@keyframes lpIconPop {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.12); }
}
.landing-page.page-about-wrap {
    padding-top: 70px;
    background: linear-gradient(180deg, #eef5fa 0%, #e4edf4 40%, #dce9f2 100%);
}
@media (min-width: 768px) {
    .landing-page.page-about-wrap {
        padding-top: 80px;
    }
}
.landing-page > .content_about {
    padding: 0 0 0;
}

/* Scroll reveal */
.landing-page .lp-reveal {
    opacity: 0;
    transform: translateY(32px);
    transition: opacity 0.7s var(--lp-ease), transform 0.7s var(--lp-ease);
    will-change: opacity, transform;
}
.landing-page .lp-reveal.lp-reveal--scale {
    transform: scale(0.94) translateY(20px);
}
.landing-page .lp-reveal.is-visible {
    opacity: 1;
    transform: none;
}
.landing-page .lp-hero-in {
    animation: lpFadeUp 0.9s var(--lp-ease) both;
}
.landing-page .lp-hero-in--delay {
    animation: lpScaleIn 1s var(--lp-ease) 0.15s both;
}

/* Hero */
.landing-hero {
    position: relative;
    overflow: hidden;
    line-height: 0;
}
.landing-hero__inner {
    overflow: hidden;
    display: block;
}
.landing-hero img {
    display: block;
    width: 100%;
    height: auto;
    animation: lpKenBurns 18s var(--lp-ease) infinite alternate;
    transform-origin: center center;
}
.landing-hero::before {
    content: "";
    position: absolute;
    inset: 0;
    z-index: 1;
    background: linear-gradient(180deg, transparent 55%, rgba(27, 71, 98, 0.18) 100%);
    pointer-events: none;
}
.landing-hero::after {
    content: "";
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 2;
    height: 6px;
    background: linear-gradient(90deg, var(--lp-blue-dark), var(--lp-blue) 35%, var(--lp-gold) 50%, var(--lp-blue) 65%, var(--lp-blue-dark));
    background-size: 200% auto;
    animation: lpShimmer 4s linear infinite;
}

/* Intro */
.landing-intro-wrap {
    max-width: 1080px;
    margin: -32px auto 0;
    padding: 0 16px;
    position: relative;
    z-index: 3;
}
@media (min-width: 768px) {
    .landing-intro-wrap {
        margin-top: -48px;
        padding: 0 24px;
    }
}
.landing-intro {
    background: var(--lp-white);
    border-radius: var(--lp-radius);
    box-shadow: var(--lp-shadow);
    border: 1px solid rgba(40, 137, 200, 0.12);
    padding: 32px 24px 28px;
    text-align: center;
    transition: box-shadow 0.4s var(--lp-ease), transform 0.4s var(--lp-ease);
}
.landing-intro:hover {
    box-shadow: 0 16px 48px rgba(27, 71, 98, 0.14);
}
@media (min-width: 768px) {
    .landing-intro {
        padding: 44px 56px 40px;
    }
}
.landing-intro__eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin: 0 0 14px;
    padding: 6px 14px;
    border-radius: 999px;
    background: rgba(40, 137, 200, 0.1);
    color: var(--lp-blue);
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    transition: background 0.3s ease, transform 0.3s var(--lp-ease-spring);
}
.landing-intro:hover .landing-intro__eyebrow {
    background: rgba(40, 137, 200, 0.16);
    transform: scale(1.03);
}
.landing-intro__eyebrow .fa {
    font-size: 14px;
    transition: transform 0.4s var(--lp-ease-spring);
}
.landing-intro:hover .landing-intro__eyebrow .fa {
    transform: scale(1.15);
}
.landing-intro h1 {
    margin: 0 0 16px;
    font-size: 28px;
    font-weight: 800;
    line-height: 1.2;
    color: var(--lp-blue-dark);
}
@media (min-width: 768px) {
    .landing-intro h1 {
        font-size: 40px;
    }
}
.landing-intro__lead {
    margin: 0 auto 24px;
    max-width: 720px;
    font-size: 17px;
    line-height: 1.75;
    color: var(--lp-muted);
}
.landing-intro__actions {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    justify-content: center;
}
.landing-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 14px 28px;
    border-radius: 999px;
    font-size: 15px;
    font-weight: 700;
    text-decoration: none !important;
    transition: transform 0.35s var(--lp-ease-spring), box-shadow 0.35s var(--lp-ease), background 0.35s ease, border-color 0.35s ease, color 0.35s ease;
    position: relative;
    overflow: hidden;
}
.landing-btn .fa {
    transition: transform 0.35s var(--lp-ease-spring);
}
.landing-btn:hover {
    transform: translateY(-3px) scale(1.02);
    text-decoration: none !important;
}
.landing-btn:hover .fa {
    transform: scale(1.15);
}
.landing-btn:active {
    transform: translateY(-1px) scale(0.98);
}
.landing-btn--primary {
    background: linear-gradient(135deg, var(--lp-blue-dark) 0%, var(--lp-blue) 100%);
    background-size: 200% 200%;
    color: var(--lp-white) !important;
    box-shadow: 0 6px 20px rgba(40, 137, 200, 0.35);
}
.landing-btn--primary:hover {
    color: var(--lp-white) !important;
    background-position: 100% 100%;
    box-shadow: 0 12px 32px rgba(40, 137, 200, 0.5);
}
.landing-btn--outline {
    background: var(--lp-white);
    color: var(--lp-blue-dark) !important;
    border: 2px solid rgba(27, 71, 98, 0.2);
}
.landing-btn--outline:hover {
    border-color: var(--lp-blue);
    color: var(--lp-blue) !important;
    box-shadow: 0 8px 24px rgba(40, 137, 200, 0.15);
}

/* Stats */
.landing-stats {
    max-width: 1080px;
    margin: 28px auto 0;
    padding: 0 16px;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
}
@media (min-width: 768px) {
    .landing-stats {
        grid-template-columns: repeat(4, 1fr);
        padding: 0 24px;
        gap: 16px;
    }
}
.landing-stat {
    background: var(--lp-white);
    border-radius: 12px;
    padding: 20px 14px;
    text-align: center;
    box-shadow: 0 4px 16px rgba(27, 71, 98, 0.06);
    border: 1px solid rgba(40, 137, 200, 0.08);
    transition: transform 0.4s var(--lp-ease-spring), box-shadow 0.4s var(--lp-ease), border-color 0.3s ease;
}
.landing-stat:hover {
    transform: translateY(-6px) scale(1.02);
    box-shadow: 0 14px 32px rgba(40, 137, 200, 0.18);
    border-color: rgba(40, 137, 200, 0.25);
}
.landing-stat strong {
    display: block;
    font-size: 26px;
    font-weight: 800;
    color: var(--lp-blue);
    line-height: 1.1;
    margin-bottom: 4px;
    transition: color 0.3s ease, transform 0.4s var(--lp-ease-spring);
}
.landing-stat:hover strong {
    color: var(--lp-blue-dark);
    transform: scale(1.05);
}
@media (min-width: 768px) {
    .landing-stat strong {
        font-size: 30px;
    }
}
.landing-stat span {
    font-size: 12px;
    font-weight: 600;
    color: var(--lp-muted);
    text-transform: uppercase;
    letter-spacing: 0.04em;
    line-height: 1.3;
}

/* Features */
.landing-features {
    max-width: 1080px;
    margin: 36px auto 0;
    padding: 0 16px 48px;
}
@media (min-width: 768px) {
    .landing-features {
        padding: 0 24px 56px;
    }
}
.landing-features__head {
    text-align: center;
    margin-bottom: 28px;
}
.landing-features__head h2 {
    margin: 0 0 8px;
    font-size: 26px;
    font-weight: 800;
    color: var(--lp-blue-dark);
}
@media (min-width: 768px) {
    .landing-features__head h2 {
        font-size: 32px;
    }
}
.landing-features__head p {
    margin: 0;
    color: var(--lp-muted);
    font-size: 16px;
}
.landing-features__grid {
    display: grid;
    gap: 16px;
}
@media (min-width: 768px) {
    .landing-features__grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }
}
.landing-feature {
    background: var(--lp-white);
    border-radius: var(--lp-radius);
    padding: 28px 22px 26px;
    text-align: center;
    box-shadow: var(--lp-shadow);
    border: 1px solid rgba(40, 137, 200, 0.08);
    transition: transform 0.45s var(--lp-ease-spring), box-shadow 0.45s var(--lp-ease), border-color 0.3s ease;
    height: 100%;
}
.landing-feature:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 44px rgba(27, 71, 98, 0.16);
    border-color: rgba(40, 137, 200, 0.22);
}
.landing-feature__icon {
    width: 56px;
    height: 56px;
    margin: 0 auto 16px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, rgba(40, 137, 200, 0.15) 0%, rgba(244, 196, 0, 0.2) 100%);
    color: var(--lp-blue-dark);
    font-size: 24px;
    transition: transform 0.45s var(--lp-ease-spring), background 0.4s ease;
}
.landing-feature:hover .landing-feature__icon {
    transform: scale(1.12) rotate(-6deg);
    background: linear-gradient(135deg, rgba(40, 137, 200, 0.28) 0%, rgba(244, 196, 0, 0.35) 100%);
    animation: lpIconPop 0.6s var(--lp-ease-spring);
}
.landing-feature h3 {
    margin: 0 0 10px;
    font-size: 18px;
    font-weight: 700;
    color: var(--lp-blue-dark);
    transition: color 0.3s ease;
}
.landing-feature:hover h3 {
    color: var(--lp-blue);
}
.landing-feature p {
    margin: 0;
    font-size: 14px;
    line-height: 1.7;
    color: var(--lp-muted);
}

/* CTA band */
.landing-cta-band {
    background: linear-gradient(135deg, var(--lp-blue-dark) 0%, #1a5f8a 50%, var(--lp-blue) 100%);
    background-size: 200% 200%;
    animation: lpCtaGradient 8s ease infinite alternate;
    padding: 48px 20px;
    text-align: center;
    position: relative;
    overflow: hidden;
}
@keyframes lpCtaGradient {
    from { background-position: 0% 50%; }
    to { background-position: 100% 50%; }
}
.landing-cta-band::before {
    content: "";
    position: absolute;
    top: -40%;
    right: -10%;
    width: 320px;
    height: 320px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.06);
    pointer-events: none;
    animation: lpFloat 9s ease-in-out infinite;
}
.landing-cta-band::after {
    content: "";
    position: absolute;
    bottom: -50%;
    left: -5%;
    width: 280px;
    height: 280px;
    border-radius: 50%;
    background: rgba(244, 196, 0, 0.12);
    pointer-events: none;
    animation: lpFloat 11s ease-in-out infinite reverse;
}
.landing-cta-band__inner {
    position: relative;
    z-index: 1;
    max-width: 640px;
    margin: 0 auto;
}
.landing-cta-band h2 {
    margin: 0 0 12px;
    font-size: 26px;
    font-weight: 800;
    color: var(--lp-white);
    line-height: 1.25;
}
@media (min-width: 768px) {
    .landing-cta-band h2 {
        font-size: 34px;
    }
}
.landing-cta-band p {
    margin: 0 0 28px;
    font-size: 16px;
    line-height: 1.65;
    color: rgba(255, 255, 255, 0.88);
}
.landing-cta-band .landing-btn--primary {
    background: var(--lp-white);
    color: var(--lp-blue-dark) !important;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
}
.landing-cta-band .landing-btn--primary:hover {
    color: var(--lp-blue) !important;
    background: var(--lp-gold);
}
.landing-cta-band .landing-btn--ghost {
    background: transparent;
    color: var(--lp-white) !important;
    border: 2px solid rgba(255, 255, 255, 0.5);
}
.landing-cta-band .landing-btn--ghost:hover {
    background: rgba(255, 255, 255, 0.12);
    border-color: var(--lp-white);
    color: var(--lp-white) !important;
}

/* Quick links */
.landing-links {
    max-width: 1080px;
    margin: 0 auto;
    padding: 32px 16px 40px;
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    justify-content: center;
}
@media (min-width: 768px) {
    .landing-links {
        padding: 36px 24px 48px;
    }
}
.landing-link-card {
    flex: 1 1 140px;
    max-width: 200px;
    display: block;
    padding: 18px 14px;
    background: var(--lp-white);
    border-radius: 12px;
    text-align: center;
    text-decoration: none !important;
    border: 1px solid rgba(40, 137, 200, 0.1);
    box-shadow: 0 4px 14px rgba(27, 71, 98, 0.06);
    transition: transform 0.4s var(--lp-ease-spring), box-shadow 0.4s var(--lp-ease), border-color 0.3s ease;
}
.landing-link-card:hover {
    transform: translateY(-6px) scale(1.03);
    border-color: var(--lp-blue);
    box-shadow: 0 16px 36px rgba(40, 137, 200, 0.2);
    text-decoration: none !important;
}
.landing-link-card img {
    width: 40px;
    height: 40px;
    object-fit: contain;
    margin-bottom: 8px;
    transition: transform 0.45s var(--lp-ease-spring);
}
.landing-link-card:hover img {
    transform: scale(1.15) translateY(-4px);
}
.landing-link-card strong {
    display: block;
    font-size: 13px;
    font-weight: 700;
    color: var(--lp-blue-dark);
    transition: color 0.3s ease;
}
.landing-link-card:hover strong {
    color: var(--lp-blue);
}

/* Accessibility */
@media (prefers-reduced-motion: reduce) {
    .landing-page .lp-reveal {
        opacity: 1;
        transform: none;
        transition: none;
    }
    .landing-page .lp-hero-in,
    .landing-page .lp-hero-in--delay,
    .landing-hero img,
    .landing-hero::after,
    .landing-cta-band,
    .landing-cta-band::before,
    .landing-cta-band::after,
    .landing-feature:hover .landing-feature__icon {
        animation: none;
    }
    .landing-btn,
    .landing-stat,
    .landing-feature,
    .landing-link-card,
    .landing-intro,
    .landing-feature__icon,
    .landing-link-card img {
        transition: none;
    }
}
</style>

<?php
$landingPhone = defined('PHONE') && PHONE !== '' ? PHONE : '1300 434 272';
$landingPhoneTel = preg_replace('/\D+/', '', $landingPhone);
$landingEmail = 'sales@durotechindustries.com.au';
?>

<div class="landing-page page-about-wrap">
    <div class="content_about col-lg-12 col-md-12 col-sm-12">

        <div class="landing-hero lp-hero-in">
            <div class="landing-hero__inner">
                <img src="<?php echo SITEURL; ?>customdurotech/images/slider/banner 4.jpg" alt="We Deliver Australia Wide — Durotech">
            </div>
        </div>

        <div class="landing-intro-wrap">
            <div class="landing-intro lp-hero-in--delay">
                <p class="landing-intro__eyebrow"><i class="fa fa-map-marker" aria-hidden="true"></i> Australia-Wide Delivery</p>
                <h1>Waterproofing Solutions, Delivered to Your Project</h1>
                <p class="landing-intro__lead">
                    Call or email our team for project-specific advice and delivery options direct to you — anywhere in Australia.
                    Durotech is a <?php echo (int)DUROTECH_YEARS; ?>-year Australian made and owned construction chemical manufacturer,
                    trusted by contractors, architects, and specifiers since <?php echo (int)DUROTECH_FOUNDED_YEAR; ?>.
                </p>
                <div class="landing-intro__actions">
                    <a href="<?php echo SITEURL; ?>contact" class="landing-btn landing-btn--primary">
                        <i class="fa fa-envelope" aria-hidden="true"></i> Contact Our Team
                    </a>
                    <a href="tel:<?php echo h($landingPhoneTel); ?>" class="landing-btn landing-btn--outline">
                        <i class="fa fa-phone" aria-hidden="true"></i> <?php echo h($landingPhone); ?>
                    </a>
                </div>
            </div>
        </div>

        <div class="landing-stats">
            <div class="landing-stat lp-reveal" data-lp-delay="0">
                <strong data-lp-count="<?php echo (int)DUROTECH_YEARS; ?>" data-lp-suffix="+">0+</strong>
                <span>Years of Excellence</span>
            </div>
            <div class="landing-stat lp-reveal" data-lp-delay="100">
                <strong>100%</strong>
                <span>Australian Made &amp; Owned</span>
            </div>
            <div class="landing-stat lp-reveal" data-lp-delay="200">
                <strong>Nationwide</strong>
                <span>Delivery Coverage</span>
            </div>
            <div class="landing-stat lp-reveal" data-lp-delay="300">
                <strong>Expert</strong>
                <span>Project Support</span>
            </div>
        </div>

        <div class="landing-features">
            <div class="landing-features__head lp-reveal">
                <h2>Why Builders Choose Durotech</h2>
                <p>End-to-end waterproofing and coating systems backed by local manufacturing and technical expertise.</p>
            </div>
            <div class="landing-features__grid">
                <div class="landing-feature lp-reveal lp-reveal--scale" data-lp-delay="0">
                    <div class="landing-feature__icon"><i class="fa fa-comments" aria-hidden="true"></i></div>
                    <h3>Project-Specific Advice</h3>
                    <p>Speak directly with our technical team for tailored recommendations on membranes, coatings, and sealants for your build.</p>
                </div>
                <div class="landing-feature lp-reveal lp-reveal--scale" data-lp-delay="120">
                    <div class="landing-feature__icon"><i class="fa fa-truck" aria-hidden="true"></i></div>
                    <h3>Direct Delivery</h3>
                    <p>We deliver Australia wide — get the right products to your site or warehouse with flexible delivery options.</p>
                </div>
                <div class="landing-feature lp-reveal lp-reveal--scale" data-lp-delay="240">
                    <div class="landing-feature__icon"><i class="fa fa-shield" aria-hidden="true"></i></div>
                    <h3>Proven Systems</h3>
                    <p>Industry-leading waterproofing technology with decades of real-world performance across commercial and residential projects.</p>
                </div>
            </div>
        </div>

        <div class="landing-cta-band lp-reveal">
            <div class="landing-cta-band__inner">
                <h2>Ready to Get Started?</h2>
                <p>Our team is here to help with product selection, specifications, and delivery — reach out today.</p>
                <div class="landing-intro__actions">
                    <a href="<?php echo SITEURL; ?>contact" class="landing-btn landing-btn--primary">
                        <i class="fa fa-paper-plane" aria-hidden="true"></i> Get in Touch
                    </a>
                    <a href="mailto:<?php echo h($landingEmail); ?>" class="landing-btn landing-btn--ghost">
                        <i class="fa fa-envelope" aria-hidden="true"></i> <?php echo h($landingEmail); ?>
                    </a>
                </div>
            </div>
        </div>

        <div class="landing-links">
            <a href="<?php echo SITEURL; ?>products" class="landing-link-card lp-reveal" data-lp-delay="0">
                <img src="<?php echo SITEURL; ?>img/paint-bucket.png" alt="">
                <strong>View Products</strong>
            </a>
            <a href="<?php echo SITEURL; ?>technical-literature" class="landing-link-card lp-reveal" data-lp-delay="80">
                <img src="<?php echo SITEURL; ?>img/book.png" alt="">
                <strong>Technical Literature</strong>
            </a>
            <a href="<?php echo SITEURL; ?>projects" class="landing-link-card lp-reveal" data-lp-delay="160">
                <img src="<?php echo SITEURL; ?>img/chemistry.png" alt="">
                <strong>Case Studies</strong>
            </a>
            <a href="<?php echo SITEURL; ?>about" class="landing-link-card lp-reveal" data-lp-delay="240">
                <img src="<?php echo SITEURL; ?>img/register.png" alt="">
                <strong>About Durotech</strong>
            </a>
        </div>

    </div>
</div>

<script>
(function () {
    var root = document.querySelector('.landing-page');
    if (!root) return;

    var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var reveals = root.querySelectorAll('.lp-reveal');

    function applyDelay(el) {
        var delay = parseInt(el.getAttribute('data-lp-delay') || '0', 10);
        el.style.transitionDelay = (delay / 1000) + 's';
    }

    function animateCounter(el) {
        if (reducedMotion || !el.hasAttribute('data-lp-count')) return;
        var target = parseInt(el.getAttribute('data-lp-count'), 10);
        var suffix = el.getAttribute('data-lp-suffix') || '';
        var start = 0;
        var duration = 1400;
        var startTime = null;

        function step(timestamp) {
            if (!startTime) startTime = timestamp;
            var progress = Math.min((timestamp - startTime) / duration, 1);
            var eased = 1 - Math.pow(1 - progress, 3);
            var value = Math.round(start + (target - start) * eased);
            el.textContent = value + suffix;
            if (progress < 1) window.requestAnimationFrame(step);
        }
        window.requestAnimationFrame(step);
    }

    if (reducedMotion) {
        reveals.forEach(function (el) {
            el.classList.add('is-visible');
            var counter = el.querySelector('[data-lp-count]');
            if (counter) {
                counter.textContent = counter.getAttribute('data-lp-count') + (counter.getAttribute('data-lp-suffix') || '');
            }
        });
        return;
    }

    reveals.forEach(applyDelay);

    if ('IntersectionObserver' in window) {
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                var el = entry.target;
                el.classList.add('is-visible');
                var counter = el.querySelector('[data-lp-count]');
                if (counter) animateCounter(counter);
                observer.unobserve(el);
            });
        }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });

        reveals.forEach(function (el) { observer.observe(el); });
    } else {
        reveals.forEach(function (el) {
            el.classList.add('is-visible');
            var counter = el.querySelector('[data-lp-count]');
            if (counter) {
                counter.textContent = counter.getAttribute('data-lp-count') + (counter.getAttribute('data-lp-suffix') || '');
            }
        });
    }
})();
</script>
