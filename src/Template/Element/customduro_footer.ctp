<?php
/**
 * Custom Duro footer element (CakePHP 3).
 */
?>
<style>
.para-gr h5{
	color: white;
	font-size: 16px;
	line-height: 26px;
	margin-top: 40px;
}
</style>
<footer>
	<div class="footer_section col-lg-12 col-md-12 col-sm-12">
		<div class="row">
			<div class="footer_about col-lg-3 col-md-3 col-sm-3 para-gr">
				<img src="<?= h(SITEURL) ?>customdurotech/images/durotech1_logo.png" alt="Durotech">
				<h5>Durotech industries is a leading manufacturer and supplier of waterproofing and coating solutions. Durotech Systems have been widely used in the construction industry for the sealing of wet areas, decks, roofs and other substrates providing protection against moisture and weather damage for over 48 years.</h5>
			</div>

			<div class="footer_company col-lg-3 col-md-3 col-sm-3">
				<h4 class="under">About Us</h4>
				<ul>
					<li><a target="_blank" href="<?= h(SITEURL) ?>Case-Study.pdf">Case studies</a></li>
					<li><a href="<?= h(SITEURL) ?>wp-content/uploads/Durotech_Credit_pplication_Term_and_condition.pdf">Terms & Conditions of Use</a></li>
					<li><a href="<?= h(SITEURL) ?>">Privacy Policy</a></li>
					<li><a href="<?= $this->Url->build('/specification') ?>">Specifications</a></li>
					<li><a href="<?= $this->Url->build('/about') ?>">Our Mission</a></li>
					<li><a href="<?= $this->Url->build('/video') ?>">Video Gallery</a></li>
					<li><a href="<?= $this->Url->build('/durotech-institute-of-waterproofing') ?>">Durotech Institute of Waterproofing</a></li>
				</ul>
			</div>

			<div class="footer_links col-lg-3 col-md-3 col-sm-3">
				<h4>Product Categories</h4>
				<ul style="color: white; list-style-type: none; padding-left: 0;">
					<li><a target="_blank" href="<?= h(SITEURL) ?>category/duroprime-primers">Primers</a></li>
					<li><a target="_blank" href="<?= h(SITEURL) ?>category/cementitious-membranes">Cementitious Membranes</a></li>
					<li><a target="_blank" href="<?= h(SITEURL) ?>category/tapes-reinforcement-fabric">Tapes / Reinforcement Fabric</a></li>
					<li><a target="_blank" href="<?= h(SITEURL) ?>category/thinners">Thinners</a></li>
					<li><a target="_blank" href="<?= h(SITEURL) ?>category/sealer">Sealer</a></li>
					<li><a target="_blank" href="<?= h(SITEURL) ?>category/water-based-waterproofing-membranes">Water based Waterproofing Membranes</a></li>
					<li><a target="_blank" href="<?= h(SITEURL) ?>category/polyurethane-waterproofing-membrane">Polyurethane Waterproofing Membranes</a></li>
					<li><a target="_blank" href="<?= h(SITEURL) ?>category/duroseal-sealants">Sealants & Silicone</a></li>
					<li><a target="_blank" href="<?= h(SITEURL) ?>category/duropoxy-epoxy-flooring">Epoxy Flooring Sheet Membranes</a></li>
					<li><a target="_blank" href="<?= h(SITEURL) ?>category/sheet-membranes-1">Sheet Membranes</a></li>
				</ul>
			</div>

			<div class="footer_info col-lg-3 col-md-3 col-sm-3">
				<h4>Contact Information</h4>
				<ul>
					<li>
						<span style="color: white; font-size: 22px;">Company Located Address</span>
					</li>
					<li>
						<i class="fa fa-map-marker" aria-hidden="true"></i>
						<a href="https://www.google.com/maps?q=14+Essex+st,+Minto,+Sydney+NSW+2566" target="_blank">NSW</a>
					</li>
					<li>
						<i class="fa fa-map-marker" aria-hidden="true"></i>
						<a href="https://www.google.com/maps?q=34+Indian+Drive,+Keysborough,+Victoria+3173" target="_blank">VICTORIA</a>
					</li>
					<li>
						<i class="fa fa-map-marker" aria-hidden="true"></i>
						<a href="https://www.google.com/maps?q=16+Export+Drive,+Molendinar,+Gold+Coast+4214" target="_blank">QUEENSLAND</a>
					</li>
					<li>
						<i class="fa fa-map-marker" aria-hidden="true"></i>
						<a href="https://www.google.com/maps?q=30C+Richard+Street,+Hindmarsh,+SA+5007" target="_blank">SOUTH AUSTRALIA</a>
					</li>
					<li><i class="fa fa-phone" aria-hidden="true"></i><a href="<?= $this->Url->build('/contact') ?>"><?= h(PHONE) ?></a></li>
					<li><i class="fa fa-envelope" aria-hidden="true"></i><a href="<?= $this->Url->build('/contact') ?>"><?= h(MAILTO) ?></a></li>
					<li>
						<a href="<?= $this->Url->build('/product_warranty') ?>" target="_blank">Product Warranty Request Form</a>
					</li>
				</ul>

				<form id="formemailnews">
					<div class="form-group">
						<input type="email" class="form-control" id="emailnews" placeholder="Subscribe">
						<h6 id="successmesg"></h6>
					</div>
					<div class="button-4">
						<div class="eff-4"></div>
						<a href="javascript:void(0)" onclick="subscribe()"> SEND </a>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="footer_bottom col-lg-12 col-md-12 col-sm-12">
		<a href="<?= h(SITEURL) ?>">www.durotechindustries.com.au</a> © 2015-<?= date('Y') ?>. All Rights Reserved
	</div>
</footer>
<script>
	function subscribe() {
		var emailnews = $("#emailnews").val();
		if (emailnews != '') {
			$.ajax({
				url: "<?= h($this->Url->build(['controller' => 'Fronts', 'action' => 'subscribe'])) ?>?email=" + encodeURIComponent(emailnews),
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
			expression: "if (VAL.match(/^([a-zA-Z0-9_\\.\\-])+\\@(([a-zA-Z0-9\\-])+\\.)+([a-zA-Z0-9]{2,4})+$/) && VAL) return true; else return false;",
			message: "Please enter valid email"
		});
	});

	var prevScrollpos = window.pageYOffset;
	window.onscroll = function() {
		var currentScrollPos = window.pageYOffset;
		if (prevScrollpos > currentScrollPos) {
			document.getElementById("header_top").style.top = "0";
		} else {
			document.getElementById("header_top").style.top = "-80px";
		}
		prevScrollpos = currentScrollPos;
	}
</script>
