
<div class="banner-section col-12 px-0">
    <div class="banner-container">
        <img src="https://www.durotechindustries.com.au/banner/casestudy_banner.jpg"
             alt="Case Study Banner"
             class="img-fluid w-100 d-block banner-img">
    </div>
</div>

<div class="content_projects col-12 testimonials-page-wrap">

    <section class="page-testimonials" aria-labelledby="testimonials-heading">
        <div class="container py-5">

            <header class="page-testimonials-header text-center mb-5">
                <h1 id="testimonials-heading" class="page-testimonials-title">What Our Clients Say</h1>
                <p class="page-testimonials-subtitle section-subtitle">
                    Real experiences from our valued customers across Australia.
                </p>
            </header>

            <?php if (!empty($testimonials)): ?>
            <div class="row page-testimonials-grid">
                <?php foreach ($testimonials as $idx => $t):
                    // Support legacy ['Testimonial' => …], flat arrays, or entity objects from the controller.
                    $cell = $t['Testimonial'] ?? $t;
                    if (is_object($cell) && method_exists($cell, 'toArray')) {
                        $cell = $cell->toArray();
                    } elseif (!is_array($cell)) {
                        $cell = [];
                    }
                    $quote = trim((string)($cell['quote'] ?? ''));
                    $name = trim((string)($cell['name'] ?? $cell['client_name'] ?? $cell['customer_name'] ?? ''));
                    $company = trim((string)($cell['company_name'] ?? $cell['company'] ?? ''));
                    $role = trim((string)($cell['role'] ?? ''));
                    $displayName = $name !== '' ? $name : $company;
                    $showCompanyLine = $company !== '' && $name !== '';
                ?>
                <div class="col-md-6 col-xl-4 page-testimonials-grid-item" style="--stagger: <?php echo (int)$idx; ?>;">
                    <article class="testimonial-page-card">
                        <span class="testimonial-page-quote-mark" aria-hidden="true">“</span>
                        <blockquote class="testimonial-page-quote">
                            <div class="testimonial-page-quote-body">
                                <?php if ($quote !== ''): ?>
                                    <p><?php echo nl2br(h($quote)); ?></p>
                                <?php else: ?>
                                    <p class="text-muted fst-italic">Thank you for your continued trust in Durotech.</p>
                                <?php endif; ?>
                            </div>
                            <?php if ($displayName !== '' || $role !== ''): ?>
                            <div class="testimonial-page-attribution">
                                <?php if ($displayName !== ''): ?>
                                    <p class="testimonial-page-name"><?php echo h($displayName); ?></p>
                                <?php endif; ?>
                                <?php if ($showCompanyLine): ?>
                                    <p class="testimonial-page-company"><?php echo h($company); ?></p>
                                <?php endif; ?>
                                <?php if ($role !== ''): ?>
                                    <p class="testimonial-page-role"><?php echo h($role); ?></p>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                        </blockquote>
                    </article>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="page-testimonials-empty testimonial-page-card text-center py-5 px-4">
                <p class="testimonial-page-quote mb-0">No testimonials available right now. Please check back soon.</p>
            </div>
            <?php endif; ?>

        </div>
    </section>
</div>

<style>
/* Testimonials page — aligned with home “home-testimonials” look (no photos) */
.page-testimonials {
    background: linear-gradient(180deg, #f0f6fb 0%, #f7f7f7 35%, #fafafa 100%);
    padding-bottom: 2rem;
}

.page-testimonials-header {
    animation: pageTestimonialsFadeUp 0.7s ease-out both;
}

.page-testimonials-title {
    color: #2889c8;
    font-size: clamp(1.75rem, 4vw, 2.25rem);
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.page-testimonials-subtitle.section-subtitle {
    color: #585a5a;
    font-size: 1.05rem;
    max-width: 36rem;
    margin-left: auto;
    margin-right: auto;
    margin-bottom: 0;
}

.page-testimonials-grid {
    margin-left: -18px;
    margin-right: -18px;
}

.page-testimonials-grid-item {
    animation: pageTestimonialsFadeUp 0.65s ease-out both;
    animation-delay: calc(0.08s * var(--stagger, 0));
    padding-left: 18px;
    padding-right: 18px;
    margin-bottom: 36px;
}

@keyframes pageTestimonialsFadeUp {
    from {
        opacity: 0;
        transform: translateY(18px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.testimonial-page-card {
    position: relative;
    background: #fff;
    border: 1px solid #dfdfdf;
    border-radius: 14px;
    padding: 2.25rem 2rem 2rem;
    min-height: 240px;
    height: 100%;
    box-shadow:
        0 4px 14px rgba(40, 137, 200, 0.06),
        0 2px 6px rgba(0, 0, 0, 0.04);
    transition:
        transform 0.35s cubic-bezier(0.22, 1, 0.36, 1),
        box-shadow 0.35s ease,
        border-color 0.35s ease;
    overflow: hidden;
}

.testimonial-page-card::before {
    content: "";
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    background: linear-gradient(180deg, #2889c8 0%, #1e6a9a 100%);
    opacity: 0.85;
    transform: scaleY(0.35);
    transform-origin: top;
    transition: transform 0.35s ease, opacity 0.35s ease;
}

.testimonial-page-card:hover {
    transform: translateY(-8px);
    border-color: rgba(40, 137, 200, 0.45);
    box-shadow:
        0 18px 40px rgba(40, 137, 200, 0.18),
        0 8px 20px rgba(255, 193, 7, 0.12),
        0 0 0 1px rgba(40, 137, 200, 0.08);
}

.testimonial-page-card:hover::before {
    transform: scaleY(1);
    opacity: 1;
}

.testimonial-page-quote-mark {
    position: absolute;
    top: 0.75rem;
    right: 1.25rem;
    z-index: 0;
    font-family: Georgia, "Times New Roman", serif;
    font-size: 4.5rem;
    line-height: 1;
    color: rgba(40, 137, 200, 0.12);
    pointer-events: none;
    transition: color 0.35s ease, transform 0.35s ease;
}

.testimonial-page-card:hover .testimonial-page-quote-mark {
    color: rgba(255, 193, 7, 0.35);
    transform: scale(1.05);
}

.testimonial-page-quote {
    display: flex;
    flex-direction: column;
    margin: 0;
    padding: 0.25rem 2.25rem 0 0;
    min-height: 200px;
    border: 0;
    position: relative;
    z-index: 1;
}

.testimonial-page-quote-body {
    flex: 1 1 auto;
    padding-bottom: 0.5rem;
}

.testimonial-page-quote-body p {
    color: #666;
    font-style: italic;
    font-size: 16px;
    line-height: 1.7;
    margin: 0;
}

.testimonial-page-attribution {
    margin-top: 1.5rem;
    padding-top: 1.25rem;
    border-top: 1px solid rgba(0, 0, 0, 0.06);
    text-align: right;
}

.testimonial-page-name {
    color: #b38b3e;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    font-size: 15px;
    margin: 0 0 0.4rem;
    transition: color 0.3s ease;
}

.testimonial-page-card:hover .testimonial-page-name {
    color: #2889c8;
}

.testimonial-page-company {
    color: #444;
    font-size: 14px;
    font-weight: 600;
    margin: 0 0 0.35rem;
}

.testimonial-page-role {
    color: #2889c8;
    font-size: 13px;
    margin: 0;
    font-weight: 500;
    padding-top: 0.15rem;
}

.page-testimonials-empty {
    max-width: 520px;
    margin-left: auto;
    margin-right: auto;
}

@media (prefers-reduced-motion: reduce) {
    .page-testimonials-header,
    .page-testimonials-grid-item {
        animation: none;
    }
    .testimonial-page-card {
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .testimonial-page-card:hover {
        transform: none;
    }
}
</style>
