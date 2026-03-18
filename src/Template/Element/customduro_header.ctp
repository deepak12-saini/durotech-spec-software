<?php
/**
 * Custom Duro header element (CakePHP 3).
 * Expects $getCategories (array of ['Category' => [...], 'Product' => [...]]) from controller.
 */
$getCategories = $getCategories ?? [];
// Only show last search term on the search results page; keep box empty on product/category/etc.
$isSearchPage = ($this->request->getParam('controller') === 'Products' && $this->request->getParam('action') === 'search');
$searchtitle = $isSearchPage ? ($this->request->getSession()->read('searchtitle') ?? '') : '';
?>
<script>
	function search() {
		var searchPro = $("#searchPro").val();
		if (searchPro != '') {
			$("#formsubmit").submit();
		} else {
			return false;
		}
	}
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
		padding: 20px 0px;
		width: 100%;
		box-shadow: none;
		-webkit-box-shadow: none;
	}

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

	.mega-dropdown-menu>li>ul {
		padding: 0;
		margin: 0;
	}

	.mega-dropdown-menu>li>ul>li {
		list-style: none;
	}

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

	.mega-dropdown-menu form {
		margin: 3px 20px;
	}

	.mega-dropdown-menu .form-group {
		margin-bottom: 3px;
	}

	@media (min-width: 768px) {
		.navbar-right .dropdown-menu {
			width: 1003px !important;
			margin-right: -414px;
		}
	}

	.mega-dropdown-menu>li>ul>li>a {
		color: black;
	}

	.mega-dropdown-menu>li ul>li>a:hover,
	.mega-dropdown-menu>li ul>li>a:focus {
		text-decoration: none;
		color: #2889c9;
	}

	.mega-dropdown-menu .dropdown-header {
		color: #2889c9;
		font-size: 11px;
		font-weight: bold;
		cursor: pointer;
	}

	.dropdown-menu {
		font-size: 11px;
	}

	.durotech_product {
		padding-top: 4%;
	}

	.mobilemenu {
		display: none !important;
	}

	@media (max-width: 500px) {
		.mobilemenu {
			display: block !important;
		}

		.desktop {
			display: none !important;
		}
	}

	.header_top_address ul {
		list-style: none;
		padding-left: 15px;
		margin: 0;
		display: flex;
		flex-wrap: wrap;
		gap: 5px;
		align-items: center;
	}

	.header_top_address li {
		display: inline-flex;
		align-items: center;
	}

	.header_top_address li i {
		margin-right: 5px;
		color: #444;
	}

	.header_top_address a {
		font-weight: bold;
		text-decoration: none;
		color: #0073e6;
	}

	.header_top_address a:hover {
		text-decoration: underline;
	}

	.header_top.scrolled {
		padding: 30px 0px;
	}

	.navbar-nav > li.dropdown.mega-dropdown:hover > .dropdown-menu {
		display: block !important;
	}

	.mega-dropdown:hover {
		display: block !important;
	}

	.navbar-nav > li > a.hover-blue {
		background-color: rgba(0, 86, 179, 0.15) !important;
		border: 1px solid rgba(0, 86, 179, 0.4);
		color: #0056b3 !important;
	}

	.navbar-nav > li > a.hover-yellow {
		background-color: rgba(244, 196, 0, 0.15) !important;
		border: 1px solid rgba(244, 196, 0, 0.4);
		color: #f4c400 !important;
	}

	.mega-dropdown-menu ul,
	.mega-dropdown-menu li {
		list-style: none !important;
	}

	.nav > li > a {
		line-height: 30px;
	}

	.mega-dropdown-menu .dropdown-header,
	.mega-dropdown-menu a {
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
		display: block;
		padding-right: 10px;
	}

	.mega-dropdown-menu li.col-sm-3 ul {
		width: 100%;
	}

	.mega-dropdown-menu li a,
	.mega-dropdown-menu .dropdown-header {
		display: block;
		padding: 6px 10px;
		transition: background-color 0.25s ease, color 0.25s ease;
		border-radius: 4px;
		cursor: pointer;
	}

	.hover-blue {
		background-color: rgba(0, 86, 179, 0.15);
		border: 1px solid rgba(0, 86, 179, 0.4);
		color: #0056b3 !important;
	}

	.hover-yellow {
		background-color: rgba(244, 196, 0, 0.15);
		border: 1px solid rgba(244, 196, 0, 0.4);
		color: #f4c400 !important;
	}

	.state-link {
		padding: 4px 10px;
		border-radius: 14px;
		transition: all 0.25s ease;
	}

	.state-link:hover {
		background: rgba(0, 86, 179, 0.15);
		color: #0056b3;
	}

	.state-link.active {
		background: rgba(52, 199, 89, 0.2);
		border: 1px solid rgba(52, 199, 89, 0.6);
		color: #1c7c3c;
	}
</style>
<script>
	jQuery(document).on('click', '.mega-dropdown', function(e) {
		e.stopPropagation()
	})
</script>
<div class="header_fixed col-lg-12 col-md-12 col-sm-12" id="header_top">
	<div class="header_top col-lg-12 col-md-12 col-sm-12">
		<div class="row">
			<div class="header_top_address col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<ul>
					<li>
						<i class="fa fa-map-marker" aria-hidden="true"></i>
						<a href="https://www.google.com/maps?q=14+Essex+st,+Minto,+Sydney+NSW+2566" class="state-link" data-state="NSW" target="_blank">NSW</a>
					</li>
					<li>
						<i class="fa fa-map-marker" aria-hidden="true"></i>
						<a href="https://www.google.com/maps?q=34+Indian+Drive,+Keysborough,+Victoria+3173" class="state-link" data-state="VIC" target="_blank">VICTORIA</a>
					</li>
					<li>
						<i class="fa fa-map-marker" aria-hidden="true"></i>
						<a href="https://www.google.com/maps?q=16+Export+Drive,+Molendinar,+Gold+Coast+4214" class="state-link" data-state="QLD" target="_blank">QUEENSLAND</a>
					</li>
					<li>
						<i class="fa fa-map-marker" aria-hidden="true"></i>
						<a href="https://www.google.com/maps?q=30C+Richard+Street,+Hindmarsh,+SA+5007" class="state-link" data-state="SA" target="_blank">SOUTH AUSTRALIA</a>
					</li>
					<li><Strong>Phone:</strong><a href="tel:<?= h(PHONE) ?>"><?= h(PHONE) ?></a></li>
					<li>
						<i class="fa fa-envelope" aria-hidden="true"></i>
						<a href="mailto:sales@durotechindustries.com.au">sales@durotechindustries.com.au</a>
					</li>
				</ul>
			</div>

			<div class="header_top_social_search col-lg-2 col-md-2 col-sm-2 col-xs-12">
				<?= $this->Form->create(null, ['url' => ['controller' => 'Products', 'action' => 'search'], 'method' => 'post', 'id' => 'formsubmit']) ?>
				<input type="text" name="search" value="<?= h($searchtitle) ?>" id="searchPro" placeholder="Search Product" required>
				<a href="javascript:void(0)" onclick="search()"><i onclick="search()" class="fa fa-search" aria-hidden="true"></i></a>
				<?= $this->Form->end() ?>
			</div>

			<div class="header_top_social col-lg-2 col-md-2 col-sm-2 col-xs-12">
				<ul>
					<li><a target="_blank" href="<?= h(FACEBOOK) ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
					<li><a target="_blank" href="<?= h(TWITER) ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
					<li><a target="_blank" href="<?= h(GOOGLE_PLUS) ?>"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
					<li><a target="_blank" href="https://www.instagram.com/durotechindustries.com.au"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
				</ul>
			</div>

			<div class="header_top_social_login col-lg-2 col-md-2 col-sm-2 col-xs-12">
			</div>
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
					<a class="navbar-brand" href="<?= h(SITEURL) ?>"><img src="<?= h(SITEURL) ?>customdurotech/images/durotech_logo.png" alt="Durotech"></a>
				</div>
				<div id="navbar5" class="navbar-collapse collapse">
					<ul class="nav navbar-nav navbar-right">
						<li><a href="<?= h(SITEURL) ?>">Home</a></li>
						<li><a href="<?= $this->Url->build('/about') ?>">About Us</a></li>
						<li><a href="<?= $this->Url->build('/projects') ?>">Projects</a></li>
						<li class="mobilemenu"><a href="<?= $this->Url->build('/product') ?>">Products</a></li>
						<li class="dropdown mega-dropdown desktop">
							<a class="dropdown-toggle" href="<?= $this->Url->build(['controller' => 'Products', 'action' => 'index']) ?>">Products</a>
							<ul class="dropdown-menu mega-dropdown-menu row" style="overflow-y: scroll; height:430px; scrollbar-width: thin;">
								<?php
								$totalCategories = count($getCategories);
								$categoriesPerColumn = $totalCategories > 0 ? (int)ceil($totalCategories / 4) : 0;
								$categoryChunks = $categoriesPerColumn > 0 ? array_chunk($getCategories, $categoriesPerColumn) : [];
								?>
								<?php foreach ($categoryChunks as $column): ?>
									<li class="col-sm-3">
										<ul>
											<?php foreach ($column as $cat): ?>
												<?php
												$catSlug = $cat['Category']['slug'] ?? '';
												$catName = $cat['Category']['category_name'] ?? '';
												$products = $cat['Product'] ?? [];
												?>
												<li class="dropdown-header rotate-text" onclick="openlink('<?= h($catSlug) ?>')"><?= h($catName) ?></li>
												<?php if (!empty($products)): ?>
													<?php foreach ($products as $product): ?>
														<?php $pSlug = is_array($product) ? ($product['slug'] ?? '') : ($product->slug ?? ''); ?>
														<?php $pTitle = is_array($product) ? ($product['title'] ?? '') : ($product->title ?? ''); ?>
														<li>
															<a href="<?= $this->Url->build('/product/' . $pSlug) ?>"><?= h($pTitle) ?></a>
														</li>
													<?php endforeach; ?>
												<?php endif; ?>
												<li class="divider"></li>
											<?php endforeach; ?>
										</ul>
									</li>
								<?php endforeach; ?>
							</ul>
						</li>
						<li><a href="<?= $this->Url->build('/technical-literature') ?>">Technical literature</a></li>
						<li><a href="<?= $this->Url->build('/durolab') ?>">DuroLab</a></li>
						<li><a href="<?= $this->Url->build('/contact') ?>">Contact Us</a></li>
					</ul>
				</div>
			</div>
		</nav>
	</div>
</div>
<script>
	function openlink(slug) {
		window.location.href = '<?= h($this->Url->build('/category/')) ?>' + slug;
	}

	window.addEventListener("scroll", function() {
		var headerTop = document.querySelector(".header_top");
		var addressBar = document.querySelector(".header_top_address");

		if (window.scrollY > 50) {
			headerTop.classList.add("scrolled");
			addressBar.style.display = "none";
		} else {
			headerTop.classList.remove("scrolled");
			addressBar.style.display = "block";
		}
	});

	$(".mega-dropdown").hover(
		function () {
			$(this).addClass("open");
		},
		function () {
			$(this).removeClass("open");
		}
	);
</script>
<script>
	let hoverToggle = true;

	$('.mega-dropdown-menu').on('mouseenter', 'a, .dropdown-header', function () {
		if (hoverToggle) {
			$(this).addClass('hover-blue');
		} else {
			$(this).addClass('hover-yellow');
		}
		hoverToggle = !hoverToggle;
	});

	$('.mega-dropdown-menu').on('mouseleave', 'a, .dropdown-header', function () {
		$(this).removeClass('hover-blue hover-yellow');
	});
</script>
<script>
	let headerHoverToggle = true;

	$('.navbar-nav > li > a').on('mouseenter', function () {
		$(this).removeClass('hover-blue hover-yellow');

		if (headerHoverToggle) {
			$(this).addClass('hover-blue');
		} else {
			$(this).addClass('hover-yellow');
		}

		headerHoverToggle = !headerHoverToggle;
	});

	$('.navbar-nav > li > a').on('mouseleave', function () {
		$(this).removeClass('hover-blue hover-yellow');
	});
</script>
<script>
	jQuery(document).ready(function () {
		jQuery('.state-link').on('click', function () {
			jQuery('.state-link').removeClass('active');
			jQuery(this).addClass('active');
		});
	});
</script>
