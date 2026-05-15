<style>
/* Space below fixed header — tuned in CSS (not full measured height) so mobile gap stays tight. */
.products-categories-page {
    padding-top: clamp(56px, 14vw, 76px);
    background: #e4edf4;
}
@media (min-width: 768px) {
    .products-categories-page {
        padding-top: clamp(72px, 9vw, 96px);
    }
}

/* ===== CATEGORY GRID ===== */
.category-grid {
    margin-top: 20px;
    padding-left: 18px;
    padding-right: 18px;
    background: linear-gradient(165deg, #f4f8fc 0%, #e8f0f8 48%, #eef4fa 100%);
    border-radius: 16px;
    box-shadow:
        0 1px 0 rgba(255, 255, 255, 0.85) inset,
        0 10px 40px rgba(20, 33, 61, 0.07),
        0 2px 8px rgba(20, 33, 61, 0.04);
    border: 1px solid rgba(40, 137, 201, 0.12);
    padding-top: 8px;
    padding-bottom: 10px;
}

/* PAGE HEADING - clearly visible, never clipped */
.category-heading {
    text-align: center;
    margin: clamp(16px, 4vw, 34px) 0 clamp(14px, 3vw, 22px);
    padding: 0 10px;
    min-height: 1px;
}
.category-heading .page-title {
    color: #2889c9;
    font-size: clamp(26px, 5.5vw, 36px);
    font-weight: 700;
    margin: 0;
    padding: 0 0 14px;
    letter-spacing: 0.02em;
    line-height: 1.3;
    text-shadow: none;
    display: block;
    visibility: visible;
    position: relative;
}
.category-heading .page-title::after {
    content: "";
    display: block;
    width: 56px;
    height: 4px;
    margin: 12px auto 0;
    border-radius: 999px;
    background: linear-gradient(90deg, #2889c9 0%, #f2c23a 100%);
    opacity: 0.9;
}

/* FLEX ROW FIX */
.category-grid .row {
    display: flex;
    flex-wrap: wrap;
    margin-left: -10px;
    margin-right: -10px;
}

/* FLEX COLUMN */
.category-grid .row > div[class*="col-"] {
    padding-left: 10px;
    padding-right: 10px;
    margin-bottom: 50px;
}

/* CATEGORY TILE */
.category-box.image-tile {
    position: relative;
    width: 100%;
    height: 280px;
    overflow: hidden;
    margin-bottom: 0;
    border-radius: 14px;
    box-shadow:
        0 1px 0 rgba(255, 255, 255, 0.35) inset,
        0 10px 28px rgba(20, 33, 61, 0.11),
        0 2px 6px rgba(20, 33, 61, 0.06);
    background: #fff;
    transition:
        transform 0.32s cubic-bezier(0.22, 1, 0.36, 1),
        box-shadow 0.32s cubic-bezier(0.22, 1, 0.36, 1);
    animation: tileFadeIn 0.55s cubic-bezier(0.22, 1, 0.36, 1) both;
    isolation: isolate;
}

/* Soft bottom vignette on photo (under overlay) — better contrast without crushing the whole image */
.category-box.image-tile::before {
    content: "";
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;
    height: 58%;
    z-index: 1;
    pointer-events: none;
    border-bottom-left-radius: inherit;
    border-bottom-right-radius: inherit;
    background: linear-gradient(
        to top,
        rgba(15, 28, 48, 0.62) 0%,
        rgba(15, 28, 48, 0.22) 42%,
        rgba(15, 28, 48, 0) 100%
    );
}

.category-box.image-tile::after {
    content: "";
    position: absolute;
    inset: 0;
    border-radius: inherit;
    box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.12) inset;
    pointer-events: none;
    z-index: 3;
}

@keyframes tileFadeIn {
    from {
        opacity: 0;
        transform: translateY(16px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* FULL IMAGE */
.category-box.image-tile img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.45s cubic-bezier(0.22, 1, 0.36, 1);
    transform: scale(1.001);
}

/* OVERLAY */
.category-overlay {
    position: absolute;
    inset: 0;
    z-index: 2;
    background: rgba(0, 0, 0, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 15px;
    transition: background 0.35s cubic-bezier(0.22, 1, 0.36, 1);
}

/* CATEGORY NAME ON TILES */
.category-overlay h2 {
    color: #ffffff;
    font-size: 23px;
    font-weight: 700;
    letter-spacing: 0.6px;
    line-height: 1.25;
    margin: 0;
    opacity: 0.96;
    transition:
        transform 0.32s cubic-bezier(0.22, 1, 0.36, 1),
        opacity 0.32s ease,
        box-shadow 0.32s ease;
    text-shadow: 0 2px 8px rgba(0, 0, 0, 0.45);
    background: rgba(0, 0, 0, 0.32);
    border: 1px solid rgba(255, 255, 255, 0.32);
    border-radius: 12px;
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
    padding: 12px 16px;
    display: inline-block;
    max-width: 92%;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.18);
}

/* HOVER - IMAGE ZOOM */
.category-box.image-tile:hover img {
    transform: scale(1.06);
}

/* Keep same color theme on all tiles */
.category-box.image-tile:hover {
    transform: translateY(-6px);
    box-shadow:
        0 1px 0 rgba(255, 255, 255, 0.4) inset,
        0 20px 40px rgba(20, 33, 61, 0.14),
        0 6px 14px rgba(20, 33, 61, 0.08);
}
.category-box.image-tile:hover .category-overlay h2 {
    transform: translateY(-2px) scale(1.02);
    opacity: 1;
}
/* ODD boxes -> blue hover overlay */
.category-grid .row > div:nth-child(odd) .category-box.image-tile:hover .category-overlay {
    background: rgba(40, 137, 201, 0.45);
}
.category-grid .row > div:nth-child(odd) .category-box.image-tile {
    border-top: 4px solid #2889c9;
}
/* EVEN boxes -> yellow hover overlay */
.category-grid .row > div:nth-child(even) .category-box.image-tile:hover .category-overlay {
    background: rgba(255, 215, 0, 0.45);
}
.category-grid .row > div:nth-child(even) .category-box.image-tile {
    border-top: 4px solid #f2c23a;
}

.category-grid .row > div:nth-child(2) .category-box.image-tile,
.category-grid .row > div:nth-child(6) .category-box.image-tile,
.category-grid .row > div:nth-child(10) .category-box.image-tile {
    animation-delay: 0.08s;
}
.category-grid .row > div:nth-child(3) .category-box.image-tile,
.category-grid .row > div:nth-child(7) .category-box.image-tile,
.category-grid .row > div:nth-child(11) .category-box.image-tile {
    animation-delay: 0.16s;
}
.category-grid .row > div:nth-child(4) .category-box.image-tile,
.category-grid .row > div:nth-child(8) .category-box.image-tile,
.category-grid .row > div:nth-child(12) .category-box.image-tile {
    animation-delay: 0.24s;
}

/* LINK RESET + accessibility */
.category-link {
    text-decoration: none;
    color: inherit;
    display: block;
    border-radius: 14px;
    outline: none;
}
.category-link:focus-visible {
    outline: 3px solid #2889c9;
    outline-offset: 4px;
}
.category-link:focus-visible .category-box.image-tile {
    box-shadow:
        0 0 0 3px rgba(40, 137, 201, 0.35),
        0 14px 32px rgba(20, 33, 61, 0.12);
}

@media (prefers-reduced-motion: reduce) {
    .category-box.image-tile,
    .category-box.image-tile img,
    .category-overlay,
    .category-overlay h2 {
        transition: none !important;
        animation: none !important;
    }
    .category-box.image-tile:hover {
        transform: none;
    }
    .category-box.image-tile:hover img {
        transform: none;
    }
    .category-box.image-tile:hover .category-overlay h2 {
        transform: none;
    }
}

/* ===== RESPONSIVE - TABLET ===== */
@media (max-width: 991px) {
    .category-box.image-tile {
        height: 260px;
    }
    .category-heading .page-title {
        font-size: clamp(26px, 4.5vw, 32px);
    }
    .category-grid .row > div[class*="col-"] {
        margin-bottom: 40px;
    }
}

/* ===== RESPONSIVE - MOBILE ===== */
@media (max-width: 767px) {
    .category-grid {
        margin-top: 15px;
        padding-left: 10px;
        padding-right: 10px;
    }
    .category-heading {
        margin: 18px 0 14px;
    }
    .category-heading .page-title {
        font-size: clamp(22px, 5.2vw, 28px);
        font-weight: 700;
    }
    .category-grid .row {
        margin-left: -7px;
        margin-right: -7px;
    }
    .category-grid .row > div[class*="col-"] {
        padding-left: 7px;
        padding-right: 7px;
        margin-bottom: 30px;
    }
    .category-link:focus-visible {
        outline-offset: 2px;
    }
    .category-box.image-tile {
        height: 220px;
        border-radius: 12px;
    }
    .category-overlay h2 {
        font-size: 16px;
        padding: 8px 10px;
    }
    .category-overlay {
        padding: 12px;
    }
}

/* ===== RESPONSIVE - SMALL MOBILE ===== */
@media (max-width: 480px) {
    .category-grid {
        padding-left: 8px;
        padding-right: 8px;
    }
    .category-heading .page-title {
        font-size: 24px;
    }
    .category-box.image-tile {
        height: 200px;
    }
    .category-overlay h2 {
        font-size: 15px;
    }
}
</style>


<div class="products-categories-page">

<div class="container category-grid">

    <div class="category-heading product_text_section">
        <h1 class="page-title">Categories</h1>
    </div>

    <div class="row">

        <?php foreach ($categories as $cat): ?>
            <?php if (empty($cat->slug)) continue; ?>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">

                <!-- FULL TILE CLICKABLE -->
                <a href="<?= h($this->Url->build('/category/' . $cat->slug)) ?>"
                   class="category-link">

                    <div class="category-box image-tile">

                        <?php if (!empty($cat->image)): ?>
                            <img src="<?= h(SITEURL . 'category/' . $cat->image) ?>"
                                 alt="<?= h($cat->category_name ?? '') ?>"
                                 loading="lazy"
                                 decoding="async">
                        <?php endif; ?>

                        <!-- CENTER TEXT -->
                        <div class="category-overlay">
                            <h2><?= h($cat->category_name ?? '') ?></h2>
                        </div>

                    </div>
                </a>

            </div>
        <?php endforeach; ?>

    </div>
</div>
</div><!-- .products-categories-page -->


