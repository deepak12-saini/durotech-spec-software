<?php
/**
 * Products header – menu categories come from controller (ProductsController / FrontsController).
 * Use $getCategories set by controller; no requestAction (deprecated in CakePHP 3).
 */
$getCategories = $getCategories ?? [];
$isSearchPage = ($this->request->getParam('controller') === 'Products' && $this->request->getParam('action') === 'search');
$searchtitle = $isSearchPage ? ($this->request->getSession()->read('searchtitle') ?? '') : '';
$headerPhoneTel = preg_replace('/\D+/', '', PHONE);
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
	@media (min-width: 768px) {
		.navbar-right .dropdown-menu {
			width: 1003px !important;
			margin-right: -414px;
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
		font-size: 11px;
		font-weight: bold;
		cursor: pointer;
	}
	.dropdown-menu { font-size: 11px; }
	.durotech_product { padding-top: 4%; }
	.mobilemenu { display: none !important; }
	@media (max-width: 500px) {
		.mobilemenu { display: block !important; }
		.desktop { display: none !important; }
	}
	/* .header_top_contact { padding: 0 30px 0 6px; text-align: right; } */
	.header_top_contact ul { list-style: none; margin: 0 0 0 auto; padding: 0; max-width: 100%; display: flex; flex-direction: row; flex-wrap: wrap; justify-content: flex-end; align-items: center; gap: 3px 8px; }
	.header_top_contact li { margin: 0; padding: 0; list-style: none; line-height: 1.2; }
	.header_top_contact a { display: inline-flex; align-items: center; gap: 3px; font-size: 10px; font-weight: 600; color: #2672EC !important; text-decoration: none !important; white-space: nowrap; }
	.header_top_contact .fa-phone, .header_top_contact .fa-envelope { color: #1a1a1a; font-size: 10px; flex-shrink: 0; }
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
		.header_top_social_search form { max-width: none; justify-content: center; }
		.header_top_social_search #searchPro { max-width: none !important; width: 90% !important; }
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
						<li class="mobilemenu"><a href="<?= $this->Url->build('/product') ?>">Products</a></li>
						<li class="dropdown mega-dropdown desktop">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#null">Products</a>
							<ul class="dropdown-menu mega-dropdown-menu row" style="overflow-y: scroll; height:430px; scrollbar-width: thin;">
								<?php
								// Dynamically generate category columns, 4 columns in grid (col-sm-3), fallback if data not set or not enough
								if (!empty($getCategories) && is_array($getCategories)) {
									// Split $getCategories into 4 almost even chunks for columns
									$totalCats = count($getCategories);
									$perCol = ceil($totalCats / 4);
									$chunks = array_chunk($getCategories, $perCol);

									foreach ($chunks as $colIdx => $chunk) {
										echo '<li class="col-sm-3"><ul>';
										foreach ($chunk as $cat) {
											// Skip empty or invalid category
											if (empty($cat['Category']['category_name'])) continue;
											// Category header w/ link
											echo '<li class="dropdown-header" onclick="openlink(\'' . htmlspecialchars($cat['Category']['slug']) . '\')">' . htmlspecialchars($cat['Category']['category_name']) . '</li>';
											// List products
											if (!empty($cat['Product']) && is_array($cat['Product'])) {
												foreach ($cat['Product'] as $prod) {
													if (!empty($prod['slug'])) {
														echo '<li><a href="' . $this->Url->build(['controller' => 'Products', 'action' => 'detail', $prod['slug']]) . '">' . htmlspecialchars($prod['title']) . '</a></li>';
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