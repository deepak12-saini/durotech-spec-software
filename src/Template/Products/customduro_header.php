<?php
/**
 * Products header – menu categories come from controller (ProductsController / FrontsController).
 * Use $getCategories set by controller; no requestAction (deprecated in CakePHP 3).
 */
$getCategories = $getCategories ?? [];
$searchtitle = $this->request->getSession()->read('searchtitle') ?? '';
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
		<div class="header_top_address col-lg-6 colmd-6 col-sm-6">
			<ul>
				<li>
					<i class="fa fa-map-marker" aria-hidden="true"></i>
					<a href="<?php echo SITEURL . 'contact'; ?>" target="_blank">Keysborough</a>
				</li>
				<li>
					<i class="fa fa-map-marker" aria-hidden="true"></i>
					<a href="<?php echo SITEURL . 'contact'; ?>" target="_blank">Campbellfield11</a>
				</li>
				<li><Strong>Phone:</strong> <?php echo PHONE;  ?></li>
			</ul>
		</div>
		<div class="header_top_social_search col-lg-2 col-md-2 col-sm-2">
<form action="<?php echo SITEURL . 'products/search' ?>" method="get" id="formsubmit">
					<input type="text" name="search" value="<?php echo $searchtitle; ?>" id="searchPro" placeholder="Search Product" required>
				<a href="javascript:void(0)" onclick="search()"><i class="fa fa-search" aria-hidden="true"></i></a>
			</form>
		</div>
		<div class="header_top_social col-lg-2 col-md-2 col-sm-2">
			<ul>
				<li><a target="_blank" href="<?php echo FACEBOOK ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
				<li><a target="_blank" href="<?php echo TWITER ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
				<li><a target="_blank" href="<?php echo GOOGLE_PLUS ?>"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
				<li><a target="_blank" href="https://www.instagram.com/durotechindustries.com.au"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
			</ul>
		</div>
		<div class="header_top_social_login col-lg-2 col-md-2 col-sm-2">
			<?php /* User login/register logic removed for brevity */ ?>
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