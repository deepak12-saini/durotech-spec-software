<style>
/* ===== CATEGORY GRID ===== */
.category-grid {
    margin-top: 40px;
}

/* FLEX ROW FIX */
.category-grid .row {
    display: flex;
    flex-wrap: wrap;
     margin-left: -3px;
    margin-right: -3px;
}

/* FLEX COLUMN */
.category-grid .row > div[class*="col-"] {
    /* display: flex; */
      padding-left: 3px;
    padding-right: 3px;
}

/* CATEGORY TILE */
.category-box.image-tile {
    position: relative;
    width: 100%;
    height: 300px;
    /* height: 100%; */
    overflow: hidden;
    margin-bottom: 10px;
}

/* FULL IMAGE */
.category-box.image-tile img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    /* display: block; */
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

/* CATEGORY NAME */
.category-overlay h2 {
    color: #ffffff;
    font-size: 22px;
    font-weight: 600;
    letter-spacing: 0.5px;
    margin: 0;
    opacity: 0.9;
    transition: all 0.3s ease;
    text-shadow: 0 2px 6px rgba(0,0,0,0.6);
}



/* HOVER EFFECT */
/* IMAGE ZOOM */
.category-box.image-tile img {
    transition: transform 0.3s ease;
}

.category-box.image-tile:hover img {
    transform: scale(1.05);
}

/* ODD boxes → BLUE hover */
.category-grid .row > div:nth-child(odd) 
.category-box.image-tile:hover .category-overlay {
    background: rgba(40, 137, 201, 0.35); /* blue */
}

/* EVEN boxes → YELLOW hover */
.category-grid .row > div:nth-child(even) 
.category-box.image-tile:hover .category-overlay {
    background: rgba(255, 215, 0, 0.35); /* yellow */
}



/* LINK RESET */
.category-link {
    text-decoration: none;
    color: inherit;
    display: block;
}

/* HEADING */
.category-heading {
    text-align: center;
    margin: 130px 0 30px;
}

/* RESPONSIVE */
@media (max-width: 991px) {
    .category-box.image-tile {
        height: 350px;
    }
}

@media (max-width: 767px) {
    .category-box.image-tile {
        height: 350px;
    }

    .category-overlay h2 {
        font-size: 18px;
    }
}




</style>


<div class="banner_durolab col-lg-12 col-md-12 col-sm-12"></div>

<div class="container category-grid">

    <div class="category-heading product_text_section">
        <h2>Categories</h2>
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


