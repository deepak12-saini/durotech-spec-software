<style>
.product_image_section {
	text-align: center;
}
footer {
	padding-top: 50px;
}
</style>
<div class="banner_durolab col-lg-12 col-md-12 col-sm-12">
	<!--img src="<?php echo SITEURL; ?>customdurotech/images/slider/banner_5.png"-->
</div>

	<div class="container">
		<div class="durotech_product col-lg-12 col-md-12 col-sm-12">     
      <div class="row">
	 
	  <h3><?php echo ucfirst($category_name); ?></h3>
	  
			<div class="product_filter col-lg-3 col-md-3 col-sm-3">
				<div class="product_search">
					<form action="<?php echo SITEURL.'products/search'?>" method="post">
						<input type="search" name="search" placeholder="Search Product" required>
						<input type="submit"  class="btn btn-primary" value="Search">
					</form>
				</div>
			
			  
			   <div class="filter_brand">
			       <h3>Filter by Categories</h3>
				   <ul>
					<?php foreach($category as $categorys){ ?>
						<li><a href="<?php echo SITEURL.'products/index/'.$categorys['Category']['slug'];?>"><?php echo $categorys['Category']['category_name'];?> <span>(<?php echo COUNT($categorys['Product']);?>)</span></a></li>				       
					<?php } ?>
			       </ul>
			  
			  </div>
			  
		</div>	

		<?php if(!empty($products)){  ?>	
			<div class="product_list col-lg-9 col-md-9 col-sm-9">	
			<p> <?php echo $this->Session->flash(); ?><p>
			<div class="product_image_section col-lg-12 col-md-12 col-sm-12">
				<?php 
				foreach($products as $product){ 
					$strlen = strlen($product['Product']['brief_description']);
				?>
				<a href="<?php echo SITEURL.'products/detail/'.$product['Product']['slug'];?>">
				<div class="product_page_list_section col-lg-4 col-md-4 col-sm-4">
				
				<figure class="snip0077 blue">
					<?php if($product['Product']['is_image'] == '250250-defult.png' || $product['Product']['is_image'] == 1){ ?>	
						<div style="padding-top:100px; width:250px !important; height:250px !important; color:#000 !important;">
							<span style="font-size:25px; font-weight:bold; color:  #2889c9 !important;"><?php echo $product['Product']['title'] ?></span>
						</div>
					<?php }else{ ?>
						<img src="<?php echo SITEURL.'productimg/'.$product['Product']['image']?>" alt="<?php echo $product['Product']['title'] ?>" style="width:250px !important; height:250px !important;" />
					<?php } ?>	
				  <figcaption>
					<h2> <span><?php echo $product['Product']['title'] ?></span></h2>				
				  </figcaption>				  
				</figure>				
				</div>
				</a>
			  	<?php } ?>   
			 </div>
			</div>
		<?php }else{ ?>
			<div class="product_list col-lg-9 col-md-9 col-sm-9" style="text-align:center;">
				Coming Soon
			</div>
		<?php  } ?>	
				
		</div>
	</div>
	</div>