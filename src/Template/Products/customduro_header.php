<?php
/**
 * Products header – menu categories come from controller (ProductsController / FrontsController).
 * Use $getCategories set by controller; no requestAction (deprecated in CakePHP 3).
 */
$getCategories = $getCategories ?? [];
$isSearchPage = ($this->request->getParam('controller') === 'Products' && $this->request->getParam('action') === 'search');
$searchtitle = $isSearchPage ? ($this->request->getSession()->read('searchtitle') ?? '') : '';
$headerPhoneTel = preg_replace('/\D+/', '', PHONE);
$currentMenuPass = $this->request->getParam('pass') ?: [];
$currentMenuSlug = $this->request->getQuery('slug') ?? $this->request->getParam('slug') ?? ($currentMenuPass[0] ?? '');
$currentMenuSlug = is_string($currentMenuSlug) ? trim(rawurldecode($currentMenuSlug)) : '';
$currentMenuController = $this->request->getParam('controller');
$currentMenuAction = $this->request->getParam('action');
$currentMenuIsCategory = ($currentMenuController === 'Products' && $currentMenuAction === 'index' && $currentMenuSlug !== '');
$currentMenuIsProduct = ($currentMenuController === 'Products' && $currentMenuAction === 'detail' && $currentMenuSlug !== '');
?>
<script>
	function search() {
		var searchPro = $.trim($("#searchPro").val());
		if (searchPro.length >= 3) {
			document.getElementById("formsubmit").submit();
			return true;
		}

		return false;
	}

	jQuery(function ($) {
		$("#formsubmit").on("submit", function () {
			return $.trim($("#searchPro").val()).length >= 3;
		});
	});
</script>
<style>
	.login {
		border: 1px solid #2889c9;
		padding: 6px 8px;
		border-radius: 12px;
		color: #2889c9;
		margin-right: 10px !important;
	}
	.mega-dropdown-menu {
		padding: 18px 16px 22px;
		width: 100%;
		background: linear-gradient(135deg, #f3f9ff 0%, #eaf4fb 100%);
		border: 1px solid rgba(40, 137, 201, 0.22);
		border-top: 3px solid #2889c9;
		border-radius: 0 0 18px 18px;
		box-shadow: 0 14px 36px rgba(40, 137, 201, 0.18), 0 4px 12px rgba(0, 51, 102, 0.08);
		-webkit-box-shadow: 0 14px 36px rgba(40, 137, 201, 0.18), 0 4px 12px rgba(0, 51, 102, 0.08);
		box-sizing: border-box;
		max-height: calc(100vh - 170px);
		overflow-y: auto;
		scrollbar-width: thin;
		scrollbar-color: rgba(40, 137, 201, 0.55) rgba(255, 255, 255, 0.65);
	}
	.mega-dropdown-menu::-webkit-scrollbar { width: 8px; }
	.mega-dropdown-menu::-webkit-scrollbar-track { background: rgba(255, 255, 255, 0.65); border-radius: 10px; }
	.mega-dropdown-menu::-webkit-scrollbar-thumb { background: rgba(40, 137, 201, 0.55); border-radius: 10px; }
	.mega-dropdown-menu:before {
		content: "";
		border-bottom: 15px solid #fff;
		border-right: 17px solid transparent;
		border-left: 17px solid transparent;
		position: absolute;
		top: -15px;
		left: 285px;
		z-index: 10;
	}
	.mega-dropdown-menu:after {
		content: "";
		border-bottom: 17px solid #ccc;
		border-right: 19px solid transparent;
		border-left: 19px solid transparent;
		position: absolute;
		top: -17px;
		left: 283px;
		z-index: 8;
	}
	.mega-dropdown-menu>li>ul { padding: 0; margin: 0; }
	.mega-dropdown-menu>li>ul>li { list-style: none; }
	.mega-dropdown-menu>li>ul>li>a {
		display: block;
		padding: 3px 20px;
		clear: both;
		font-weight: normal;
		line-height: 1.428571429;
		color: #999;
		white-space: normal;
	}
	.mega-dropdown-menu>li ul>li>a:hover,
	.mega-dropdown-menu>li ul>li>a:focus {
		text-decoration: none;
		color: #444;
		background-color: #f5f5f5;
	}
	.mega-dropdown-menu .dropdown-header {
		color: #428bca;
		font-size: 18px;
		font-weight: bold;
	}
	.mega-dropdown-menu form { margin: 3px 20px; }
	.mega-dropdown-menu .form-group { margin-bottom: 3px; }
	/* Match the dropdown panel accent with the current Products nav text color */
	.mega-dropdown > a.hover-blue + .mega-dropdown-menu {
		border-top-color: #2889c9;
		box-shadow: 0 14px 36px rgba(40, 137, 201, 0.18), 0 4px 12px rgba(0, 51, 102, 0.08);
		-webkit-box-shadow: 0 14px 36px rgba(40, 137, 201, 0.18), 0 4px 12px rgba(0, 51, 102, 0.08);
	}
	.mega-dropdown > a.hover-yellow + .mega-dropdown-menu {
		border-color: rgba(244, 196, 0, 0.28);
		border-top-color: #f4c400;
		box-shadow: 0 14px 36px rgba(244, 196, 0, 0.22), 0 4px 12px rgba(0, 51, 102, 0.08);
		-webkit-box-shadow: 0 14px 36px rgba(244, 196, 0, 0.22), 0 4px 12px rgba(0, 51, 102, 0.08);
	}
	.mega-dropdown-menu > li.col-sm-3 {
		border: 1px solid rgba(40, 137, 201, 0.14);
		border-radius: 14px;
		background: rgba(255, 255, 255, 0.82);
		box-shadow: 0 4px 12px rgba(0, 51, 102, 0.06);
		padding: 14px 16px;
		transition: border-color 0.22s ease, box-shadow 0.22s ease, transform 0.22s ease;
	}
	.mega-dropdown-menu > li.col-sm-3:hover {
		border-color: rgba(40, 137, 201, 0.42);
		box-shadow: 0 10px 24px rgba(40, 137, 201, 0.16);
		transform: translateY(-2px);
	}
	.mega-dropdown > a.hover-yellow + .mega-dropdown-menu > li.col-sm-3:hover {
		border-color: rgba(244, 196, 0, 0.48);
		box-shadow: 0 10px 24px rgba(244, 196, 0, 0.18);
	}
	.mega-dropdown > a.hover-blue + .mega-dropdown-menu > li.col-sm-3:hover {
		border-color: rgba(40, 137, 201, 0.42);
		box-shadow: 0 10px 24px rgba(40, 137, 201, 0.16);
	}
	@media (min-width: 768px) {
		.navbar-right .dropdown-menu {
			width: min(1280px, calc(100vw - 32px)) !important;
			margin-right: 0;
		}
	}
	.mega-dropdown-menu>li>ul>li>a {
		color: #777;
	}
	.mega-dropdown-menu>li ul>li>a:hover,
	.mega-dropdown-menu>li ul>li>a:focus {
		text-decoration: none;
		color: #2889c9;
	}
	.mega-dropdown-menu .dropdown-header {
		color: #2889c9;
		font-size: 12px;
		font-weight: 700;
		letter-spacing: 0.02em;
		padding-bottom: 7px;
		margin: 4px 0 6px;
		border-bottom: 1px solid rgba(40, 137, 201, 0.16);
		cursor: pointer;
		position: relative;
		padding-left: 14px;
	}
	.mega-dropdown-menu .dropdown-header::before {
		content: "";
		position: absolute;
		left: 0;
		top: 8px;
		width: 4px;
		height: 18px;
		border-radius: 999px;
		background: linear-gradient(180deg, #2889c9 0%, #f4c400 100%);
	}
	.mega-dropdown-menu li a,
	.mega-dropdown-menu .dropdown-header {
		border: 1px solid transparent;
		border-radius: 10px;
		transition: border-color 0.22s ease, box-shadow 0.22s ease, transform 0.22s ease, background-color 0.22s ease;
	}
	.mega-dropdown-menu li a {
		font-size: 11px;
		line-height: 1.55;
		position: relative;
		padding-left: 18px;
	}
	.mega-dropdown-menu li a::before {
		content: "\203A";
		position: absolute;
		left: 7px;
		top: 50%;
		transform: translateY(-50%) translateX(-4px);
		opacity: 0;
		transition: opacity 0.22s ease, transform 0.22s ease;
	}
	.mega-dropdown-menu li a:hover::before,
	.mega-dropdown-menu li a:focus::before {
		opacity: 1;
		transform: translateY(-50%) translateX(0);
	}
	.mega-dropdown-menu li a:hover,
	.mega-dropdown-menu li a:focus,
	.mega-dropdown-menu .dropdown-header:hover,
	.mega-dropdown-menu .dropdown-header:focus {
		background: rgba(255, 255, 255, 0.72) !important;
		border-color: rgba(40, 137, 201, 0.25);
		box-shadow: 0 6px 16px rgba(0, 51, 102, 0.12);
		transform: translateX(3px);
		text-decoration: none;
	}
	.mega-dropdown-menu .dropdown-header:hover,
	.mega-dropdown-menu .dropdown-header:focus {
		color: #2889c9;
	}
	.mega-dropdown-menu li a.is-current,
	.mega-dropdown-menu .dropdown-header.is-current {
		background: linear-gradient(90deg, rgba(40, 137, 201, 0.14), rgba(244, 196, 0, 0.12)) !important;
		border-color: rgba(40, 137, 201, 0.38);
		box-shadow: 0 6px 16px rgba(40, 137, 201, 0.14);
		color: #0056b3 !important;
		font-weight: 700;
	}
	.mega-dropdown-menu li a.is-current::before {
		opacity: 1;
		transform: translateY(-50%) translateX(0);
	}
	.mega-dropdown-menu > li.col-sm-3 {
		background: linear-gradient(180deg, #fff 0%, #f8fbff 100%);
	}
	.navbar-nav > li.dropdown.mega-dropdown:hover > .mega-dropdown-menu {
		animation: megaMenuFadeIn 0.22s ease both;
	}
	@keyframes megaMenuFadeIn {
		from { opacity: 0; transform: translateY(8px); }
		to { opacity: 1; transform: translateY(0); }
	}
	@media (min-width: 768px) {
		.navbar-nav > li.dropdown.mega-dropdown:hover > .mega-dropdown-menu {
			display: flex !important;
		}
		.mega-dropdown-menu.row {
			margin-left: 0 !important;
			margin-right: 0 !important;
		}
		.mega-dropdown-menu {
			flex-wrap: wrap;
			align-items: flex-start;
			gap: 20px;
			padding-left: 24px;
			padding-right: 24px;
		}
		.mega-dropdown-menu > li.col-sm-3 {
			float: none !important;
			width: calc(20% - 16px) !important;
			box-sizing: border-box;
			min-width: 0;
		}
	}
	.dropdown-menu { font-size: 11px; }
	.durotech_product { padding-top: 4%; }
	.mobilemenu { display: none !important; }
	.mobile-products-accordion {
		display: none;
		margin: 0 10px 12px;
		padding: 8px;
		list-style: none;
		background: linear-gradient(135deg, #f3f9ff 0%, #fff 100%);
		border: 1px solid rgba(40, 137, 201, 0.18);
		border-radius: 14px;
		box-shadow: 0 8px 22px rgba(0, 51, 102, 0.08);
		max-height: 65vh;
		overflow-y: auto;
	}
	.mobilemenu.is-open .mobile-products-accordion {
		display: block;
	}
	.mobile-products-toggle {
		display: flex !important;
		align-items: center;
		justify-content: space-between;
	}
	.mobile-products-icon {
		width: 22px;
		height: 22px;
		border-radius: 50%;
		background: rgba(40, 137, 201, 0.12);
		color: #2889c9;
		font-weight: 700;
		line-height: 22px;
		text-align: center;
		transition: transform 0.22s ease, background-color 0.22s ease;
	}
	.mobilemenu.is-open .mobile-products-icon {
		background: rgba(244, 196, 0, 0.2);
		transform: rotate(45deg);
	}
	.mobile-product-category {
		list-style: none;
		border-bottom: 1px solid rgba(40, 137, 201, 0.1);
	}
	.mobile-product-category:last-child {
		border-bottom: 0;
	}
	.mobile-product-category-toggle {
		width: 100%;
		display: flex;
		align-items: center;
		justify-content: space-between;
		gap: 8px;
		padding: 10px 8px 10px 12px;
		background: transparent;
		border: 0;
		color: #2889c9;
		font-size: 12px;
		font-weight: 700;
		text-align: left;
	}
	.mobile-product-category-toggle:after {
		content: "+";
		width: 20px;
		height: 20px;
		flex: 0 0 20px;
		border-radius: 50%;
		background: rgba(40, 137, 201, 0.1);
		color: #2889c9;
		line-height: 20px;
		text-align: center;
	}
	.mobile-product-category.is-open > .mobile-product-category-toggle:after {
		content: "-";
		background: rgba(244, 196, 0, 0.22);
		color: #b58a00;
	}
	.mobile-product-list {
		display: none;
		margin: 0;
		padding: 0 0 8px;
		list-style: none;
	}
	.mobile-product-category.is-open > .mobile-product-list {
		display: block;
	}
	.mobile-product-list a {
		display: block;
		margin: 2px 0;
		padding: 7px 10px 7px 22px;
		border-radius: 10px;
		color: #333;
		font-size: 12px;
		line-height: 1.35;
		text-decoration: none !important;
	}
	.mobile-product-list a:hover,
	.mobile-product-list a:focus,
	.mobile-product-list a.is-current,
	.mobile-product-category-toggle.is-current {
		background: linear-gradient(90deg, rgba(40, 137, 201, 0.14), rgba(244, 196, 0, 0.12));
		color: #0056b3 !important;
		font-weight: 700;
	}
	.mobile-view-category {
		color: #2889c9 !important;
		font-weight: 700;
	}
	@media (max-width: 767px) {
		.mobilemenu { display: block !important; }
		.desktop { display: none !important; }
	}
	.header_top_contact { padding: 0 35px 0 6px; text-align: right; }
	.header_top_contact ul { list-style: none; margin: 0 0 0 auto; padding: 0; max-width: 100%; display: flex; flex-direction: row; flex-wrap: wrap; justify-content: flex-end; align-items: center; gap: 3px 8px; }
	.header_top_contact li { margin: 0; padding: 0; list-style: none; line-height: 1.2; }
	.header_top_contact a { display: inline-flex; align-items: center; gap: 3px; font-size: 12px; font-weight: 600; color: #2672EC !important; text-decoration: none !important; white-space: nowrap; }
	.header_top_contact .fa-phone, .header_top_contact .fa-envelope { color: #1a1a1a; font-size: 12px; flex-shrink: 0; }
	@media (min-width: 768px) {
		.header_top_social_search { display: flex; align-items: center; justify-content: flex-end; padding-right: 4px; }
		.header_top_social_search form { display: flex; align-items: center; justify-content: flex-end; width: 100%; max-width: 180px; margin-left: 0; margin-right: 0; }
		.header_top_social_search #searchPro { width: auto !important; max-width: 130px; min-width: 88px; flex: 1 1 auto; }
		.header_top_contact ul { justify-content: flex-end; }
	}
	@media (min-width: 992px) {
		.header_top_social_search form { max-width: 200px; }
		.header_top_social_search #searchPro { max-width: 150px; }
	}
	@media (max-width: 767px) {
		.header_top_contact { text-align: center; padding: 10px 10px 0; }
		.header_top_contact ul { align-items: center; justify-content: center; }
		.header_top_contact a { white-space: normal; justify-content: center; }
		.header_top_social_search { display: flex; justify-content: center; padding: 6px 12px 0; }
		.header_top_social_search form { display: flex; align-items: center; justify-content: center; width: 100%; max-width: 245px; margin: 0 auto; }
		.header_top_social_search #searchPro { max-width: none !important; width: calc(100% - 28px) !important; flex: 1 1 auto; }
	}
</style>
<script>
	jQuery(document).on('click', '.mega-dropdown', function(e) {
		e.stopPropagation()
	});
</script>
<?php
// Optional: show a small indicator when menu data is missing (remove in production if desired)
if (empty($getCategories) || !is_array($getCategories)) {
	echo '<!-- Menu: no categories data (controller should set $getCategories) -->';
}
?>
<div class="header_fixed col-lg-12 col-md-12 col-sm-12" id="header_top">
	<div class="header_top col-lg-12 col-md-12 col-sm-12">
		<div class="header_top_address col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<ul>
				<li>
					<i class="fa fa-map-marker" aria-hidden="true"></i>
					<a href="<?php echo SITEURL . 'contact'; ?>" target="_blank">Keysborough</a>
				</li>
				<li>
					<i class="fa fa-map-marker" aria-hidden="true"></i>
					<a href="<?php echo SITEURL . 'contact'; ?>" target="_blank">Campbellfield11</a>
				</li>
			</ul>
		</div>
		<div class="header_top_social_search col-lg-2 col-md-2 col-sm-12 col-xs-12">
<form action="<?php echo SITEURL . 'products/search' ?>" method="get" id="formsubmit">
					<input type="text" name="search" value="<?php echo $searchtitle; ?>" id="searchPro" placeholder="Search Product" required>
				<a href="javascript:void(0)" onclick="search()"><i class="fa fa-search" aria-hidden="true"></i></a>
			</form>
		</div>
		<div class="header_top_contact col-lg-4 col-md-4 col-sm-12 col-xs-12">
			<ul>
				<li>
					<a href="tel:<?php echo h($headerPhoneTel); ?>">
						<i class="fa fa-phone" aria-hidden="true"></i>
						<span class="sr-only">Phone: </span>
						<?php echo h(PHONE); ?>
					</a>
				</li>
				<li>
					<a href="mailto:sales@durotechindustries.com.au">
						<i class="fa fa-envelope" aria-hidden="true"></i>
						<span>sales@durotechindustries.com.au</span>
					</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="container example5">
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar5">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="<?php echo SITEURL; ?>"><img src="<?php echo SITEURL; ?>customdurotech/images/durotech_logo.png" alt="Dispute Bills"></a>
				</div>
				<div id="navbar5" class="navbar-collapse collapse">
					<ul class="nav navbar-nav navbar-right">
						<li><a href="<?php echo SITEURL ?>">Home</a></li>
						<li><a href="<?php echo SITEURL ?>about">About Us</a></li>
						<li class="mobilemenu<?php echo ($currentMenuIsCategory || $currentMenuIsProduct) ? ' is-open' : ''; ?>">
							<a href="javascript:void(0)" class="mobile-products-toggle" aria-expanded="<?php echo ($currentMenuIsCategory || $currentMenuIsProduct) ? 'true' : 'false'; ?>">
								Products <span class="mobile-products-icon">+</span>
							</a>
							<ul class="mobile-products-accordion">
								<?php if (!empty($getCategories) && is_array($getCategories)): ?>
									<?php foreach ($getCategories as $cat): ?>
										<?php
										if (empty($cat['Category']['category_name'])) {
											continue;
										}
										$categorySlug = $cat['Category']['slug'] ?? '';
										$hasCurrentProduct = false;
										if ($currentMenuIsProduct && !empty($cat['Product']) && is_array($cat['Product'])) {
											foreach ($cat['Product'] as $prodForActive) {
												if (($prodForActive['slug'] ?? '') === $currentMenuSlug) {
													$hasCurrentProduct = true;
													break;
												}
											}
										}
										$categoryIsCurrent = ($currentMenuIsCategory && $categorySlug === $currentMenuSlug) || $hasCurrentProduct;
										?>
										<li class="mobile-product-category<?php echo $categoryIsCurrent ? ' is-open' : ''; ?>">
											<button type="button" class="mobile-product-category-toggle<?php echo $categoryIsCurrent ? ' is-current' : ''; ?>" aria-expanded="<?php echo $categoryIsCurrent ? 'true' : 'false'; ?>">
												<?php echo h($cat['Category']['category_name']); ?>
											</button>
											<ul class="mobile-product-list">
												<li><a class="mobile-view-category<?php echo $currentMenuIsCategory && $categorySlug === $currentMenuSlug ? ' is-current' : ''; ?>" href="<?php echo $this->Url->build('/category/' . $categorySlug); ?>">View Category</a></li>
												<?php if (!empty($cat['Product']) && is_array($cat['Product'])): ?>
													<?php foreach ($cat['Product'] as $prod): ?>
														<?php if (!empty($prod['slug'])): ?>
															<li>
																<a class="<?php echo $currentMenuIsProduct && $prod['slug'] === $currentMenuSlug ? 'is-current' : ''; ?>" href="<?php echo $this->Url->build(['controller' => 'Products', 'action' => 'detail', $prod['slug']]); ?>">
																	<?php echo h($prod['title']); ?>
																</a>
															</li>
														<?php endif; ?>
													<?php endforeach; ?>
												<?php endif; ?>
											</ul>
										</li>
									<?php endforeach; ?>
								<?php endif; ?>
							</ul>
						</li>
						<li class="dropdown mega-dropdown desktop">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#null">Products</a>
							<ul class="dropdown-menu mega-dropdown-menu row">
								<?php
								// Dynamically generate category columns, 5 columns to use the right-side space
								if (!empty($getCategories) && is_array($getCategories)) {
									// Split $getCategories into 5 almost even chunks for columns
									$totalCats = count($getCategories);
									$perCol = max(1, (int)ceil($totalCats / 5));
									$chunks = array_chunk($getCategories, $perCol);

									foreach ($chunks as $colIdx => $chunk) {
										echo '<li class="col-sm-3"><ul>';
										foreach ($chunk as $cat) {
											// Skip empty or invalid category
											if (empty($cat['Category']['category_name'])) continue;
											$categorySlug = $cat['Category']['slug'] ?? '';
											$hasCurrentProduct = false;
											if ($currentMenuIsProduct && !empty($cat['Product']) && is_array($cat['Product'])) {
												foreach ($cat['Product'] as $prodForActive) {
													if (($prodForActive['slug'] ?? '') === $currentMenuSlug) {
														$hasCurrentProduct = true;
														break;
													}
												}
											}
											$categoryCurrentClass = ($currentMenuIsCategory && $categorySlug === $currentMenuSlug) || $hasCurrentProduct ? ' is-current' : '';
											// Category header w/ link
											echo '<li class="dropdown-header' . $categoryCurrentClass . '" onclick="openlink(\'' . htmlspecialchars($categorySlug) . '\')">' . htmlspecialchars($cat['Category']['category_name']) . '</li>';
											// List products
											if (!empty($cat['Product']) && is_array($cat['Product'])) {
												foreach ($cat['Product'] as $prod) {
													if (!empty($prod['slug'])) {
														$productCurrentClass = $currentMenuIsProduct && $prod['slug'] === $currentMenuSlug ? ' class="is-current"' : '';
														echo '<li><a' . $productCurrentClass . ' href="' . $this->Url->build(['controller' => 'Products', 'action' => 'detail', $prod['slug']]) . '">' . htmlspecialchars($prod['title']) . '</a></li>';
													}
												}
											} else {
												echo '<li style="color:#b00;font-style:italic;">No products in this category</li>';
											}
											echo '<li class="divider"></li>';
										}
										echo '</ul></li>';
									}
								} else {
									echo '<li class="col-sm-12" style="color:red;padding:10px;">No product categories found. Please check database and backend logic.</li>';
								}
								?>
							</ul>
						</li>
						<li><a href="<?php echo SITEURL ?>technical-literature">Technical literature</a></li>
						<li><a href="<?php echo SITEURL ?>durolab">DuroLab</a></li>
						<li><a href="<?php echo SITEURL ?>contact">Contact Us</a></li>
					</ul>
				</div>
			</div>
		</nav>
	</div>
</div>
<script>
	function openlink(slug) {
		window.location.href = '<?php echo SITEURL . 'category/' ?>' + slug;
	}
</script>
<script>
jQuery(function ($) {
	$('.mobile-products-toggle').on('click', function (e) {
		e.preventDefault();
		var $menu = $(this).closest('.mobilemenu');
		$menu.toggleClass('is-open');
		$(this).attr('aria-expanded', $menu.hasClass('is-open') ? 'true' : 'false');
	});

	$('.mobile-product-category-toggle').on('click', function () {
		var $category = $(this).closest('.mobile-product-category');
		$category.toggleClass('is-open').siblings('.mobile-product-category').removeClass('is-open').children('.mobile-product-category-toggle').attr('aria-expanded', 'false');
		$(this).attr('aria-expanded', $category.hasClass('is-open') ? 'true' : 'false');
	});
});
</script>
<script>
jQuery(function ($) {
	function fitProductsMegaMenu() {
		var $menuItem = $('.mega-dropdown.desktop').first();
		var $menu = $menuItem.children('.mega-dropdown-menu');
		if (!$menuItem.length || !$menu.length) {
			return;
		}
		var viewportWidth = $(window).width();
		var menuWidth = Math.min(1280, viewportWidth - 32);
		var menuLeft = Math.max(16 - $menuItem.offset().left, (viewportWidth - menuWidth) / 2 - $menuItem.offset().left);
		$menu.css({
			width: menuWidth + 'px',
			left: menuLeft + 'px',
			right: 'auto',
			marginRight: 0
		});
	}
	$('.mega-dropdown.desktop').on('mouseenter', fitProductsMegaMenu);
	$(window).on('resize', fitProductsMegaMenu);
	fitProductsMegaMenu();
});
</script>