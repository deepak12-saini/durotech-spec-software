
<style>
/* --- Modern footer polish (brand blue #2889c9 / yellow #f4c400) --- */
.footer_section {
	background: #3d4246 !important;
	padding: 48px 36px 36px !important;
	position: relative;
	width: 100%;
	float: left;
	box-sizing: border-box;
}
.footer_section::before {
	content: '';
	position: absolute;
	left: 0;
	right: 0;
	top: 0;
	height: 4px;
	background: linear-gradient(90deg, #2889c9 0%, #2889c9 42%, #f4c400 42%, #f4c400 58%, #2889c9 58%, #2889c9 100%);
}
.footer_section .row {
	display: flex;
	flex-wrap: wrap;
	margin-left: -12px;
	margin-right: -12px;
}
.footer_section .footer_about,
.footer_section .footer_company,
.footer_section .footer_links,
.footer_section .footer_info {
	padding-left: 12px;
	padding-right: 12px;
	box-sizing: border-box;
	float: none;
}
.para-gr h5 {
	color: rgba(255, 255, 255, 0.92);
	font-size: 15px;
	line-height: 1.65;
	margin-top: 18px;
	margin-bottom: 0;
	font-weight: 400;
	text-align: left;
	letter-spacing: 0.01em;
}
.footer_section .footer-brand-logo {
	max-width: 100%;
	width: 260px;
	height: auto;
	display: block;
}
.footer-about-social {
	margin-top: 20px;
	padding-top: 18px;
	border-top: 1px solid rgba(255, 255, 255, 0.16);
}
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
	transition: background 0.2s ease, transform 0.15s ease;
}
.footer_section .footer-about-social a:hover,
.footer_section .footer-about-social a:focus {
	background: #2889c9 !important;
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
}
.footer_section .footer-about-social .fa::before {
	line-height: 1;
}

/* Column titles */
.footer_section h4,
.footer_section .footer-col-toggle {
	color: #fff !important;
	font-size: 18px !important;
	font-weight: 700 !important;
	line-height: 1.3 !important;
	margin: 0 0 14px !important;
	padding: 0 0 10px !important;
	border-bottom: 2px solid rgba(255, 255, 255, 0.22) !important;
	letter-spacing: 0.02em;
	position: relative;
}
.footer_section h4::after,
.footer_section .footer-col-toggle::after {
	content: '';
	position: absolute;
	left: 0;
	bottom: -2px;
	width: 42px;
	height: 2px;
	background: #f4c400;
}
.footer_section ul {
	list-style: none !important;
	padding: 0 !important;
	margin: 0 !important;
}
.footer_section .footer_company ul li,
.footer_section .footer_links ul li {
	margin: 0;
	padding: 0;
}
.footer_section .footer_company a,
.footer_section .footer_links a {
	display: inline-block !important;
	color: rgba(255, 255, 255, 0.9) !important;
	font-size: 15px !important;
	line-height: 1.45 !important;
	padding: 7px 0 !important;
	text-decoration: none !important;
	border-bottom: 1px solid transparent;
	transition: color 0.2s ease, transform 0.2s ease, border-color 0.2s ease;
}
.footer_section .footer_company a:hover,
.footer_section .footer_company a:focus,
.footer_section .footer_links a:hover,
.footer_section .footer_links a:focus {
	color: #fff !important;
	transform: translateX(4px);
	border-bottom-color: #f4c400;
}

/* Contact */
.footer_section .footer-contact-list {
	margin: 0 0 16px !important;
}
.footer_section .footer-loc-label {
	display: block;
	color: rgba(255, 255, 255, 0.95);
	font-size: 15px;
	font-weight: 700;
	margin: 4px 0 10px;
}
.footer_section .footer-loc-pills {
	display: flex;
	flex-direction: column;
	flex-wrap: nowrap;
	align-items: stretch;
	gap: 12px;
	margin: 0 !important;
	padding: 0 0 15px 0 !important;
	list-style: none !important;
}
.footer_section .footer-loc-pills li {
	margin: 0;
	padding: 0;
	width: 100%;
}
.footer_section .footer-loc-pills a {
	display: inline-flex !important;
	align-items: center;
	gap: 8px;
	width: 100%;
	box-sizing: border-box;
	padding: 11px 14px !important;
	border-radius: 10px;
	border: 1px solid rgba(255, 255, 255, 0.28);
	background: rgba(255, 255, 255, 0.06);
	color: #fff !important;
	font-size: 13px !important;
	font-weight: 600 !important;
	letter-spacing: 0.04em;
	line-height: 1 !important;
	text-decoration: none !important;
	transition: background 0.2s ease, border-color 0.2s ease, transform 0.15s ease;
}
.footer_section .footer-loc-pills a:hover,
.footer_section .footer-loc-pills a:focus {
	background: #2889c9 !important;
	border-color: #2889c9;
	transform: translateY(-1px);
}
.footer_section .footer-loc-pills .fa {
	color: #fff !important;
	padding: 0 !important;
	margin: 0 !important;
	font-size: 12px !important;
}

.footer_section .footer-contact-chip {
	display: flex !important;
	align-items: center;
	gap: 10px;
	width: 100%;
	max-width: 100%;
	box-sizing: border-box;
	padding: 10px 12px !important;
	margin: 0 0 10px !important;
	border-radius: 10px;
	background: rgba(255, 255, 255, 0.07);
	color: #fff !important;
	text-decoration: none !important;
	font-size: 15px !important;
	line-height: 1.35 !important;
	overflow: visible;
	transition: background 0.2s ease;
}
.footer_section .footer-contact-chip > span {
	flex: 1 1 auto;
	min-width: 0;
	white-space: normal;
	overflow-wrap: anywhere;
	word-break: break-word;
}
.footer_section .footer-contact-chip:hover,
.footer_section .footer-contact-chip:focus {
	background: rgba(40, 137, 201, 0.45) !important;
	color: #fff !important;
}
.footer_section .footer-contact-chip .fa {
	color: #fff !important;
	padding: 0 !important;
	margin: 0 !important;
	font-size: 16px !important;
	width: 18px;
	flex: 0 0 18px;
	text-align: center;
}
.footer_section .footer_info,
.footer_section .footer-contact-list,
.footer_section .footer-col-panel {
	overflow: visible;
	max-width: 100%;
	box-sizing: border-box;
}
.footer_section .footer-warranty-btn {
	display: inline-flex !important;
	align-items: center;
	justify-content: center;
	gap: 8px;
	margin: 10px 0 18px !important;
	padding: 10px 14px !important;
	border: 1px solid rgba(255, 255, 255, 0.55) !important;
	border-radius: 10px;
	color: #fff !important;
	font-size: 14px !important;
	font-weight: 600 !important;
	line-height: 1.3 !important;
	text-decoration: none !important;
	background: transparent;
	transition: background 0.2s ease, border-color 0.2s ease, transform 0.15s ease;
}
.footer_section .footer-warranty-btn:hover,
.footer_section .footer-warranty-btn:focus {
	background: #2889c9 !important;
	border-color: #2889c9 !important;
	color: #fff !important;
	transform: translateY(-1px);
}

/* Subscribe row */
.footer_section #formemailnews.footer-subscribe {
	margin-top: 4px;
}
.footer_section .footer-subscribe-row {
	display: flex;
	align-items: stretch;
	gap: 0;
	max-width: 100%;
}
.footer_section .footer-subscribe-row .form-control {
	flex: 1 1 auto;
	min-width: 0;
	height: 44px;
	border: 0;
	border-radius: 10px 0 0 10px;
	box-shadow: none;
	padding: 10px 14px;
	font-size: 14px;
}
.footer_section .footer-subscribe-send {
	flex: 0 0 auto;
	display: inline-flex;
	align-items: center;
	justify-content: center;
	min-width: 88px;
	height: 44px;
	padding: 0 16px;
	border: 0;
	border-radius: 0 10px 10px 0;
	background: #2889c9;
	color: #fff !important;
	font-size: 13px;
	font-weight: 700;
	letter-spacing: 0.06em;
	text-decoration: none !important;
	cursor: pointer;
	transition: background 0.2s ease, transform 0.1s ease;
}
.footer_section .footer-subscribe-send:hover,
.footer_section .footer-subscribe-send:focus {
	background: #1f74ad;
	color: #fff !important;
}
.footer_section .footer-subscribe-send:active {
	transform: scale(0.98);
}
.footer_section #successmesg {
	color: #f4c400;
	min-height: 1.2em;
	margin: 8px 0 0;
	font-size: 13px;
}

/* Hide legacy button-4 styles inside new subscribe */
.footer_section #formemailnews .button-4 {
	display: none;
}

.footer_bottom {
	background: #2889c9 !important;
	color: rgba(255, 255, 255, 0.95);
	text-align: center;
	padding: 16px 18px !important;
	font-size: 13px;
	width: 100%;
	float: left;
}
.footer_bottom a {
	color: #fff !important;
	text-decoration: none;
	font-weight: 600;
}
.footer_bottom a:hover {
	color: #f4c400 !important;
}

/* Accordion toggle (mobile) */
.footer_section .footer-col-toggle {
	display: none;
	width: 100%;
	text-align: left;
	background: transparent;
	border-left: 0;
	border-right: 0;
	border-top: 0;
	cursor: pointer;
	appearance: none;
	-webkit-appearance: none;
}
.footer_section .footer-col-toggle .footer-col-chevron {
	float: right;
	font-size: 18px;
	line-height: 1;
	opacity: 0.85;
	transition: transform 0.2s ease;
}
.footer_section .footer-col.is-open > .footer-col-toggle .footer-col-chevron {
	transform: rotate(180deg);
}

@media (min-width: 992px) {
	.footer_section .footer_links {
		flex: 0 0 28%;
		max-width: 28%;
	}
	.footer_section .footer_about,
	.footer_section .footer_company,
	.footer_section .footer_info {
		flex: 0 0 24%;
		max-width: 24%;
	}
}

@media (max-width: 991px) {
	.footer_section {
		padding: 36px 20px 28px !important;
	}
	.footer_section .footer_about,
	.footer_section .footer_company,
	.footer_section .footer_links,
	.footer_section .footer_info {
		flex: 0 0 50%;
		max-width: 50%;
		margin-bottom: 28px;
	}
}

@media (max-width: 767px) {
	.footer_section .footer_about,
	.footer_section .footer_company,
	.footer_section .footer_links,
	.footer_section .footer_info {
		flex: 0 0 100%;
		max-width: 100%;
		margin-bottom: 8px;
	}
	.footer_section .footer_about {
		margin-bottom: 22px;
	}
	.footer_section .footer-col > h4 {
		display: none !important;
	}
	.footer_section .footer-col-toggle {
		display: block;
	}
	.footer_section .footer-col-panel {
		display: none;
		padding-bottom: 12px;
	}
	.footer_section .footer-col.is-open > .footer-col-panel {
		display: block;
	}
	.footer_section .footer-subscribe-row {
		flex-direction: row;
	}
}
</style>
<?php echo $this->element('customduro_locations_promo'); ?>
<footer>
	<div class="footer_section col-lg-12 col-md-12 col-sm-12">
		<div class="row">
			<div class="footer_about col-lg-3 col-md-3 col-sm-3 para-gr">
				<img class="footer-brand-logo" src="<?php echo SITEURL; ?>customdurotech/images/durotech_logo_new.png?v=20260521" alt="Durotech — Commercial waterproofing and sealants, Australian Made and Owned">
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

			<div class="footer_company footer-col col-lg-3 col-md-3 col-sm-3">
				<button type="button" class="footer-col-toggle" aria-expanded="false">
					About Us <span class="footer-col-chevron" aria-hidden="true">▾</span>
				</button>
				<h4 class="under">About Us</h4>
				<div class="footer-col-panel">
					<ul>
						<li><a target="_blank" href="<?php echo SITEURL; ?>Case-Study.pdf">Case studies</a></li>
						<li><a href="<?php echo SITEURL; ?>wp-content/uploads/Durotech_Credit_pplication_Term_and_condition.pdf">Terms & Conditions of Use</a></li>
						<li><a href="<?php echo SITEURL; ?>">Privacy Policy</a></li>
						<?php /* <li><a href="<?php echo SITEURL; ?>specifiers">Specifications</a></li> */ ?>
						<li><a href="<?php echo SITEURL; ?>about">Our Mission</a></li>
						<li><a href="<?php echo SITEURL; ?>video">Video Gallery</a></li>
						<li><a href="<?php echo SITEURL; ?>durotech-institute-of-waterproofing">Durotech Institute of Waterproofings</a></li>
					</ul>
				</div>
			</div>

			<div class="footer_links footer-col col-lg-3 col-md-3 col-sm-3">
				<button type="button" class="footer-col-toggle" aria-expanded="false">
					Product Categories <span class="footer-col-chevron" aria-hidden="true">▾</span>
				</button>
				<h4>Product Categories</h4>
				<div class="footer-col-panel">
					<ul>
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
							<a href="<?php echo h($this->Url->build('/category/' . $_slug)); ?>">
								<?php echo h($_c['category_name'] ?? ''); ?>
							</a>
						</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>

			<div class="footer_info footer-col col-lg-3 col-md-3 col-sm-3">
				<button type="button" class="footer-col-toggle" aria-expanded="false">
					Contact Information <span class="footer-col-chevron" aria-hidden="true">▾</span>
				</button>
				<h4>Contact Information</h4>
				<div class="footer-col-panel">
					<?php $officeMaps = (array)\Cake\Core\Configure::read('Durotech.officeMapUrls'); ?>
					<div class="footer-contact-list">
						<span class="footer-loc-label">Company Located Address</span>
						<ul class="footer-loc-pills">
							<li>
								<a href="<?php echo h($officeMaps['nsw'] ?? '#'); ?>" target="_blank" rel="noopener noreferrer">
									<i class="fa fa-map-marker" aria-hidden="true"></i> NSW
								</a>
							</li>
							<li>
								<a href="<?php echo h($officeMaps['vic'] ?? '#'); ?>" target="_blank" rel="noopener noreferrer">
									<i class="fa fa-map-marker" aria-hidden="true"></i> VICTORIA
								</a>
							</li>
							<li>
								<a href="<?php echo h($officeMaps['qld'] ?? '#'); ?>" target="_blank" rel="noopener noreferrer">
									<i class="fa fa-map-marker" aria-hidden="true"></i> QUEENSLAND
								</a>
							</li>
							<li>
								<a href="<?php echo h($officeMaps['sa'] ?? '#'); ?>" target="_blank" rel="noopener noreferrer">
									<i class="fa fa-map-marker" aria-hidden="true"></i> SOUTH AUSTRALIA
								</a>
							</li>
						</ul>

						<a class="footer-contact-chip" href="<?php echo SITEURL . 'contact'; ?>">
							<i class="fa fa-phone" aria-hidden="true"></i>
							<span><?php echo h(PHONE); ?></span>
						</a>
						<a class="footer-contact-chip" href="<?php echo SITEURL . 'contact'; ?>">
							<i class="fa fa-envelope" aria-hidden="true"></i>
							<span><?php echo h(MAILTO); ?></span>
						</a>

						<a class="footer-warranty-btn" href="<?php echo SITEURL; ?>product_warranty_v2" target="_blank" rel="noopener noreferrer">
							<i class="fa fa-file-text-o" aria-hidden="true"></i>
							Product Warranty Request Form
						</a>
					</div>

					<form id="formemailnews" class="footer-subscribe" onsubmit="return false;">
						<div class="footer-subscribe-row">
							<input type="email" class="form-control" id="emailnews" placeholder="Subscribe" aria-label="Email for newsletter">
							<a class="footer-subscribe-send" href="javascript:void(0);" onclick="subscribe()" role="button">SEND</a>
						</div>
						<h6 id="successmesg"></h6>
					</form>
				</div>
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

	jQuery(function() {
		$("#emailnews").validate({
			expression: "if (VAL) return true; else return false;",
			message: "Please enter email"
		});
		jQuery("#emailnews").validate({
			expression: "if (VAL.match(\/^([a-zA-Z0-9_\\.\\-])+\\@(([a-zA-Z0-9\\-])+\\.)+([a-zA-Z0-9]{2,4})+$\/) && VAL) return true; else return false;",
			message: "Please enter valid email"
		});

		var $cols = $('.footer_section .footer-col');
		$cols.find('.footer-col-toggle').on('click', function() {
			var $col = $(this).closest('.footer-col');
			var willOpen = !$col.hasClass('is-open');
			$cols.removeClass('is-open');
			$cols.find('.footer-col-toggle').attr('aria-expanded', 'false');
			if (willOpen) {
				$col.addClass('is-open');
				$(this).attr('aria-expanded', 'true');
			}
		});
	});
</script>
