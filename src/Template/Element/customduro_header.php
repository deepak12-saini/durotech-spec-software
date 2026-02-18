<script>
	function search() {
		var searchPro = $("#searchPro").val();
		if (searchPro != '') {
			$("#formsubmit").submit();
		} else {
			//$("#formsubmit").submit();
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
		/* color: #777; */
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
		list-style: none;       /* remove bullets */
		padding-left: 15px;
		margin: 0;
		display: flex;          /* put items in one line */
		flex-wrap: wrap;        /* wrap if screen is small */
		gap: 5px;              /* spacing between items */
		align-items: center;    /* align vertically with icons */
	}

	.header_top_address li {
		display: inline-flex;   /* inline with icon */
		align-items: center;
	}

	.header_top_address li i {
		margin-right: 5px;      /* spacing between icon and text */
		color: #444;            /* optional: style map icon */
	}

	.header_top_address a {
		font-weight: bold;      /* match your UI style */
		text-decoration: none;
		color: #0073e6;         /* link color */
	}

	.header_top_address a:hover {
		text-decoration: underline;  /* hover effect */
	}

	.header_top.scrolled {
		padding: 30px 0px; /* increased padding on scroll */
	}

	/* new_code for UI */

	/* ===== OPEN PRODUCTS MENU ON HOVER ===== */
		.navbar-nav > li.dropdown.mega-dropdown:hover > .dropdown-menu {
			display: block !important;
		}

		/* Keep menu open when moving mouse inside */
		.mega-dropdown:hover {
			display: block !important;
		}

		/* FORCE CUSTOM HOVER COLORS */
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


		/* ===== OPEN PRODUCTS MEGA MENU ON HOVER ===== */
		.navbar-nav > li.dropdown.mega-dropdown:hover > .dropdown-menu {
			display: block !important;
		}

		

	/* Remove dots (bullets) from mega dropdown menu */
	.mega-dropdown-menu ul,
	.mega-dropdown-menu li {
		list-style: none !important;
	}

	.nav > li > a {
		line-height: 30px;
	}

	/* 30-12-2025 */

	/* For dropdown headers */
	.mega-dropdown-menu .dropdown-header,
	.mega-dropdown-menu a {
		white-space: nowrap;         /* Prevent text wrapping */
		overflow: hidden;            /* Hide overflow */
		text-overflow: ellipsis;     /* Show ... for long text */
		display: block;              /* Ensure proper width applies */
		padding-right: 10px;         /* Keep some space on the right */
	}

	/* Optional: fix width of column */
	.mega-dropdown-menu li.col-sm-3 ul {
		width: 100%; /* or a fixed px value like 200px */
	}


	/* Base hover style */
	.mega-dropdown-menu li a,
	.mega-dropdown-menu .dropdown-header {
		display: block;
		padding: 6px 10px;
		transition: background-color 0.25s ease, color 0.25s ease;
		border-radius: 4px;
		cursor: pointer;

	
	}

	.hover-blue {
		background-color: rgba(0, 86, 179, 0.15);  /* semi-transparent brand blue */
		border: 1px solid rgba(0, 86, 179, 0.4);  /* subtle border */
		color: #0056b3 !important;                /* brand blue text */
	}

	/* Subtle Yellow highlight */
	.hover-yellow {
		background-color: rgba(244, 196, 0, 0.15); /* semi-transparent brand yellow */
		border: 1px solid rgba(244, 196, 0, 0.4); /* subtle border */
		color: #f4c400 !important;                /* brand yellow text */
	}




	.state-link {
    padding: 4px 10px;
    border-radius: 14px;
    transition: all 0.25s ease;
	}

	/* Hover = live read preview */
	.state-link:hover {
		background: rgba(0, 86, 179, 0.15);
		color: #0056b3;
	}

	/* Active (clicked) */
	.state-link.active {
		background: rgba(52, 199, 89, 0.2); /* subtle green */
		border: 1px solid rgba(52, 199, 89, 0.6);
		color: #1c7c3c;
	}




</style>
<script>
	jQuery(document).on('click', '.mega-dropdown', function(e) {
		e.stopPropagation()
	})
</script>
<?php
// $getCategories is set in AppController::beforeFilter() (requestAction would crash: actions must return Response|null)
if (!isset($getCategories)) {
    $getCategories = [];
}
$searchtitle = $this->request->getSession()->read('searchtitle');

?>
<div class="header_fixed col-lg-12 col-md-12 col-sm-12" id="header_top">
	<div class="header_top col-lg-12 col-md-12 col-sm-12">
       <div class="row">
			<div class="header_top_address col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<ul>
				
						<li>
							<i class="fa fa-map-marker" aria-hidden="true"></i>
									<a href="https://www.google.com/maps?q=14+Essex+st,+Minto,+Sydney+NSW+2566" class="state-link" data-state="NSW" target="_blank">
										NSW
									</a>
						</li>
						<li>
							<i class="fa fa-map-marker" aria-hidden="true"></i>
									<a href="https://www.google.com/maps?q=34+Indian+Drive,+Keysborough,+Victoria+3173" class="state-link" data-state="VIC" target="_blank">
											VICTORIA
										</a>
						</li>
						<li>
							<i class="fa fa-map-marker" aria-hidden="true"></i>
							<a href="https://www.google.com/maps?q=16+Export+Drive,+Molendinar,+Gold+Coast+4214" class="state-link" data-state="QLD" target="_blank">
								QUEENSLAND
							</a>
						</li>
					
						<li>
							<i class="fa fa-map-marker" aria-hidden="true"></i>
							<a href="https://www.google.com/maps?q=30C+Richard+Street,+Hindmarsh,+SA+5007" class="state-link" data-state="SA" target="_blank">
								SOUTH AUSTRALIA
							</a>
						</li>

					<li><Strong>Phone:</strong><a href="tel:<?php echo PHONE; ?>"><?php echo PHONE; ?></a></li>

					<li>
						<i class="fa fa-envelope" aria-hidden="true"></i>
						<a href="mailto:sales@durotechindustries.com.au">sales@durotechindustries.com.au</a>
					</li>

				</ul>
			</div>

			<div class="header_top_social_search col-lg-2 col-md-2 col-sm-2 col-xs-12">
				<form action="<?php echo SITEURL . 'products/search' ?>" method="get" id="formsubmit">
					<input type="text" name="search" value="<?php echo $searchtitle; ?>" id="searchPro" placeholder="Search Product" required>
					<a href="javascript:void(0)" onclick="search()"><i onclick="search()" class="fa fa-search" aria-hidden="true"></i></a>
				</form>
			</div>

			<div class="header_top_social col-lg-2 col-md-2 col-sm-2 col-xs-12">
				<ul>
					<li><a target="_blank" href="<?php echo FACEBOOK ?>"><i class="fa fa-facebook" aria-hidden="true"></a></i></li>
					<li><a target="_blank" href="<?php echo TWITER ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
					<li><a target="_blank" href="<?php echo GOOGLE_PLUS ?>"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
					<li><a target="_blank" href="https://www.instagram.com/durotechindustries.com.au"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
				</ul>
			</div>

			<div class="header_top_social_login col-lg-2 col-md-2 col-sm-2 col-xs-12">
				<?php
				/*
				$is_customer = $this->Session->read('is_customer'); 
				if(empty($is_customer)){		
				?>
					<a href="<?php echo SITEURL.'login'; ?>" class="login">Login </a>					
				
					<a href="<?php echo SITEURL.'register'; ?>" class="login">Register</a>					
				<?php }else{ ?>
					<a href="<?php echo SITEURL.'users/dashboard'; ?>" class="login">Account</a>	
				<?php } */ ?>
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
					<a class="navbar-brand" href="<?php echo SITEURL; ?>"><img src="<?php echo SITEURL; ?>customdurotech/images/durotech_logo.png" alt="Dispute Bills">
					</a>
				</div>
				<div id="navbar5" class="navbar-collapse collapse">
					<ul class="nav navbar-nav navbar-right">
						<!--li class="active"><a href="<?php echo SITEURL ?>">Home</a></li-->
						<li><a href="<?php echo SITEURL ?>">Home</a></li>
						<li><a href="<?php echo SITEURL ?>about">About Us</a></li>
						<li><a href="<?php echo SITEURL ?>projects">Projects</a></li>
						<!-- <li><a href="<?php //echo SITEURL ?>testimonials">Testimonials</a></li> -->


						<li class="mobilemenu"><a href="<?= $this->Url->build('/product') ?>">Products</a></li>
						<li class="dropdown mega-dropdown desktop">
							<!-- <a class="dropdown-toggle" data-toggle="dropdown" href="#null">Products</a> -->
							<a class="dropdown-toggle"
								href="<?= $this->Url->build(['controller' => 'Products', 'action' => 'categories']) ?>">
								Products
							</a>



							<ul class="dropdown-menu mega-dropdown-menu row" style="overflow-y: scroll; height:430px; scrollbar-width: thin;">


							<?php
							// Split all categories into 4 columns
							$totalCategories = count($getCategories);
							$categoriesPerColumn = ceil($totalCategories / 4);
							$categoryChunks = array_chunk($getCategories, $categoriesPerColumn);
							?>

							<?php foreach ($categoryChunks as $column): ?>
								<li class="col-sm-3">
									<ul>
										<?php foreach ($column as $cat): ?>
											<li class="dropdown-header rotate-text" onclick="openlink('<?php echo $cat['Category']['slug']; ?>')">
												<?php echo h($cat['Category']['category_name']); ?>
											</li>
											<?php if (!empty($cat['Product'])): ?>
												<?php foreach ($cat['Product'] as $product): ?>
													<li>
														<a href="<?= $this->Url->build('/product/' . ($product['slug'] ?? '')) ?>">
															<?php echo h($product['title']); ?>
														</a>
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
						<li><a href="<?php echo SITEURL ?>technical-literature">Technical literature</a></li>
						<!-- <li><a href="<?php echo SITEURL ?>specifiers">Specifiers</a></li> -->
						<!--li><a href="<?php echo SITEURL ?>video">Video</a></li-->
						<!--li><a href="https://duroshop.com">DuroShop</a></li-->
						<li><a href="<?php echo SITEURL ?>durolab">DuroLab</a></li>

						<!--li><a href="http://durotechpolymers.com">Durotech Polymers</a></li-->
						<li><a href="<?php echo SITEURL ?>contact">Contact Us</a></li>
					</ul>
				</div>
				<!--/.nav-collapse -->
			</div>
			<!--/.container-fluid -->
		</nav>
	</div>
</div>
<script>
	function openlink(slug) {
		window.location.href = '<?= $this->Url->build('/category/') ?>' + slug;
	}

	window.addEventListener("scroll", function() {
		var headerTop = document.querySelector(".header_top");
		var addressBar = document.querySelector(".header_top_address");

		if (window.scrollY > 50) {
			headerTop.classList.add("scrolled");  // padding 30px
			addressBar.style.display = "none";   // hide address bar
		} else {
			headerTop.classList.remove("scrolled"); // padding back to 20px
			addressBar.style.display = "block";     // show address bar
		}
	});

	//new_code
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
    let hoverToggle = true; // true = blue, false = yellow

    $('.mega-dropdown-menu').on(
        'mouseenter',
        'a, .dropdown-header',
        function () {
            if (hoverToggle) {
                $(this).addClass('hover-blue');
            } else {
                $(this).addClass('hover-yellow');
            }
            hoverToggle = !hoverToggle;
        }
    );

    $('.mega-dropdown-menu').on(
        'mouseleave',
        'a, .dropdown-header',
        function () {
            $(this).removeClass('hover-blue hover-yellow');
        }
    );
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

        // remove active from all
        jQuery('.state-link').removeClass('active');

        // add active to clicked
        jQuery(this).addClass('active');

        // preview only (no blocking navigation)
        // If Kal says "don’t open map yet", uncomment below:
        // return false;
    });
});
</script>


