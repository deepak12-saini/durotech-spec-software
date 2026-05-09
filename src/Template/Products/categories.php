<style>
/* Clear fixed header so "Categories" heading is not cut off */
.products-categories-page {
    padding-top: 40px;
    background: #e4edf4;
}
@media (max-width: 767px) {
    .products-categories-page {
        padding-top: 40px;
    }
}

/* ===== CATEGORY GRID ===== */
.category-grid {
    margin-top: 20px;
    padding-left: 18px;
    padding-right: 18px;
    background: #edf3f8;
    border-radius: 16px;
    box-shadow: 0 10px 32px rgba(20, 33, 61, 0.08);
    padding-top: 8px;
    padding-bottom: 10px;
}

/* PAGE HEADING - clearly visible, never clipped */
.category-heading {
    text-align: center;
    margin: 30px 0 35px;
    padding: 0 10px;
    min-height: 1px;
}
.category-heading .page-title {
    color: #2889c9;
    font-size: 36px;
    font-weight: 700;
    margin: 0;
    padding: 0;
    letter-spacing: 0.02em;
    line-height: 1.3;
    text-shadow: none;
    display: block;
    visibility: visible;
}
.category-heading .page-subtitle {
    margin: 8px auto 0;
    color: #5f7d99;
    font-size: 15px;
    font-weight: 500;
    max-width: 780px;
    line-height: 1.6;
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
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(20, 33, 61, 0.12);
    background: #fff;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    animation: tileFadeIn 0.55s ease both;
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
    transition: transform 0.3s ease;
}

/* OVERLAY */
.category-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.36);
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 15px;
    transition: background 0.3s ease;
}

/* CATEGORY NAME ON TILES */
.category-overlay h2 {
    color: #ffffff;
    font-size: 23px;
    font-weight: 700;
    letter-spacing: 0.6px;
    line-height: 1.25;
    margin: 0;
    opacity: 0.95;
    transition: all 0.3s ease;
    text-shadow: 0 2px 6px rgba(0,0,0,0.6);
    background: rgba(0, 0, 0, 0.28);
    border: 1px solid rgba(255, 255, 255, 0.28);
    border-radius: 10px;
    backdrop-filter: blur(2px);
    padding: 10px 14px;
    display: inline-block;
}

/* HOVER - IMAGE ZOOM */
.category-box.image-tile:hover img {
    transform: scale(1.05);
}

/* Keep same color theme on all tiles */
.category-box.image-tile:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 28px rgba(20, 33, 61, 0.18);
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

/* LINK RESET */
.category-link {
    text-decoration: none;
    color: inherit;
    display: block;
}

/* ===== RESPONSIVE - TABLET ===== */
@media (max-width: 991px) {
    .category-box.image-tile {
        height: 260px;
    }
    .category-heading .page-title {
        font-size: 32px;
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
        margin: 20px 0 25px;
    }
    .category-heading .page-title {
        font-size: 28px;
        font-weight: 700;
    }
    .category-heading .page-subtitle {
        font-size: 14px;
        line-height: 1.5;
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
    .category-box.image-tile {
        height: 220px;
        border-radius: 10px;
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
    .category-heading .page-subtitle {
        font-size: 13px;
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
<div class="banner_durolab col-lg-12 col-md-12 col-sm-12"></div>

<div class="container category-grid">

    <div class="category-heading product_text_section">
        <h1 class="page-title">Categories</h1>
        <p class="page-subtitle">Explore our complete range of engineered waterproofing and construction chemical solutions.</p>
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
                                 alt="<?= h($cat->category_name ?? '') ?>">
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


