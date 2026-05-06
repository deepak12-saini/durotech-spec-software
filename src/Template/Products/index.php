<style>
.product_image_section {
	text-align: center;
	padding: 0px 5%;
}
footer {
	padding-top: 50px;
}

.product_search{ text-align:center; }
.ptitle {   
    color: #50d9b9;
    text-align: center;
    font-size: 17px;
    font-weight: 600;
}
.ctitle{
	padding: 0px 65px;
	color: #000;   
    font-size: 17px;
    font-weight: 500;
}
input[type="search"] {
	background: #fff url(https://static.tumblr.com/ftv85bp/MIXmud4tx/search-icon.png) no-repeat 9px center;	
	width: 150px;	
	margin-left: 52px;
}
.borderdiv{
    border: 1px solid #ddd;
    margin-top: 46px;
}
a{ color:#777797; }
a:focus, a:hover {
    color: #23527c;
    text-decoration: none;
    font-weight: 600;
}
.modal-content p:hover {
       text-align: left;
}
.borderleft{ border-left:1px solid #000; }
@media screen and (max-width: 768px) {
	.product_image_section {
		padding: 0px 1%;
	}
	input[type="search"] { width: 78%; margin-left: 0px; }
	.product_search{ text-align:center;  }
	
	.borderdiv{
		border: 1px solid #ddd;
		margin-top: 130px;
	}
	.ctitle {
		padding: 0px 18px;
		color: #000;
		font-size: 17px;
		font-weight: 500;
		margin-top: 20px;
	}
	figure.snip0077{
		margin:10px 0%;
	}
}
</style>
<div class="banner_durolab col-lg-12 col-md-12 col-sm-12">
	<!--img src="<?php echo SITEURL; ?>customdurotech/images/slider/banner_5.png"-->
</div>
	<!-- Modal -->
	<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="false">
	  <div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
		  <div class="modal-header mobilemodal">
			<h5 class="modal-title" id="exampleModalLongTitle1">Filter by Categories <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button></h5>
			
		  </div>
		  <div class="modal-body">				
				<div class="row">
				<?php $i=0; foreach($category as $categorys){
				
				?>
					<div class="col-lg-6 col-md-6 col-sm-6">
						<p><a href="<?= h($this->Url->build('/category/' . ($categorys['Category']['slug'] ?? ''))) ?>"><?= h($categorys['Category']['category_name'] ?? '') ?></a></p>
					</div>		       
				<?php $i++;  } ?>
			   </div>
		  </div>
		</div>
	  </div>
	</div>

	<div class="container">
		<?php if (!empty($isProductListingHome)): ?>
		<div class="row" style="margin-bottom:24px;">
			<div class="col-lg-12 col-md-12 col-sm-12">
				<h1 class="ptitle" style="margin-top:24px; margin-bottom:12px;">Waterproofing Products &amp; Membranes</h1>
				<p style="font-size:15px; line-height:1.6; color:#333;">Browse our range of Australian-made waterproofing membranes, sealants and construction coatings. We supply builders, contractors and specifiers across Sydney, Melbourne, Brisbane and Australia. Choose a category below or use the filter to find the right product for your project. For specifications and technical support, <a href="<?= h($this->Url->build('/contact')) ?>">contact us</a> or view our <a href="<?= h($this->Url->build('/terrace-waterproofing')) ?>">terrace waterproofing</a> and <a href="<?= h($this->Url->build('/retaining-walls')) ?>">retaining wall</a> solutions.</p>
			</div>
		</div>
		<?php else: ?>
		<div class="row" style="margin-bottom:12px;">
			<div class="col-lg-12 col-md-12 col-sm-12">
				<h1 class="ptitle" style="margin-top:24px; margin-bottom:8px;"><?= h($category_name ?? 'Products') ?></h1>
			</div>
		</div>
		<?php endif; ?>
		<div class="durotech_product col-lg-12 col-md-12 col-sm-12">     
			<div class="row">
			
				<div class="product_list col-lg-12 col-md-12 col-sm-12">	
					<div class="col-lg-4 col-md-4 col-sm-4">
						<p class="ctitle"><a href="#null"  data-toggle="modal" data-target="#exampleModalCenter"><img src="<?= h(SITEURL) ?>img/menu.png" alt=""></a> &nbsp;&nbsp; Category</p>
					</div>
					
					<div class="col-lg-4 col-md-4 col-sm-4">
						<p class="ptitle"><?= h(ucfirst($category_name ?? '')) ?></p>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4">
						<div class="product_search">
							<?= $this->Form->create(null, ['url' => ['controller' => 'Products', 'action' => 'search'], 'method' => 'get']) ?>
								<input type="search" name="search" placeholder="Search Product" required>
							<?= $this->Form->end() ?>
						</div>
					</div>
					
				</div>	
				
				<div class="borderdiv"></div>	

				<?php  if(!empty($products)){  ?>	
				<div class="product_list col-lg-12 col-md-12 col-sm-12">	
					<p><?= $this->Flash->render() ?></p>
					<div class="product_image_section col-lg-12 col-md-12 col-sm-12">
						<?php 
						foreach($products as $product){ 
							$strlen = strlen($product['Product']['brief_description']);
						?>
						<a href="<?= h($this->Url->build('/product/' . ($product['Product']['slug'] ?? ''))) ?>">
						<div class="product_page_list_section col-lg-4 col-md-4 col-sm-4">
						
							<figure class="snip0077 blue">
							<?php if(($product['Product']['is_image'] ?? '') == '250250-defult.png' || ($product['Product']['is_image'] ?? '') == 1){ ?>
								<div style="padding-top:100px; width:250px !important; height:250px !important; color:#000 !important;">
									<span style="font-size:25px; font-weight:bold; color:  #2889c9 !important;"><?= h($product['Product']['title'] ?? '') ?></span>
								</div>
							<?php }else{ ?>
								<img src="<?= h(SITEURL) ?>productimg/<?= h($product['Product']['image'] ?? '') ?>" alt="<?= h($product['Product']['title'] ?? '') ?>" style="width:250px !important; height:250px !important;" />
							<?php } ?>	
							<figcaption>
								<h2> <span><?= h($product['Product']['title'] ?? '') ?></span></h2>
							</figcaption>	
								
							</figure>
							<h2 style="color:#777797; font-weight:500; border-bottom-color:#fff;"><?= h($product['Product']['title'] ?? '') ?></h2>				
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