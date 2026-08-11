<?php
$caseData = $case['CaseStudy'] ?? [];

/**
 * Build a public media URL; encodes path segments so spaces/special chars work.
 */
$caseMediaUrl = function ($path) {
    $path = trim((string)$path);
    if ($path === '') {
        return '';
    }
    if (stripos($path, 'http://') === 0 || stripos($path, 'https://') === 0) {
        return $path;
    }
    $segments = array_map('rawurlencode', explode('/', ltrim(str_replace('\\', '/', $path), '/')));
    return rtrim(SITEURL, '/') . '/' . implode('/', $segments);
};

$featuredImage = !empty($caseData['featured_image'])
    ? $caseMediaUrl($caseData['featured_image'])
    : 'https://www.durotechindustries.com.au/banner/Project.jpg';
?>

<style>
.case-study-page-wrap {
    background: #eaf1f7;
    padding-bottom: 44px;
    --case-sticky-offset: 220px;
}

.case-hero {
    position: relative;
    border-radius: 14px;
    overflow: hidden;
    margin-bottom: 28px;
    box-shadow: 0 10px 28px rgba(20, 33, 61, 0.16);
    background: #c5d4e0;
    aspect-ratio: 2.35 / 1;
    max-height: 620px;
    width: 100%;
}

.case-hero__img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center center;
    display: block;
}

.case-hero__overlay {
    position: absolute;
    inset: 0;
    pointer-events: none;
    /* Light fade only at bottom so title stays readable; photo stays clear */
    background: linear-gradient(
        to top,
        rgba(9, 21, 38, 0.55) 0%,
        rgba(9, 21, 38, 0.22) 28%,
        rgba(9, 21, 38, 0.04) 52%,
        transparent 72%
    );
}

.case-hero__content {
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 2;
    padding: 18px 20px;
    color: #fff;
}

.case-hero__title {
    margin: 0 0 10px;
    font-size: clamp(1.45rem, 2vw, 2.05rem);
    font-weight: 700;
    line-height: 1.25;
    text-shadow: 0 2px 12px rgba(0, 0, 0, 0.55);
}

.case-hero__meta {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.case-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(15, 28, 45, 0.45);
    border: 1px solid rgba(255, 255, 255, 0.28);
    border-radius: 999px;
    padding: 6px 12px;
    color: #fff;
    font-size: 0.86rem;
    font-weight: 600;
    backdrop-filter: blur(4px);
}

.case-quick-nav {
    position: sticky;
    top: 90px; /* JS syncs to real #header_top height */
    z-index: 999; /* below fixed site header (1000), above page content */
    background: #fff;
    border: 1px solid rgba(40, 137, 201, 0.18);
    border-radius: 12px;
    box-shadow: 0 6px 16px rgba(20, 33, 61, 0.08);
    margin-bottom: 28px;
    padding: 12px;
    overflow: visible;
    isolation: isolate;
}

.case-quick-nav ul {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    align-items: stretch;
    overflow: visible;
}

.case-quick-nav li {
    margin: 0;
    padding: 0;
    float: none;
    list-style: none;
    overflow: visible;
}

.case-study-page-wrap .case-quick-nav a,
.case-study-page-wrap .case-quick-nav a:link,
.case-study-page-wrap .case-quick-nav a:visited {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    box-sizing: border-box;
    text-decoration: none !important;
    color: #243b4d !important;
    font-weight: 700 !important;
    font-size: 15px !important;
    line-height: 1.35 !important;
    letter-spacing: 0.01em;
    white-space: nowrap;
    padding: 10px 16px !important;
    min-height: 42px;
    border-radius: 999px;
    border: 1px solid transparent;
    background: #f3f7fb;
    overflow: visible;
    text-overflow: clip;
    max-width: none;
    height: auto !important;
    transition: background 0.2s ease, color 0.2s ease, border-color 0.2s ease;
}

.case-study-page-wrap .case-quick-nav a:hover,
.case-study-page-wrap .case-quick-nav a:focus,
.case-study-page-wrap .case-quick-nav a.is-active {
    color: #fff !important;
    background: linear-gradient(90deg, #2889c9, #5a1ea8) !important;
    border-color: transparent;
    outline: none;
}

/* Keep section titles clear of sticky site header + tab bar */
.case-section,
#gallery,
#products-used,
#datasheet,
#summary,
#challenge,
#solution,
#outcome {
    scroll-margin-top: var(--case-sticky-offset);
}

.case-section {
    background: #fff;
    border-radius: 12px;
    border-left: 4px solid #2889c9;
    padding: 22px 22px 20px;
    margin-bottom: 20px;
    box-shadow: 0 6px 16px rgba(20, 33, 61, 0.08);
}

.case-section:nth-of-type(even) {
    border-left-color: #f2c23a;
}

.case-section h4 {
    margin: 0 0 10px;
    font-size: 1.05rem;
    font-weight: 700;
    color: #1f5f8e;
    letter-spacing: 0.04em;
    text-transform: uppercase;
}

.product_text_section {
    font-size: 15px;
    line-height: 1.78;
    color: #374b5f;
    margin: 0;
}

.gallery-title {
    margin: 26px 0 14px;
    font-size: 1.08rem;
    font-weight: 700;
    color: #1f5f8e;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}

.gallery-title-row {
    display: flex;
    align-items: baseline;
    justify-content: space-between;
    gap: 12px;
    flex-wrap: wrap;
    margin: 26px 0 16px;
}
.gallery-title-row .gallery-title {
    margin: 0;
}
.gallery-hint {
    margin: 0;
    font-size: 13px;
    color: #6a849c;
    font-weight: 500;
}

/* Before / After pair */
.project-gallery--compare {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 16px;
    margin-bottom: 8px;
}
.project-gallery--compare .gallery-label {
    margin: 0 0 8px;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    color: #1f5f8e;
}

/* Modern masonry-style photo grid */
.project-gallery--masonry {
    column-count: 3;
    column-gap: 16px;
}
.project-gallery--masonry .gallery-card {
    break-inside: avoid;
    margin: 0 0 16px;
}
.gallery-item {
    display: block;
    position: relative;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 6px 18px rgba(20, 33, 61, 0.1);
    background: #e8eef4;
    text-decoration: none !important;
    border: 1px solid rgba(31, 95, 142, 0.1);
    transition: box-shadow 0.25s ease, transform 0.25s ease, border-color 0.25s ease;
}
.gallery-item img {
    width: 100%;
    height: auto;
    display: block;
    vertical-align: middle;
    transition: transform 0.4s ease;
}
.project-gallery--compare .gallery-item img {
    height: 280px;
    object-fit: cover;
}
.project-gallery--masonry .gallery-item img {
    min-height: 180px;
    max-height: 420px;
    object-fit: cover;
    width: 100%;
}
.gallery-item__overlay {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(180deg, rgba(12, 40, 68, 0.05) 0%, rgba(12, 40, 68, 0.55) 100%);
    opacity: 0;
    transition: opacity 0.25s ease;
    pointer-events: none;
}
.gallery-item__zoom {
    width: 46px;
    height: 46px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.95);
    color: #1f5f8e;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
    transform: translateY(8px);
    transition: transform 0.25s ease;
}
.gallery-item:hover,
.gallery-item:focus {
    box-shadow: 0 12px 28px rgba(20, 33, 61, 0.16);
    border-color: rgba(31, 95, 142, 0.28);
    transform: translateY(-2px);
    outline: none;
}
.gallery-item:hover img,
.gallery-item:focus img {
    transform: scale(1.06);
}
.gallery-item:hover .gallery-item__overlay,
.gallery-item:focus .gallery-item__overlay {
    opacity: 1;
}
.gallery-item:hover .gallery-item__zoom,
.gallery-item:focus .gallery-item__zoom {
    transform: translateY(0);
}

/* Simple lightbox */
.image-lightbox {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 2000;
    background: rgba(6, 16, 30, 0.92);
    align-items: center;
    justify-content: center;
    padding: 26px;
}
.image-lightbox.is-open {
    display: flex;
}
.image-lightbox img {
    max-width: min(1100px, 92vw);
    max-height: 86vh;
    border-radius: 10px;
    box-shadow: 0 16px 36px rgba(0, 0, 0, 0.5);
}
.image-lightbox__close {
    position: absolute;
    top: 16px;
    right: 20px;
    border: 0;
    border-radius: 999px;
    width: 42px;
    height: 42px;
    font-size: 24px;
    line-height: 1;
    color: #fff;
    background: rgba(255, 255, 255, 0.2);
    cursor: pointer;
    z-index: 2;
}
.image-lightbox__close:hover {
    background: rgba(255, 255, 255, 0.32);
}
.image-lightbox__nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 44px;
    height: 44px;
    border: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.18);
    color: #fff;
    font-size: 28px;
    line-height: 1;
    cursor: pointer;
    z-index: 2;
}
.image-lightbox__nav:hover {
    background: rgba(255, 255, 255, 0.32);
}
.image-lightbox__prev { left: 16px; }
.image-lightbox__next { right: 16px; }
.image-lightbox__counter {
    position: absolute;
    bottom: 18px;
    left: 50%;
    transform: translateX(-50%);
    color: rgba(255, 255, 255, 0.85);
    font-size: 13px;
    font-weight: 600;
    letter-spacing: 0.04em;
}

.datasheet-section iframe {
    width: 100%;
    height: 580px;
    border-radius: 10px;
    border: 1px solid #d7e0e8;
    background: #fff;
}

.products-used-section {
    margin: 30px 0 10px;
    position: relative;
    z-index: 1;
}

.products-used-grid {
    display: flex;
    flex-wrap: wrap;
    margin-left: -8px;
    margin-right: -8px;
}

.products-used-col {
    width: 33.3333%;
    padding-left: 8px;
    padding-right: 8px;
    margin-bottom: 16px;
}

.products-used-card {
    height: 100%;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 6px 16px rgba(20, 33, 61, 0.1);
    border: 1px solid rgba(40, 137, 201, 0.1);
    transition: box-shadow 0.24s ease;
}

.products-used-card:hover {
    box-shadow: 0 12px 24px rgba(20, 33, 61, 0.14);
}

.products-used-card__img-wrap {
    background: #f4f8fc;
    text-align: center;
    padding: 14px 12px 8px;
    min-height: 180px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.products-used-card__img-wrap img {
    max-width: 100%;
    max-height: 150px;
    object-fit: contain;
}

.products-used-card__body {
    padding: 12px 14px 14px;
}

.products-used-card__title {
    font-size: 1.04rem;
    margin: 0 0 8px;
    color: #4a1d6a;
    font-weight: 700;
    line-height: 1.3;
}

.products-used-card__desc {
    margin: 0;
    color: #4b6073;
    font-size: 0.9rem;
    line-height: 1.55;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.products-used-card__link {
    display: inline-block;
    margin-top: 10px;
    color: #2e8b57;
    font-weight: 700;
    text-decoration: none;
}

.products-used-card__link:hover {
    color: #236c43;
    text-decoration: none;
}

.case-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 18px;
}

.case-actions .btn {
    border-radius: 9px;
    font-weight: 600;
    padding: 10px 16px;
}

@media (max-width: 992px) {
    .project-gallery--masonry {
        column-count: 2;
    }
}

@media (max-width: 768px) {
    .case-study-page-wrap {
        padding-bottom: 26px;
    }
    .case-hero {
        aspect-ratio: 16 / 10;
        max-height: 420px;
    }
    .case-hero__img {
        object-fit: cover;
        object-position: center center;
    }
    .case-hero__content {
        padding: 12px 12px 14px;
    }
    .case-quick-nav {
        top: 70px;
        padding: 10px;
        margin-bottom: 20px;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .case-quick-nav ul {
        flex-wrap: nowrap;
        width: max-content;
        min-width: 100%;
    }
    .case-study-page-wrap .case-quick-nav a,
    .case-study-page-wrap .case-quick-nav a:link,
    .case-study-page-wrap .case-quick-nav a:visited {
        font-size: 14px !important;
        padding: 9px 14px !important;
        min-height: 40px;
    }
    .case-section,
    #gallery,
    #products-used,
    #datasheet,
    #summary,
    #challenge,
    #solution,
    #outcome {
        scroll-margin-top: var(--case-sticky-offset);
    }
    .case-section {
        padding: 16px;
    }
    .product_text_section {
        font-size: 14px;
        line-height: 1.7;
    }
    .project-gallery--masonry {
        column-count: 2;
        column-gap: 12px;
    }
    .project-gallery--masonry .gallery-card {
        margin-bottom: 12px;
    }
    .project-gallery--compare {
        grid-template-columns: 1fr;
        gap: 12px;
    }
    .project-gallery--compare .gallery-item img {
        height: 220px;
    }
    .project-gallery--masonry .gallery-item img {
        max-height: 320px;
        min-height: 160px;
    }
    .image-lightbox__nav {
        width: 38px;
        height: 38px;
        font-size: 24px;
    }
    .image-lightbox__prev { left: 8px; }
    .image-lightbox__next { right: 8px; }
    .datasheet-section iframe {
        height: 420px;
    }
    .products-used-col {
        width: 50%;
    }
}

@media (max-width: 575px) {
    .project-gallery--masonry {
        column-count: 1;
    }
    .products-used-col {
        width: 100%;
    }
}
</style>

<div class="case-study-page-wrap">
    <div class="container mt-4 mb-5">
        <div class="case-hero">
            <img src="<?= h($featuredImage) ?>" alt="<?= h($caseData['title'] ?? 'Case Study') ?>" class="case-hero__img" loading="eager">
            <div class="case-hero__overlay"></div>
            <div class="case-hero__content">
                <h1 class="case-hero__title"><?= h($caseData['title'] ?? '') ?></h1>
                <div class="case-hero__meta">
                    <?php if (!empty($caseData['location'])): ?>
                        <span class="case-chip">📍 <?= h($caseData['location']) ?></span>
                    <?php endif; ?>
                    <?php if (!empty($caseData['project_date'])): ?>
                        <span class="case-chip">📅 <?= h(format_db_date('d M Y', $caseData['project_date'])) ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <nav class="case-quick-nav" aria-label="Case study sections">
            <ul>
                <?php if (!empty($caseData['short_summary'])): ?><li><a href="#summary">Summary</a></li><?php endif; ?>
                <?php if (!empty($caseData['challenge'])): ?><li><a href="#challenge">Challenge</a></li><?php endif; ?>
                <?php if (!empty($caseData['solution'])): ?><li><a href="#solution">Solution</a></li><?php endif; ?>
                <?php if (!empty($caseData['outcome'])): ?><li><a href="#outcome">Outcome</a></li><?php endif; ?>
                <?php if (!empty($case['CaseImage'])): ?><li><a href="#gallery">Gallery</a></li><?php endif; ?>
                <?php if (!empty($case['CaseProduct'])): ?><li><a href="#products-used">Products Used</a></li><?php endif; ?>
                <?php if (!empty($caseData['datasheet'])): ?><li><a href="#datasheet">Datasheet</a></li><?php endif; ?>
            </ul>
        </nav>

        <?php if (!empty($caseData['short_summary'])): ?>
            <section id="summary" class="case-section">
                <h4>Short Summary</h4>
                <p class="product_text_section"><?= nl2br(h($caseData['short_summary'])) ?></p>
            </section>
        <?php endif; ?>

        <?php if (!empty($caseData['challenge'])): ?>
            <section id="challenge" class="case-section">
                <h4>Challenge</h4>
                <p class="product_text_section"><?= $caseData['challenge'] ?></p>
            </section>
        <?php endif; ?>

        <?php if (!empty($caseData['solution'])): ?>
            <section id="solution" class="case-section">
                <h4>Solution</h4>
                <p class="product_text_section"><?= $caseData['solution'] ?></p>
            </section>
        <?php endif; ?>

        <?php if (!empty($caseData['outcome'])): ?>
            <section id="outcome" class="case-section">
                <h4>Outcome</h4>
                <p class="product_text_section"><?= $caseData['outcome'] ?></p>
            </section>
        <?php endif; ?>

        <?php if (!empty($case['CaseImage'])): ?>
            <?php
            $beforeImg = null;
            $afterImg = null;
            $otherGalleryImages = [];
            foreach ($case['CaseImage'] as $img) {
                $imgType = $img['type'] ?? 'other';
                if ($imgType === 'before') {
                    $beforeImg = $img;
                } elseif ($imgType === 'after') {
                    $afterImg = $img;
                } else {
                    $otherGalleryImages[] = $img;
                }
            }
            ?>
            <section id="gallery" class="case-section">
                <?php if ($beforeImg || $afterImg): ?>
                    <h4 class="gallery-title" style="margin-top:0;">Before / After Comparison</h4>
                    <div class="project-gallery project-gallery--compare">
                        <?php if ($beforeImg): ?>
                            <div>
                                <p class="gallery-label">Before</p>
                                <a href="<?= h($caseMediaUrl($beforeImg['filename'] ?? '')) ?>" class="gallery-item" data-lightbox="case-gallery">
                                    <img src="<?= h($caseMediaUrl($beforeImg['filename'] ?? '')) ?>" alt="Before" loading="lazy">
                                    <span class="gallery-item__overlay" aria-hidden="true"><span class="gallery-item__zoom"><i class="fa fa-search-plus"></i></span></span>
                                </a>
                            </div>
                        <?php endif; ?>
                        <?php if ($afterImg): ?>
                            <div>
                                <p class="gallery-label">After</p>
                                <a href="<?= h($caseMediaUrl($afterImg['filename'] ?? '')) ?>" class="gallery-item" data-lightbox="case-gallery">
                                    <img src="<?= h($caseMediaUrl($afterImg['filename'] ?? '')) ?>" alt="After" loading="lazy">
                                    <span class="gallery-item__overlay" aria-hidden="true"><span class="gallery-item__zoom"><i class="fa fa-search-plus"></i></span></span>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($otherGalleryImages)): ?>
                    <div class="gallery-title-row"<?= ($beforeImg || $afterImg) ? '' : ' style="margin-top:0;"' ?>>
                        <h4 class="gallery-title">Project Photo Gallery</h4>
                        <p class="gallery-hint">Click any photo to enlarge</p>
                    </div>
                    <div class="project-gallery project-gallery--masonry">
                        <?php foreach ($otherGalleryImages as $img): ?>
                            <div class="gallery-card">
                                <a href="<?= h($caseMediaUrl($img['filename'] ?? '')) ?>" class="gallery-item" data-lightbox="case-gallery">
                                    <img src="<?= h($caseMediaUrl($img['filename'] ?? '')) ?>" alt="Project photo" loading="lazy">
                                    <span class="gallery-item__overlay" aria-hidden="true"><span class="gallery-item__zoom"><i class="fa fa-search-plus"></i></span></span>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>
        <?php endif; ?>

        <?php if (!empty($case['CaseProduct'])): ?>
            <section id="products-used" class="products-used-section">
                <h4 class="gallery-title">Products Used</h4>
                <div class="products-used-grid">
                    <?php foreach ($case['CaseProduct'] as $prod): ?>
                        <?php
                        $prodSlug = $prod['slug'] ?? '';
                        $prodUrl = $prodSlug !== '' ? $this->Url->build('/product/' . $prodSlug) : $this->Url->build('/product');
                        $prodTitle = $prod['title'] ?? 'Product';
                        $prodDesc = trim(strip_tags((string)($prod['brief_description'] ?? '')));
                        $prodImage = trim((string)($prod['image'] ?? ''));
                        if ($prodImage !== '' && $prodImage !== '250250-defult.png') {
                            $imgUrl = $caseMediaUrl('productimg/' . ltrim($prodImage, '/'));
                        } else {
                            $imgUrl = $caseMediaUrl('productimg/250250-defult.png');
                        }
                        ?>
                        <div class="products-used-col">
                            <div class="products-used-card">
                                <a href="<?= h($prodUrl) ?>" class="products-used-card__img-wrap">
                                    <img src="<?= h($imgUrl) ?>" alt="<?= h($prodTitle) ?>" loading="lazy"
                                         onerror="this.onerror=null;this.src='<?= h($caseMediaUrl('productimg/250250-defult.png')) ?>';">
                                </a>
                                <div class="products-used-card__body">
                                    <h5 class="products-used-card__title"><?= h($prodTitle) ?></h5>
                                    <?php if ($prodDesc !== ''): ?>
                                        <p class="products-used-card__desc"><?= h($prodDesc) ?></p>
                                    <?php endif; ?>
                                    <a href="<?= h($prodUrl) ?>" class="products-used-card__link">View Product →</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

        <?php if (!empty($caseData['datasheet'])): ?>
            <section id="datasheet" class="case-section datasheet-section text-center mt-4">
                <h4><i class="fa fa-file-pdf-o text-danger"></i> Datasheet</h4>
                <iframe src="<?= h(SITEURL . $caseData['datasheet']) ?>"></iframe>
                <div class="case-actions">
                    <a href="<?= h(SITEURL . $caseData['datasheet']) ?>" class="btn btn-outline-primary" target="_blank" rel="noopener">
                        <i class="fa fa-download"></i> Download Datasheet
                    </a>
                </div>
            </section>
        <?php endif; ?>

        <section class="case-section mt-4">
            <h4>Products &amp; Support</h4>
            <p class="product_text_section">
                View our <a href="<?= h($this->Url->build('/product')) ?>">waterproofing products</a> and <a href="<?= h($this->Url->build('/projects')) ?>">more case studies</a>.
                For specifications and technical support, <a href="<?= h($this->Url->build('/contact')) ?>">contact us</a>.
            </p>
            <div class="case-actions">
                <a href="<?= h(SITEURL . 'projects') ?>" class="btn btn-secondary">← Back to Projects</a>
                <a href="<?= h($this->Url->build('/contact')) ?>" class="btn btn-primary">Request Technical Support</a>
            </div>
        </section>
    </div>
</div>

<div class="image-lightbox" id="imageLightbox" aria-hidden="true">
    <button type="button" class="image-lightbox__close" id="imageLightboxClose" aria-label="Close image">×</button>
    <button type="button" class="image-lightbox__nav image-lightbox__prev" id="imageLightboxPrev" aria-label="Previous image">‹</button>
    <button type="button" class="image-lightbox__nav image-lightbox__next" id="imageLightboxNext" aria-label="Next image">›</button>
    <img src="" alt="Preview" id="imageLightboxImg">
    <div class="image-lightbox__counter" id="imageLightboxCounter"></div>
</div>

<script>
(function () {
    var nav = document.querySelector('.case-quick-nav');
    var pageWrap = document.querySelector('.case-study-page-wrap');
    var links = document.querySelectorAll('.case-quick-nav a[href^="#"]');

    function headerHeight() {
        var header = document.getElementById('header_top');
        if (!header) {
            return window.matchMedia('(max-width: 768px)').matches ? 70 : 90;
        }
        return Math.max(60, Math.ceil(header.getBoundingClientRect().height));
    }

    function syncStickyMetrics() {
        var headerH = headerHeight();
        var navH = nav ? Math.ceil(nav.getBoundingClientRect().height) : 0;
        if (nav) {
            nav.style.top = headerH + 'px';
        }
        var offset = headerH + navH + 28;
        if (pageWrap) {
            pageWrap.style.setProperty('--case-sticky-offset', offset + 'px');
        }
        return offset;
    }

    function scrollOffset() {
        return syncStickyMetrics();
    }

    links.forEach(function (link) {
        link.addEventListener('click', function (e) {
            var id = this.getAttribute('href').slice(1);
            var target = document.getElementById(id);
            if (!target) return;
            e.preventDefault();
            var top = target.getBoundingClientRect().top + window.pageYOffset - scrollOffset();
            window.scrollTo({ top: Math.max(0, top), behavior: 'smooth' });
            if (history.replaceState) {
                history.replaceState(null, '', '#' + id);
            }
        });
    });

    var sections = [];
    links.forEach(function (link) {
        var id = link.getAttribute('href').slice(1);
        var target = document.getElementById(id);
        if (target) {
            sections.push({ id: id, link: link, node: target });
        }
    });
    function updateActive() {
        var scrollPos = window.pageYOffset + scrollOffset() + 8;
        var currentId = '';
        sections.forEach(function (item) {
            if (item.node.offsetTop <= scrollPos) {
                currentId = item.id;
            }
        });
        sections.forEach(function (item) {
            item.link.classList.toggle('is-active', item.id === currentId);
        });
    }
    window.addEventListener('scroll', updateActive, { passive: true });
    window.addEventListener('resize', function () {
        syncStickyMetrics();
        updateActive();
    }, { passive: true });
    syncStickyMetrics();
    updateActive();

    var lightbox = document.getElementById('imageLightbox');
    var lightboxImg = document.getElementById('imageLightboxImg');
    var closeBtn = document.getElementById('imageLightboxClose');
    var prevBtn = document.getElementById('imageLightboxPrev');
    var nextBtn = document.getElementById('imageLightboxNext');
    var counterEl = document.getElementById('imageLightboxCounter');
    var galleryLinks = Array.prototype.slice.call(document.querySelectorAll('[data-lightbox="case-gallery"]'));
    var currentIndex = 0;

    function updateLightbox() {
        if (!galleryLinks.length) return;
        var link = galleryLinks[currentIndex];
        lightboxImg.src = link.getAttribute('href');
        lightboxImg.alt = link.querySelector('img') ? (link.querySelector('img').getAttribute('alt') || 'Preview') : 'Preview';
        if (counterEl) {
            counterEl.textContent = (currentIndex + 1) + ' / ' + galleryLinks.length;
        }
    }

    function openLightbox(index) {
        if (!galleryLinks.length) return;
        currentIndex = index;
        updateLightbox();
        lightbox.classList.add('is-open');
        lightbox.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        lightbox.classList.remove('is-open');
        lightbox.setAttribute('aria-hidden', 'true');
        lightboxImg.src = '';
        document.body.style.overflow = '';
    }

    function showNext(delta) {
        if (!galleryLinks.length) return;
        currentIndex = (currentIndex + delta + galleryLinks.length) % galleryLinks.length;
        updateLightbox();
    }

    galleryLinks.forEach(function (a, index) {
        a.addEventListener('click', function (e) {
            e.preventDefault();
            openLightbox(index);
        });
    });

    closeBtn.addEventListener('click', closeLightbox);
    if (prevBtn) prevBtn.addEventListener('click', function (e) { e.stopPropagation(); showNext(-1); });
    if (nextBtn) nextBtn.addEventListener('click', function (e) { e.stopPropagation(); showNext(1); });
    lightbox.addEventListener('click', function (e) {
        if (e.target === lightbox) closeLightbox();
    });
    document.addEventListener('keydown', function (e) {
        if (!lightbox.classList.contains('is-open')) return;
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft') showNext(-1);
        if (e.key === 'ArrowRight') showNext(1);
    });
})();
</script>
