
<style>
.para-gr h5{

	color: white;
	font-size: 16px;
	line-height: 26px;
	margin-top: 40px;
}
.footer-about-social {
	margin-top: 20px;
	padding-top: 18px;
	border-top: 1px solid rgba(255, 255, 255, 0.18);
}
/* Beat .footer_section ul / a / .fa from theme (padding-right on icons, line-height on links) */
.footer_section .footer-about-social ul {
	list-style: none !important;
	padding: 0 !important;
	margin: 0 !important;
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
	align-items: center;
}
.footer_section .footer-about-social li {
	margin: 0;
	padding: 0;
	list-style: none;
	line-height: 1;
}
.footer_section .footer-about-social a {
	display: flex !important;
	align-items: center;
	justify-content: center;
	width: 44px;
	height: 44px;
	border-radius: 10px;
	box-sizing: border-box;
	color: #fff !important;
	background: rgba(255, 255, 255, 0.1);
	text-decoration: none !important;
	line-height: 1 !important;
	letter-spacing: normal !important;
	font-size: 18px;
	padding: 0 !important;
	transition: background 0.2s ease, color 0.2s ease, transform 0.15s ease;
}
.footer_section .footer-about-social a:hover,
.footer_section .footer-about-social a:focus {
	background: #2889c9;
	color: #fff !important;
	transform: translateY(-2px);
	outline: none;
}
.footer_section .footer-about-social .fa {
	color: #fff !important;
	padding: 0 !important;
	margin: 0 !important;
	font-size: 20px !important;
	line-height: 1 !important;
	display: inline-flex;
	align-items: center;
	justify-content: center;
	width: 1em;
	height: 1em;
	text-align: center;
	vertical-align: middle;
}
.footer_section .footer-about-social .fa::before {
	line-height: 1;
}

</style>
<?php echo $this->element('customduro_locations_promo'); ?>
<footer>
	<div class="footer_section col-lg-12 col-md-12 col-sm-12">
		<div class="row">
			<div class="footer_about col-lg-3 col-md-3 col-sm-3 para-gr">
				<img src="<?php echo SITEURL; ?>customdurotech/images/durotech_logo_new.png?v=20260521" alt="Durotech — Commercial waterproofing and sealants, Australian Made and Owned" style="max-width:100%;width:280px;height:auto;display:block;">
				<h5>Durotech industries is a leading manufacturer and supplier of waterproofing and coating solutions. Durotech Systems have been widely used in the construction industry for the sealing of wet areas, decks, roofs and other substrates providing protection against moisture and weather damage for over <?php echo (int)DUROTECH_YEARS; ?> years.</h5>
				<nav class="footer-about-social" aria-label="Social media">
					<ul>
						<li><a target="_blank" rel="noopener noreferrer" href="<?php echo h(FACEBOOK); ?>" aria-label="Facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
						<li><a target="_blank" rel="noopener noreferrer" href="<?php echo h(TWITER); ?>" aria-label="Twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
						<li><a target="_blank" rel="noopener noreferrer" href="<?php echo h(LINKDIN); ?>" aria-label="LinkedIn"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
						<li><a target="_blank" rel="noopener noreferrer" href="https://www.instagram.com/durotech_australia" aria-label="Instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
					</ul>
				</nav>
			</div>

			<div class="footer_company col-lg-3 col-md-3 col-sm-3">
				<h4 class="under">About Us</h4>
				<ul>
					<li><a target="_blank" href="<?php echo SITEURL; ?>Case-Study.pdf">Case studies</a></li>
					<li><a href="<?php echo SITEURL; ?>wp-content/uploads/Durotech_Credit_pplication_Term_and_condition.pdf">Terms & Conditions of Use</a></li>
					<li><a href="<?php echo SITEURL; ?>">Privacy Policy</a></li>
					<li><a href="<?php echo SITEURL; ?>specifiers">Specifications</a></li>
					<li><a href="<?php echo SITEURL; ?>about">Our Mission</a></li>
					<li><a href="<?php echo SITEURL; ?>video">Video Gallery</a></li>
					<li><a href="<?php echo SITEURL; ?>durotech-institute-of-waterproofing">Durotech Institute of Waterproofing</a></li>

				</ul>
			</div>

			<div class="footer_links col-lg-3 col-md-3 col-sm-3">
				<h4>Product Categories</h4>
				<ul style="color: white; list-style-type: none; padding-left: 0;">
					<?php
					$_footerCats = isset($footerCategories) ? $footerCategories : [];
					foreach ($_footerCats as $_fc) :
						$_c = $_fc['Category'] ?? [];
						$_slug = $_c['slug'] ?? '';
						if ($_slug === '') {
							continue;
						}
						?>
					<li>
						<a href="<?php echo h($this->Url->build('/category/' . $_slug)); ?>" style="color: white;">
							<?php echo h($_c['category_name'] ?? ''); ?>
						</a>
					</li>
					<?php endforeach; ?>
				</ul>
			</div>

			<div class="footer_info col-lg-3 col-md-3 col-sm-3">
				<h4>Contact Information</h4>
				<?php $officeMaps = (array)\Cake\Core\Configure::read('Durotech.officeMapUrls'); ?>
				<ul>
					<!-- <li><i class="fa fa-map-marker" aria-hidden="true"></i><a href="<?php //echo SITEURL . 'contact'; 
																							?>"><?php //echo ADDRESS;  
																																?></a></li> -->
					<li>
						<i class="" style="color: white;" aria-hidden="true"></i>
						<span style="color: white; font-size: 22px;">Company Located Address</span>
					</li>
					<li>
						<i class="fa fa-map-marker" aria-hidden="true"></i>
							<a href="<?php echo h($officeMaps['nsw'] ?? '#'); ?>" target="_blank">
                            NSW</a>
					</li>
					<li>
						<i class="fa fa-map-marker" aria-hidden="true"></i>
						 <a href="<?php echo h($officeMaps['vic'] ?? '#'); ?>" target="_blank">
							VICTORIA
						</a>
					</li>
					<li>
						<i class="fa fa-map-marker" aria-hidden="true"></i>
						 <a href="<?php echo h($officeMaps['qld'] ?? '#'); ?>" target="_blank">
							QUEENSLAND
						</a>
					</li>

					<li>
						<i class="fa fa-map-marker" aria-hidden="true"></i>
						<a href="<?php echo h($officeMaps['sa'] ?? '#'); ?>" target="_blank">
							SOUTH AUSTRALIA
						</a>
					</li>

					<li><i class="fa fa-phone" aria-hidden="true"></i><a href="<?php echo SITEURL . 'contact'; ?>"><?php echo PHONE;  ?></a></li>
					<li><i class="fa fa-envelope" aria-hidden="true"></i><a href="<?php echo SITEURL . 'contact'; ?>"><?php echo MAILTO;  ?></a></li>

					<li>
						<a href="<?php echo SITEURL; ?>product_warranty_v2" target="_blank">
							Product Warranty Request Form
						</a>
					</li>
				</ul>

				<form id="formemailnews">
					<div class="form-group">
						<input type="email" class="form-control" id="emailnews" placeholder="Subscribe">
						<h6 id="successmesg"></h6>

					</div>
					<div class="button-4">
						<div class="eff-4"></div>
						<a onclick="subscribe()"> SEND </a>
					</div>
				</form>
				<!--div class="row">
				<a href="https://play.google.com/store/apps/details?id=com.xoro.durotech&hl=en"><img src="<?php echo SITEURL ?>android-app-icon.png" style="width:80px !important; margin-left:5px"></a>
				<a href="https://itunes.apple.com/us/app/durotech/id1262728802?mt=8"><img src="<?php echo SITEURL ?>AppStore_Download.png" style="width:92px  !important; margin-left:5px"></a>		 
			</div-->
			</div>
		</div>
	</div>
	<div class="footer_bottom col-lg-12 col-md-12 col-sm-12">
		<a href="<?php echo SITEURL ?>">www.durotechindustries.com.au</a> © 2015-<?php echo date('Y'); ?>. All Rights Reserved
	</div>
</footer>
<script>
	function subscribe() {
		var emailnews = $("#emailnews").val();
		if (emailnews != '') {

			$.ajax({
				url: "<?php echo SITEURL . 'fronts/subscribe?email=' ?>" + emailnews,
				success: function(result) {
					$("#emailnews").val('');
					$("#successmesg").html(result);
					setTimeout(function() {
						$("#successmesg").html('');
					}, 5000);
				}
			});

		} else {
			$("#formemailnews").submit();
		}
	}

	jQuery(function() { //short for $(document).ready(function(){
		$("#emailnews").validate({
			expression: "if (VAL) return true; else return false;",
			message: "Please enter email"
		});
		jQuery("#emailnews").validate({
			expression: "if (VAL.match(\/^([a-zA-Z0-9_\\.\\-])+\\@(([a-zA-Z0-9\\-])+\\.)+([a-zA-Z0-9]{2,4})+$\/) && VAL) return true; else return false;",
			message: "Please enter valid email"
		});
	});
</script>