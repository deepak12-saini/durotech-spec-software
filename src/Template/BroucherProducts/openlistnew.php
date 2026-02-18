<style>
.product_image_section {
	text-align: center;
}
footer {
	padding-top: 50px;
}
.durotech_product {
    padding-top: 1%;
}
.instrcution ul li {
	background: #000;
	color: #fff;
	padding: 5px 24px;
	margin-left: -38px;
	border-bottom: 1px solid #fff;	
}
.userarea ul li {
	background: #478cc0;
	color: #fff;
	padding: 5px 24px;
	margin-left: -38px;
	border-bottom: 1px solid #fff;	
	font-size: 12px;
}
.banner_durolab{ display:none; }
.header_fixed{ display:none; }
.footer_section {
	width: 100%;
	float: left;
	display: none;
}
</style>
<div class="banner_durolab col-lg-12 col-md-12 col-sm-12">
	<!--img src="<?php echo SITEURL; ?>customdurotech/images/slider/banner_5.png"-->
</div>

	<div class="container">
		<div class="durotech_product col-lg-12 col-md-12 col-sm-12">     
      <div class="row">
	 
	 
	  
		<!--div class="product_filter col-lg-3 col-md-3 col-sm-3">
				
			   <div class="filter_brand">
			       <h3>Filter by Categories</h3>
				   <ul>
					<?php foreach($BorucherCategory as $categorys){ ?>
						<li><a href="<?php echo SITEURL.'broucher_products/openlistcate/'.$categorys['BorucherCategory']['slug'];?>"><?php echo $categorys['BorucherCategory']['title'];?></a></li>				       
					<?php } ?>
			       </ul>
			  
			  </div>
			  
		</div-->	

		<?php 
		
		if(!empty($BroucherProductListArr)){  ?>	
			<div class="product_list col-lg-12 col-md-12 col-sm-12">	
			
			<?php 
			
				foreach($BroucherProductListArr as $products){
				if(!empty($products['BroucherProduct']) && ($products['BorucherCategory']['title'] != 'other')){
			?>
			<div class="product_list col-lg-12 col-md-12 col-sm-12">	
			 <h3 style="text-align: left;text-decoration: underline;color: red;"><?php echo $products['BorucherCategory']['title'];?></h3>	
				<?php		
				foreach($products['BroucherProduct'] as $product){ 
				
				?>
					<div class="col-lg-6 col-md-6 col-sm-6" style="height:290px;">
					<div class="product_page_list_section col-lg-3 col-md-3 col-sm-3">
						<?php if($product['is_image'] == '250250-defult.png' || $product['is_image'] == 1){ ?>	
							<div style="padding-top:100px; width:250px !important; height:250px !important; color:#000 !important;">
								<span style="font-size:25px; font-weight:bold; color:  #2889c9 !important;">
								<?php 
								echo $product['title'] ?></span>
							</div>
						<?php }else{ ?>
							<div style="max-width:100px"><img src="<?php echo SITEURL.'productimg/'.$product['image']?>" alt="<?php echo $product['title'] ?>" style="width:100% !important;" /></div>
						<?php } ?>
						<div style="max-width:100px; margin-top: 30px;"><img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?php echo SITEURL.'broucher_products/openlist/'.$product['slug']?>" alt="<?php echo $product['title'] ?>" style="width:100% !important;" /></div>
								
					</div>
					<div class="col-lg-5 col-md-5 col-sm-5">
						<a href="<?php echo SITEURL.'broucher_products/openlist/'.$product['slug']; ?>">
						<h2 style="border-bottom: 0px solid #fff;font-weight: bold; font-size:22px;"> 
							<span>	
							<?php 
								$exp = explode('(',$product['title']);
								echo $exp[0].'<small>('.$exp[1].'</small>'; 
							?>
							</span>
						</h2>
						</a>	
						<p><?php echo $product['brief_description'] ?></p>
						<div class="instrcution">
							<?php echo $product['instruction']; ?>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4">
						<h2 style="border-bottom: 0px solid #fff;font-weight: bold; font-size:22px;"> <span>User Area</span></h2>
						
						<div class="userarea">							
							<?php echo $product['userarea']; ?>
						</div>
					</div>
				</div>
			<?php }?>
			</div>
			<?php }	} ?>   
		</div>
		<?php } ?>	
				
		</div>
	</div>
	</div>