<style>
	@keyframes slidy {
	0% { left: 0%; }
	20% { left: 0%; }
	25% { left: -100%; }
	45% { left: -100%; }
	50% { left: -200%; }
	70% { left: -200%; }
	75% { left: -300%; }
	90% { left: -300%; }
	95% { left: -400%; }
	100% { left: -400%; }
	}

	body { margin: 0; } 
	div#slider { overflow: hidden; }
	div#slider figure img { width: 20%; float: left; }
	div#slider figure { 
	  position: relative;
	  width: 500%;
	  margin: 0;
	  left: 0;
	  text-align: left;
	  font-size: 0;
	  animation: 20s slidy infinite; 
	}
	.project h3 {
		text-align: center;
		font-size: 30px;
		color: #585A5A;
	}


	.app_new_product img {
		float: left;
		width: 115px;
	}
	.app_new_product h3 {
		font-size: 22px;
		font-weight: bold;
		color: #2889c9;
	}
		.app_new_product {
		padding: 50px 0px;
	}
	.app_new_product_content p {

	font-size: 18px;
	letter-spacing: 0.05em;
	text-align: justify;
	}
	.mobile_section {
		text-align: center;
	}
	.mobile_section img {
		width: 260px;
	}
	.app_new_product_img {
		float: left;
		margin-right: 23px;
	}
	.app_new_product_img {
		float: left;
		margin-right: 23px;
		height: auto;
		padding-bottom: 100px;
	}
	.mobile_app_section h2 {
		text-align: center;
		font-size: 47px;
		border-bottom: none;
	}
	.mobile_app_section_top_content p {
		text-align: center;
		font-size: 17px;
		letter-spacing: 0.05em;
		color: #828282;
		padding-bottom: 50px;
	}
	.work_section_img {
		text-align: center;
		padding: 7% 0px;
	}
	.bodycenter{ text-align:left;} 
	.formmode{ margin-top: 19%; }
	@media screen and (max-width: 768px) {
		.formmode{ margin-top: 0%; }
		.bodycenter{ text-align:center;} 
	}
	.modal-newsletter {	
		color: #999;
		width: 805px;
		font-size: 15px;
	}
	.modal-newsletter .modal-content {
		padding: 30px;
		border-radius: 0;		
		border: none;
	}
	.modal-newsletter .modal-header {
		border-bottom: none;   
        position: relative;
		border-radius: 0;
	}
	.modal-newsletter h4 {
		color: #585A5A;
		font-size: 30px;
		margin: 0;
		font-weight: bold;
	}
	
	.modal-newsletter .close:hover {
		opacity: 0.8;
	}
	.modal-newsletter .icon-box {
		color: #7265ea;		
		display: inline-block;
		z-index: 9;
		text-align: center;
		position: relative;
		margin-bottom: 10px;
	}
	.modal-newsletter .icon-box i {
		font-size: 110px;
	}
	.modal-newsletter .form-control, .modal-newsletter .btn {
		min-height: 46px;
		border-radius: 0;
	}
	.modal-newsletter .form-control {
		box-shadow: none;
		border-color: #dbdbdb;
	}
	.modal-newsletter .form-control:focus {
		border-color: #f95858;
		box-shadow: 0 0 8px rgba(249, 88, 88, 0.4);
	}
    .modal-newsletter .btn {
        color: #fff;
		background: #f95858;
		text-decoration: none;
		transition: all 0.4s;
        line-height: normal;
		padding: 6px 20px;
		min-width: 150px;
		margin-left: 6px !important;
        border: none;
    }
	.modal-newsletter .btn:hover, .modal-newsletter .btn:focus {
		box-shadow: 0 0 8px rgba(249, 88, 88, 0.4);
		background: #f72222;
		outline: none;
	}	
	.content p {		
		font-size: 16px;	
		line-height: 26px;
	}
	.content {
		background: #e4edf4;
	}
	.image a {
		font-size: 16px;
		color: #fff;
		font-weight: 500;
		border: 1px solid #1a4860;
		padding: 12px 54px;
		background: #1a4860;
		border-radius: 19px;
	}
	.card {		
		box-shadow: none;		
		background: #f2f2f2 !important;
		width: 300px;
		height: 252px;
		margin-left: 71px;
	}
	.we_offer {
	  background-image: linear-gradient(to right, rgb(41, 136, 200), rgba(0, 136, 200, 0.78));
	  color: #ffffff;
	}
	.we_offer h3{  color:#ffffff;  margin-top: 67px; font-weight: 600; }
	.work_section_content_1 {		
		text-align: center;		
	}
	.number{ color:#2889c8 !important; }
	.projectFactsWrap .item p {
		color: #585A5A;
	}
	.projectFactsWrap .item span.stat-divider {
		width: 60px;
		height: 2px;
		display: block;
		margin: 0 auto;
		background: #2889c8;
	}
	.projectFactsWrap .item p.stat-value-line span {
		display: inline;
		width: auto;
		height: auto;
		background: transparent;
		margin: 0;
		padding: 0;
		vertical-align: baseline;
	}
	.projectFactsWrap .item:hover i, .projectFactsWrap .item:hover p {
		color: #585A5A;
	}
	.work_section {
		padding-top: 20px !important;
	}
	.work_section_content {
		padding-top: 0px !important;
	}
	.work_section_content_1 .fa {		
		background: none;	
		border: 2px solid #fff;
		float: none;
	}
	.projectFactsWrap .item:nth-child(1) {
		background: #fff;
	}
	.projectFactsWrap .item:nth-child(2) {
		background: #fff;
	}
	.projectFactsWrap .item:nth-child(3) {
		background: #fff;
	}
	.projectFactsWrap .item:nth-child(4) {
		background: #fff;
	}
	.projectFactsWrap .item p.number.stat-value-line {
		line-height: 1.25;
		min-height: 2.5em;
		padding: 0 8px;
	}
	.client_logo h3 {		
		color: #2889c8;		
	}
	.project h3 {	
		color: #2889c8;
	} 
	
	.button-4 {	
		border: 2px solid #fff;		
	}
	
	.tab_service{ margin-bottom:30px; }
	/* Blue / white / yellow / white stripe frame (brand reference: color bands separated by white gaps) */
	.tab_service .images{
		--duro-stripe-blue: #2889c9;
		--duro-stripe-yellow: #f4c400;
		--duro-stripe-white: #ffffff;
		--duro-stripe-thick: 9px;
		--duro-stripe-color: 36px;
		--duro-stripe-gap: 16px;
		display: block;
		width: 100%;
		min-height: 194px;
		box-sizing: border-box;
		border-radius: 14px;
		background: #ffffff;
		box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
		transition: transform 0.22s ease, box-shadow 0.22s ease;
		position: relative;
		overflow: hidden;
		isolation: isolate;
		text-decoration: none;
		color: inherit;
		cursor: pointer;
	}
	.tab_service .images:focus-visible {
		outline: 2px solid #2889c8;
		outline-offset: 2px;
	}
	.tab_service .images::before {
		content: "";
		position: absolute;
		inset: 0;
		border-radius: inherit;
		padding: var(--duro-stripe-thick);
		background: repeating-linear-gradient(
			-45deg,
			var(--duro-stripe-blue) 0,
			var(--duro-stripe-blue) var(--duro-stripe-color),
			var(--duro-stripe-white) var(--duro-stripe-color),
			var(--duro-stripe-white) calc(var(--duro-stripe-color) + var(--duro-stripe-gap)),
			var(--duro-stripe-yellow) calc(var(--duro-stripe-color) + var(--duro-stripe-gap)),
			var(--duro-stripe-yellow) calc(var(--duro-stripe-color) * 2 + var(--duro-stripe-gap)),
			var(--duro-stripe-white) calc(var(--duro-stripe-color) * 2 + var(--duro-stripe-gap)),
			var(--duro-stripe-white) calc(var(--duro-stripe-color) * 2 + var(--duro-stripe-gap) * 2)
		);
		background-position: calc((var(--duro-stripe-color) + var(--duro-stripe-gap)) * 0.5) calc((var(--duro-stripe-color) + var(--duro-stripe-gap)) * 0.5);
		-webkit-mask:
			linear-gradient(#fff 0 0) content-box,
			linear-gradient(#fff 0 0);
		mask:
			linear-gradient(#fff 0 0) content-box,
			linear-gradient(#fff 0 0);
		-webkit-mask-composite: xor;
		mask-composite: exclude;
		pointer-events: none;
		z-index: 0;
	}
	.tab_service .images > * {
		position: relative;
		z-index: 1;
	}
	.tab_service .images:hover {
		transform: translateY(-5px);
		box-shadow: none;
	}
	@media (max-width: 767px) {
		.tab_service .images {
			--duro-stripe-thick: 8px;
			--duro-stripe-color: 28px;
			--duro-stripe-gap: 14px;
		}
	}
	.div_right{ padding:20px 20px 10px; }
	.img_left{ padding:0px 20px; }
	.img_left img {
		width: 56px;
		height: 56px;
		object-fit: contain;
	}
	.h2_color{
		padding:4px 20px 0;
		color: #2889c8;
		font-weight: 700;
	}
	.p_color{
		padding:2px 20px 20px;
		color: #556a82;
	}
	.spn_right{
		float:right;
		font-size: 17px;
		font-weight: 500;
		color: #586074;
		transition: color 0.2s ease;
	}
	.tab_service .images:hover .spn_right {
		color: #2889c8;
	}



	/* new css for reels */
	.instagram-reels {
		background: #e4edf4;
	}
	.instagram-reels .container > h3 {
		color: #2889c8;
		font-weight: 600;
		display: inline-block;
		position: relative;
		transition: color 0.25s ease, text-shadow 0.25s ease, transform 0.25s ease;
		animation: instagramTitleFadeUp 0.7s ease both;
	}
	.instagram-reels .container > h3:after {
		content: "";
		position: absolute;
		left: 50%;
		bottom: -8px;
		width: 70px;
		height: 3px;
		border-radius: 999px;
		background: linear-gradient(90deg, #2889c8 0%, #f4c400 100%);
		transform: translateX(-50%) scaleX(0.55);
		transform-origin: center;
		transition: width 0.25s ease, transform 0.25s ease, box-shadow 0.25s ease;
	}
	.instagram-reels:hover .container > h3 {
		color: #0056b3;
		text-shadow: 0 6px 16px rgba(40, 137, 200, 0.18);
		transform: translateY(-3px);
	}
	.instagram-reels:hover .container > h3:after {
		width: 120px;
		transform: translateX(-50%) scaleX(1);
		box-shadow: 0 4px 12px rgba(40, 137, 200, 0.22);
	}
	@keyframes instagramTitleFadeUp {
		from {
			opacity: 0;
			transform: translateY(12px);
		}
		to {
			opacity: 1;
			transform: translateY(0);
		}
	}
	.instagram-reels .container > p:first-of-type {
		color: #585A5A;
	}

	.instagram-slider .slick-track {
		display: flex !important;
	}
	.instagram-slider .slick-slide {
		height: inherit !important;
	}
	.instagram-slider .slide {
		padding: 5px; /* spacing between reels */
		height: auto;
	}

	.insta-reel-wrapper {
		--insta-crop-top: 58px;
		--insta-crop-bottom: 80px;
		width: 100%;
		position: relative;
		height: 330px;
		overflow: hidden;
		background: #fff;
		border: 1px solid #e4e4e4;
		border-radius: 12px;
	}

	.insta-reel-wrapper > blockquote,
	.insta-reel-wrapper > iframe {
		position: static;
		width: 100% !important;
		height: calc(100% + var(--insta-crop-top) + var(--insta-crop-bottom)) !important;
		min-height: calc(100% + var(--insta-crop-top) + var(--insta-crop-bottom)) !important;
		min-width: 100% !important;
		margin: calc(0px - var(--insta-crop-top)) 0 0 !important;
	}
	@media (max-width: 991px) {
		.insta-reel-wrapper {
			height: 320px;
		}
	}
	@media (max-width: 576px) {
		.insta-reel-wrapper {
			height: 300px;
		}
	}

	/* === HOME TESTIMONIALS (hidden pending client approval) — remove this wrapper comment to restore CSS ===
	.home-testimonials {
		background: #f7f7f7;
		padding: 50px 0;
	}
	.home-testimonials h3 {
		text-align: center;
		color: #2889c8;
		font-size: 30px;
		margin-bottom: 10px;
	}
	.home-testimonials p.section-subtitle {
		text-align: center;
		color: #585A5A;
		margin-bottom: 30px;
	}
	.testimonial-grid-item {
		margin-bottom: 24px;
	}
	.testimonial-box {
		background: #fff;
		border: 1px solid #dfdfdf;
		padding: 28px;
		min-height: 240px;
	}
	.testimonial-quote {
		color: #666;
		font-style: italic;
		font-size: 16px;
		line-height: 1.7;
		margin: 0 0 18px;
	}
	.testimonial-client-name {
		color: #b38b3e;
		font-weight: 700;
		letter-spacing: 0.08em;
		text-transform: uppercase;
		font-size: 18px;
		margin: 0;
	}
	.testimonial-marquee-row {
		overflow: hidden;
		width: 100%;
		margin-bottom: 20px;
	}
	.testimonial-marquee-track {
		display: flex;
		align-items: stretch;
		width: max-content;
		will-change: transform;
		animation: testimonialMarqueeRtl 48s linear infinite;
	}
	.testimonial-marquee-row.row-2 .testimonial-marquee-track {
		animation-duration: 56s;
	}
	.testimonial-marquee-row:hover .testimonial-marquee-track {
		animation-play-state: paused;
	}
	.testimonial-marquee-item {
		flex: 0 0 480px;
		max-width: 480px;
		padding: 0 12px;
		box-sizing: border-box;
	}
	@keyframes testimonialMarqueeRtl {
		from { transform: translateX(0); }
		to { transform: translateX(-50%); }
	}
	@media (max-width: 991px) {
		.testimonial-marquee-item {
			flex-basis: 420px;
			max-width: 420px;
		}
	}
	@media (max-width: 767px) {
		.testimonial-marquee-track {
			animation: testimonialMarqueeRtl 42s linear infinite;
			width: max-content;
			display: flex;
		}
		.testimonial-marquee-item {
			flex: 0 0 86vw;
			max-width: 86vw;
			padding: 0 8px;
			margin-bottom: 0;
		}
	}
	=== end testimonials CSS (remove opening/closing comment lines above to uncomment) === */
</style>
<div class="banner col-lg-12 col-md-12 col-sm-12">
	 
		<div id="slider">
			<figure>
				
				<img src="<?php echo SITEURL ;?>customdurotech/images/slider/Banner1.jpg"  onclick="openlink(1)">
				<img src="<?php echo SITEURL ;?>customdurotech/images/slider/Banner2.jpg"  onclick="openlink(2)">
				<img src="<?php echo SITEURL ;?>customdurotech/images/slider/Banner3.jpg"  onclick="openlink(3)">
				<img src="<?php echo SITEURL ;?>customdurotech/images/slider/banner 4.jpg"  onclick="openlink(4)">
				<img src="<?php echo SITEURL ;?>customdurotech/images/slider/banner 5.jpg"  onclick="openlink(5)">
			</figure>
			</div>
		</div>

		<div class="content col-lg-12 col-md-12 col-sm-12">
			 <h1  style="text-align:center; color:#2889c8; font-weight: 600; text-decoration:underline;">About Us</h1>
			 <p style="text-align:center;">Durotech Australia is a 48 year old Australian Made and Owned construction chemical manufacturer. The Durotech Group was established in 1977 to provide Innovative waterproofing and coating technology to the local and global market. We continue to lead the market with end to end solutions offering the latest technology backed systems. The Durotech group established itself as a market leader and a preferred choice for many Contractors, Architects, Distributors and industries partners.</p>			 
		</div>
		
		<div class="duro_service col-lg-12 col-md-12 col-sm-12" style="background:#e4edf4;padding-top: 62px;">
		
		      <div class="container_service">
			       <div class="col-lg-4 col-md-4 col-sm-4 tab_service">
					  <a class="images" href="<?php echo SITEURL.'products'; ?>">
					      <div class="div_right">
							<span class="spn_right">View All</span>
						  </div>
						  <div class="img_left">
							<img src="<?php echo SITEURL ;?>img/paint-bucket.png" alt="">
						  </div>
						  <h3 class="h2_color">Duro Products</h3>
						  <p  class="p_color">A wide range of waterproofing Products</p>
					  </a>
					
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 tab_service">
					  <a class="images" href="<?php echo SITEURL.'technical-literature'; ?>">
					      <div class="div_right">
							<span class="spn_right">View All</span>
						  </div>
						  <div class="img_left">
							<img src="<?php echo SITEURL ;?>img/book.png" alt="">
						  </div>
						  <h3 class="h2_color">Technical Literature</h3>
						  <p  class="p_color">Products datasheet and other documents</p>
					  </a>
					
					</div>
					
					<!-- <div class="col-lg-4 col-md-4 col-sm-4 tab_service">
					  <div class="images">
					      <div class="div_right">
							<span class="spn_right"><a style="color:#585A5A;" href="<?php echo SITEURL.'specifiers'; ?>">View All</a></span>
						  </div>
						  <div class="img_left">
							<img src="<?php echo SITEURL ;?>img/register.png">
						  </div>
						  <h3 class="h2_color">Durotech Specifiers</h3>
						  <p  class="p_color">Get CPD points and other product details</p>
					  </div>
					
					</div> -->
					
					
					<div class="col-lg-4 col-md-4 col-sm-4 tab_service">
					  <a class="images" href="<?php echo SITEURL.'durolab'; ?>">
					      <div class="div_right">
							<span class="spn_right">View All</span>
						  </div>
						  <div class="img_left">
							<img src="<?php echo SITEURL ;?>img/chemistry.png" alt="">
						  </div>
						  <h3 class="h2_color">DuroLab</h3>
						  <p  class="p_color">Product Testing with latest technology.</p>
					  </a>
					
					</div>
					
					<!--div class="col-lg-4 col-md-4 col-sm-4 tab_service">
					  <div class="images">
					      <div class="div_right">
							<span class="spn_right"><a style="color:#585A5A;" href="<?php echo SITEURL.'durooem'; ?>">View All</a></span>
						  </div>
						  <div class="img_left">
							<img src="<?php echo SITEURL ;?>img/paint.png">
						  </div>
						  <h3 class="h2_color">DuroToll</h3>
						  <p  class="p_color">Wide range of waterproofing tools</p>
					  </div>
					
					</div-->
					
					<!--div class="col-lg-4 col-md-4 col-sm-4 tab_service">
					  <div class="images">
					      <div class="div_right">
							<span class="spn_right"><a style="color:#585A5A;" href="https://duroshop.com">View All</a></span>
						  </div>
						  <div class="img_left">
							<img src="<?php echo SITEURL ;?>img/shopping-cart.png">
						  </div>
						  <h3 class="h2_color">Duro Store</h3>
						  <p  class="p_color">Buy all the products online with one click</p>
					  </div>					
					</div-->
					
			  </div>
		
		</div>
		
		<div class="work_with col-lg-12 col-md-12 col-sm-12">
			<div class="row we_offer">
			<h3>What We Offer</h3>
			<p>Durotech industries is a leading manufacturer and supplier of waterproofing products. </p>
				<div class="work_section col-lg-12 col-md-12 col-sm-12">
					 <div class="container">			        
						 <div class="work_section_content col-lg-3 col-md-3 col-sm-3">
							  <div>
								  <div class="work_section_content_1">
									  <i class="fa" aria-hidden="true" > <img src="<?php echo SITEURL ;?>themeicon/1.png" style="margin-top: -8px;">	</i>							 
								  </div>
							  </div>
							   <h4 style="text-align:center; font-size:21px;">Research and development</h4>
							   <p  style="text-align:center;  font-size:13px;">local and international R&D working and developing end to end systems and solutions.</p>
						 </div>
						 
						 <div class="work_section_content col-lg-3 col-md-3 col-sm-3">
							  <div>
								  <div class="work_section_content_1">
									  <i class="fa" aria-hidden="true" > <img src="<?php echo SITEURL ;?>themeicon/2.png" style="margin-top: -8px;"></i>							 
								  </div>
							  </div>
							   <h4 style="text-align:center; font-size:21px;">Local manufacturing</h4>
							   <p  style="text-align:center;  font-size:13px;">Manufacturing locally makes durotech fast efficient and reliable providing high quality products.</p>
						 </div>
						 
						 <div class="work_section_content col-lg-3 col-md-3 col-sm-3">
							  <div>
								  <div class="work_section_content_1">
									  <i class="fa" aria-hidden="true" > <img src="<?php echo SITEURL ;?>themeicon/3.png" style="margin-top: -8px;"></i>				 
								  </div>
							  </div>
							   <h4 style="text-align:center; font-size:21px;">National and global technical support </h4>
							   <p  style="text-align:center;  font-size:13px;">National and international projects are handling with great professionalism with or global offices.</p>
						 </div>
						 
						 <div class="work_section_content col-lg-3 col-md-3 col-sm-3">
							  <div>
								  <div class="work_section_content_1">
									 <i class="fa" aria-hidden="true" > <img src="<?php echo SITEURL ;?>themeicon/4.png" style="margin-top: -8px;"></i>					 
								  </div>
							  </div>
							   <h4 style="text-align:center; font-size:21px;">International distribution </h4>
							   <p  style="text-align:center;  font-size:13px;">Having global distribution networks allows durotech to better serve there local and international clients.</p>
						 </div>
					 </div>
				</div>
		  </div>
		</div>
		
		<div id="company-stats-section" class="counter col-lg-12 col-md-12 col-sm-12">
		     <div id="projectFacts" class="sectionClass" style="background:#e4edf4">
				<div class="fullWidth eight columns" style="background:#e4edf4;">
					<div class="projectFactsWrap" style="background:#e4edf4;">
						<div class="item wow fadeInUpBig animated animated" data-count-end="1000000" data-count-comma="1" style="visibility: visible;background:#e4edf4;"  >
							
							<img src="<?php echo SITEURL ;?>img/Group 42.png" style="width:42px; height:46px" alt="">
							<p class="number stat-value-line"><span class="stat-prefix">Over </span><span class="stat-value">0</span><span class="stat-suffix">m2</span></p>
							<span class="stat-divider" aria-hidden="true"></span>
							<p>Projects Completed</p>
						</div>
						<div class="item wow fadeInUpBig animated animated" data-count-end="300" style="visibility: visible; background:#e4edf4;">
							<img src="<?php echo SITEURL ;?>img/Group 43.png" style="width:42px; height:46px" alt="">
							<p class="number stat-value-line"><span class="stat-value">0</span><span class="stat-suffix">+</span></p>
							<span class="stat-divider" aria-hidden="true"></span>
							<p>Products Developed</p>
						</div>
						<div class="item wow fadeInUpBig animated animated" data-count-end="100" style="visibility: visible; background:#e4edf4;" >
							<img src="<?php echo SITEURL ;?>img/Group 44.png" style="width:42px; height:46px" alt="">
							<p class="number stat-value-line"><span class="stat-value">0</span><span class="stat-suffix">+</span></p>
							<span class="stat-divider" aria-hidden="true"></span>
							<p>Global Team</p>
						</div>
						<div class="item wow fadeInUpBig animated animated" data-count-end="49" style="visibility: visible; background:#e4edf4;">
							<img src="<?php echo SITEURL ;?>img/Group 45.png" style="width:42px; height:46px" alt="">
							<p class="number stat-value-line"><span class="stat-value">0</span><span class="stat-suffix"> years</span></p>
							<span class="stat-divider" aria-hidden="true"></span>
							<p>Years in Business</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script>
		(function () {
			var root = document.getElementById('company-stats-section');
			if (!root) {
				return;
			}

			function formatComma(n) {
				return String(Math.round(n)).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
			}

			function resetCounters() {
				var items = root.querySelectorAll('.item[data-count-end]');
				for (var i = 0; i < items.length; i++) {
					var el = items[i].querySelector('.stat-value');
					if (el) {
						el.textContent = '0';
					}
				}
			}

			function runCounters() {
				var items = root.querySelectorAll('.item[data-count-end]');
				var duration = 2200;
				var start = null;

				function tick(now) {
					if (start === null) {
						start = now;
					}
					var elapsed = now - start;
					var t = Math.min(1, elapsed / duration);
					var ease = 1 - (1 - t) * (1 - t);
					for (var i = 0; i < items.length; i++) {
						var item = items[i];
						var end = parseInt(item.getAttribute('data-count-end'), 10);
						var comma = item.getAttribute('data-count-comma') === '1';
						var el = item.querySelector('.stat-value');
						if (!el || isNaN(end)) {
							continue;
						}
						var val = Math.floor(ease * end);
						if (t >= 1) {
							val = end;
						}
						el.textContent = comma ? formatComma(val) : String(val);
					}
					if (t < 1) {
						root._companyStatsRaf = requestAnimationFrame(tick);
					} else {
						root._companyStatsRaf = null;
					}
				}

				if (root._companyStatsRaf) {
					cancelAnimationFrame(root._companyStatsRaf);
				}
				start = null;
				root._companyStatsRaf = requestAnimationFrame(tick);
			}

			function onIntersect(entries) {
				for (var e = 0; e < entries.length; e++) {
					var entry = entries[e];
					if (entry.isIntersecting) {
						resetCounters();
						runCounters();
					} else {
						if (root._companyStatsRaf) {
							cancelAnimationFrame(root._companyStatsRaf);
							root._companyStatsRaf = null;
						}
						resetCounters();
					}
				}
			}

			if ('IntersectionObserver' in window) {
				var io = new IntersectionObserver(onIntersect, { threshold: 0.15, rootMargin: '0px 0px -5% 0px' });
				io.observe(root);
			} else {
				runCounters();
			}
		})();
		</script>


		<div class="instagram-reels col-lg-12 col-md-12 col-sm-12">
			<div class="container">
				<h3>Our Latest Instagram Posts</h3>
				<section class="instagram-slider">

					<div class="slide">
						<!-- Reel 1 -->
						<div class="insta-reel-wrapper">
							<blockquote class="instagram-media" data-instgrm-captioned data-instgrm-permalink="https://www.instagram.com/p/DO-Vi8Ek7Is/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="14" style="width:100%; max-width:540px;">
							</blockquote>
						</div>	
					</div>

					<div class="slide">
						<!-- Reel 2 -->
						 
						 <div class="insta-reel-wrapper">
							<blockquote class="instagram-media" data-instgrm-captioned data-instgrm-permalink="https://www.instagram.com/p/DOIasoakiAT/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="14" style="width:100%; max-width:540px;">
							</blockquote>
						 </div>
					</div>

					<div class="slide">
						<!-- Reel 3 -->
						<div class="insta-reel-wrapper">
							<blockquote class="instagram-media" data-instgrm-captioned data-instgrm-permalink="https://www.instagram.com/p/DN2nsgx5HLM/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="14" style="width:100%; max-width:540px;">
							</blockquote>
						</div>
					</div>

					<div class="slide">
						<!-- Reel 4 -->
						 <div class="insta-reel-wrapper">
							<blockquote class="instagram-media" data-instgrm-captioned data-instgrm-permalink="https://www.instagram.com/p/DN2aTC9Yr1I/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="14" style="width:100%; max-width:540px;">
							</blockquote>
						 </div>
					</div>

					<div class="slide">
						<!-- Reel 5 -->
						 <div class="insta-reel-wrapper">
							<blockquote class="instagram-media" data-instgrm-captioned data-instgrm-permalink="https://www.instagram.com/p/DNFFat4RiQR/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="14" style="width:100%; max-width:540px;">
							</blockquote>
						 </div>
					</div>

					<div class="slide">
						<!-- Reel 6 -->
						 <div class="insta-reel-wrapper">
							<blockquote class="instagram-media" data-instgrm-captioned data-instgrm-permalink="https://www.instagram.com/p/DNEdysBzyMa/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="14" style="width:100%; max-width:540px;">
							</blockquote>
						 </div>
					</div>

					<div class="slide">
						<!-- Reel 7 -->
						 <div class="insta-reel-wrapper">
							<blockquote class="instagram-media" data-instgrm-captioned data-instgrm-permalink="https://www.instagram.com/p/DM_1uOgTkX0/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="14" style="width:100%; max-width:540px;">
							</blockquote>
						 </div>
					</div>

					<div class="slide">
						<!-- Reel 8 -->
						 <div class="insta-reel-wrapper">
							<blockquote class="instagram-media" data-instgrm-captioned data-instgrm-permalink="https://www.instagram.com/p/DLj3jntxkk0/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="14" style="width:100%; max-width:540px;">
							</blockquote>
						 </div>
					</div>

					<div class="slide">
						<!-- Reel 9 -->
						 <div class="insta-reel-wrapper">
							<blockquote class="instagram-media" data-instgrm-captioned data-instgrm-permalink="https://www.instagram.com/p/DLi_yJLy0CS/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="14" style="width:100%; max-width:540px;">
							</blockquote>
						 </div>
					</div>


					<div class="slide">
						<!-- Reel 10 -->
						 <div class="insta-reel-wrapper">
							<blockquote class="instagram-media" data-instgrm-captioned data-instgrm-permalink="https://www.instagram.com/p/DLYlioMBtds/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="14" style="width:100%; max-width:540px;">
							</blockquote>
						 </div>
					</div>

										<div class="slide">
						<!-- Reel 11 -->
						 <div class="insta-reel-wrapper">
							<blockquote class="instagram-media" data-instgrm-captioned data-instgrm-permalink="https://www.instagram.com/p/DKLgR9Ay9lM/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="14" style="width:100%; max-width:540px;">
							</blockquote>
						 </div>
					</div>

					<div class="slide">
						<!-- Reel 12 -->
						 <div class="insta-reel-wrapper">
							<blockquote class="instagram-media" data-instgrm-captioned data-instgrm-permalink="https://www.instagram.com/p/DJ_VFcDOlGH/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="14" style="width:100%; max-width:540px;">
							</blockquote>
						 </div>
					</div>

					<div class="slide">
						<!-- Reel 13 -->
						 <div class="insta-reel-wrapper">
							<blockquote class="instagram-media" data-instgrm-captioned data-instgrm-permalink="https://www.instagram.com/p/DJ3Oebdxeet/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="14" style="width:100%; max-width:540px;">
							</blockquote>
						 </div>
					</div>

					<div class="slide">
						<!-- Reel 14 -->
						 <div class="insta-reel-wrapper">
							<blockquote class="instagram-media" data-instgrm-captioned data-instgrm-permalink="https://www.instagram.com/p/DJ1JHYeSLYn/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="14" style="width:100%; max-width:540px;">
							</blockquote>
						 </div>
					</div>

					<div class="slide">
						<!-- Reel 15 -->
						 <div class="insta-reel-wrapper">
							<blockquote class="instagram-media" data-instgrm-captioned data-instgrm-permalink="https://www.instagram.com/p/DIzpGKszpQv/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="14" style="width:100%; max-width:540px;">
							</blockquote>
						 </div>
					</div>

				</section>
			</div>
        </div>

		<?php
		/**
		 * Home testimonials block — hidden until client approval.
		 * To restore: change `false` below to `true` (and uncomment testimonials CSS in the <style> block above).
		 */
		if (false):
		?>
		<div class="home-testimonials col-lg-12 col-md-12 col-sm-12">
			<div class="container">
				<h3>What Our Clients Say</h3>
				<p class="section-subtitle">Trusted feedback from Durotech customers.</p>
				<?php
					$testimonialItems = [];
					if (!empty($homeTestimonials)) {
						foreach ($homeTestimonials as $item) {
							$t = $item['Testimonial'] ?? [];
							$quote = trim((string)($t['quote'] ?? ''));
							$name = trim((string)($t['name'] ?? ''));
							if ($quote !== '' || $name !== '') {
								$testimonialItems[] = ['quote' => $quote, 'name' => $name];
							}
						}
					}
				?>
				<?php if (!empty($testimonialItems)): ?>
					<?php
						$row1 = [];
						$row2 = [];
						foreach ($testimonialItems as $idx => $card) {
							if ($idx % 2 === 0) {
								$row1[] = $card;
							} else {
								$row2[] = $card;
							}
						}
						if (empty($row2)) {
							$row2 = $row1;
						}
					?>
					<div class="testimonial-marquee-row row-1">
						<div class="testimonial-marquee-track">
							<?php for ($loop = 0; $loop < 2; $loop++): ?>
								<?php foreach ($row1 as $card): ?>
									<div class="testimonial-marquee-item">
										<div class="testimonial-box">
											<p class="testimonial-quote"><?php echo h((string)$card['quote']); ?></p>
											<p class="testimonial-client-name"><?php echo h((string)$card['name']); ?></p>
										</div>
									</div>
								<?php endforeach; ?>
							<?php endfor; ?>
						</div>
					</div>
					<div class="testimonial-marquee-row row-2">
						<div class="testimonial-marquee-track">
							<?php for ($loop = 0; $loop < 2; $loop++): ?>
								<?php foreach ($row2 as $card): ?>
									<div class="testimonial-marquee-item">
										<div class="testimonial-box">
											<p class="testimonial-quote"><?php echo h((string)$card['quote']); ?></p>
											<p class="testimonial-client-name"><?php echo h((string)$card['name']); ?></p>
										</div>
									</div>
								<?php endforeach; ?>
							<?php endfor; ?>
						</div>
					</div>
				<?php else: ?>
					<div class="row">
						<div class="col-lg-12">
							<div class="testimonial-box">
								<p class="testimonial-quote">Testimonials will be displayed here once published.</p>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<?php endif; ?>
        <script async src="//www.instagram.com/embed.js"></script>
		<!-- <div class="client_logo col-lg-12 col-md-12 col-sm-12">		
			<div class="container">
				<h3>We Work With</h3>
				<p>Renowned national and multinational companies whom we work with.</p>
				<section class="customer-logos slider">
				  <div class="slide"><img src="<?php echo SITEURL ;?>customdurotech/images/client_icon_1.png"></div>
				  <div class="slide"><img src="<?php echo SITEURL ;?>customdurotech/images/client_icon_2.png"></div>
				  <div class="slide"><img src="<?php echo SITEURL ;?>customdurotech/images/client_icon_3.png"></div>
				  <div class="slide"><img src="<?php echo SITEURL ;?>customdurotech/images/client_icon_4.png"></div>
				  <div class="slide"><img src="<?php echo SITEURL ;?>customdurotech/images/client_icon_5.png"></div>
				  <div class="slide"><img src="<?php echo SITEURL ;?>customdurotech/images/client_icon_6.png"></div>
				  <div class="slide"><img src="<?php echo SITEURL ;?>customdurotech/images/client_icon_7.png"></div>
				  <div class="slide"><img src="<?php echo SITEURL ;?>customdurotech/images/client_icon_8.png"></div>
				  <div class="slide"><img src="<?php echo SITEURL ;?>customdurotech/images/client_icon_9.png"></div>
				</section>
			</div>
		</div> -->
		
		<!-- <div class="client_logo col-lg-12 col-md-12 col-sm-12">		
			<div class="container"> -->
				<!-- <div class="Accreditations col-lg-12 col-md-12 col-sm-12">
				    <h3>Accreditations</h3>
					<section class="customer-logos slider">
						
						<div class="slide"><img src="<?php echo SITEURL ;?>img/AIW_logo_new.jpg"></div>
						<div class="slide"><img src="<?php echo SITEURL ;?>img/australia_builder_new.jpg"></div>
						<div class="slide"><img src="<?php echo SITEURL ;?>img/HIA Master Builders_logo_new.jpg"></div>
						<div class="slide"><img src="<?php echo SITEURL ;?>img/netspec_logo_new.jpg"></div>
						<div class="slide"><img src="<?php echo SITEURL ;?>img/refuel_new.jpg"></div>
						<div class="slide"><img src="<?php echo SITEURL ;?>img/australia_builder_new.jpg"></div>
						<div class="slide"><img src="<?php echo SITEURL ;?>img/HIA Master Builders_logo_new.jpg"></div>
					</section>
			   </div> -->
			   
			<!--div class="Accreditations col-lg-6 col-md-6 col-sm-6">
				<h3>Strategic Alliances</h3>
			   <section class="customer-logos slider">
					
					<div class="slide"><img src="<?php echo SITEURL ;?>img/graco_new.jpg"></div>
					<div class="slide"><img src="<?php echo SITEURL ;?>img/HB Fuller_new.jpg"></div>					
					<div class="slide"><img src="<?php echo SITEURL ;?>img/graco_new.jpg"></div>
					<div class="slide"><img src="<?php echo SITEURL ;?>img/HB Fuller_new.jpg"></div>
					<div class="slide"><img src="<?php echo SITEURL ;?>img/graco_new.jpg"></div>
			   </section>
			   </div-->		   
			<!-- </div>
		</div> -->
		<!--div class="mobile_app_section col-lg-12 col-md-12 col-s-12">
	      <div class="container">
		  <div class="mobile_app_section_top_content">
		  <h2>Our Hi-Tech Mobile App </h2>
		  <p>With an Australian wide community that is connected to Durotech for over 40 years, we wish to make the user experience simplified and convenient. Download our latest mobile App to know about latest products and waterproofing solutions from Durotech Industries. </p>
          </div>
	      <div class="mobile_app_section_1 col-lg-4 col-md-4 col-sm-4">
		       <div class="app_new_product">
				   <div class="app_new_product_img"><img src="<?php echo SITEURL ;?>customdurotech/images/product_icon.png"></div>
				   <div class="app_new_product_content"><h3>New Products</h3>
				      <p>Get latest new about new product additions and project updates</p>
				   </div>
			   </div>
			   
			   <div class="app_new_product">
				   <div class="app_new_product_img"><img src="<?php echo SITEURL ;?>customdurotech/images/app_QR_icon.png"></div>
				   <div class="app_new_product_content"><h3>Scan QR Code Feature</h3>
				      <p>Use our exclusive product QR code scanner to get information on any product</p>
				   </div>
			   </div>
          </div>
		  <div class="mobile_section col-lg-4 col-md-4 col-sm-4">
		       <img src="<?php echo SITEURL ;?>customdurotech/images/mobile_app_img.png">
		  </div>
		  <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="app_new_product">
				   <div class="app_new_product_img"><img src="<?php echo SITEURL ;?>customdurotech/images/check_icon.png"></div>
				   <div class="app_new_product_content"><h3>Technical Datasheets</h3>
				      <p>Get complete access to product datasheets and MSDS docs</p>
				   </div>
			   </div>
			   
			   <div class="app_new_product">
				   <div class="app_new_product_img"><img src="<?php echo SITEURL ;?>customdurotech/images/vcard_icon.png"></div>
				   <div class="app_new_product_content"><h3>Exclusive vcard feature</h3>
				      <p>Creare your personal profile on the APP and generate a personal QR code linked to your contact information</p>
				   </div>
			   </div>

          </div>
    </div>
    </div-->
		<!--script src="http://lightwidget.com/widgets/lightwidget.js"></script><iframe src="http://lightwidget.com/widgets/6b59d0e0b09e59d1bbfadd63c7a3ed43.html" scrolling="no" allowtransparency="true" class="lightwidget-widget" style="width: 100%; border: 0; overflow: hidden;"></iframe-->
		<?php
		/*
			$data = file_get_contents('https://cdn.lightwidget.com/widgets/6b59d0e0b09e59d1bbfadd63c7a3ed43.html');
			$datas = htmlspecialchars($data);			
					
			preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $datas, $match);	
			$images  = array_chunk($match[0],5);			
			if(!empty($images)){ ?>
		<div class="project col-lg-12 col-md-12 col-sm-12">
		<h3>Durotech Projects </h3>
		<p style="text-align:center;">Check out latest projects form instagram page</p>
	    <div class="row">
		
			<?php 
				$i=0;
				foreach($images as $img){					
				$linknew = str_replace('"','',$img[0]);
				$linknew = str_replace('&quot','',$linknew);
				if($i > 7){
					break;
				}
				$i++;
			?>
			
			 <div class="card">
				  <div class="content">
					<div class="front">
					  <a href="<?php echo $linknew ;?>" target="_blank"><img src="<?php echo $img[3] ;?>" style="width:100%"></a>
					</div>
					<div class="back">
					  <a href="<?php echo $linknew ;?>"  target="_blank"><img src="<?php echo $img[3] ;?>" style="width:100%"></a>
					</div>
				  </div>
			 </div>
			 <?php  } ?>
		</div>
		</div>
		
		<?php } */ ?>


       <!-- chat bot code start here -->

			<!-- Floating Chatbot Button -->
		<!-- <div id="chatButton" style="
			position: fixed;bottom: 20px;right: 20px;
			background: #2889c8;color: #fff;border-radius: 50%;
			width: 60px; height: 60px;text-align: center;line-height: 60px;
			cursor: pointer;font-size: 30px;z-index: 9999;">💬</div> -->

			
			<!-- Chat Popup -->
			<div id="chatPopup" style="
				display:none;position: fixed;bottom: 100px;right: 20px;
				width: 320px;background: white;border: 1px solid #ccc;
				border-radius: 10px;box-shadow: 0 4px 10px rgba(0,0,0,0.3);z-index: 9999;">

				<!-- Header with close icon -->
				<div style="background:#2889c8; color:white; padding:10px;
				border-radius:10px 10px 0 0; display:flex; justify-content:space-between; align-items:center;">
					<span>Ask Durotech AI Assistant</span>
					<span id="closeChat" style="cursor:pointer; font-size:18px; font-weight:bold;">&times;</span>
				</div>

				<!-- Chat messages -->
				<div id="chatBox" style="height:250px; overflow-y:auto; padding:10px;"></div>

				<!-- Input section -->
				<div style="display:flex;">
					<input type="text" id="chatInput" style="flex:1; border:none; padding:10px; border-top:1px solid #ccc;">
					<button id="sendBtn" style="background:#2889c8; color:white; border:none; padding:10px;">Send</button>
				</div>
			</div>


		<script>
			(function () {
				var chatButton = document.getElementById('chatButton');
				var chatPopup = document.getElementById('chatPopup');
				var sendBtn = document.getElementById('sendBtn');
				var chatInput = document.getElementById('chatInput');
				var chatBox = document.getElementById('chatBox');
				if (!chatPopup || !sendBtn || !chatInput || !chatBox) {
					return;
				}

				if (chatButton) {
					chatButton.onclick = function() {
						chatPopup.style.display = chatPopup.style.display === 'none' ? 'block' : 'none';
					};
				}

				sendBtn.onclick = async function() {
					var msg = chatInput.value;
					if (!msg) return;
					chatBox.innerHTML += '<div><b>You:</b> ' + msg + '</div>';
					chatInput.value = '';

					const response = await fetch('<?php echo SITEURL; ?>chat_bot/chatbot', {
						method: 'POST',
						headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
						body: 'message=' + encodeURIComponent(msg)
					});

					const data = await response.json();
					const reply = (data && data.choices && data.choices[0] && data.choices[0].message)
						? data.choices[0].message.content
						: 'Sorry, no response received.';
					chatBox.innerHTML += '<div style="color:#2889c8;"><b>AI:</b> ' + reply + '</div>';
					chatBox.scrollTop = chatBox.scrollHeight;
				};
			})();
		</script>
		<script>
		$(document).ready(function(){
			$('.customer-logos').slick({
				slidesToShow: 7,
				slidesToScroll: 1,
				autoplay: true,
				autoplaySpeed: 1500,
				arrows: false,
				dots: false,
				pauseOnHover: false,
				responsive: [{
					breakpoint: 768,
					settings: {
						slidesToShow: 6
					}
				}, {
					breakpoint: 520,
					settings: {
						slidesToShow: 6
					}
				}]
			});
			$("#duroprodcut").click(function() {
				window.location.href = '<?php echo SITEURL.'products'?>';
			});
			
		});
		</script>

<script>
	$(document).ready(function(){
		$('.instagram-slider').slick({
			slidesToShow: 3,        // visible reels at a time
			slidesToScroll: 1,
			autoplay: true,
			autoplaySpeed: 3000,    // 3 seconds per slide
			infinite: true,         // loop continuously
			arrows: false,          // hide prev/next arrows
			dots: false,            // hide pagination
			pauseOnHover: false,
			responsive: [
				{
					breakpoint: 992,
					settings: { slidesToShow: 2 }
				},
				{
					breakpoint: 576,
					settings: { slidesToShow: 1 }
				}
			]
		});
	});
</script>
		