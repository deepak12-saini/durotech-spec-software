<script type="text/javascript" src="<?php echo SITEURL ;?>fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="<?php echo SITEURL ;?>fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />
<script type="text/javascript" src="<?php echo SITEURL ;?>fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.fancybox').fancybox();
		
		
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
</style>

<script src='<?php echo SITEURL ;?>jquery.elevatezoom.js'></script>

<div class="banner_durolab col-lg-12 col-md-12 col-sm-12">
	 <img src="<?php echo SITEURL ;?>customdurotech/images/durotoll_banner.jpg">
</div>
<div class="container">	  
<div class="durotech_product_detail col-lg-12 col-md-12 col-sm-12">
     
      <div class="row">
	  <h3><?php echo $products['Product']['title']; ?></h3>
     
	  
	  <div class="product_list col-lg-9 col-md-9 col-sm-9">
	
	  <div class="product_image_section col-lg-12 col-md-12 col-sm-12">
	       <div class="product_page_detail_image_section col-lg-4 col-md-4 col-sm-4">
			<?php if($products['Product']['image'] == '250250-defult.png' ||  $products['Product']['is_image'] == 1){ ?>	
			<div class="product_detail_image" style="padding:90px 10px; width:280px !important; height:250px !important; color:#000 !important;text-align: center;background: #f2f2f2;">				
				<span style="font-size:25px; font-weight:bold; color:  #2889c9 !important;text-align: center !important;"><?php echo $products['Product']['title'] ?></span>			
			 </div>
			<?php }else{ ?>
			<div class="product_detail_image">
				 <a class="fancybox" href="<?php echo SITEURL.'productimg/'.$products['Product']['image']?>" title="<?php echo $products['Product']['title']; ?>" > <img src="<?php echo SITEURL.'productimg/'.$products['Product']['image']?>" alt="<?php echo $products['Product']['title']; ?>"  class="img-responsive">	 </a>   
			 </div>
			<?php } ?>	
		    <?php if(!empty($products['Project'])){ ?>
			<h3>Project Reference</h3>
			<div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="false">
			
			 <ol class="carousel-indicators">
				<?php $i=0; foreach($products['Project'] as $project){?>	
					<li data-target="#carousel-example-generic" data-slide-to="<?php echo  $i; ?>" <?php if($i==0){ ?>class="active" <?php } ?>></li>
				<?php  $i++; } ?>
			  </ol>

			  
			  <div class="carousel-inner">

				<?php
					$k=0;
					$class = 'item active srle';
					foreach($products['Project'] as $project){					
					if($k > 0){
						$class = 'item';
					}	
				?>	
				
				<div class="<?php echo $class; ?>">
				  <img src="<?php echo SITEURL.'productimg/'.$project['images'];?>" alt="1.jpg" class="img-responsive">
				  <div class="carousel-caption">

				  </div>
				</div>
				<?php $k++; } ?>
			  </div>
					
				<ul class="thumbnails-carousel clearfix">				
					<?php foreach($products['Project'] as $projectnew){	?>	
						<li style="border:1px solid #ddd;"><img src="<?php echo SITEURL.'productimg/'.$projectnew['images'];?>" style="width:48px; height:36px;" alt="1_tn.jpg"></li>
					<?php }  ?>
					
					
						
				</ul>
			</div>
			<?php } ?>
			<?php /* if(!empty($products['Project'])){ ?>
			<div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="false">
			
			  <ol class="carousel-indicators">
				<?php $i=0; foreach($products['Project'] as $project){?>	
					<li data-target="#carousel-example-generic" data-slide-to="<?php echo  $i; ?>" <?php if($i==0){ ?>class="active" <?php } ?>></li>
				<?php  $i++; } ?>
			  </ol>

			  
			  <div class="carousel-inner">
				<?php foreach($products['Project'] as $project){?>	
				<div class="item active srle">
				  <img src="<?php echo SITEURL.'productimg/'.$project['images'];?>" alt="<?php echo $products['Product']['title']; ?>" class="img-responsive">
				  <div class="carousel-caption">				
				  </div>
				</div>
				<?php } ?>
			  </div>			 
			  <ul class="thumbnails-carousel clearfix">
				<?php foreach($products['Project'] as $project){?>
				<li><img src="<?php echo SITEURL.'productimg/'.$project['images'];?>" alt="<?php echo $products['Product']['title']; ?>"></li>
				<?php } ?>
			  </ul>
			</div>
			<?php } */ ?>
			
			  <?php if(!empty($products['Product']['video_url'])){ ?>
				  <div class="tab-video">
					<iframe src="<?php echo $products['Product']['video_url']; ?>"  style="width:100%; height:240px;"></iframe>
				  </div>
			  <?php  } ?>
		   </div>
		   
		   <div class="product_text_section col-lg-8 col-md-8 col-sm-8">
		       <p><?php echo strip_tags($products['Product']['description']) ?><a href="#myModal" class="btn btn-primary" data-toggle="modal">Read More</a></p>
			   <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
				  <div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					</div>
					<div class="modal-body">
					  <?php echo strip_tags($products['Product']['description']) ?>
					</div>
				  </div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			  </div><!-- /.modal -->
			  <?php 
				if($products['Product']['id'] == 137 || $products['Product']['id'] == 136  || $products['Product']['id'] == 135  || $products['Product']['id'] == 134){		
				}else{	
			  ?>
			   <div class="product_detail_download col-lg-12 col-md-12 col-sm-12">
		           <h4>Downloads</h4>
				    <div class="button-4 col-lg-3 col-md-3 col-sm-3">
						<div class="eff-4"></div>
						<?php if(!empty($products['Product']['datasheet'])){ ?>
							<a href="<?php echo $products['Product']['datasheet']; ?>" target="_blank">DataSheet Download</a>
						<?php }else{ ?>
							<a href="#myModal1" data-toggle="modal"  >DataSheet Download</a>
						<?php } ?>
					</div>
					<?php if($products['Product']['id'] == 93){ ?>
						<div class="button-4 col-lg-3 col-md-3 col-sm-3">
							<div class="eff-4"></div>
							<a href="<?php echo SITEURL ?>wp-content/uploads/datasheet/Dow Durotech Brochure 8 pages.pdf" target="_blank">Dow Durotech Brochure</a>			
						</div>
						<div class="button-4 col-lg-3 col-md-3 col-sm-3">
							<div class="eff-4"></div>
							<a href="<?php echo SITEURL ?>wp-content/uploads/datasheet/7515 Sprayable Brochure (1).pdf" target="_blank">Sprayable Brochure</a>			
						</div>
					<?php } ?>
					
					<?php
					if(!empty($products['Product']['msds'])){  
						$msds = explode("##",$products['Product']['msds']);	
											
						if(count($msds) == 2){
							$msds_0 = $msds[0];
							$msds_1 = $msds[1];
						}else{
							$msds_0 = $msds[0];
						}	
						
						
					?>
					<?php if(!empty($msds_0)){	?>
						<div class="button-4 col-lg-3 col-md-3 col-sm-3">
							<div class="eff-4"></div>
								<a href="<?php echo $msds_0; ?>"  target="_blank">Msds-1 Download </a>						
						</div>
					<?php } ?>
					<?php if(!empty($msds_1)){	?>
						<div class="button-4 col-lg-3 col-md-3 col-sm-3">
							<div class="eff-4"></div>
							<a href="<?php echo $msds_1; ?>"  target="_blank">Msds-2 Download </a>						
						</div>
					<?php } ?>
					
					<?php  }else{ ?>
						<div class="button-4 col-lg-3 col-md-3 col-sm-3">
							<div class="eff-4"></div>
							<a href="#myModal2" data-toggle="modal" >Msds Download</a>
						</div>	
					<?php }   ?>
					
					<?php if(!empty($products['Product']['voc_pdf'])){ ?>
					<div class="button-4 col-lg-3 col-md-3 col-sm-3">
						<div class="eff-4"></div>
						<a href="<?php echo $products['Product']['voc_pdf']; ?>"  target="_blank">VOC Download</a>
					</div>
					<?php }  ?>
					
					
		       </div>
			   <?php } ?>
			   <?php if($products['Product']['id'] == 39){ ?>
					<div class="product_detail_download col-lg-12 col-md-12 col-sm-12">
						<div class="button-8 col-lg-8 col-md-8 col-sm-8">
							<div class="eff-8"></div>
							<a href="<?php echo SITEURL ?>/wp-content/uploads/A REPORT OF DEVELOPMENT OF SOLAR REFLECTIVE COATINGS_1.pdf" target="_blank">DEVELOPMENT OF SOLAR REFLECTIVE COATINGS</a>			
						</div>
					</div>					
				<?php } ?>
			   
			    <div class="features_tab">
			     <h3>Features</h3>
                 <ul>
				     <?php echo $products['Product']['feature']; ?>
				 </ul>
				</div>
			  
			  
			  <div class="area_tab">
			  <h3>Area Used</h3>
			      <ul>
				      <?php echo $products['Product']['userarea']; ?>
				  </ul>
			  </div>
			  
			  <div class="instruction_tab">
			    <h3>Instruction</h3>
                <ul>
				<?php if(!empty($products['Product']['instruction'])){ ?>
				    <?php echo $product_arr['Product']['instruction']?>					
				<?php  }else{ echo '<p> No Instruction Available</p>'; }?>			
				 </ul>
			  </div>
			</div>	   
		</div>
	</div>  
	  <div class="product_filter col-lg-3 col-md-3 col-sm-3">
			<div class="product_search">
			  <form action="<?php echo SITEURL.'products/search'?>" method="get">
				<input type="search" name="search" placeholder="Search Product" required>
				<input type="submit"  class="btn btn-primary" value="Search">
			  </form>
			</div>
			
			   <div class="filter_brand">
			       <h3 style="margin-top:0px !important">Filter by Categories</h3>
				   <ul>
				       <?php foreach($category as $categorys){ ?>
						<li><a href="<?php echo SITEURL.'category/'.$categorys['Category']['slug'];?>"><?php echo $categorys['Category']['category_name'];?> <span>(<?php echo COUNT($categorys['Product']);?>)</span></a></li>				       
					<?php } ?>
			       </ul>
			  
			  </div>
			  
	  </div>
	  
	  </div>

</div>
</div>
     <div class="related_product_detail_page col-lg-12 col-md-12 col-sm-12">
	      <div class="container">
		       <h3>Related Products</h3>
			   <?php foreach($random as $randoms){ ?>
				<a href="<?php echo SITEURL.'products/detail/'.$randoms['products']['slug'];?>">
				<div class="product_page_list_section col-lg-3 col-md-3 col-sm-3">
					<figure class="snip0077 blue">
						<img src="<?php echo SITEURL.'productimg/'.$randoms['products']['image']; ?>" alt="<?php echo $randoms['products']['title']; ?>"  style="width:250px; height:250px;"/>
						<figcaption>
						<h2><?php echo $randoms['products']['title']; ?></h2>

						</figcaption>
						<?php //echo $randoms['products']['title']; ?>
					</figure>				
				</div>
				</a>
				<?php } ?>	


		  </div>
     </div>	

	 <script>
	$(document).ready(function(){ 
	 // thumbnails.carousel.js jQuery plugin
;(function(window, $, undefined) {

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

		if(!conf.backgroundControl) {
			cache.$carouselContainer.find('.carousel-control').addClass('controls-background-reset');
		}
		else {
			cache.$controls.height(cache.$carouselContainer.find('.carousel-inner').height());
		}

		if(conf.center) {
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

		cache.$thumbnailsLi.click(function(){
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

$('.thumbnails-carousel').thumbnailsCarousel();

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