<?php
$currentCategoryData = $currentCategory['Category'] ?? [];
$categoryDescription = trim((string)($currentCategoryData['description'] ?? ''));
$categoryImage = trim((string)($currentCategoryData['category_page_image'] ?? ''));
if ($categoryImage === '') {
	$categoryImage = trim((string)($currentCategoryData['image'] ?? ''));
}
$hasCategoryImage = $categoryImage !== '' && $categoryImage !== '250250-defult.png';
$categoryList = (isset($category) && is_array($category)) ? $category : [];
$currentSlug = (string)($slug ?? '');
$isHome = !empty($isProductListingHome);
$pageTitle = $isHome ? 'Featured Products' : (string)($category_name ?? 'Products');
$productsList = !empty($products) ? $products : [];
$hasCategoryHero = (!$isHome && ($hasCategoryImage || $categoryDescription !== ''));
$productPaging = (isset($productPaging) && is_array($productPaging)) ? $productPaging : [
	'page' => 1,
	'pageCount' => 1,
	'count' => count($productsList),
	'perPage' => 12,
	'hasPrev' => false,
	'hasNext' => false,
];

// Build pagination URLs while keeping current path/slug
$productPageUrl = function ($pageNum) use ($isHome, $currentSlug) {
	$pageNum = (int)$pageNum;
	if ($isHome) {
		$url = ['controller' => 'Products', 'action' => 'index'];
		if ($pageNum > 1) {
			$url['?'] = ['page' => $pageNum];
		}
		return $url;
	}
	$url = '/category/' . $currentSlug;
	if ($pageNum > 1) {
		$url .= '?page=' . $pageNum;
	}
	return $url;
};

/** Map category slug/name → Font Awesome 4 icon class */
$categoryIconClass = function ($slug, $name) {
	$key = strtolower(trim((string)$slug . ' ' . (string)$name));
	$map = [
		'primer' => 'fa-tint',
		'cementitious' => 'fa-cubes',
		'tape' => 'fa-tags',
		'reinforcement' => 'fa-th',
		'tile adhesive' => 'fa-th-large',
		'tile adhesives' => 'fa-th-large',
		'water based' => 'fa-paint-brush',
		'water-based' => 'fa-paint-brush',
		'polyurethane' => 'fa-flask',
		'sealant' => 'fa-wrench',
		'silicone' => 'fa-wrench',
		'epoxy' => 'fa-cogs',
		'flooring' => 'fa-cogs',
		'sheet membrane' => 'fa-clone',
		'sheet-membrane' => 'fa-clone',
	];
	foreach ($map as $needle => $icon) {
		if ($needle !== '' && strpos($key, $needle) !== false) {
			return $icon;
		}
	}
	return 'fa-cube';
};
?>
<style>
/* --- Page shell --- */
.products-bg-wrap {
	background: #e4edf4;
	/* Clear fixed site header so page title is never clipped */
	padding: 110px 0 32px;
	overflow: visible;
}
.products-toolbar {
	display: flex;
	flex-wrap: wrap;
	align-items: center;
	justify-content: space-between;
	gap: 12px;
	margin-bottom: 18px;
	position: relative;
	z-index: 2;
}
.products-toolbar__title {
	margin: 0;
	color: #5a1ea8;
	font-size: 22px;
	font-weight: 700;
	line-height: 1.3;
	display: block;
	position: relative;
	z-index: 2;
}
.products-toolbar__title.is-category {
	color: #5a1ea8;
	font-size: 17px;
	font-weight: 600;
}
.products-toolbar__actions {
	display: flex;
	align-items: center;
	gap: 10px;
	flex-wrap: wrap;
}
.products-mobile-cat-btn {
	display: none;
	align-items: center;
	gap: 8px;
	border: 1px solid #d5dde6;
	background: #fff;
	color: #243b4d;
	border-radius: 10px;
	padding: 9px 14px;
	font-size: 14px;
	font-weight: 600;
	cursor: pointer;
}
.products-mobile-cat-btn img {
	width: 16px;
	height: 16px;
}
.products-search input[type="search"] {
	background: #fff url(https://static.tumblr.com/ftv85bp/MIXmud4tx/search-icon.png) no-repeat 9px center;
	width: 180px;
	max-width: 100%;
	height: 36px;
	margin: 0;
	padding: 6px 12px 6px 32px;
	border: 1px solid #d5dde6;
	border-radius: 4px;
	font-size: 14px;
}
.products-search input[type="search"]:focus {
	outline: none;
	border-color: #6fb3e0;
}

/* --- Full-width category hero (previous style) --- */
/* --- Featured Products heading (All Products) --- */
.products-featured-heading {
	margin: 0 0 18px;
	padding: 4px 0 0;
	color: #5a1ea8;
	font-size: 22px;
	font-weight: 700;
	line-height: 1.35;
	display: block;
	position: relative;
	z-index: 1;
	overflow: visible;
	clear: both;
}
.products-intro {
	background: #fff;
	border-radius: 10px;
	padding: 18px 20px;
	margin-bottom: 18px;
	box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
}
.products-intro p {
	margin: 0;
	font-size: 15px;
	line-height: 1.6;
	color: #333;
}
.category-hero {
	background: #e4edf4;
	border-radius: 10px;
	padding: 22px;
	margin-bottom: 18px;
	box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
	width: 100%;
}
.category-hero__content {
	display: flex;
	flex-direction: column;
	justify-content: center;
	min-height: 260px;
}
.category-hero__img-wrap {
	text-align: center;
}
.category-hero__img {
	width: 100%;
	height: 260px;
	object-fit: cover;
	border-radius: 8px;
	background: #f5f5f5;
}
.category-hero__title {
	margin: 0 0 8px;
	color: #5a1ea8;
	font-size: 26px;
	font-weight: 700;
}
.category-hero__desc {
	margin: 0;
	font-size: 15px;
	line-height: 1.7;
	color: #536f8c;
}

/* --- Sidebar + products row (below hero) --- */
.products-layout {
	display: grid;
	grid-template-columns: 260px minmax(0, 1fr);
	gap: 22px;
	align-items: start;
}
.products-sidebar {
	background: #fff;
	border: 1px solid #e3e8ee;
	border-radius: 14px;
	box-shadow: 0 6px 18px rgba(20, 33, 61, 0.06);
	padding: 18px 14px;
	position: sticky;
	top: 110px;
}
.products-sidebar__title {
	margin: 0 0 14px;
	padding: 0 8px 12px;
	border-bottom: 1px solid #edf1f5;
	font-size: 15px;
	font-weight: 700;
	letter-spacing: 0.02em;
	color: #1f3347;
	text-transform: uppercase;
}
.products-sidebar__nav {
	list-style: none;
	margin: 0;
	padding: 0;
}
.products-sidebar__nav li {
	margin: 0 0 4px;
	padding: 0;
	list-style: none;
}
.products-sidebar__nav a {
	display: flex;
	align-items: flex-start;
	gap: 10px;
	padding: 10px 12px;
	border-radius: 8px;
	color: #31485c !important;
	font-size: 14px;
	font-weight: 500;
	line-height: 1.35;
	text-decoration: none !important;
	transition: background 0.15s ease, color 0.15s ease;
}
.products-sidebar__nav a .cat-ico {
	flex: 0 0 18px;
	width: 18px;
	margin-top: 1px;
	text-align: center;
	font-size: 14px;
	color: #6a8aa8;
	line-height: 1.35;
}
.products-sidebar__nav a .cat-label {
	flex: 1 1 auto;
	min-width: 0;
}
.products-sidebar__nav a:hover,
.products-sidebar__nav a:focus {
	background: #f3f7fb;
	color: #1a6fb5 !important;
	font-weight: 600;
}
.products-sidebar__nav a:hover .cat-ico,
.products-sidebar__nav a:focus .cat-ico {
	color: #1a6fb5;
}
.products-sidebar__nav a.is-active {
	background: #e8f1f8;
	color: #1565a8 !important;
	font-weight: 700;
}
.products-sidebar__nav a.is-active .cat-ico {
	color: #1565a8;
}
.products-main {
	min-width: 0;
}

/* --- Previous product box styles (unchanged look) --- */
.product_image_section {
	text-align: center;
	padding: 0;
	display: flex;
	flex-wrap: wrap;
	gap: 5px;
}
.product_image_section > a {
	display: block;
	flex: 0 0 calc(33.333% - 4px);
	max-width: calc(33.333% - 4px);
	box-sizing: border-box;
	text-decoration: none !important;
}
.product_page_list_section {
	background: #ffffff;
	border-radius: 14px;
	box-shadow: 0 4px 14px rgba(0,0,0,0.08);
	padding: 12px 12px 18px;
	margin: 0;
	width: 100%;
	float: none;
	transition: transform 0.2s ease, box-shadow 0.2s ease;
	box-sizing: border-box;
}
.product_page_list_section:hover {
	transform: translateY(-4px);
	box-shadow: 0 10px 26px rgba(0,0,0,0.14);
}
.product_page_list_section h2 {
	font-size: 15px;
	margin-top: 10px;
	color: #777797;
	font-weight: 500;
	border-bottom-color: #fff;
}
.products-main a {
	color: #777797;
}
.products-main a:focus,
.products-main a:hover {
	color: #23527c;
	text-decoration: none;
	font-weight: 600;
}
.products-empty {
	background: #fff;
	border: 1px dashed #d5dde6;
	border-radius: 14px;
	padding: 40px 20px;
	text-align: center;
	color: #6a7f93;
	font-size: 16px;
	font-weight: 600;
}
.products-pagination {
	clear: both;
	display: flex;
	flex-wrap: wrap;
	align-items: center;
	justify-content: center;
	gap: 8px;
	margin: 8px 0 4px;
	padding: 16px 0 8px;
}
.products-pagination a,
.products-pagination span {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	min-width: 36px;
	height: 36px;
	padding: 0 10px;
	border-radius: 8px;
	border: 1px solid #d5dde6;
	background: #fff;
	color: #31485c !important;
	font-size: 14px;
	font-weight: 600;
	text-decoration: none !important;
	box-shadow: 0 2px 6px rgba(20, 33, 61, 0.04);
}
.products-pagination a:hover,
.products-pagination a:focus {
	border-color: #6fb3e0;
	color: #1565a8 !important;
	background: #f3f9fd;
}
.products-pagination .is-active {
	background: #5a1ea8;
	border-color: #5a1ea8;
	color: #fff !important;
}
.products-pagination .is-disabled {
	opacity: 0.45;
	pointer-events: none;
}
.products-pagination__info {
	width: 100%;
	text-align: center;
	margin-bottom: 4px;
	color: #6a7f93;
	font-size: 13px;
	font-weight: 500;
	border: 0 !important;
	background: transparent !important;
	box-shadow: none !important;
	min-width: 0;
	height: auto;
	padding: 0;
}

/* Mobile category drawer */
.products-drawer-backdrop {
	display: none;
	position: fixed;
	inset: 0;
	background: rgba(15, 28, 45, 0.45);
	z-index: 1040;
}
.products-drawer-backdrop.is-open {
	display: block;
}
.products-drawer {
	position: fixed;
	top: 0;
	left: 0;
	width: min(320px, 88vw);
	height: 100%;
	background: #fff;
	z-index: 1050;
	transform: translateX(-105%);
	transition: transform 0.25s ease;
	box-shadow: 8px 0 24px rgba(20, 33, 61, 0.18);
	padding: 18px 14px 24px;
	overflow-y: auto;
}
.products-drawer.is-open {
	transform: translateX(0);
}
.products-drawer__head {
	display: flex;
	align-items: center;
	justify-content: space-between;
	gap: 10px;
	margin-bottom: 12px;
	padding-bottom: 12px;
	border-bottom: 1px solid #edf1f5;
}
.products-drawer__head h3 {
	margin: 0;
	font-size: 15px;
	font-weight: 700;
	color: #1f3347;
	text-transform: uppercase;
}
.products-drawer__close {
	border: 0;
	background: #f3f7fb;
	width: 34px;
	height: 34px;
	border-radius: 8px;
	font-size: 20px;
	line-height: 1;
	color: #31485c;
	cursor: pointer;
}

@media (max-width: 991px) {
	.products-bg-wrap {
		padding-top: 90px;
	}
	.products-layout {
		grid-template-columns: 1fr;
	}
	.products-sidebar {
		display: none;
	}
	.products-mobile-cat-btn {
		display: inline-flex;
	}
	.product_image_section > a {
		flex: 0 0 calc(50% - 3px);
		max-width: calc(50% - 3px);
	}
	.category-hero__content {
		min-height: 0;
	}
	.category-hero__img {
		height: 200px;
		margin-top: 14px;
	}
	.category-hero {
		padding: 16px;
	}
	.category-hero__title {
		font-size: 21px;
	}
}
@media (max-width: 575px) {
	.products-search input[type="search"] {
		width: 100%;
	}
	.products-toolbar__actions {
		width: 100%;
	}
	.products-search {
		flex: 1;
	}
	.product_image_section {
		gap: 5px;
		padding: 0;
	}
	.product_image_section > a {
		flex: 0 0 100%;
		max-width: 100%;
	}
}
</style>

<div class="products-bg-wrap">
	<div class="container">
		<?php /* Full-width toolbar + category description/image (like previous) */ ?>
		<div class="products-toolbar">
			<?php if ($isHome): ?>
			<h1 class="products-toolbar__title products-featured-heading">Featured Products</h1>
			<?php elseif (!$hasCategoryHero): ?>
			<h1 class="products-toolbar__title is-category"><?= h($pageTitle) ?></h1>
			<?php else: ?>
			<div></div>
			<?php endif; ?>
			<div class="products-toolbar__actions">
				<button type="button" class="products-mobile-cat-btn" id="productsMobileCatBtn" aria-controls="productsCategoryDrawer" aria-expanded="false">
					<img src="<?= h(SITEURL) ?>img/menu.png" alt=""> Categories
				</button>
				<div class="products-search">
					<form action="<?= h($this->Url->build(['controller' => 'Products', 'action' => 'search'])) ?>" method="get">
						<input type="search" name="search" placeholder="Search Product" required aria-label="Search Product">
					</form>
				</div>
			</div>
		</div>

		<?php if ($hasCategoryHero): ?>
		<div class="category-hero">
			<div class="row">
				<?php if ($hasCategoryImage): ?>
				<div class="col-lg-6 col-md-6 col-sm-12 category-hero__content">
				<?php else: ?>
				<div class="col-lg-12 col-md-12 col-sm-12 category-hero__content">
				<?php endif; ?>
					<h1 class="category-hero__title"><?= h($category_name ?? 'Products') ?></h1>
					<?php if ($categoryDescription !== ''): ?>
					<p class="category-hero__desc"><?= nl2br(h($categoryDescription)) ?></p>
					<?php endif; ?>
				</div>
				<?php if ($hasCategoryImage): ?>
				<div class="col-lg-6 col-md-6 col-sm-12 category-hero__img-wrap">
					<img src="<?= h($this->Url->build('/files/category/' . $categoryImage)) ?>" alt="<?= h($category_name ?? 'Category image') ?>" class="category-hero__img">
				</div>
				<?php endif; ?>
			</div>
		</div>
		<?php endif; ?>

		<?php /* Browse by Category below description; products on the right */ ?>
		<div class="products-layout">
			<aside class="products-sidebar" aria-label="Browse by category">
				<h2 class="products-sidebar__title">Browse by Category</h2>
				<ul class="products-sidebar__nav">
					<li>
						<a href="<?= h($this->Url->build('/product')) ?>" class="<?= $isHome ? 'is-active' : '' ?>">
							<i class="fa fa-th-list cat-ico" aria-hidden="true"></i>
							<span class="cat-label">All Products</span>
						</a>
					</li>
					<?php foreach ($categoryList as $categorys): ?>
						<?php
							$catSlug = (string)($categorys['Category']['slug'] ?? '');
							$catName = (string)($categorys['Category']['category_name'] ?? '');
							if ($catName === '') {
								continue;
							}
							$isActive = (!$isHome && $catSlug !== '' && $catSlug === $currentSlug);
							$ico = $categoryIconClass($catSlug, $catName);
						?>
						<li>
							<a href="<?= h($this->Url->build('/category/' . $catSlug)) ?>" class="<?= $isActive ? 'is-active' : '' ?>">
								<i class="fa <?= h($ico) ?> cat-ico" aria-hidden="true"></i>
								<span class="cat-label"><?= h($catName) ?></span>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</aside>

			<div class="products-main">
				<?= $this->Flash->render() ?>

				<?php if (!empty($productsList)): ?>
				<div class="product_image_section clearfix">
					<?php foreach ($productsList as $product): ?>
						<?php
							$pTitle = (string)($product['Product']['title'] ?? '');
							$pSlug = (string)($product['Product']['slug'] ?? '');
							$pImage = (string)($product['Product']['image'] ?? '');
							$isDefaultImage = (($product['Product']['is_image'] ?? '') == '250250-defult.png' || ($product['Product']['is_image'] ?? '') == 1);
						?>
						<a href="<?= h($this->Url->build('/product/' . $pSlug)) ?>">
							<div class="product_page_list_section col-lg-4 col-md-4 col-sm-6">
								<figure class="snip0077 blue">
									<?php if ($isDefaultImage): ?>
										<div style="padding-top:100px; width:250px !important; height:250px !important; color:#000 !important; margin:0 auto;">
											<span style="font-size:25px; font-weight:bold; color:#2889c9 !important;"><?= h($pTitle) ?></span>
										</div>
									<?php else: ?>
										<img src="<?= h(SITEURL) ?>productimg/<?= h($pImage) ?>" alt="<?= h($pTitle) ?>" style="width:250px !important; height:250px !important;" />
									<?php endif; ?>
									<figcaption>
										<h2><span><?= h($pTitle) ?></span></h2>
									</figcaption>
								</figure>
								<h2 style="color:#777797; font-weight:500; border-bottom-color:#fff;"><?= h($pTitle) ?></h2>
							</div>
						</a>
					<?php endforeach; ?>
				</div>
				<?php
					$pageCount = (int)($productPaging['pageCount'] ?? 1);
					$currentPage = (int)($productPaging['page'] ?? 1);
					$totalCount = (int)($productPaging['count'] ?? 0);
					$perPage = (int)($productPaging['perPage'] ?? 12);
					if ($pageCount > 1):
						$from = (($currentPage - 1) * $perPage) + 1;
						$to = min($totalCount, $currentPage * $perPage);
				?>
				<nav class="products-pagination" aria-label="Product pages">
					<span class="products-pagination__info">Showing <?= (int)$from ?>–<?= (int)$to ?> of <?= (int)$totalCount ?> products</span>
					<?php if (!empty($productPaging['hasPrev'])): ?>
						<?= $this->Html->link('‹ Prev', $productPageUrl($productPaging['prevPage']), ['escape' => false]) ?>
					<?php else: ?>
						<span class="is-disabled">‹ Prev</span>
					<?php endif; ?>

					<?php for ($p = 1; $p <= $pageCount; $p++): ?>
						<?php if ($p === $currentPage): ?>
							<span class="is-active" aria-current="page"><?= $p ?></span>
						<?php else: ?>
							<?= $this->Html->link((string)$p, $productPageUrl($p)) ?>
						<?php endif; ?>
					<?php endfor; ?>

					<?php if (!empty($productPaging['hasNext'])): ?>
						<?= $this->Html->link('Next ›', $productPageUrl($productPaging['nextPage']), ['escape' => false]) ?>
					<?php else: ?>
						<span class="is-disabled">Next ›</span>
					<?php endif; ?>
				</nav>
				<?php endif; ?>
				<?php else: ?>
				<div class="products-empty">Coming Soon</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<div class="products-drawer-backdrop" id="productsDrawerBackdrop" hidden></div>
<aside class="products-drawer" id="productsCategoryDrawer" aria-hidden="true" aria-label="Categories">
	<div class="products-drawer__head">
		<h3>Browse by Category</h3>
		<button type="button" class="products-drawer__close" id="productsDrawerClose" aria-label="Close">&times;</button>
	</div>
	<ul class="products-sidebar__nav">
		<li>
			<a href="<?= h($this->Url->build('/product')) ?>" class="<?= $isHome ? 'is-active' : '' ?>">
				<i class="fa fa-th-list cat-ico" aria-hidden="true"></i>
				<span class="cat-label">All Products</span>
			</a>
		</li>
		<?php foreach ($categoryList as $categorys): ?>
			<?php
				$catSlug = (string)($categorys['Category']['slug'] ?? '');
				$catName = (string)($categorys['Category']['category_name'] ?? '');
				if ($catName === '') {
					continue;
				}
				$isActive = (!$isHome && $catSlug !== '' && $catSlug === $currentSlug);
				$ico = $categoryIconClass($catSlug, $catName);
			?>
			<li>
				<a href="<?= h($this->Url->build('/category/' . $catSlug)) ?>" class="<?= $isActive ? 'is-active' : '' ?>">
					<i class="fa <?= h($ico) ?> cat-ico" aria-hidden="true"></i>
					<span class="cat-label"><?= h($catName) ?></span>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</aside>

<script>
(function () {
	var btn = document.getElementById('productsMobileCatBtn');
	var drawer = document.getElementById('productsCategoryDrawer');
	var backdrop = document.getElementById('productsDrawerBackdrop');
	var closeBtn = document.getElementById('productsDrawerClose');
	if (!btn || !drawer || !backdrop) return;

	function openDrawer() {
		drawer.classList.add('is-open');
		backdrop.classList.add('is-open');
		backdrop.hidden = false;
		drawer.setAttribute('aria-hidden', 'false');
		btn.setAttribute('aria-expanded', 'true');
		document.body.style.overflow = 'hidden';
	}
	function closeDrawer() {
		drawer.classList.remove('is-open');
		backdrop.classList.remove('is-open');
		backdrop.hidden = true;
		drawer.setAttribute('aria-hidden', 'true');
		btn.setAttribute('aria-expanded', 'false');
		document.body.style.overflow = '';
	}

	btn.addEventListener('click', openDrawer);
	closeBtn && closeBtn.addEventListener('click', closeDrawer);
	backdrop.addEventListener('click', closeDrawer);
	document.addEventListener('keydown', function (e) {
		if (e.key === 'Escape') closeDrawer();
	});
})();
</script>
