<?php
$caseData = $case['CaseStudy'] ?? [];
$featuredImage = !empty($caseData['featured_image']) ? SITEURL . $caseData['featured_image'] : 'https://www.durotechindustries.com.au/banner/Project.jpg';
?>

<style>
.case-study-page-wrap {
    background: #eaf1f7;
    padding-bottom: 44px;
}

.case-hero {
    position: relative;
    border-radius: 14px;
    overflow: hidden;
    margin-bottom: 28px;
    box-shadow: 0 10px 28px rgba(20, 33, 61, 0.16);
    background: #dfe8f0;
}

.case-hero__img {
    width: 100%;
    height: clamp(320px, 58vh, 720px);
    object-fit: cover;
    object-position: center;
    display: block;
}

.case-hero__overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(9, 21, 38, 0.74), rgba(9, 21, 38, 0.25) 44%, rgba(9, 21, 38, 0.05) 70%, transparent);
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
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.45);
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
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.35);
    border-radius: 999px;
    padding: 6px 12px;
    color: #fff;
    font-size: 0.86rem;
    font-weight: 600;
    backdrop-filter: blur(4px);
}

.case-quick-nav {
    position: sticky;
    top: 74px;
    z-index: 5;
    background: rgba(255, 255, 255, 0.94);
    border: 1px solid rgba(40, 137, 201, 0.18);
    border-radius: 12px;
    box-shadow: 0 6px 16px rgba(20, 33, 61, 0.08);
    margin-bottom: 22px;
    padding: 10px 12px;
}

.case-quick-nav ul {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.case-quick-nav a {
    display: inline-block;
    text-decoration: none;
    color: #2f4d66;
    font-weight: 700;
    font-size: 1.14rem;
    padding: 11px 16px;
    border-radius: 999px;
    transition: all 0.22s ease;
}

.case-quick-nav a:hover,
.case-quick-nav a.is-active {
    color: #fff;
    background: linear-gradient(90deg, #2889c9, #5a1ea8);
}

.case-section {
    background: #fff;
    border-radius: 12px;
    border-left: 4px solid #2889c9;
    padding: 20px 22px;
    margin-bottom: 20px;
    box-shadow: 0 6px 16px rgba(20, 33, 61, 0.08);
    transition: transform 0.24s ease, box-shadow 0.24s ease;
}

.case-section:nth-of-type(even) {
    border-left-color: #f2c23a;
}

.case-section:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 22px rgba(20, 33, 61, 0.13);
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

.project-gallery .gallery-item {
    display: block;
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(20, 33, 61, 0.1);
}

.project-gallery .gallery-item img {
    width: 100%;
    height: 260px;
    object-fit: cover;
    transition: transform 0.32s ease;
}

.project-gallery .gallery-item:hover img {
    transform: scale(1.05);
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
    transition: transform 0.24s ease, box-shadow 0.24s ease;
}

.products-used-card:hover {
    transform: translateY(-3px);
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

/* Simple lightbox */
.image-lightbox {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 2000;
    background: rgba(6, 16, 30, 0.9);
    align-items: center;
    justify-content: center;
    padding: 26px;
}

.image-lightbox.is-open {
    display: flex;
}

.image-lightbox img {
    max-width: min(1100px, 95vw);
    max-height: 88vh;
    border-radius: 10px;
    box-shadow: 0 16px 36px rgba(0, 0, 0, 0.5);
}

.image-lightbox__close {
    position: absolute;
    top: 16px;
    right: 20px;
    border: 0;
    border-radius: 999px;
    width: 38px;
    height: 38px;
    font-size: 24px;
    line-height: 1;
    color: #fff;
    background: rgba(255, 255, 255, 0.2);
}

@media (max-width: 768px) {
    .case-study-page-wrap {
        padding-bottom: 26px;
    }
    .case-hero__img {
        height: clamp(240px, 40vh, 370px);
    }
    .case-hero__content {
        padding: 12px 12px 14px;
    }
    .case-quick-nav {
        top: 66px;
        padding: 8px;
    }
    .case-quick-nav a {
        font-size: 1.03rem;
        padding: 9px 13px;
    }
    .case-section {
        padding: 16px;
    }
    .product_text_section {
        font-size: 14px;
        line-height: 1.7;
    }
    .project-gallery .gallery-item img {
        height: 210px;
    }
    .datasheet-section iframe {
        height: 420px;
    }
    .products-used-col {
        width: 50%;
    }
}

@media (max-width: 575px) {
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
            <?php if ($beforeImg || $afterImg): ?>
            <section id="gallery">
                <h4 class="gallery-title">Before / After Comparison</h4>
                <div class="row project-gallery">
                    <?php if ($beforeImg): ?>
                        <div class="col-md-6 col-sm-6 mb-4">
                            <p class="fw-bold mb-2">Before</p>
                            <a href="<?= h(SITEURL . $beforeImg['filename']) ?>" class="gallery-item" data-lightbox="case-gallery">
                                <img src="<?= h(SITEURL . $beforeImg['filename']) ?>" alt="Before" loading="lazy">
                            </a>
                        </div>
                    <?php endif; ?>
                    <?php if ($afterImg): ?>
                        <div class="col-md-6 col-sm-6 mb-4">
                            <p class="fw-bold mb-2">After</p>
                            <a href="<?= h(SITEURL . $afterImg['filename']) ?>" class="gallery-item" data-lightbox="case-gallery">
                                <img src="<?= h(SITEURL . $afterImg['filename']) ?>" alt="After" loading="lazy">
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
            <?php endif; ?>

            <?php if (!empty($otherGalleryImages)): ?>
            <section id="project-photos">
                <h4 class="gallery-title">Project Photo Gallery</h4>
                <div class="row project-gallery">
                    <?php foreach ($otherGalleryImages as $img): ?>
                        <div class="col-md-4 col-sm-6 mb-4">
                            <a href="<?= h(SITEURL . $img['filename']) ?>" class="gallery-item" data-lightbox="case-gallery">
                                <img src="<?= h(SITEURL . $img['filename']) ?>" alt="Project photo" loading="lazy">
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>
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
                        $imgUrl = ($prodImage !== '' && $prodImage !== '250250-defult.png')
                            ? rtrim(SITEURL, '/') . '/productimg/' . $prodImage
                            : rtrim(SITEURL, '/') . '/productimg/250250-defult.png';
                        ?>
                        <div class="products-used-col">
                            <div class="products-used-card">
                                <a href="<?= h($prodUrl) ?>" class="products-used-card__img-wrap">
                                    <img src="<?= h($imgUrl) ?>" alt="<?= h($prodTitle) ?>" loading="lazy">
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
    <img src="" alt="Preview" id="imageLightboxImg">
</div>

<script>
(function () {
    var links = document.querySelectorAll('.case-quick-nav a[href^="#"]');
    links.forEach(function (link) {
        link.addEventListener('click', function (e) {
            var id = this.getAttribute('href').slice(1);
            var target = document.getElementById(id);
            if (!target) return;
            e.preventDefault();
            var top = target.getBoundingClientRect().top + window.pageYOffset - 120;
            window.scrollTo({ top: top, behavior: 'smooth' });
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
        var scrollPos = window.pageYOffset + 150;
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
    updateActive();

    var lightbox = document.getElementById('imageLightbox');
    var lightboxImg = document.getElementById('imageLightboxImg');
    var closeBtn = document.getElementById('imageLightboxClose');
    document.querySelectorAll('[data-lightbox="case-gallery"]').forEach(function (a) {
        a.addEventListener('click', function (e) {
            e.preventDefault();
            lightboxImg.src = this.getAttribute('href');
            lightbox.classList.add('is-open');
            lightbox.setAttribute('aria-hidden', 'false');
        });
    });
    function closeLightbox() {
        lightbox.classList.remove('is-open');
        lightbox.setAttribute('aria-hidden', 'true');
        lightboxImg.src = '';
    }
    closeBtn.addEventListener('click', closeLightbox);
    lightbox.addEventListener('click', function (e) {
        if (e.target === lightbox) closeLightbox();
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && lightbox.classList.contains('is-open')) {
            closeLightbox();
        }
    });
})();
</script>
