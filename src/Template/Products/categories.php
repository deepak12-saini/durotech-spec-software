<style>
/* Clear fixed header so "Categories" heading is not cut off */
.products-categories-page {
    padding-top: 40px;
}
@media (max-width: 767px) {
    .products-categories-page {
        padding-top: 40px;
    }
}

/* ===== CATEGORY GRID ===== */
.category-grid {
    margin-top: 20px;
    padding-left: 15px;
    padding-right: 15px;
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

/* FLEX ROW FIX */
.category-grid .row {
    display: flex;
    flex-wrap: wrap;
    margin-left: -6px;
    margin-right: -6px;
}

/* FLEX COLUMN */
.category-grid .row > div[class*="col-"] {
    padding-left: 6px;
    padding-right: 6px;
}

/* CATEGORY TILE */
.category-box.image-tile {
    position: relative;
    width: 100%;
    height: 280px;
    overflow: hidden;
    margin-bottom: 12px;
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
    background: rgba(0, 0, 0, 0.35);
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
    font-size: 22px;
    font-weight: 600;
    letter-spacing: 0.5px;
    margin: 0;
    opacity: 0.95;
    transition: all 0.3s ease;
    text-shadow: 0 2px 6px rgba(0,0,0,0.6);
}

/* HOVER - IMAGE ZOOM */
.category-box.image-tile:hover img {
    transform: scale(1.05);
}

/* ODD boxes → BLUE hover */
.category-grid .row > div:nth-child(odd) .category-box.image-tile:hover .category-overlay {
    background: rgba(40, 137, 201, 0.45);
}

/* EVEN boxes → YELLOW hover */
.category-grid .row > div:nth-child(even) .category-box.image-tile:hover .category-overlay {
    background: rgba(255, 215, 0, 0.45);
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
    .category-grid .row {
        margin-left: -5px;
        margin-right: -5px;
    }
    .category-grid .row > div[class*="col-"] {
        padding-left: 5px;
        padding-right: 5px;
    }
    .category-box.image-tile {
        height: 220px;
        margin-bottom: 10px;
    }
    .category-overlay h2 {
        font-size: 16px;
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
<div class="banner_durolab col-lg-12 col-md-12 col-sm-12"></div>

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


