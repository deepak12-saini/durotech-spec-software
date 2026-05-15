<style>
/* Offset for fixed header is on .banner_durolab via customduro_header.js — no extra wrapper padding (avoids double gap). */
.page-durolab-wrap {
    padding-top: 0;
}
.banner_durolab {
    overflow: visible;
    display: block;
    margin-top: 0;
    margin-bottom: 0;
    padding-top: 0;
    padding-bottom: 0;
}
.banner_durolab img {
    display: block;
    width: 100%;
    height: auto;
    vertical-align: top;
}
/* DuroLab project gallery: CSS Grid (equal thirds, centred — avoids Bootstrap row float / margin drift) */
.durolab-project-gallery {
    display: block;
    width: 100%;
    max-width: 1200px;
    margin-left: auto;
    margin-right: auto;
    padding: 28px 16px 48px;
    box-sizing: border-box;
    float: none;
    clear: both;
}
.durolab-project-gallery .durolab-project-heading {
    text-align: center;
    font-size: 22px;
    font-weight: 600;
    color: #1a3d52;
    margin: 0 0 24px 0;
    letter-spacing: 0.02em;
}
.durolab-project-gallery .durolab-project-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 20px;
    width: 100%;
    margin: 0;
    padding: 0;
}
@media (max-width: 991px) {
    .durolab-project-gallery .durolab-project-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}
@media (max-width: 575px) {
    .durolab-project-gallery .durolab-project-grid {
        grid-template-columns: minmax(0, 1fr);
    }
}
.durolab-project-gallery .durolab-project-tile {
    padding: 0;
    margin: 0;
    min-width: 0;
    width: auto;
    float: none;
}
/* 3D flip (scoped — same idea as legacy .project .card) */
.durolab-project-gallery .durolab-flip {
    perspective: 700px;
    height: 280px;
}
@media (min-width: 992px) {
    .durolab-project-gallery .durolab-flip {
        height: 300px;
    }
}
.durolab-project-gallery .durolab-flip-inner {
    position: relative;
    width: 100%;
    height: 100%;
    transition: transform 0.55s ease;
    transform-style: preserve-3d;
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
}
.durolab-project-gallery .durolab-flip:hover .durolab-flip-inner {
    transform: rotateY(180deg);
}
.durolab-project-gallery .durolab-flip-face {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    backface-visibility: hidden;
    -webkit-backface-visibility: hidden;
    border-radius: 12px;
    overflow: hidden;
    background: #ffffff;
}
.durolab-project-gallery .durolab-flip-face a {
    display: block;
    width: 100%;
    height: 100%;
    text-decoration: none;
}
.durolab-project-gallery .durolab-flip-face img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}
.durolab-project-gallery .durolab-flip-back {
    transform: rotateY(180deg);
    background: #03446a;
}
/* Standards/Test section alignment (layout-only; no color changes) */
.durolab-standards-intro {
    margin: 0 0 16px;
    line-height: 1.7;
}
.durolab-standards-grid {
    display: flex;
    flex-wrap: wrap;
    margin: 0 -12px;
}
.durolab-standards-grid .durolab_list {
    float: none;
    width: 50%;
    padding: 0 12px;
    margin-bottom: 10px;
    box-sizing: border-box;
}
.durolab-standards-grid .durolab_list strong {
    display: block;
    margin-bottom: 10px;
}
.durolab-standards-grid .durolab_list ul {
    margin: 0;
    padding-left: 18px;
    list-style-type: disc;
    list-style-position: outside;
}
.durolab-standards-grid .durolab_list li {
    margin-bottom: 6px;
    line-height: 1.6;
    display: list-item;
}
@media (max-width: 767px) {
    .durolab-standards-grid .durolab_list {
        width: 100%;
    }
}
body{background:url(<?php echo SITEURL.'img/'?>bg-4.png)}
</style>
<div class="page-durolab-wrap">
		<div class="banner_durolab col-lg-12 col-md-12 col-sm-12">
		     <img src="<?php echo SITEURL ;?>customdurotech/images/durolab_banner.jpg" alt="DuroLab">
		</div>
		<div class="durolab_page col-lg-12 col-md-12 col-sm-12">
		<div class="content lab col-lg-12 col-md-12 col-sm-12">
		     <div class="row">
		     <p>With the new age of a fast pace world its more important than ever to be able to stay one step ahead of the market. Its extremely important to make sure that when deciding which technologies you are chosing to use on your next project that you are partnering with the right people. At Durotech we make it our mission is to be at the front when choosing construction chemical products and solutions.</p>
			 </div>
		</div>
		
		<div class="duro_lab_content col-lg-12 col-md-12 col-sm-12">
		     <div class="duro_lab_content_heading col-lg-12 col-md-12 col-sm-12">
			     <h3>How do we stay at the front?</h3>
			 </div>
			
			 <div class="duro_lab_content_page col-lg-12 col-md-12 col-sm-12">
			     <p>After establishing in 1977 Durotech is now just over 45  years old making Durotech one of the Original Australian Made and Owned manufactures of construction chemicals. Durotech now 45 years later has cemented them selfs in the market as the most powerful Australian MADE and Australian OWNED companies. With 45 years comes allot of history, evidence and facts that Durotech does not only have some of the highest quality products it has the most Innovative products backed by an extremely well experienced and educated team off technical chemists and engineers. After 45 years Durotech has proven that its products have been designed and have latest some of the harshest conditions in the world….The Australian Sun. By manufacturing locally in Sydney Australia we are able to support our customers with local support and fast response times.

In todays market the Environment comes first. At Durotech we realise this and we ensure that we keep it that way. By utalising the latest research techniques Durotech Laboratory technical team Is able to develop a range of low VOC products and ULTRA low VOC products making these products not only safe for Australian conditions but being safe for global conditions as well.

While Durotech has its own testing laboratory, the Durotech range has also been externally tested as low VOC by an independent, nationally accredited Firm. By doing this Durotech has become the most environmental construction chemical supplier in Australia.

At Durotech 45 years ago DuroLab was establishing for one main purpose to support and show our responsibility to our customers and our country. Making QUALITY products was and still is our priority and continually Investing in the backbone of our company. DuroLab is where it all started and its where it will take us into the future.</p>



                  <div class="duro_lab_content_heading col-lg-12 col-md-12 col-sm-12">
			          <h3>Making Sure We Meet The Most Up to Date Standards</h3>
			      
			     <p class="durolab-standards-intro">Our State of the Art Laboratory is just one piece of the puzzle. The Other part is being sure we comply with all the latest and most up to date Australian standards. Being Australian Compliant is extremely strenuous and tough standard to comply to but with our state of the art testing facility and highly trained technical team our products pass with flying colors:</p>

				 <div class="durolab-standards-grid">
				 <div class="durolab_list col-lg-6 col-md-6 col-sm-6">
					 <strong>Some Of the Australian Standards we test to:</strong>
					 <ul>
						<li>AS4654.1 - Waterproofing Membrane Systems for External above ground use - materials</li>
						<li>AS4858 - Wet Area Membranes</li>
						<li>AS4020 - Products for use in contact with Drinking Water</li>
					 </ul>
				 </div>
				 <div class="durolab_list col-lg-6 col-md-6 col-sm-6">
					 <strong>Some Of the Test We perform:</strong>
					 <ul>
						<li>Abrasion Resistance</li>
						<li>Heat Ageing</li>
						<li>Bond Strength</li>
						<li>Temperature resistance</li>
						<li>Cyclic Movement</li>
						<li>Ultraviolet Resistance</li>
						<li>Dimensional Stability</li>
						<li>Tensile Strength</li>
						<li>Elongation at Break</li>
						<li>Thickness</li>
						<li>Field Seam Strength</li>
						<li>Durability</li>
						<li>Negative pressure rating</li>
						<li>Water Vapor Transmission rate</li>
						<li>AS4858 - Wet Area Membranes</li>
						<li>AS4020 - Products for use in contact with Drinking Water</li>
					 </ul>
				 </div>
                 </div>
			     </div>
				 


			 </div>
			
		</div>
		
        </div>
		<section class="durolab-project-gallery">
			<h3 class="durolab-project-heading">DuroProject Gallery</h3>
			<div class="durolab-project-grid">
				<?php
				$projectBase = rtrim(SITEURL, '/') . '/technical-literature/project';
				$imgBase = rtrim(SITEURL, '/') . '/customdurotech/images/';
				for ($pi = 1; $pi <= 6; $pi++) :
					$imgSrc = $imgBase . 'project_' . $pi . '.jpg';
					?>
				<div class="durolab-project-tile">
					<div class="durolab-flip">
						<div class="durolab-flip-inner">
							<div class="durolab-flip-face durolab-flip-front">
								<a href="<?php echo h($projectBase); ?>">
									<img src="<?php echo h($imgSrc); ?>" alt="Durotech project <?php echo (int)$pi; ?>">
								</a>
							</div>
							<div class="durolab-flip-face durolab-flip-back">
								<a href="<?php echo h($projectBase); ?>">
									<img src="<?php echo h($imgSrc); ?>" alt="Durotech project <?php echo (int)$pi; ?>">
								</a>
							</div>
						</div>
					</div>
				</div>
				<?php endfor; ?>
			</div>
		</section>

</div>
</div><!-- .page-durolab-wrap -->