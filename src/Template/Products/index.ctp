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
    color: #5a1ea8;
    text-align: center;
    font-size: 17px;
    font-weight: 600;
}
.ctitle{
	padding: 0px 65px;
	color: #5a1ea8;   
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
.product_page_list_section {
	background: #ffffff;
	border-radius: 14px;
	box-shadow: 0 4px 14px rgba(0,0,0,0.08);
	padding: 12px 12px 18px;
	margin-bottom: 20px;
	transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.product_page_list_section:hover {
	transform: translateY(-4px);
	box-shadow: 0 10px 26px rgba(0,0,0,0.14);
}
.product_page_list_section h2 {
	font-size: 15px;
	margin-top: 10px;
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
.durotech_product,
.product_list,
.product_image_section {
	background: #e4edf4;
}
.products-bg-wrap {
	background: #e4edf4;
	padding: 12px 0 24px;
}
.category-hero {
	background: #e4edf4;
	border-radius: 10px;
	padding: 22px;
	margin-bottom: 18px;
	box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
}
.category-hero__content {
	display: flex;
	flex-direction: column;
	justify-content: center;
	min-height: 260px;
}
.category-hero__img-wrap {
	text-align: center;
}
.category-hero__img {
	width: 100%;
	height: 260px;
	object-fit: cover;
	border-radius: 8px;
	background: #f5f5f5;
}
.category-hero__title {
	margin: 0 0 8px;
	color: #5a1ea8;
	font-size: 26px;
	font-weight: 700;
}
.category-hero__desc {
	margin: 0;
	font-size: 15px;
	line-height: 1.7;
	color: #536f8c;
}
@media screen and (max-width: 768px) {
	.product_image_section {
		padding: 0px 1%;
	}
	/* Hide duplicate text heading on mobile – hero title already visible */
	.ptitle {
		display: none;
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
	.category-hero {
		padding: 16px;
	}
	.category-hero__content {
		min-height: 0;
	}
	.category-hero__title {
		font-size: 21px;
		margin-top: 0;
	}
	.category-hero__img {
		height: 200px;
		margin-top: 14px;
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
				<?php $categoryList = (isset($category) && is_array($category)) ? $category : []; $i=0; foreach($categoryList as $categorys){
				
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

	<div class="products-bg-wrap">
	<div class="container">
		<?php
			$currentCategoryData = $currentCategory['Category'] ?? [];
			$categoryDescription = trim((string)($currentCategoryData['description'] ?? ''));
			$categoryImage = trim((string)($currentCategoryData['category_page_image'] ?? ''));
			if ($categoryImage === '') {
				$categoryImage = trim((string)($currentCategoryData['image'] ?? ''));
			}
			$hasCategoryImage = $categoryImage !== '' && $categoryImage !== '250250-defult.png';
		?>
		<?php if (empty($isProductListingHome) && ($hasCategoryImage || $categoryDescription !== '')): ?>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="category-hero">
					<div class="row">
						<?php if ($hasCategoryImage): ?>
						<div class="col-lg-6 col-md-6 col-sm-12 category-hero__content">
						<?php else: ?>
						<div class="col-lg-12 col-md-12 col-sm-12 category-hero__content">
						<?php endif; ?>
							<h2 class="category-hero__title"><?= h($category_name ?? 'Products') ?></h2>
							<p class="category-hero__desc"><?= nl2br(h($categoryDescription)) ?></p>
						</div>
						<?php if ($hasCategoryImage): ?>
						<div class="col-lg-6 col-md-6 col-sm-12 category-hero__img-wrap">
							<img src="<?= h($this->Url->build('/files/category/' . $categoryImage)) ?>" alt="<?= h($category_name ?? 'Category image') ?>" class="category-hero__img">
						</div>
						<?php endif; ?>
					</div>
				</div>
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
	</div>