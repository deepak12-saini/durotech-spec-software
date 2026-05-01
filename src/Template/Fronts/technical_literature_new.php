<script type="text/javascript" src="<?php echo SITEURL ;?>fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="<?php echo SITEURL ;?>fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />
<script type="text/javascript" src="<?php echo SITEURL ;?>fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.fancybox').fancybox();	
	});
</script>
<style>
.sidebar_cate{
	width:100%;
	background:#efefef;
	height:361px;
	margin-top:30px;
}
.item{ padding:5px; }

.sidebar_cate ul{ padding:2px 10px;  }
.sidebar_cate ul li{ padding:10px 10px; border-bottom: 1px solid #4085a2; font-weight: bold;}
.tab {  padding: 0px 0px; }
.image {
	padding-top: 1px;
	padding-bottom: 31px;
}
.card {
    height: 134px;
}
.cardimg {
	position: relative;
	width: 300px;
	max-width: 100%;
	height: 189px;
	overflow: hidden;
	box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
	float: left;
	margin-left: 67px;
	margin-bottom: 1px;
	background: #f2f2f2 !important;
}
.cardimg img {
	display: block;
	width: 100%;
	height: auto;
	max-height: 189px;
	object-fit: contain;
	object-position: center center;
}
.card h3 {
    font-size: 18px;
    padding-bottom: 20px;
    color: #4085a2;
    font-weight: bold;
}
.image a {
	font-size: 16px;
	color: #fff;
	font-weight: 500;
	border: 1px solid #1b4762;
	padding: 7px 16px;
	background: #1b4762;
	border-radius: 7px;
	display: inline-block;
	max-width: 100%;
	box-sizing: border-box;
}
.technical_literature .btn {
	max-width: 384px;
	width: 100%;
	box-sizing: border-box;
}
.technical_literature {
	background: #e4edf4;
}
.technical_literature .container_service {
	overflow-x: hidden;
}
/* One visual card per tile: image + title + button stay together on all screen sizes */
.tech-literature-tile {
	background: #fff;
	border: 1px solid #e4e4e4;
	border-radius: 10px;
	overflow: hidden;
	box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
	margin-bottom: 24px;
	width: 100%;
	box-sizing: border-box;
}
/* Full width inside column — .cardimg was 300px fixed, which left empty space on the right */
.tech-literature-tile .cardimg {
	float: none;
	margin: 0 !important;
	margin-left: 0 !important;
	margin-right: 0 !important;
	width: 100%;
	max-width: 100%;
	min-height: 0;
	height: auto;
	box-shadow: none;
	border-radius: 0;
	background: #f2f2f2 !important;
	display: flex;
	align-items: center;
	justify-content: center;
	padding: 12px;
	box-sizing: border-box;
}
.tech-literature-tile .cardimg img {
	width: 100%;
	max-width: 100%;
	height: auto;
	max-height: 200px;
	object-fit: contain;
}
.tech-literature-tile .card {
	/* Override global .card in style.css (300px + float:left + margin-left:67px) on desktop */
	width: 100% !important;
	max-width: 100% !important;
	float: none !important;
	clear: both !important;
	margin: 0 !important;
	height: auto;
	min-height: 0;
	padding: 0;
	/* Same light grey as image area above (unified “previous” look) */
	background: #f2f2f2 !important;
	border: none;
	border-top: 1px solid #e5e5e5;
	box-shadow: none !important;
	overflow: visible !important;
}
.tech-literature-tile .card .image {
	/* Override global .image (height:100%, padding, grey bg) from style.css */
	padding: 16px 14px 20px !important;
	text-align: center !important;
	height: auto !important;
	min-height: 0 !important;
	background: #f2f2f2 !important;
	background-image: none !important;
	padding-top: 16px !important;
	padding-bottom: 20px !important;
}
.tech-literature-tile .card h3 {
	text-align: center !important;
}
.tech-literature-tile .card .image a {
	margin-left: auto;
	margin-right: auto;
	display: inline-block;
}
@media (max-width: 767px) {
	.technical_literature {
		overflow-x: hidden;
	}
	.technical_literature .container,
	.technical_literature .container .row {
		margin-left: auto;
		margin-right: auto;
		padding-left: 10px;
		padding-right: 10px;
	}
	.technical_literature .container > .row {
		margin-left: 0;
		margin-right: 0;
	}
	.technical_literature .container_service .col-sm-4 {
		text-align: center !important;
	}
	.cardimg {
		float: none;
		width: 100%;
		max-width: 100%;
		height: auto;
		min-height: 0;
		margin-left: auto;
		margin-right: auto;
		margin-bottom: 12px;
		overflow: visible;
		display: flex;
		align-items: center;
		justify-content: center;
		padding: 12px;
		box-sizing: border-box;
	}
	.cardimg img {
		max-height: none;
		width: auto;
		max-width: 100%;
		height: auto;
		object-fit: contain;
		object-position: center center;
	}
	/* Stronger than .cardimg img above — fill tile width on small screens */
	.technical_literature .tech-literature-tile .cardimg img {
		width: 100%;
		max-width: 100%;
		display: block;
		margin-left: auto;
		margin-right: auto;
	}
	.tech-literature-tile .card {
		margin-bottom: 0;
	}
	.card {
		clear: both;
		float: none;
		width: 100%;
		height: auto;
		min-height: 0;
		padding-bottom: 16px;
		margin-bottom: 24px;
		text-align: center;
	}
	.card .image {
		padding-bottom: 16px;
		text-align: center;
	}
	.card h3 {
		font-size: 16px;
		padding-bottom: 12px;
		word-wrap: break-word;
		text-align: center;
	}
	.card .image a {
		margin-left: auto;
		margin-right: auto;
	}
	.technical_literature .btn {
		width: 100%;
		max-width: 100%;
	}
	.banner_durolab img {
		max-width: 100%;
		height: auto;
	}
	.tech-lit-form-wrap {
		width: 100% !important;
		max-width: 100% !important;
		box-sizing: border-box;
	}
	/* Real Android / WebKit: global .cardimg { margin-left:67px } can still win — hard reset */
	.technical_literature .tech-literature-tile {
		width: 100% !important;
		max-width: 100% !important;
		margin-left: 0 !important;
		margin-right: 0 !important;
		box-sizing: border-box !important;
	}
	.technical_literature .tech-literature-tile .cardimg {
		float: none !important;
		position: relative !important;
		left: 0 !important;
		right: auto !important;
		margin: 0 !important;
		margin-left: 0 !important;
		margin-right: 0 !important;
		-webkit-margin-start: 0 !important;
		-webkit-margin-end: 0 !important;
		padding: 12px !important;
		width: 100% !important;
		max-width: 100% !important;
		min-width: 0 !important;
		box-sizing: border-box !important;
		align-self: stretch !important;
	}
	.technical_literature .container_service {
		padding-left: 0 !important;
		padding-right: 0 !important;
	}
	.technical_literature .container_service .col-sm-4 {
		padding-left: 8px !important;
		padding-right: 8px !important;
	}
	.technical_literature .container {
		padding-left: 8px !important;
		padding-right: 8px !important;
		width: 100% !important;
		max-width: 100% !important;
		box-sizing: border-box !important;
	}
}
</style>		
		<div class="banner_durolab col-lg-12 col-md-12 col-sm-12">
		<?php if($page == 'datasheet'){ ?>

		    <img src="<?php echo SITEURL ;?>banner/TDS BANNER.jpg">
		<?php }else if($page == 'msds'){ ?>
			<img src="<?php echo SITEURL ;?>banner/MSDS BANNER.jpg">
		<?php }else if($page == 'warranty'){ ?>			
			<img src="<?php echo SITEURL ;?>banner/BANNER brochure.jpg" >
		<?php }else if($page == 'project'){ ?>
			<img src="<?php echo SITEURL ;?>banner/Project.jpg">
		<?php }else if($page == 'brochure'){ ?>
			<img src="<?php echo SITEURL ;?>banner/BANNER brochure.jpg">
		<?php }else if($page == 'specification'){ ?>
			<img src="<?php echo SITEURL ;?>banner/BANNER brochure.jpg">
		<?php }else if($page == 'quick-spec'){ ?>
			<img src="<?php echo SITEURL ;?>banner/BANNER brochure.jpg">
		<?php }else if($page == 'method-statement'){ ?>
			<img src="<?php echo SITEURL ;?>banner/BANNER brochure.jpg">
		<?php } ?>
				
		</div>
		<div class="technical_search col-lg-12 col-md-12 col-sm-12">
		    <div class="container" style="margin-top: 2%;">
				<div class="col-md-6 col-md-offset-3">				
					
					<?= $this->Flash->render() ?>
				</div>
			</div>
		</div>
		<?php if(empty($page)){ ?>
		<div class="technical_literature col-lg-12 col-md-12 col-sm-12">
			 <div class="container">
				<div class="row" style="margin:30px 0px;">
					<div class="container_service">	
					    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" >
							<div class="tech-literature-tile">
							<div class="cardimg">
								<img src="<?php echo SITEURL.'tech/1.jpg'; ?>" alt="Product Data Sheets">	
							 </div>
							<div class="card">								
							  <div class='image'>							  
								  <h3>Product Data Sheets</h3>
								  <a href="<?php echo SITEURL.'technical-literature/datasheet'; ?>">View More</a>
							  </div>						 
							</div>
							</div>
						</div>
						
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" >
							<div class="tech-literature-tile">
							<div class="cardimg">
								<img src="<?php echo SITEURL.'tech/2.jpg'; ?>" alt="Product MSDS">	
							 </div>
							<div class="card">								
							  <div class='image'>							  
								  <h3>Product MSDS</h3>
								  <a href="<?php echo SITEURL.'technical-literature/msds'; ?>">View More</a>
							  </div>						 
							</div>
							</div>
						</div>
						
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" >
							<div class="tech-literature-tile">
							<div class="cardimg">
								<img src="<?php echo SITEURL.'tech/3.jpg'; ?>" alt="Product Brochure">	
							 </div>
							<div class="card">								
							  <div class='image'>							  
								  <h3>Product Brochure</h3>
								  <a href="<?php echo SITEURL.'technical-literature/brochure'; ?>">View More</a>
							  </div>						 
							</div>
							</div>
						</div>
						
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" >
							<div class="tech-literature-tile">
							<div class="cardimg">
								<img src="<?php echo SITEURL.'tech/4.jpg'; ?>" alt="Project Reference">	
							 </div>
							<div class="card">								
							  <div class='image'>							  
								  <h3>Project Reference</h3>
								  <a href="<?php echo SITEURL.'technical-literature/project'; ?>">View More</a>
							  </div>						 
							</div>
							</div>
						</div>
						
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" >
							<div class="tech-literature-tile">
							<div class="cardimg">
								<img src="<?php echo SITEURL.'tech/5.jpg'; ?>" alt="Project Specification">	
							 </div>
							<div class="card">								
							  <div class='image'>							  
								  <h3>Project Specification</h3>
								  <a href="<?php echo SITEURL.'technical-literature'; ?>">Coming Soon</a>
							  </div>						 
							</div>
							</div>
						</div>
						
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" >
							<div class="tech-literature-tile">
							<div class="cardimg">
								<img src="<?php echo SITEURL.'tech/6.jpg'; ?>" alt="Project Warranty Request">	
							 </div>
							<div class="card">								
							  <div class='image'>							  
								  <h3>Project Warranty Request</h3>
								  <a href="<?php echo SITEURL.'technical-literature/warranty'; ?>">View More</a>
							  </div>						 
							</div>
							</div>
						</div>
						
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" >
							<div class="tech-literature-tile">
							<div class="cardimg">
								<img src="<?php echo SITEURL.'tech/7.jpg'; ?>" alt="Quick Spec">	
							 </div>
							<div class="card">								
							  <div class='image'>							  
								  <h3>Quick Spec</h3>
								  <a href="<?php echo SITEURL.'quick-spec'; ?>">Request Quick Spec</a>
							  </div>						 
							</div>
							</div>
						</div>
						
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" >
							<div class="tech-literature-tile">
							<div class="cardimg">
								<img src="<?php echo SITEURL.'tech/8.jpg'; ?>" alt="Method Statement">	
							 </div>
							<div class="card">								
							  <div class='image'>							  
								  <h3>Method Statement</h3>
								  <a href="<?php echo SITEURL.'technical-literature'; ?>">Coming Soon</a>
								  <!-- <a href="<?php // echo SITEURL.'method-statement'; ?>">Request Method Statement</a> -->
							  </div>						 
							</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
		<?php if(!empty($page)){ ?>
			<div class="technical_literature col-lg-12 col-md-12 col-sm-12">
		     <div class="container">
				<div class="row">
					<div class="col-lg-9 col-md-6 col-sm-12">
						<div class="tab" role="tabpanel">					
							<div class="tab-content tabs">
						
							<?php if($page == 'method-statement'){ ?>
								<div>
									<p>Request a method statement using our online form.</p>
									<p><a class="btn btn-primary" href="<?php echo SITEURL.'method-statement'; ?>">Request Method Statement</a></p>
								</div>
							<?php } ?>
							<?php if($page == 'quick-spec'){ ?>
								<div>
									<p>Request a quick specification using our online form.</p>
									<p><a class="btn btn-primary" href="<?php echo SITEURL.'quick-spec'; ?>">Request Quick Spec</a></p>
								</div>
							<?php } ?>
							<?php if($page == 'specification'){ ?>
								<div>
									<h3>Coming Soon </h3>								
								</div>
							<?php } ?>
							<?php if($page == 'warranty'){ ?>
								<div class="tech-lit-form-wrap" style="max-width:500px">
									<div>
										<?= $this->Form->create(null, ['url' => ['controller' => 'Fronts', 'action' => 'submitform'], 'class' => 'contact-form', 'id' => 'formbankreg']) ?>
											<div class="form-group">
											  <input type="text" class="form-control" id="name" name="name" placeholder="Name" required="" autofocus="">
											</div>
											<div class="form-group form_left">
											  <input type="email" class="form-control" id="email" name="email" placeholder="Email" required="">
											</div>
											<div class="form-group">
											   <input type="text" class="form-control" id="phone" name="phone" maxlength="10" placeholder="Mobile No." required="">
											</div>
											<div class="form-group">
											   <input type="text" class="form-control" id="project_name" name="project_name" placeholder="Project Name" required="">
											</div>
											<div class="form-group">
											   <select name="year" id="year" class="form-control">
													<option value="7 Year">7 Year</option>
													<option value="10 Year">10 Year</option>
													<option value="15 Year">15 Year</option>
													<option value="20 Year">20 Year</option>
											   </select>
											</div>
											<div class="form-group">
												<button href="#null" type="submit" class="btn btn-xs btn-info" style="padding:0px 30px !important;width: 112px;height: 71px;"> SEND </button>
											</div>
										<?= $this->Form->end() ?>
									</div>
								</div>
							<?php } ?>
							<?php if($page == 'msds'){ ?>
								<div>
									<?php
									// MSDS URLs come from products table `msds` column (dynamic from DB)
									foreach($product as $pro)
									{						
									$title = $pro['Category']['category_name'];										
									?>
									<div class="row">
										<h2><?= $title; ?></h2>
										<?php
											foreach($pro['Product'] as $products)
											{
											$msds_parts = isset($products['msds']) ? explode("##", (string)$products['msds']) : [];
											$msds_1 = isset($msds_parts[0]) ? trim($msds_parts[0]) : '';
											$msds_2 = isset($msds_parts[1]) ? trim($msds_parts[1]) : '';
											if (!empty($msds_1)) {
												$msds_url = (strpos($msds_1, 'http') === 0) ? $msds_1 : (rtrim(SITEURL, '/') . '/' . ltrim($msds_1, '/'));
										?>
											<a target="_blank" href="<?php echo h($msds_url); ?>" class="btn effect5"><?php echo h($products['title']); ?></a>
										<?php } } ?>
									</div>
									<?php } ?>	
								</div>
								<?php } ?>
								<?php 							
								if($page == 'datasheet'){ ?>
									<div>
										<?php
										// Datasheet URLs come from products table `datasheet` column (dynamic from DB)
										foreach($product as $pro)
										{						
										$title = $pro['Category']['category_name'];										
										?>
										<div class="row">
											<h2><?= $title; ?></h2>
											<?php
												foreach($pro['Product'] as $products)
												{
											$datasheet = isset($products['datasheet']) ? explode("##", (string)$products['datasheet']) : [];
											$datasheet_1 = isset($datasheet[0]) ? trim($datasheet[0]) : '';
											$datasheetdownload_2 = isset($datasheet[1]) ? trim($datasheet[1]) : '';
											// Use dynamic URL from DB; if relative path, prepend SITEURL
											if (!empty($datasheet_1)) {
												$datasheet_url = (strpos($datasheet_1, 'http') === 0) ? $datasheet_1 : (rtrim(SITEURL, '/') . '/' . ltrim($datasheet_1, '/'));
											?>
												<a target="_blank" href="<?php echo h($datasheet_url); ?>" class="btn effect5"><?php echo h($products['title']); ?></a>
											<?php } } ?>
										</div>
										<?php } ?>	
									</div>
							  <?php } ?>
							  <?php if($page == 'project'){ ?>
							  <div>					
								
								<a class="fancybox" href="<?php echo SITEURL ;?>customdurotech/images/project_images/28158464_597730207233729_4450512397072859136_n.jpg" title="" >
									<div class="item">
									<img src="<?php echo SITEURL ;?>customdurotech/images/project_images/28158464_597730207233729_4450512397072859136_n.jpg" /><div class="info"><h2>Durotech Project</h2>
								  </div></div>
								</a>
								
								<a class="fancybox" href="<?php echo SITEURL ;?>customdurotech/images/project_images/28156943_1851826481503969_6097429456538828800_n.jpg" title="" >
									<div class="item">
									<img src="<?php echo SITEURL ;?>customdurotech/images/project_images/28156943_1851826481503969_6097429456538828800_n.jpg" /><div class="info"><h2>Durotech Project</h2>
								  </div></div>
								</a>
								
								<a class="fancybox" href="<?php echo SITEURL ;?>customdurotech/images/project_images/28156646_754753851380933_7812861694031429632_n.jpg" title="" >
									<div class="item">
									<img src="<?php echo SITEURL ;?>customdurotech/images/project_images/28156646_754753851380933_7812861694031429632_n.jpg" /><div class="info"><h2>Durotech Project</h2>
								  </div></div>
								</a>
								
								<a class="fancybox" href="<?php echo SITEURL ;?>customdurotech/images/project_images/27575623_1428286160614390_6940262366848221184_n.jpg" title="" >
									<div class="item">
									<img src="<?php echo SITEURL ;?>customdurotech/images/project_images/27575623_1428286160614390_6940262366848221184_n.jpg" /><div class="info"><h2>Durotech Project</h2>
								  </div></div>
								</a>
								
								<a class="fancybox" href="<?php echo SITEURL ;?>customdurotech/images/project_images/26300610_186308615435407_4746681947256782848_n.jpg" title="" >
									<div class="item">
									<img src="<?php echo SITEURL ;?>customdurotech/images/project_images/26300610_186308615435407_4746681947256782848_n.jpg" /><div class="info"><h2>Durotech Project</h2>
								  </div></div>
								</a>
								
								<a class="fancybox" href="<?php echo SITEURL ;?>customdurotech/images/project_images/25038912_1970632336531034_9071819245322502144_n.jpg" title="" >
									<div class="item">
									<img src="<?php echo SITEURL ;?>customdurotech/images/project_images/25038912_1970632336531034_9071819245322502144_n.jpg" /><div class="info"><h2> Durotech Project</h2>
								  </div></div>
								</a>
								
								<a class="fancybox" href="<?php echo SITEURL ;?>customdurotech/images/project_images/25012773_1962412800649322_1587339729857150976_n.jpg" title="" >
									<div class="item">
									<img src="<?php echo SITEURL ;?>customdurotech/images/project_images/25012773_1962412800649322_1587339729857150976_n.jpg" /><div class="info"><h2> Durotech Project</h2>
								  </div></div>
								</a>
								
								
								<a class="fancybox" href="<?php echo SITEURL ;?>customdurotech/images/project_images/24331982_151214638850996_6773179849746939904_n.jpg" title="" >
									<div class="item">
									<img src="<?php echo SITEURL ;?>customdurotech/images/project_images/24331982_151214638850996_6773179849746939904_n.jpg" /><div class="info"><h2>Durotech Project </h2>
								  </div></div>
								</a>
								
								
								<a class="fancybox" href="<?php echo SITEURL ;?>customdurotech/images/project_images/24274376_2003518576599332_8243324477740417024_n.jpg" title="" >
									<div class="item">
									<img src="<?php echo SITEURL ;?>customdurotech/images/project_images/24274376_2003518576599332_8243324477740417024_n.jpg" /><div class="info"><h2>Durotech Project </h2>
								  </div></div>
								</a>
								
								<a class="fancybox" href="<?php echo SITEURL ;?>customdurotech/images/project_images/23966908_236811296855571_457670542535688192_n.jpg" title="" >
									<div class="item">
									<img src="<?php echo SITEURL ;?>customdurotech/images/project_images/23966908_236811296855571_457670542535688192_n.jpg" /><div class="info"><h2>Durotech Project </h2>
								  </div></div>
								</a>
								
								<a class="fancybox" href="<?php echo SITEURL ;?>customdurotech/images/project_images/23825230_289386534903904_2511455901265690624_n.jpg" title="" >
									<div class="item">
									<img src="<?php echo SITEURL ;?>customdurotech/images/project_images/23825230_289386534903904_2511455901265690624_n.jpg" /><div class="info"><h2>Durotech Project </h2>
								  </div></div>
								</a>
								<a class="fancybox" href="<?php echo SITEURL ;?>customdurotech/images/project_images/23825158_1962145440667760_3328675765515452416_n.jpg" title="" >
									<div class="item">
									<img src="<?php echo SITEURL ;?>customdurotech/images/project_images/23825158_1962145440667760_3328675765515452416_n.jpg" /><div class="info"><h2>Durotech Project </h2>
								  </div></div>
								</a>
								<a class="fancybox" href="<?php echo SITEURL ;?>customdurotech/images/project_images/23824077_398964173853966_7099736216240652288_n.jpg" title="" >
									<div class="item">
									<img src="<?php echo SITEURL ;?>customdurotech/images/project_images/23824077_398964173853966_7099736216240652288_n.jpg" /><div class="info"><h2> Durotech Project</h2>
								  </div></div>
								</a>
								<a class="fancybox" href="<?php echo SITEURL ;?>customdurotech/images/project_images/23594329_460542551009104_5923777297332043776_n.jpg" title="" >
									<div class="item">
									<img src="<?php echo SITEURL ;?>customdurotech/images/project_images/23594329_460542551009104_5923777297332043776_n.jpg" /><div class="info"><h2> Durotech Project</h2>
								  </div></div>
								</a>
								<a class="fancybox" href="<?php echo SITEURL ;?>customdurotech/images/project_images/23279660_1788961471397267_5797136359793623040_n.jpg" title="" >
									<div class="item">
									<img src="<?php echo SITEURL ;?>customdurotech/images/project_images/23279660_1788961471397267_5797136359793623040_n.jpg" /><div class="info"><h2> Durotech Project</h2>
								  </div></div>
								</a>
								<a class="fancybox" href="<?php echo SITEURL ;?>customdurotech/images/project_images/23279301_132247677489651_433455559870513152_n.jpg" title="" >
									<div class="item">
									<img src="<?php echo SITEURL ;?>customdurotech/images/project_images/23279301_132247677489651_433455559870513152_n.jpg" /><div class="info"><h2>Durotech Project </h2>
								  </div></div>
								</a>
								<a class="fancybox" href="<?php echo SITEURL ;?>customdurotech/images/project_images/22858188_362050654216651_6599849516734611456_n.jpg" title="" >
									<div class="item">
									<img src="<?php echo SITEURL ;?>customdurotech/images/project_images/22858188_362050654216651_6599849516734611456_n.jpg" /><div class="info"><h2>Durotech Project </h2>
								  </div></div>
								</a>
								<a class="fancybox" href="<?php echo SITEURL ;?>customdurotech/images/project_images/22710293_1941582779426397_6436727509236056064_n.jpg" title="" >
									<div class="item">
									<img src="<?php echo SITEURL ;?>customdurotech/images/project_images/22710293_1941582779426397_6436727509236056064_n.jpg" /><div class="info"><h2> Durotech Project</h2>
								  </div></div>
								</a>
								<a class="fancybox" href="<?php echo SITEURL ;?>customdurotech/images/project_images/22709357_2386165134855601_8803433224396079104_n.jpg" title="" >
									<div class="item">
									<img src="<?php echo SITEURL ;?>customdurotech/images/project_images/22709357_2386165134855601_8803433224396079104_n.jpg" /><div class="info"><h2>Durotech Project </h2>
								  </div></div>
								</a>
							</div>
							 <?php } ?>
							 <?php if($page == 'brochure'){ ?>
								<div>									
									<a target="_blank" href="<?php echo SITEURL.'wp-content/uploads/Durotech_Brochure.pdf'?>" class="btn effect5">Company Profile</a>
									<a target="_blank" href="<?php echo SITEURL.'wp-content/uploads/Durotech Waterproofing System Catalogue 2025.pdf'?>"  class="btn effect5">Waterproofing Systems</a>
									<a target="_blank" href="<?php echo SITEURL.'wp-content/uploads/Epoxy Flooring Catalog 8 pages.pdf'?>"  class="btn effect5">Epoxy Flooring System</a>
									<a target="_blank" href="<?php echo SITEURL.'wp-content/uploads/Product Catalog- Yellow book.pdf'?>"  class="btn effect5">Product Catalogue </a>
								    <a target="_blank" href="<?php echo SITEURL.'wp-content/uploads/Distributor Catalogue 2025.pdf'?>"  class="btn effect5">Distributor Catalogue </a>

									<!--a target="_blank" href="<?php echo SITEURL.'wp-content/uploads/Dow Durotech Brochure 8 pages.pdf'?>"  class="btn effect5">Dow Spray Polyurea</a-->
								</div>
							 <?php } ?>	
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-12">
					<div class="tab" role="tabpanel">		
						<div class="sidebar_cate">
							<ul>
								<li><a href="<?php echo SITEURL.'technical-literature/datasheet'; ?>">Product Data Sheets</a></li>
								<li><a href="<?php echo SITEURL.'technical-literature/msds'; ?>">Product MSDS</a></li>
								<li><a href="<?php echo SITEURL.'technical-literature/brochure'; ?>">Product Brochure</a></li>
								<li><a href="<?php echo SITEURL.'technical-literature/project'; ?>">Project Reference</a></li>
								<li><a href="<?php echo SITEURL.'technical-literature'; ?>">Project Specification</a></li>
								<li><a href="<?php echo SITEURL.'technical-literature/warranty'; ?>">Project Warranty Request</a></li>
								<li><a href="<?php echo SITEURL.'quick-spec'; ?>">Quick Spec</a></li>
								<li><a href="<?php echo SITEURL.'method-statement'; ?>">Method Statement</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		    </div>
        </div>
		<?php } ?>
	</div>
	<?php if(!empty($project)){ ?>
	<script>		
		$(document).ready(function(){
			$("#project").trigger('click');			
		});		
		
	</script>
	<?php } ?>		
	<script>	

	jQuery(function(){ 
		$("#captcha").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter captcha"
		});$("#name").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter name"
		});$("#phone").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter phone"
		});$("#email").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter email"
		});$("#project_name").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter project name"
		});jQuery("#email").validate({
			expression: "if (VAL.match(\/^([a-zA-Z0-9_\\.\\-])+\\@(([a-zA-Z0-9\\-])+\\.)+([a-zA-Z0-9]{2,4})+$\/) && VAL) return true; else return false;",
			message: "Please enter valid email"
		}); 
	});

	</script>		