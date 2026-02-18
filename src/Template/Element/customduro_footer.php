
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
				<img src="<?php echo SITEURL; ?>customdurotech/images/durotech_logo.png">
				<h5>Durotech industries is a leading manufacturer and supplier of waterproofing and coating solutions. Durotech Systems have been widely used in the construction industry for the sealing of wet areas, decks, roofs and other substrates providing protection against moisture and weather damage for over 48 years.</h5>
			</div>

			<div class="footer_company col-lg-3 col-md-3 col-sm-3">
				<h4 class="under">About Us</h4>
				<ul>
					<li><a target="_blank" href="<?php echo SITEURL; ?>Case-Study.pdf">Case studies</a></li>
					<li><a href="<?php echo SITEURL; ?>wp-content/uploads/Durotech_Credit_pplication_Term_and_condition.pdf">Terms & Conditions of Use</a></li>
					<li><a href="<?php echo SITEURL; ?>">Privacy Policy</li>
					<li><a href="<?php echo SITEURL; ?>specifiers">Specifications</a></li>
					<li><a href="<?php echo SITEURL; ?>about">Our Mission</a></li>
					<li><a href="<?php echo SITEURL; ?>video">Video Gallery</a></li>
					<li><a href="<?php echo SITEURL; ?>durotech-institute-of-waterproofing">Durotech Institute of Waterproofing</a></li>

				</ul>
			</div>

			<div class="footer_links col-lg-3 col-md-3 col-sm-3">
				<h4>Product Categories</h4>
				<ul style="color: white; list-style-type: none; padding-left: 0;">
					<li><a target="_blank" href="<?php echo SITEURL; ?>category/duroprime-primers">Primers</a></li>
					<li><a target="_blank" href="<?php echo SITEURL; ?>category/cementitious-membranes">Cementitious Membranes</a></li>
					<li><a target="_blank" href="<?php echo SITEURL; ?>category/tapes-reinforcement-fabric">Tapes / Reinforcement Fabric</a></li>
					<li><a target="_blank" href="<?php echo SITEURL; ?>category/thinners">Thinners</a></li>
					<li><a target="_blank" href="<?php echo SITEURL; ?>category/sealer">Sealer</a></li>
					<li><a target="_blank" href="<?php echo SITEURL; ?>category/water-based-waterproofing-membranes">Water based Waterproofing Membranes</a></li>
					<li><a target="_blank" href="<?php echo SITEURL; ?>category/polyurethane-waterproofing-membrane">Polyurethane Waterproofing Membranes</a></li>
					<li><a target="_blank" href="<?php echo SITEURL; ?>category/duroseal-sealants">Sealants & Silicone</a></li>
					<li><a target="_blank" href="<?php echo SITEURL; ?>category/duropoxy-epoxy-flooring">Epoxy Flooring Sheet Membranes</a></li>
					<li><a target="_blank" href="<?php echo SITEURL; ?>category/sheet-membranes-1">Sheet Membranes</a></li>


					<!-- <?php //foreach ($category as $categorys): 
							?>
						<li>
							<a href="<?php //echo SITEURL . 'category/' . $categorys['Category']['slug']; 
										?>" style="color: white;">
								<?php //echo $categorys['Category']['category_name']; 
								?>
							</a>
						</li>
                    <?php //endforeach; 
					?> -->
				</ul>


			</div>

			<div class="footer_info col-lg-3 col-md-3 col-sm-3">
				<h4>Contact Information</h4>
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
							<a href="https://www.google.com/maps?q=14+Essex+st,+Minto,+Sydney+NSW+2566" target="_blank">
                            NSW</a>
					</li>
					<li>
						<i class="fa fa-map-marker" aria-hidden="true"></i>
						 <a href="https://www.google.com/maps?q=34+Indian+Drive,+Keysborough,+Victoria+3173" target="_blank">
							VICTORIA
						</a>
					</li>
					<li>
						<i class="fa fa-map-marker" aria-hidden="true"></i>
						 <a href="https://www.google.com/maps?q=16+Export+Drive,+Molendinar,+Gold+Coast+4214" target="_blank">
							QUEENSLAND
						</a>
					</li>

					<li>
						<i class="fa fa-map-marker" aria-hidden="true"></i>
						<a href="https://www.google.com/maps?q=30C+Richard+Street,+Hindmarsh,+SA+5007" target="_blank">
							SOUTH AUSTRALIA
						</a>
					</li>

					<li><i class="fa fa-phone" aria-hidden="true"></i><a href="<?php echo SITEURL . 'contact'; ?>"><?php echo PHONE;  ?></a></li>
					<li><i class="fa fa-envelope" aria-hidden="true"></i><a href="<?php echo SITEURL . 'contact'; ?>"><?php echo MAILTO;  ?></a></li>

					<li>
						<a href="<?php echo SITEURL; ?>product_warranty" target="_blank">
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