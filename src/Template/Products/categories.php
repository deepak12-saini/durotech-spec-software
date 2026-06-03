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
    overflow: visible;
}

/* Heading toolbar: title + search */
.category-heading-toolbar {
    display: flex;
    flex-wrap: wrap;
    align-items: flex-end;
    justify-content: space-between;
    gap: 16px 20px;
    margin: clamp(16px, 4vw, 34px) 0 clamp(10px, 2vw, 16px);
    padding: 0 10px;
    overflow: visible;
}
.category-heading {
    text-align: left;
    margin: 0;
    padding: 0;
    min-height: 1px;
    flex: 1 1 auto;
    min-width: 160px;
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
    margin: 12px 0 0;
    border-radius: 999px;
    background: linear-gradient(90deg, #2889c9 0%, #f2c23a 100%);
    opacity: 0.9;
}

.category-search-wrap {
    position: relative;
    flex: 0 1 320px;
    width: 100%;
    max-width: 360px;
    min-width: 200px;
    box-sizing: border-box;
    overflow: visible;
    margin-right: 4px;
    padding: 2px 4px 2px 2px;
}
.category-search-wrap .fa-search {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #2889c9;
    font-size: 15px;
    pointer-events: none;
    opacity: 0.85;
}
#categoryFilter {
    display: block;
    width: 100%;
    max-width: 100%;
    min-height: 44px;
    padding: 10px 42px 10px 40px;
    border: 1px solid rgba(40, 137, 201, 0.35);
    border-radius: 999px;
    background: #fff;
    font-size: 15px;
    color: #14213d;
    box-sizing: border-box;
    box-shadow: 0 2px 10px rgba(20, 33, 61, 0.06);
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
    -webkit-appearance: none;
    appearance: none;
}
#categoryFilter::-webkit-search-decoration,
#categoryFilter::-webkit-search-cancel-button {
    -webkit-appearance: none;
    appearance: none;
    display: none;
}
#categoryFilter::placeholder {
    color: #6b7c93;
}
#categoryFilter:focus {
    outline: none;
    border-color: #2889c9;
    box-shadow: 0 0 0 3px rgba(40, 137, 201, 0.2);
}
#categoryFilterClear {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    width: 32px;
    height: 32px;
    border: none;
    border-radius: 50%;
    background: rgba(40, 137, 201, 0.12);
    color: #2889c9;
    font-size: 20px;
    line-height: 1;
    cursor: pointer;
    padding: 0;
}
#categoryFilterClear:hover {
    background: rgba(40, 137, 201, 0.22);
}
#categoryFilterClear:focus-visible {
    outline: 2px solid #2889c9;
    outline-offset: 2px;
}
.sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border: 0;
}
.category-filter-status,
.category-filter-empty {
    text-align: center;
    margin: 0 10px 12px;
    font-size: 14px;
    color: #4a5f78;
}
.category-filter-empty {
    color: #2889c9;
    font-weight: 600;
    padding: 8px 0 4px;
}
.category-card-item.is-filter-hidden {
    display: none !important;
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
    height: clamp(300px, 32vw, 380px);
    min-height: 300px;
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
    height: 42%;
    z-index: 1;
    pointer-events: none;
    border-bottom-left-radius: inherit;
    border-bottom-right-radius: inherit;
    background: linear-gradient(
        to top,
        rgba(12, 24, 42, 0.55) 0%,
        rgba(12, 24, 42, 0.12) 55%,
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

/* Bottom caption only — no full-card dark overlay */
.category-overlay {
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 2;
    background: transparent;
    display: flex;
    align-items: flex-end;
    justify-content: center;
    text-align: center;
    padding: 0 14px 18px;
    pointer-events: none;
}

/* Category name — text shadow only, no dark pill */
.category-overlay h2 {
    color: #ffffff;
    font-size: clamp(17px, 2.2vw, 22px);
    font-weight: 700;
    letter-spacing: 0.04em;
    line-height: 1.3;
    margin: 0;
    padding: 0;
    background: none;
    border: none;
    border-radius: 0;
    backdrop-filter: none;
    -webkit-backdrop-filter: none;
    display: block;
    max-width: 100%;
    box-shadow: none;
    text-shadow:
        0 1px 2px rgba(0, 0, 0, 0.65),
        0 4px 14px rgba(0, 0, 0, 0.45);
    transition: transform 0.32s cubic-bezier(0.22, 1, 0.36, 1);
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
    transform: translateY(-3px);
}
.category-grid .row > div:nth-child(odd) .category-box.image-tile {
    border-top: 4px solid #2889c9;
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
        height: 320px;
        min-height: 280px;
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
    .category-heading-toolbar {
        flex-direction: column;
        align-items: stretch;
        margin: 18px 0 12px;
    }
    .category-search-wrap {
        max-width: none;
        flex: 1 1 100%;
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
        height: 280px;
        min-height: 260px;
        border-radius: 12px;
    }
    .category-overlay h2 {
        font-size: 16px;
    }
    .category-overlay {
        padding: 0 12px 14px;
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
        height: 260px;
        min-height: 240px;
    }
    .category-overlay h2 {
        font-size: 15px;
    }
}
</style>


<div class="products-categories-page">

<div class="container category-grid">

    <div class="category-heading-toolbar">
        <div class="category-heading product_text_section">
            <h1 class="page-title">Categories</h1>
        </div>
        <div class="category-search-wrap">
            <label class="sr-only" for="categoryFilter">Search categories</label>
            <i class="fa fa-search" aria-hidden="true"></i>
            <input type="search" id="categoryFilter" placeholder="Search categories…" autocomplete="off">
            <button type="button" id="categoryFilterClear" aria-label="Clear search" hidden>&times;</button>
        </div>
    </div>
    <p class="category-filter-status" id="categoryFilterStatus" aria-live="polite" hidden></p>
    <p class="category-filter-empty" id="categoryFilterEmpty" hidden>No categories match your search.</p>

    <div class="row" id="categoryCardsRow">

        <?php foreach ($categories as $cat): ?>
            <?php if (empty($cat->slug)) continue; ?>
            <?php
            $catNameLower = function_exists('mb_strtolower')
                ? mb_strtolower((string)($cat->category_name ?? ''), 'UTF-8')
                : strtolower((string)($cat->category_name ?? ''));
            ?>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 category-card-item"
                 data-category-name="<?= h($catNameLower) ?>"
                 data-category-slug="<?= h($cat->slug) ?>">

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

<script>
(function () {
    var input = document.getElementById('categoryFilter');
    var clearBtn = document.getElementById('categoryFilterClear');
    var statusEl = document.getElementById('categoryFilterStatus');
    var emptyEl = document.getElementById('categoryFilterEmpty');
    var cards = document.querySelectorAll('.category-card-item');
    if (!input || !cards.length) {
        return;
    }

    var total = cards.length;

    function applyFilter() {
        var q = (input.value || '').trim().toLowerCase();
        var visible = 0;

        for (var i = 0; i < cards.length; i++) {
            var name = (cards[i].getAttribute('data-category-name') || '').toLowerCase();
            var slug = (cards[i].getAttribute('data-category-slug') || '').toLowerCase();
            var match = !q || name.indexOf(q) !== -1 || slug.indexOf(q) !== -1;
            cards[i].classList.toggle('is-filter-hidden', !match);
            if (match) {
                visible++;
            }
        }

        if (clearBtn) {
            clearBtn.hidden = !q;
        }
        if (emptyEl) {
            emptyEl.hidden = !q || visible > 0;
        }
        if (statusEl) {
            if (q) {
                statusEl.textContent = 'Showing ' + visible + ' of ' + total + ' categories';
                statusEl.hidden = false;
            } else {
                statusEl.hidden = true;
                statusEl.textContent = '';
            }
        }
    }

    input.addEventListener('input', applyFilter);
    if (clearBtn) {
        clearBtn.addEventListener('click', function () {
            input.value = '';
            input.focus();
            applyFilter();
        });
    }
})();
</script>


