<link rel="stylesheet" type="text/css" href="<?php echo SITEURL; ?>fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />
<script type="text/javascript" src="<?php echo SITEURL; ?>fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
<script type="text/javascript" src="<?php echo SITEURL; ?>fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
<?php /* jQuery, Slick JS, and Bootstrap are already in customduro_layout head — do not load jQuery again here or plugins break. */ ?>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick-theme.min.css"/>

<script type="text/javascript">
	$(document).ready(function() {
		if ($.fn.fancybox) {
			$('.fancybox').fancybox();
		}
	});
</script>

<style>
		.button-8 {
			width: 275px;
			height: 50px;
			border: 2px solid #2889c9;
			float: left;
			text-align: center;
			cursor: pointer;
			position: relative;
			box-sizing: border-box;
			overflow: hidden;
			margin: 0 0 40px 0px;
			margin-right: 0px;
		}

		.button-8:hover a {
			color: #fff !important;
		}

		.product_detail_download .button-8 a {
			font-size: 16px;
			text-decoration: none;
			line-height: 22px;
			transition: all .5s ease;
			z-index: 2;
			position: relative;
		}

		.button-8:hover .eff-8 {
			left: 23px;
		}

		.product_detail_download .eff-8 {
			width: 217px;
			height: 50px;
			left: -219px;
			background: #2889c9;
			position: absolute;
			transition: all .5s ease;
			z-index: 1;
		}

		.h2cl {
			margin-top: 47px;
			/* color: #50d9b9; */
			color: #009688; /* darker & readable */

			border-bottom: 1px solid #50d9b9;
		}

		.product_detail_image {
			margin-top: 50px;
			border: none !important;
			width: 100%;
			height: 300px;
			background: #f2f2f2;
			color: #2889c9;
			font-size: 22px;
			font-weight: 600;
			padding: 10px;
			display: flex;
			align-items: center;
			justify-content: center;
			text-align: center;
		}


		.product_text_section p {
			font-size: 14px;
			line-height: 25px;
		}

		ul,
		ol {
			list-style: disc !important;
		}

		/* CSS for image container */
		.image-container {
			display: flex;
			flex-wrap: wrap;
			justify-content: space-between;
			gap: 15px;
		}

		/* CSS for individual image items */
		.image-item {
			width: 30%;
			/* Adjust to fit 3 images per row */
		}

		.image-item img {
			width: 100%;
			height: auto;
			border-radius: 8px;
			/* Optional, to add rounded corners */
		}


		.image-item {
			margin: 10px;
			/* Optionally add padding, border, or background */
			/* This is where you control how each image is laid out */
		}



		div#downloadButton {
			font-size: 16px;
			font-weight: 700;
			color: #2889c9 !important;
			padding-top: 12px;
		}

		div#downloadButton1 {
			font-size: 16px;
			font-weight: 700;
			color: #2889c9 !important;
			padding-top: 12px;
		}

		.heading-feature {
			color: #009688;
		}
		.heading-related {
			color: #009688 !important;
		}
		.related_product_detail_page .related-slider {
			margin: 0 -8px;
		}
		.related_product_detail_page .related-slide {
			padding: 0 8px;
			box-sizing: border-box;
		}
		.related_product_detail_page .slick-prev {
			left: -12px;
			z-index: 2;
		}
		.related_product_detail_page .slick-next {
			right: -12px;
			z-index: 2;
		}
				.text-highlight {
			color: #009688; /* Teal - better contrast */
		}

		.text-purple {
		color: #6a1b9a; /* Replace with your theme color */
		font-weight: 600;
	 }


     /* tab section style start here */
		/* Whole block: depth + yellow accent ties tab strip to panel */
		.product-tabs {
			border-radius: 10px;
			overflow: hidden;
			box-shadow:
				0 4px 6px rgba(0, 51, 102, 0.06),
				0 12px 28px rgba(0, 51, 102, 0.12);
		}

		/* Base nav style */
		.product-tabs .nav-tabs {
			position: relative;
			display: flex;
			flex-wrap: nowrap;
			align-items: flex-end;
			gap: 0;
			background-color: #f8f9fa;
			border-radius: 10px 10px 0 0;
			padding: 8px 10px;
			box-shadow:
				inset 0 -1px 0 rgba(255, 204, 0, 0.35),
				0 2px 8px rgba(0, 0, 0, 0.05);
		}

		.product-tabs .nav-tabs > li {
			float: none;
			flex: 1 1 0;
			margin-bottom: 0;
		}
		.product-tabs .nav-tabs > li:nth-child(1) {
			text-align: left;
		}
		.product-tabs .nav-tabs > li:nth-child(2) {
			text-align: center;
		}
		.product-tabs .nav-tabs > li:nth-child(3) {
			text-align: right;
		}

	   .product-tabs .nav-tabs .nav-link {
			display: inline-block;
			color: #003366;
			font-weight: 600;
			padding: 12px 20px;
			background: #e9ecef;
			border: none;
			position: relative;
			text-align: center;
			margin: 0;
			border-radius: 5px 5px 0 0;
			transition: color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease, background 0.2s ease;
		}

		/* Hover effect */
		.product-tabs .nav-tabs .nav-link:hover {
			color: #003366;
			transform: translateY(-1px);
			box-shadow: 0 4px 12px rgba(0, 51, 102, 0.12);
		}

		/* Active underline effect */
		.product-tabs .nav-tabs > li.active > a,
		.product-tabs .nav-tabs > li.active > a:hover,
		.product-tabs .nav-tabs > li.active > a:focus,
		.product-tabs .nav-tabs .nav-link.active {
			color: #003366; /* Keep blue text */
			box-shadow: 0 3px 12px rgba(255, 204, 0, 0.45);
		}

		.product-tabs .nav-tabs > li.active > a::after,
		.product-tabs .nav-tabs .nav-link.active::after {
			content: "";
			position: absolute;
			left: 0;
			right: 0;
			bottom: -2px;
			height: 3px;
			background: #ffcc00;
			border-radius: 3px;
		}



	/* Content box — border matches active tab yellow (#ffcc00), panel shadow */
		.product-tabs .tab-content,
		#productTabContent.tab-content.product-tab-panel {
			background: #fff;
			padding: 22px 24px;
			border: 1px solid rgba(255, 204, 0, 0.85);
			border-top: 3px solid #ffcc00;
			border-radius: 0 0 10px 10px;
			box-shadow:
				0 4px 14px rgba(0, 51, 102, 0.08),
				0 8px 24px rgba(0, 51, 102, 0.06),
				inset 0 1px 0 rgba(255, 255, 255, 0.95);
		}

		/* BS3 tabs: only one pane visible; fade + missing .in caused invisible-but-tall panes */
		#productTabContent.tab-content > .tab-pane {
			display: none !important;
		}
		#productTabContent.tab-content > .tab-pane.active {
			display: block !important;
			opacity: 1 !important;
		}
		#productTabContent.tab-content > .tab-pane.fade:not(.active) {
			opacity: 0;
		}

		.product-tabs .datasheet-tab-heading {
			margin: 0 0 14px;
			padding: 0;
		}


		.text-highlight {
			color: #2889c9;
		}

		/* Duro Button */
		.btn-duro {
			background-color: #2889c9;
			color: #fff;
			border: 2px solid #2889c9;
			font-weight: 600;
			border-radius: 30px;
			padding: 10px 25px;
			transition: all 0.3s ease;
		}

	.btn-duro:hover {
		background-color: #f1c40f;
		color: #000;
		border-color: #f1c40f;
	}

	/* tabs media css */

	/* Make nav-tabs wrap on small screens */
		.nav-tabs.flex-wrap {
			display: flex;
			flex-wrap: wrap; /* allows wrapping to next row */
			background-color: #f8f9fa;
			border-radius: 5px;
			padding: 5px;
		}

		/* Tab link styling */
		.nav-tabs.flex-wrap .nav-link {
			background-color: #e9ecef;
			border-radius: 5px 5px 0 0;
			margin: 2px; /* small margin around each tab */
			flex: 1 1 auto; /* allow flexible width */
			text-align: center;
		}

		/* Optional: full width on very small screens */
		@media (max-width: 576px) {
			.product-tabs .nav-tabs {
				flex-wrap: wrap;
				gap: 8px;
			}
			.product-tabs .nav-tabs > li {
				flex: 1 1 100%;
				text-align: center;
			}
			.product-tabs .nav-tabs .nav-link {
				width: 100%; /* full width */
				padding: 8px 10px;
				margin: 0;
				font-size: 14px;
			}

			.product-tabs .nav-tabs > li.active > a::after,
			.product-tabs .nav-tabs .nav-link.active::after {
				left: 10px;
				right: 10px;
			}
		}



</style>

<style>
	.custom-bullets {
		list-style: none; /* remove default bullets */
		padding-left: 0;
	}

	.custom-bullets li {
		position: relative;
		padding-left: 15px;
		margin-bottom: 10px;
		/* background: #fff8dc; */
		display: block;
			border-bottom: 1px solid #ddd; /* horizontal line */

	}

	.custom-bullets li::before {
		content: '';
		position: absolute;
		left: 0;
		top: 8px; /* adjust vertical alignment */
		width: 8px;  /* bullet width */
		height: 8px; /* bullet height */
		background-color: #f1c40f; /* yellow color */
		border-radius: 50%; /* make it round */
		
	}


</style>

<script src='<?php echo SITEURL; ?>jquery.elevatezoom.js'></script>

<div class="banner_durolab col-lg-12 col-md-12 col-sm-12">
	<img src="<?php echo SITEURL; ?>customdurotech/images/durotoll_banner.jpg">
</div>

<div class="container">
    <?php if ($products['Product']['is_comming_soon'] == 1) { ?>
        <style>
            .product_text_section p {
                font-size: 20px;
                line-height: 25px;
                text-align: center;
                margin-top: 73px;
                font-weight: 600;
            }
        </style>
			<?php if (!empty($products['Category'])): ?>
				<div class="category-header text-center p-4 rounded shadow-sm mt-5 product_text_section" >
					<h2 class="text-uppercase text-primary fw-bold mb-2 mt-3" style="letter-spacing: 1px;">
						<?= h($products['Category']['category_name']); ?>
					</h2>
					<div class="divider mx-auto mb-3" style="width:80px; height:3px; border-radius:2px;"></div>
					
					<?php if (!empty($products['Category']['description'])): ?>
						<p class="lead">
							<?= nl2br(h($products['Category']['description'])); ?>
						</p>
					<?php endif; ?>
				</div>
			<?php endif; ?>
        <div class="durotech_product_detail row text-center">
            <div class="col-12 product_text_section">
                <h3 class="h2cl">
                    <?php echo ($products['Product']['title'] == 'Duroprime DSP') ? 'Duroprime DSP (Damp Screed Primer)' : $products['Product']['title']; ?>
                </h3>
                <p>Coming Soon</p>
            </div>
        </div>
    <?php } else { ?>

			<?php if (!empty($products['Category'])): ?>
				<div class="category-header text-center p-4 rounded shadow-sm mt-5 product_text_section">
					<h2 class="text-uppercase text-primary fw-bold mb-2 mt-3" style="letter-spacing: 1px;">
						<?= h($products['Category']['category_name']); ?>
					</h2>
					<div class="divider mx-auto mb-3" style="width:80px; height:3px; border-radius:2px;"></div>
					
					<?php if (!empty($products['Category']['description'])): ?>
						<p class="lead">
							<?= nl2br(h($products['Category']['description'])); ?>
						</p>
					<?php endif; ?>
				</div>
			<?php endif; ?>

         <div class="durotech_product_detail row">

		 
            <!-- Image Section -->
			<div class="col-md-4 col-sm-12 d-flex align-items-center justify-content-center">
				<?php if ($products['Product']['image'] == '250250-defult.png' || $products['Product']['is_image'] == 1) { ?>
					<!-- Fallback: Text instead of image -->
					<div class="product_detail_image text-center d-flex align-items-center justify-content-center rounded shadow"
						style="width:100%; height:100%; background:#f2f2f2; color:#2889c9; font-size:22px; font-weight:600; padding: 10px;">
						<?= $products['Product']['title']; ?>
					</div>
				<?php } else { ?>
					<!-- Actual Image -->
					<a class="fancybox " 
					href="<?= SITEURL . 'productimg/' . $products['Product']['image'] ?>" 
					title="<?= $products['Product']['title']; ?>">
						<img src="<?= SITEURL . 'productimg/' . $products['Product']['image']; ?>" 
							class="img-fluid rounded shadow product_detail_image" 
							style="height: 300px; object-fit: contain; background: #fff; padding: 10px;" 
							alt="<?= $products['Product']['title']; ?>">
					</a>
				<?php } ?>
			</div>



            <!-- Text Section -->
            <div class="col-md-8 col-sm-12 product_text_section">
                <h3 class="h2cl"><?= $products['Product']['title']; ?></h3>
                <p><?= strip_tags($products['Product']['description']); ?> <a href="#myModal" class="btn btn-primary" data-toggle="modal">Read More</a></p>

                <!-- Modal for Description -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" data-backdrop="false" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header"><button type="button" class="close" data-dismiss="modal">x</button></div>
                            <div class="modal-body"><?= strip_tags($products['Product']['description']); ?></div>
                        </div>
                    </div>
                </div>

                <!-- Downloads -->
				<div class="row product_detail_download" >
					<?php /* if (!in_array($products['Product']['id'], [134, 135, 136, 137])) { ?>
						<div class="col-sm-3 button-4"><div class="eff-4"></div>
							<?php if (!empty($products['Product']['datasheet'])) { ?>
								<a href="<?= $products['Product']['datasheet']; ?>" target="_blank">DataSheet Download</a>
							<?php } else { ?>
								<a href="#myModal1" data-toggle="modal">DataSheet Download</a>
							<?php } ?>
						</div>

						<?php if (!empty($products['Product']['msds'])) {
							$msds = explode("##", $products['Product']['msds']);
							$msds_0 = $msds[0];
							$msds_1 = isset($msds[1]) ? $msds[1] : null;
						?>
							<div class="col-sm-3 button-4"><div class="eff-4"></div>
								<a href="<?= $msds_0; ?>" target="_blank">Msds-A Download</a>
							</div>
							<?php if ($msds_1) { ?>
								<div class="col-sm-3 button-4"><div class="eff-4"></div>
									<a href="<?= $msds_1; ?>" target="_blank">Msds-B Download</a>
								</div>
							<?php } ?>
						<?php } else { ?>
							<div class="col-sm-3 button-4"><div class="eff-4"></div>
								<a href="#myModal2" data-toggle="modal">Msds Download</a>
							</div>
						<?php } ?>

						<?php if (!empty($products['Product']['voc_pdf'])) { ?>
							<div class="col-sm-3 button-4"><div class="eff-4"></div>
								<a href="<?= $products['Product']['voc_pdf']; ?>" target="_blank">VOC Download</a>
							</div>
						<?php } ?>

						<!-- NEW: Colour Chart Download Button -->
						<?php if (!empty($products['Product']['chart_image'])) { ?>
							<div class="col-sm-3 button-4"><div class="eff-4"></div>
								<a href="<?= $products['Product']['chart_image']; ?>" target="_blank">Colour Chart Download</a>
							</div>
						<?php } ?>

						<?php if ($products['Product']['id'] == 93) { ?>
							<div class="col-sm-3 button-4"><div class="eff-4"></div>
								<a href="<?= SITEURL ?>wp-content/uploads/datasheet/Dow Durotech Brochure 8 pages.pdf" target="_blank">Dow Durotech Brochure</a>
							</div>
							<div class="col-sm-3 button-4"><div class="eff-4"></div>
								<a href="<?= SITEURL ?>wp-content/uploads/datasheet/7515 Sprayable Brochure (1).pdf" target="_blank">Sprayable Brochure</a>
							</div>
						<?php } ?>

						<?php if ($products['Product']['id'] == 39) { ?>
							<div class="col-sm-3 button-4"><div class="eff-4"></div>
								<a href="<?= SITEURL ?>/wp-content/uploads/A REPORT OF DEVELOPMENT OF SOLAR REFLECTIVE COATINGS_1.pdf" target="_blank">Solar Reflective Coatings</a>
							</div>
						<?php } ?>
					<?php  } */?>
				</div>

            </div>
        </div>


				<!-- Product Detail Tabs -->
		<div class="product-tabs mt-5">
			<ul class="nav nav-tabs" id="productTab" role="tablist">
				<li class="active">
					<a class="nav-link text-dark" id="outline-tab" data-toggle="tab" href="#outline" role="tab" aria-controls="outline" aria-selected="true">
						Product Outline
					</a>
				</li>
				<li>
					<a class="nav-link text-dark" id="datasheet-tab" data-toggle="tab" href="#datasheet" role="tab" aria-controls="datasheet" aria-selected="false">
						Data Sheets
					</a>
				</li>
				<li>
					<a class="nav-link text-dark" id="certificates-tab" data-toggle="tab" href="#certificates" role="tab" aria-controls="certificates" aria-selected="false">
						Certificates
					</a>
				</li>
				<!-- <li class="nav-item">
					<a class="nav-link text-dark" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false" 
					style="background-color:#e9ecef; border-radius:5px 5px 0 0;">
						Projects
					</a>
				</li> -->
			</ul>

			<div class="tab-content product-tab-panel" id="productTabContent">
				<!-- Product Outline -->
				<!-- Product Outline -->
				<div class="tab-pane fade in active" id="outline" role="tabpanel" aria-labelledby="outline-tab">
					<div class="row mb-3">
						<div class="col-md-6 product_text_section">
							  <h5 class="text-purple">Description</h5>
							<p><?= strip_tags($products['Product']['description']); ?></p>
						</div>
						<?php if (!empty(trim($products['Product']['brief_description'] ?? ''))) { ?>
						<div class="col-md-6 product_text_section">
							<h5 class="text-purple">Brief Description</h5>
							<p><?= strip_tags($products['Product']['brief_description']); ?></p>
						</div>
						<?php } ?>
					</div>

					<div class="row">
						

						<div class="col-md-6 product_text_section" style="margin-top:30px;">
							

							<?php if (!empty($products['Product']['feature'])) { ?>
								<h5 class="text-purple">Features</h5>
								<div class="row mt-4">
									<!-- Feature Text -->
									<div class="col-md-6 py-4">
										<!-- <h3 class="heading-feature">Features</h3> -->
										<ul class="custom-bullets">
										 <?= $products['Product']['feature']; ?>
										</ul>
									</div>

									<!-- Feature Image -->
									<div class="col-md-6 d-flex align-items-center product_list justify-content-center" style="min-height:300px;">
										<?php if ($products['Product']['image'] == '250250-defult.png' || $products['Product']['is_image'] == 1) { ?>
											<div style="font-size:25px; font-weight:bold; color:#2889c9; text-align: center;">
												<?= $products['Product']['title']; ?>
											</div>
										<?php } else { ?>
											<img src="<?= SITEURL . 'productimg/' . $products['Product']['image']; ?>"
												style="max-width:100%; max-height:100%; object-fit: contain; float:right;" 
												alt="<?= $products['Product']['title']; ?>">
										<?php } ?>
									</div>
								</div>
							<?php } ?>
						</div>

						<div class="col-md-6 product_text_section" style="margin-top:30px;">
						<h5 class="text-purple">Typical Uses</h5>

						<?php if (!empty($products['Product']['userarea'])) { ?>
							 <ul class="custom-bullets">
							  <?= $products['Product']['userarea']; ?>
						    </ul>
							<?php } ?>
						</div>
					</div>
				</div>


				<!-- Data Sheets -->
				<div class="tab-pane fade" id="datasheet" role="tabpanel" aria-labelledby="datasheet-tab">
					<h4 class="text-highlight datasheet-tab-heading">Downloadable Files</h4>

					<?php
					$msds = [];
					if (!empty($products['Product']['msds'])) {
						$msds = explode("##", $products['Product']['msds']);
					}
					?>

					<?php if (!empty($products['Product']['datasheet']) || !empty($msds)): ?>
						<div class="row">
							<!-- Datasheet -->
							<?php if (!empty($products['Product']['datasheet'])): ?>
							<div class="col-md-6 text-center mb-3">
								<h5 class="text-purple">Product Datasheet</h5>
								<iframe 
									src="<?= $products['Product']['datasheet']; ?>" 
									style="width:100%; height:300px; border:1px solid #ddd; border-radius:5px;" 
									frameborder="0">
								</iframe>
								<br>
								<a href="<?= $products['Product']['datasheet']; ?>" target="_blank" class="btn btn-sm btn-duro mt-2">
									Download Datasheet
								</a>
							</div>
							<?php endif; ?>

							<!-- MSDS -->
							<?php if (!empty($msds)): ?>
								<?php foreach ($msds as $index => $msdsFile): ?>
									<div class="col-md-6 text-center mb-3">
										<h5 class="text-purple">MSDS <?= chr(65 + $index); ?> Download</h5>
										<iframe 
											src="<?= $msdsFile; ?>" 
											style="width:100%; height:300px; border:1px solid #ddd; border-radius:5px;" 
											frameborder="0">
										</iframe>
										<br>
										<a href="<?= $msdsFile; ?>" target="_blank" class="btn btn-sm btn-duro mt-2">
											Download MSDS <?= chr(65 + $index); ?>
										</a>
									</div>
								<?php endforeach; ?>
							<?php endif; ?>
						</div>
					<?php else: ?>
						<p>No datasheets available.</p>
					<?php endif; ?>
				</div>



				<!-- Certificates -->
				<div class="tab-pane fade" id="certificates" role="tabpanel" aria-labelledby="certificates-tab">
					
					<?php if (!empty($products['Product']['voc_pdf'])): ?>
						<div class="row">
							<?php if (!empty($products['Product']['voc_pdf'])): ?>
							<div class="col-md-6 text-center mb-3">
								<h5 class="text-purple">Voc Certificate</h5>
								<iframe 
									src="<?= $products['Product']['voc_pdf']; ?>" 
									style="width:100%; height:300px; border:1px solid #ddd; border-radius:5px;" 
									frameborder="0">
								</iframe>
								<br>
								<a href="<?= $products['Product']['voc_pdf']; ?>" target="_blank" class="btn btn-sm btn-duro mt-2"><?= $products['Product']['title']; ?></a>
							</div>
							<?php endif; ?>
						</div>
					<?php else: ?>
						<div class="text-center" style="padding: 35px 0;">
							<img
								src="<?= SITEURL . 'img/coming-soon.png'; ?>"
								alt="Coming soon"
								style="max-width: 260px; width: 100%; height: auto; display: inline-block;"
							>
							<!-- <p class="text-muted" style="color:#888; font-weight:500; margin-top:12px;">
								No Voc certificate available.
							</p> -->
						</div>
					<?php endif; ?>
				</div>

				<!-- Projects -->
				<div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
					   <p class="text-center text-muted" style="color:#888; font-weight:500; margin-top:50px;">
							Currently No Projects.
						</p>
				</div>
			</div>
		</div>

		<!-- end of tab section -->

        <!-- Features -->

		<?php 
		/*
		if (!empty($products['Product']['feature'])) { ?>
			<div class="row mt-4" style="background:#f2f2f2;">
				<!-- Feature Text -->
				<div class="col-md-6 py-4">
					<h3 class="heading-feature">Features</h3>
					<?= $products['Product']['feature']; ?>
				</div>

				<!-- Feature Image -->
				<div class="col-md-6 d-flex align-items-center product_list justify-content-center" style="min-height:300px;">
					<?php if ($products['Product']['image'] == '250250-defult.png' || $products['Product']['is_image'] == 1) { ?>
						<div style="font-size:25px; font-weight:bold; color:#2889c9; text-align: center;">
							<?= $products['Product']['title']; ?>
						</div>
					<?php } else { ?>
						<img src="<?= SITEURL . 'productimg/' . $products['Product']['image']; ?>"
							style="max-width:100%; max-height:100%; object-fit: contain; float:right;" 
							alt="<?= $products['Product']['title']; ?>">
					<?php } ?>
				</div>
			</div>
		<?php } 
		*/
		?>


        <!-- Related Products -->
        <div class="related_product_detail_page col-12 mt-5">
            <div class="container">
				<h3 class="heading-related">Related Products</h3>
                <div class="related-slider">
                    <?php foreach ($random as $randoms) { ?>
                        <div class="related-slide">
                            <div class="text-center mb-3">
                            <a href="<?= $this->Url->build('/product/' . ($randoms['Product']['slug'] ?? '')); ?>">
                                <figure class="snip0077 blue">
                                    <img src="<?= SITEURL . 'productimg/' . ($randoms['Product']['image'] ?? ''); ?>" class="img-fluid" alt="<?= h($randoms['Product']['title'] ?? ''); ?>">
                                    <figcaption>
                                        <h2><?= h($randoms['Product']['title'] ?? ''); ?></h2>
                                    </figcaption>
                                    <p class="text-highlight"><?= h($randoms['Product']['title'] ?? ''); ?></p>
                                </figure>
                            </a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>
</div>


	<div class="product_filter col-lg-1 col-md-1 col-sm-1"></div>





<script>
(function () {
	var b = document.getElementById('downloadButton');
	if (b) {
		b.addEventListener('click', function() {
			window.location.href = '/col-chart.jpg';
		});
	}
	var b1 = document.getElementById('downloadButton1');
	if (b1) {
		b1.addEventListener('click', function() {
			window.location.href = '/col-chartds.jpg';
		});
	}
})();
</script>
<script>
	$(document).ready(function() {
		// thumbnails.carousel.js jQuery plugin
		;
		(function(window, $, undefined) {

			var conf = {
				center: true,
				backgroundControl: false
			};

			var cache = {
				$carouselContainer: $('.thumbnails-carousel').parent(),
				$thumbnailsLi: $('.thumbnails-carousel li'),
				$controls: $('.thumbnails-carousel').parent().find('.carousel-control')
			};

			function init() {
				cache.$carouselContainer.find('ol.carousel-indicators').addClass('indicators-fix');
				cache.$thumbnailsLi.first().addClass('active-thumbnail');

				if (!conf.backgroundControl) {
					cache.$carouselContainer.find('.carousel-control').addClass('controls-background-reset');
				} else {
					cache.$controls.height(cache.$carouselContainer.find('.carousel-inner').height());
				}

				if (conf.center) {
					cache.$thumbnailsLi.wrapAll("<div class='center clearfix'></div>");
				}
			}

			function refreshOpacities(domEl) {
				cache.$thumbnailsLi.removeClass('active-thumbnail');
				cache.$thumbnailsLi.eq($(domEl).index()).addClass('active-thumbnail');
			}

			function bindUiActions() {
				cache.$carouselContainer.on('slide.bs.carousel', function(e) {
					refreshOpacities(e.relatedTarget);
				});

				cache.$thumbnailsLi.click(function() {
					cache.$carouselContainer.carousel($(this).index());
				});
			}

			$.fn.thumbnailsCarousel = function(options) {
				conf = $.extend(conf, options);

				init();
				bindUiActions();

				return this;
			}

		})(window, jQuery);

		if ($('.thumbnails-carousel').length) {
			$('.thumbnails-carousel').thumbnailsCarousel();
		}

	});
</script>

		<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					</div>
					<div class="modal-body">
						No DataSheet Availabale
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		
		<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					</div>
					<div class="modal-body">
						No MSDS Availabale
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->


<script type="text/javascript">
	$(document).ready(function() {
		if ($.fn.fancybox) {
			$('.fancybox').fancybox();
		}
	});

	$(document).ready(function() {
		if ($('#outline-tab').length && typeof $.fn.tab === 'function') {
			$('#outline-tab').tab('show');
		}
	});

</script>

<script>
$(document).ready(function(){
    var $section = $('.related_product_detail_page');
    var $slider = $('.related-slider');
    if (!$slider.length || !$slider.children('.related-slide').length) {
        return;
    }
    if (!$.fn.slick) {
        return;
    }
    $slider.slick({
        /* If slidesToShow >= number of slides, nothing visibly moves — keep below slide count. */
        slidesToShow: 3,
        slidesToScroll: 1,
        arrows: true,
        dots: false,
        infinite: true,
        draggable: true,
        swipeToSlide: true,
        autoplay: true,
        autoplaySpeed: 3500,
        speed: 500,
        pauseOnHover: true,
        responsive: [
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });
    $slider.slick('slickPlay');
    $section.on('mouseenter', function() {
        $slider.slick('slickPause');
    });
    $section.on('mouseleave', function() {
        $slider.slick('slickPlay');
    });
});
</script>