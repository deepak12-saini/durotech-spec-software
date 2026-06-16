<style>
/* Top offset for fixed #header_top — set in customduro_header.js (applyBannerTopPadding) from measured header height so mobile matches the real bar (avoids pale band or banner underlap). */
.page-about-wrap {
    padding-top: 70px;
    background: #e4edf4;
}
@media (min-width: 768px) {
    .page-about-wrap {
        padding-top: 80px;
    }
}
/* style.css sets .content_about { padding: 40px 0 } — that top padding sits above the banner and reads as a gap under the header */
.page-about-wrap > .content_about {
    padding-top: 0;
    padding-left: 0;
    padding-right: 0;
    padding-bottom: 40px;
}
/* Ensure banner image displays fully and is not clipped */
.banner_about {
    overflow: visible;
    display: block;
    margin-top: 0;
    padding-top: 0;
}
.banner_about img {
    display: block;
    width: 100%;
    height: auto;
    vertical-align: top;
}
/* Remove space below banner */
.banner_about {
    margin-bottom: 0;
    padding-bottom: 0;
}
.content_about > h3:first-of-type {
    margin-top: 0;
}
.about-intro {
    max-width: 940px;
    margin: 14px auto 26px;
    text-align: center;
}
.about-intro__badge {
    width: 54px;
    height: 54px;
    margin: 0 auto 10px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #ffffff;
    color: #5a1ea8;
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
    font-size: 24px;
}
.about-intro h3 {
    margin: 0 0 10px;
    font-size: 44px;
    font-weight: 700;
    color: #1b4762;
}
.about-intro__text {
    margin: 0;
    background: #e4edf4;
    border-radius: 14px;
    padding: 16px 20px;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
    line-height: 1.75;
    color: #4f6782;
}

/* Who We Are cards */
.we_are_section {
    padding: 0 10px 20px;
    border: none !important;
    box-shadow: none !important;
}
.we_are_section .block {
    background: #ffffff;
    border-radius: 14px;
    border: none !important;
    padding: 30px 22px 28px;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
    text-align: center;
    height: 100%;
    min-height: 300px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.we_are_section .block i.fa {
    font-size: 32px;
    margin-bottom: 12px;
    color: #5a1ea8;
}
.we_are_section .block h4 {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 10px;
    color: #1b4762;
}
.we_are_section .block p {
    font-size: 13px;
    line-height: 1.7;
    color: #536f8c;
    min-height: 112px;
}
.we_are_section .block a {
    display: inline-block;
    margin-top: 8px;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.03em;
    color: #5a1ea8;
    text-transform: uppercase;
}
.we_are_section .block .read-more-trigger {
    display: inline-block;
    margin-top: 8px;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.03em;
    color: #5a1ea8;
    text-transform: uppercase;
    border: 0;
    background: transparent;
    padding: 0;
    transition: color 0.2s ease;
}
.we_are_section .block:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 26px rgba(0, 0, 0, 0.12);
    background: linear-gradient(140deg, #2a95dd 0%, #1a78bf 100%);
}
.we_are_section .block:hover i.fa,
.we_are_section .block:hover h4,
.we_are_section .block:hover p {
    color: #ffffff;
}
.we_are_section .block:hover .read-more-trigger {
    color: #ffe062;
}
@media (max-width: 767px) {
    .about-intro {
        margin: 10px auto 18px;
    }
    .about-intro h3 {
        font-size: 32px;
    }
    .about-intro__text {
        padding: 14px 14px;
    }
    .we_are_section {
        margin-top: 16px;
    }
    .we_are_section .block {
        padding: 24px 18px;
        min-height: 260px;
    }
}

/* Stable modal behavior with a lighter backdrop */
.modal-backdrop.in {
    opacity: 0.25;
}

/* Non-blocking custom popup for About "Read More" */
.about-readmore-popup {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: min(680px, 92vw);
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 16px 36px rgba(0, 0, 0, 0.25);
    z-index: 2000;
    display: none;
}
.about-readmore-popup__header {
    padding: 14px 18px;
    border-bottom: 1px solid #e4e7ef;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.about-readmore-popup__title {
    margin: 0;
    font-size: 22px;
    font-weight: 700;
    color: #1b4762;
}
.about-readmore-popup__close {
    border: 0;
    background: transparent;
    font-size: 24px;
    line-height: 1;
    color: #7b8799;
}
.about-readmore-popup__body {
    padding: 18px;
    color: #536f8c;
    line-height: 1.7;
    max-height: 60vh;
    overflow: auto;
}
</style>

	<div class="page-about-wrap">
	<div class="content_about col-lg-12 col-md-12 col-sm-12">
	        <div class="banner_about col-lg-12 col-md-12 col-sm-12">
				<img src="<?php echo SITEURL ;?>customdurotech/images/about_us_banner.jpg" alt="About Durotech">
			</div>
             <div class="about-intro">
                 <div class="about-intro__badge"><i class="fa fa-building-o" aria-hidden="true"></i></div>
		         <h3>Who We Are</h3>
		         <p class="about-intro__text">Durotech industries is a leading manufacturer and supplier of waterproofing and coating solutions. Durotech Systems have been widely
used in the construction industry for the sealing of wet areas, decks, roofs and other substrates providing protection against moisture and weather
damage for over <?php echo (int)DUROTECH_YEARS; ?> years. State of the art technology combined with dedicated commitment to research and development has made Durotech Industries an authoritative and dominant leader in the waterproofing and coatings arena.</p>
             </div>
			 <div class="container">
			 
			 <div class="we_are_section col-lg-3 col-md-3 col-sm-3">
			     <div class="block">
				     <i class="fa fa-eye" aria-hidden="true"></i>
				     <h4>Our Vision</h4>
					 <p>To deliver high quality, durable waterproofing solutions to customers around the world..... </p>
					 <button type="button" class="read-more-trigger" data-toggle="modal" data-target="#basicModal">READ MORE</button>
					 <div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel">
					  <div class="modal-dialog">
						<div class="modal-content">
						  <div class="modal-header">
							<h4 class="modal-title" id="basicModalLabel">Our Vision</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						  </div>
						  <div class="modal-body">
							<p>To deliver high quality, durable waterproofing solutions to customers around the world. To be the market leader in the provision of high quality, durable waterproofing solutions and to deliver exceptional results for all our our customers, our employees, our communities, our natural environment, shareholders and board. We stand for sustainable excellence.</p>
						  </div>
						 
						</div>
					  </div>
					</div>
				 </div>
			 </div>
			 <div class="we_are_section col-lg-3 col-md-3 col-sm-3">
			     <div class="block">
				     <i class="fa fa-rocket" aria-hidden="true"></i>
				     <h4>Our Mission</h4>
					 <p>Durotech Industries delivers high quality, durable and sustainable waterproofing....</p>
					  <button type="button" class="read-more-trigger" data-toggle="modal" data-target="#basicModal_1">READ MORE</button>
					 <div class="modal fade" id="basicModal_1" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel1">
					  <div class="modal-dialog">
						<div class="modal-content">
						  <div class="modal-header">
							<h4 class="modal-title" id="basicModalLabel1">Our Mission</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						  </div>
						  <div class="modal-body">
							<p>Durotech Industries delivers high quality, durable and sustainable waterproofing solutions for architects, specifiers, builders as well as other end-users that want confidence in the integrity of waterproofed areas without leaving a large carbon footprint.</p>
						  </div>
						 
						</div>
					  </div>
					</div>
				 </div>
			 </div>
			 <div class="we_are_section col-lg-3 col-md-3 col-sm-3">
			      <div class="block">
				      <i class="fa fa-industry" aria-hidden="true"></i>
				      <h4>Manufacturing Facilities</h4>
					 <p>Australian manufacturing for over <?php echo (int)DUROTECH_YEARS; ?> years Local quality control to ensure consistent products.... </p>
					  <button type="button" class="read-more-trigger" data-toggle="modal" data-target="#basicModal_2">READ MORE</button>
					 <div class="modal fade" id="basicModal_2" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel2">
					  <div class="modal-dialog">
						<div class="modal-content">
						  <div class="modal-header">
							<h4 class="modal-title" id="basicModalLabel2">Manufacturing Facilities</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						  </div>
						  <div class="modal-body">
							<p>Australian manufacturing for over <?php echo (int)DUROTECH_YEARS; ?> years Local quality control to ensure consistent products Large production capacity 400,000 Litres monthly production capacity Customised formulation to customer specific solutions .</p>
						  </div>
						 
						</div>
					  </div>
					</div>
				  </div>
			 </div>
			 <div class="we_are_section col-lg-3 col-md-3 col-sm-3">
			      <div class="block">
				       <i class="fa fa-headphones" aria-hidden="true"></i>
				       <h4>Support systems</h4>
					 <p>Specification &amp; design services Onsite and in house QA and technical suppor.... </p>
					  <button type="button" class="read-more-trigger" data-toggle="modal" data-target="#basicModal_3">READ MORE</button>
					 <div class="modal fade" id="basicModal_3" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel3">
					  <div class="modal-dialog">
						<div class="modal-content">
						  <div class="modal-header">
							<h4 class="modal-title" id="basicModalLabel3">Support Systems</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						  </div>
						  <div class="modal-body">
							<p>Specification &amp; design services Onsite and in house QA and technical support End to end solution from manufacturing to accessories. Innovative research and design using the latest technology Long history over <?php echo (int)DUROTECH_YEARS; ?> years of proven technologies.</p>
						  </div>
						 
						</div>
					  </div>
					</div>
				  </div>
			 </div>
			 </div>
			 
		</div>
		
		<!--div class="about_director col-lg-12 col-md-12 col-sm-12">
		      <div class="container">
		      <div class="col-lg-6 col-md-6 col-sm-6">
			      <div class="zoom-effect-container">
					  <div class="image-card">
						  <img src="<?php echo SITEURL ;?>customdurotech/images/kal_img.jpg"/>
						  <h5>Business Manager</h5>
						  <p>Durotech industries is a leading manufacturer and supplier of waterproofing products. Durotech waterproofing products have been widely used in the construction industry for the sealing of wet areas, decks, roofs and other substrates providing protection against moisture and weather damage for over <?php echo (int)DUROTECH_YEARS; ?> years.</p>
					  </div>
				  </div>
			  </div>
			  <div class="col-lg-6 col-md-6 col-sm-6">
			      <div class="zoom-effect-container">
					  <div class="image-card">
						 <img src="<?php echo SITEURL ;?>customdurotech/images/varan_img.jpg"/>
						  <h5>Business Manager</h5>
						  <p>Durotech industries is a leading manufacturer and supplier of waterproofing products. Durotech waterproofing products have been widely used in the construction industry for the sealing of wet areas, decks, roofs and other substrates providing protection against moisture and weather damage for over <?php echo (int)DUROTECH_YEARS; ?> years.</p>
					  </div>
				  </div>
			  </div>
			  </div>
		</div-->
	</div><!-- .page-about-wrap -->

    <div class="about-readmore-popup" id="aboutReadMorePopup" aria-hidden="true">
        <div class="about-readmore-popup__header">
            <h4 class="about-readmore-popup__title" id="aboutReadMoreTitle"></h4>
            <button type="button" class="about-readmore-popup__close" id="aboutReadMoreClose" aria-label="Close">&times;</button>
        </div>
        <div class="about-readmore-popup__body" id="aboutReadMoreBody"></div>
    </div>

<script>
jQuery(function($) {
    var $popup = $('#aboutReadMorePopup');
    var $title = $('#aboutReadMoreTitle');
    var $body = $('#aboutReadMoreBody');

    // Prevent Bootstrap modal from taking over these buttons.
    $('.read-more-trigger').removeAttr('data-toggle').removeAttr('data-target');

    $('.read-more-trigger').on('click', function(e) {
        e.preventDefault();
        var $block = $(this).closest('.block');
        var heading = $.trim($block.find('h4').first().text());
        var content = $.trim($block.find('.modal .modal-body p').first().text());
        $title.text(heading);
        $body.text(content);
        $popup.show().attr('aria-hidden', 'false');
    });

    function closePopup() {
        $popup.hide().attr('aria-hidden', 'true');
    }

    $('#aboutReadMoreClose').on('click', closePopup);

    $(document).on('click', function(e) {
        if ($popup.is(':visible') && !$(e.target).closest('#aboutReadMorePopup, .read-more-trigger').length) {
            closePopup();
        }
    });

    $(document).on('keydown', function(e) {
        if (e.key === 'Escape') {
            closePopup();
        }
    });
});
</script>