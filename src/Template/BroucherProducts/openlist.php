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
}
.userarea{ margin-top:33px;}
.product_page_list_section{  margin-top: 75px; }
.button-4 {
    width: 194px;
    margin: 0 0 40px 3%;
}
.button-4:hover .eff-4 {
    left: 0px;
}
.eff-4 {
    width: 190px;
}	
@media (min-width: 768px){
.userarea{ margin-top:33px;}
.product_page_list_section{  margin-top: 10px; }
}
</style>
<div class="banner_durolab col-lg-12 col-md-12 col-sm-12">
	<!--img src="<?php echo SITEURL; ?>customdurotech/images/slider/banner_5.png"-->
</div>
<a data-toggle="modal" data-target="#myModal" id="targetmyModal" href="javascript:void(0);">&nbsp;</a>
	<div class="container">
		<div class="durotech_product col-lg-12 col-md-12 col-sm-12">     
      <div class="row">
	 
	  <h3><?php echo ucfirst($BroucherProduct['BorucherCategory']['title']); ?></h3>
	  
			<div class="product_filter col-lg-3 col-md-3 col-sm-3">
				<!--div class="product_search">
					<form action="<?php echo SITEURL.'products/search'?>" method="post">
						<input type="search" name="search" placeholder="Search Product" required>
						<input type="submit"  class="btn btn-primary" value="Search">
					</form>
				</div-->
			
			  
			   <div class="filter_brand">
			       <h3>Filter by Categories</h3>
				   <ul>
					<?php foreach($BorucherCategory as $categorys){ ?>
						<li><a href="<?php echo SITEURL.'broucher_products/openlistcate/'.$categorys['BorucherCategory']['slug'];?>"><?php echo $categorys['BorucherCategory']['title'];?></a></li>				       
					<?php } ?>
			       </ul>
			  
			  </div>
			  
		</div>	

		<?php if(!empty($BroucherProductListArr)){  ?>	
			<div class="product_list col-lg-9 col-md-9 col-sm-9">	
			<p> <?php echo $this->Flash->render(); ?><p>
			<?php 
				foreach($BroucherProductListArr as $product){ 
					
				?>
				<div class="col-lg-12 col-md-12 col-sm-12">
					<div class="product_page_list_section col-lg-4 col-md-4 col-sm-4">
						<?php if($product['BroucherProduct']['is_image'] == '250250-defult.png' || $product['BroucherProduct']['is_image'] == 1){ ?>	
								<a href="<?php echo SITEURL.'broucher_products/detail/'.$product['BroucherProduct']['slug']; ?>"><div style="padding-top:100px; width:250px !important; height:250px !important; color:#000 !important;"></a>	
								<span style="font-size:25px; font-weight:bold; color:  #2889c9 !important;">
								<?php 
								echo $product['BroucherProduct']['title'] ?></span>
							</div>
						<?php }else{ ?>
								<a href="<?php echo SITEURL.'broucher_products/detail/'.$product['BroucherProduct']['slug']; ?>"><img src="<?php echo SITEURL.'productimg/'.$product['BroucherProduct']['image']?>" alt="<?php echo $product['BroucherProduct']['title'] ?>" style="width:250px !important; height:250px !important;" /></a>	
						<?php } ?>					  
											
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4">
						<a href="<?php echo SITEURL.'broucher_products/detail/'.$product['BroucherProduct']['slug']; ?>">
						<h2 style="border-bottom: 0px solid #fff;font-weight: bold; font-size:22px;"> 
							<span>	
							<?php 
								$exp = explode('(',$product['BroucherProduct']['title']);
								echo $exp[0].'<small>('.$exp[1].'</small>'; 
							?>
							</span>
						</h2>
						</a>	
						<p style="font-weight: bold;"><?php echo $product['BroucherProduct']['brief_description'] ?></p>
						<div class="instrcution">
							<?php echo $product['BroucherProduct']['instruction']; ?>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4">
						<h2 style="border-bottom: 0px solid #fff;font-weight: bold; font-size:22px;"> <span>User Area</span></h2>
						
						<div class="userarea">							
							<?php echo $product['BroucherProduct']['userarea']; ?>
						</div>
					</div>
				</div>
			<?php } ?>   
			</div>
		<?php }else{ ?>
			<div class="product_list col-lg-9 col-md-9 col-sm-9" style="text-align:center;">
				Coming Soon
			</div>
		<?php  } ?>	
				
		</div>
	</div>
	</div>
	

<div id="myModal" class="modal fade" role="dialog" style="display: block;margin-top: -89px;">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="text-align:center;"><?php echo $BroucherProduct['BroucherProduct']['title']; ?></h4>
      </div>
      <div class="modal-body"  style="padding:0px;">
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="product_page_list_section col-lg-4 col-md-4 col-sm-4" >
					<?php if($BroucherProduct['BroucherProduct']['is_image'] == '250250-defult.png' || $BroucherProduct['BroucherProduct']['is_image'] == 1){ ?>	
						<div style="padding-top:100px; width:250px !important; height:250px !important; color:#000 !important;">
							<span style="font-size:25px; font-weight:bold; color:  #2889c9 !important;">
							<?php 
							echo $BroucherProduct['BroucherProduct']['title'] ?></span>
						</div>
					<?php }else{ ?>
						<a href="<?php echo SITEURL.'broucher_products/detail/'.$BroucherProduct['BroucherProduct']['slug']; ?>"><img src="<?php echo SITEURL.'productimg/'.$BroucherProduct['BroucherProduct']['image']?>" alt="<?php echo $BroucherProduct['BroucherProduct']['title'] ?>" style="width:100% !important;" /></a>	
					<?php } ?>					  
										
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4">
					<a href="<?php echo SITEURL.'broucher_products/detail/'.$BroucherProduct['BroucherProduct']['slug']; ?>">
					<h2 style="border-bottom: 0px solid #fff;font-weight: bold; font-size:22px;"> 
						<span>	
						<?php 
							$exp = explode('(',$BroucherProduct['BroucherProduct']['title']);
							echo $exp[0].'<small>('.$exp[1].'</small>'; 
						?>
						</span>
					</h2>
					</a>	
					<!--p style="font-weight: bold;"><?php echo $BroucherProduct['BroucherProduct']['brief_description'] ?></p-->
					<div class="instrcution">
						<?php echo $BroucherProduct['BroucherProduct']['instruction']; ?>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4">
					<h2 style="border-bottom: 0px solid #fff;font-weight: bold; font-size:22px;"> <span>User Area</span></h2>
					
					<div class="userarea">							
						<?php echo $BroucherProduct['BroucherProduct']['userarea']; ?>
					</div>
				</div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12">
			<h2 style="border-bottom: 0px solid #fff;font-weight: bold; font-size:16px; text-align:center;"> Downloads</h2>
			<div class="col-lg-1 col-md-1 col-sm-1" style="margin-left: 28px;"></div>	
			<div class="button-4 col-lg-3 col-md-3 col-sm-3">
				<div class="eff-4"></div>
				<?php if(!empty($BroucherProduct['BroucherProduct']['datasheet'])){ ?>
					<a href="<?php echo $BroucherProduct['BroucherProduct']['datasheet']; ?>" target="_blank">DataSheet Download</a>
				<?php }else{ ?>
					<a href="#myModal1" data-toggle="modal"  >DataSheet Download</a>
				<?php } ?>				
			</div>						
			<div class="button-4 col-lg-3 col-md-3 col-sm-3">
				<div class="eff-4"></div>
				<?php
					if(!empty($BroucherProduct['BroucherProduct']['msds'])){  
						$msds = explode("##",$BroucherProduct['BroucherProduct']['msds']);	
											
						if(count($msds) == 2){
							$msds_0 = $msds[0];
							$msds_1 = $msds[1];
						}else{
							$msds_0 = $msds[0];
						}
					}						
					?>
				<?php if(!empty($msds_0)){ ?>
					<a href="<?php echo $msds_0; ?>" target="_blank">Msds-1 Download</a>
				<?php }else{ ?>
					<a href="#myModal1" data-toggle="modal"  >Msds-1 Download</a>
				<?php } ?>
										
			</div>
		</div>
      </div>
      <div class="modal-footer">
        <!--button type="button" class="btn btn-default" data-dismiss="modal">Close</button-->
      </div>
    </div>
	</div>
</div>

<script>
	$(document).ready(function(){
		$("#targetmyModal").trigger('click');
	});
</script>