<script type="text/javascript" src="<?= h(SITEURL) ?>fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="<?= h(SITEURL) ?>fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />
<script type="text/javascript" src="<?= h(SITEURL) ?>fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
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
	height: 189px;	
	overflow: hidden;
	box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
	float: left;
	margin-left: 67px;
	margin-bottom: 1px;
	background: #f2f2f2 !important;
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
}
.technical_literature .btn {	
	width: 384px;
}
</style>		
		<div class="banner_durolab col-lg-12 col-md-12 col-sm-12">
		<?php if($page == 'datasheet'){ ?>

		    <img src="<?= h(SITEURL) ?>banner/TDS BANNER.jpg">
		<?php }else if($page == 'msds'){ ?>
			<img src="<?= h(SITEURL) ?>banner/MSDS BANNER.jpg">
		<?php }else if($page == 'warranty'){ ?>			
			<img src="<?= h(SITEURL) ?>banner/BANNER brochure.jpg" >
		<?php }else if($page == 'project'){ ?>
			<img src="<?= h(SITEURL) ?>banner/Project.jpg">
		<?php }else if($page == 'brochure'){ ?>
			<img src="<?= h(SITEURL) ?>banner/BANNER brochure.jpg">
		<?php }else if($page == 'specification'){ ?>
			<img src="<?= h(SITEURL) ?>banner/BANNER brochure.jpg">
		<?php }else if($page == 'quick-spec'){ ?>
			<img src="<?= h(SITEURL) ?>banner/BANNER brochure.jpg">
		<?php }else if($page == 'method-statement'){ ?>
			<img src="<?= h(SITEURL) ?>banner/BANNER brochure.jpg">
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
					    <div class="col-lg-4 col-md-4 col-sm-4" >
							<div class="cardimg">
								<img src="<?= h(SITEURL).'tech/1.jpg'; ?>">	
							 </div>
							<div class="card">								
							  <div class='image'>							  
								  <h3>Product Data Sheets</h3>
								  <a href="<?= h(SITEURL).'technical-literature/datasheet'; ?>">View More</a>
							  </div>						 
							</div>						 
						</div>
						
						<div class="col-lg-4 col-md-4 col-sm-4" >
							<div class="cardimg">
								<img src="<?= h(SITEURL).'tech/2.jpg'; ?>">	
							 </div>
							<div class="card">								
							  <div class='image'>							  
								  <h3>Product MSDS</h3>
								  <a href="<?= h(SITEURL).'technical-literature/msds'; ?>">View More</a>
							  </div>						 
							</div>						 
						</div>
						
						<div class="col-lg-4 col-md-4 col-sm-4" >
							<div class="cardimg">
								<img src="<?= h(SITEURL).'tech/3.jpg'; ?>">	
							 </div>
							<div class="card">								
							  <div class='image'>							  
								  <h3>Product Brochure</h3>
								  <a href="<?= h(SITEURL).'technical-literature/brochure'; ?>">View More</a>
							  </div>						 
							</div>						 
						</div>
						
						<div class="col-lg-4 col-md-4 col-sm-4" >
							<div class="cardimg">
								<img src="<?= h(SITEURL).'tech/4.jpg'; ?>">	
							 </div>
							<div class="card">								
							  <div class='image'>							  
								  <h3>Project Reference</h3>
								  <a href="<?= h(SITEURL).'technical-literature/project'; ?>">View More</a>
							  </div>						 
							</div>						 
						</div>
						
						<div class="col-lg-4 col-md-4 col-sm-4" >
							<div class="cardimg">
								<img src="<?= h(SITEURL).'tech/5.jpg'; ?>">	
							 </div>
							<div class="card">								
							  <div class='image'>							  
								  <h3>Project Specification</h3>
								  <a href="<?= h(SITEURL).'technical-literature'; ?>">Coming Soon</a>
							  </div>						 
							</div>						 
						</div>
						
						<div class="col-lg-4 col-md-4 col-sm-4" >
							<div class="cardimg">
								<img src="<?= h(SITEURL).'tech/6.jpg'; ?>">	
							 </div>
							<div class="card">								
							  <div class='image'>							  
								  <h3>Project Warranty Request</h3>
								  <a href="<?= h(SITEURL).'technical-literature/warranty'; ?>">View More</a>
							  </div>						 
							</div>						 
						</div>
						
						<div class="col-lg-4 col-md-4 col-sm-4" >
							<div class="cardimg">
								<img src="<?= h(SITEURL).'tech/7.jpg'; ?>">	
							 </div>
							<div class="card">								
							  <div class='image'>							  
								  <h3>Quick Spec</h3>
								  <a href="<?= h(SITEURL).'technical-literature'; ?>">Coming Soon</a>
							  </div>						 
							</div>						 
						</div>
						
						<div class="col-lg-4 col-md-4 col-sm-4" >
							<div class="cardimg">
								<img src="<?= h(SITEURL).'tech/8.jpg'; ?>">	
							 </div>
							<div class="card">								
							  <div class='image'>							  
								  <h3>Method Statement</h3>
								  <a href="<?= h(SITEURL).'technical-literature'; ?>">Coming Soon</a>
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
									<h3>Coming Soon </h3>								
								</div>
							<?php } ?>
							<?php if($page == 'quick-spec'){ ?>
								<div>
									<h3>Coming Soon </h3>								
								</div>
							<?php } ?>
							<?php if($page == 'specification'){ ?>
								<div>
									<h3>Coming Soon </h3>								
								</div>
							<?php } ?>
							<?php if($page == 'warranty'){ ?>
								<div  style="width:500px">
									<div>
										
										<?= $this->Form->create(null, ['url' => ['controller' => 'Fronts', 'action' => 'submitform'], 'class' => 'contact-form', 'id' => 'formbankreg']) ?>
								
											<div class="form-group">
											  <input type="text" class="form-control" id="name" name="name" placeholder="Name" required="" autofocus="">
											</div>								
										
											<div class="form-group form_left">
											  <input type="email" class="form-control" id="email" name="email" placeholder="Email" required="">
											</div>
										
											<div class="form-group">
											   <input type="text" class="form-control" id="phone" name="phone"  maxlength="10" placeholder="Mobile No." required="">
											</div>
											<div class="form-group">
											   <input type="text" class="form-control" id="project_name" name="project_name"  placeholder="Project Name" required="">
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
										foreach($product as $pro)
										{						
										$title = $pro['Category']['category_name'];										
										?>
										<div class="row">
											<h2><?= $title; ?></h2>
											<?php
												foreach($pro['Product'] as $products)
												{
											
												$datasheet = explode("##",$products['msds']);
												isset($datasheet[0])? $datasheet_1 = $datasheet[0] : $datasheet_1 = '';
												isset($datasheet[1])? $datasheetdownload_2 = $datasheet[1] : $datasheetdownload_2 = '';
												if(!empty($datasheet_1)){
											?>
												<a target="_blank" href="<?= h($datasheet_1) ?>" class="btn effect5"><?= h($products['title']) ?></a>
											<?php } } ?>
										</div>
										<?php } ?>	
									
								</div>
								<?php } ?>
								<?php 							
								if($page == 'datasheet'){ ?>
									<div>										
										<?php 
										foreach($product as $pro)
										{						
										$title = $pro['Category']['category_name'];										
										?>
										<div class="row">
											<h2><?= $title; ?></h2>
											<?php
												foreach($pro['Product'] as $products)
												{
											
											$datasheet = explode("##",$products['datasheet']);
											isset($datasheet[0])? $datasheet_1 = $datasheet[0] : $datasheet_1 = '';
											isset($datasheet[1])? $datasheetdownload_2 = $datasheet[1] : $datasheetdownload_2 = '';
											if(!empty($datasheet_1)){
											?>
												<a target="_blank" href="<?= h($datasheet_1) ?>" class="btn effect5"><?= h($products['title']) ?></a>
											<?php } } ?>
										</div>
										<?php } ?>	
									</div>
							  <?php } ?>
							  <?php if($page == 'project'){ ?>
							  <div>					
								
								<a class="fancybox" href="<?= h(SITEURL) ?>customdurotech/images/project_images/28158464_597730207233729_4450512397072859136_n.jpg" title="" >
									<div class="item">
									<img src="<?= h(SITEURL) ?>customdurotech/images/project_images/28158464_597730207233729_4450512397072859136_n.jpg" /><div class="info"><h2>Durotech Project</h2>
								  </div></div>
								</a>
								
								<a class="fancybox" href="<?= h(SITEURL) ?>customdurotech/images/project_images/28156943_1851826481503969_6097429456538828800_n.jpg" title="" >
									<div class="item">
									<img src="<?= h(SITEURL) ?>customdurotech/images/project_images/28156943_1851826481503969_6097429456538828800_n.jpg" /><div class="info"><h2>Durotech Project</h2>
								  </div></div>
								</a>
								
								<a class="fancybox" href="<?= h(SITEURL) ?>customdurotech/images/project_images/28156646_754753851380933_7812861694031429632_n.jpg" title="" >
									<div class="item">
									<img src="<?= h(SITEURL) ?>customdurotech/images/project_images/28156646_754753851380933_7812861694031429632_n.jpg" /><div class="info"><h2>Durotech Project</h2>
								  </div></div>
								</a>
								
								<a class="fancybox" href="<?= h(SITEURL) ?>customdurotech/images/project_images/27575623_1428286160614390_6940262366848221184_n.jpg" title="" >
									<div class="item">
									<img src="<?= h(SITEURL) ?>customdurotech/images/project_images/27575623_1428286160614390_6940262366848221184_n.jpg" /><div class="info"><h2>Durotech Project</h2>
								  </div></div>
								</a>
								
								<a class="fancybox" href="<?= h(SITEURL) ?>customdurotech/images/project_images/26300610_186308615435407_4746681947256782848_n.jpg" title="" >
									<div class="item">
									<img src="<?= h(SITEURL) ?>customdurotech/images/project_images/26300610_186308615435407_4746681947256782848_n.jpg" /><div class="info"><h2>Durotech Project</h2>
								  </div></div>
								</a>
								
								<a class="fancybox" href="<?= h(SITEURL) ?>customdurotech/images/project_images/25038912_1970632336531034_9071819245322502144_n.jpg" title="" >
									<div class="item">
									<img src="<?= h(SITEURL) ?>customdurotech/images/project_images/25038912_1970632336531034_9071819245322502144_n.jpg" /><div class="info"><h2> Durotech Project</h2>
								  </div></div>
								</a>
								
								<a class="fancybox" href="<?= h(SITEURL) ?>customdurotech/images/project_images/25012773_1962412800649322_1587339729857150976_n.jpg" title="" >
									<div class="item">
									<img src="<?= h(SITEURL) ?>customdurotech/images/project_images/25012773_1962412800649322_1587339729857150976_n.jpg" /><div class="info"><h2> Durotech Project</h2>
								  </div></div>
								</a>
								
								
								<a class="fancybox" href="<?= h(SITEURL) ?>customdurotech/images/project_images/24331982_151214638850996_6773179849746939904_n.jpg" title="" >
									<div class="item">
									<img src="<?= h(SITEURL) ?>customdurotech/images/project_images/24331982_151214638850996_6773179849746939904_n.jpg" /><div class="info"><h2>Durotech Project </h2>
								  </div></div>
								</a>
								
								
								<a class="fancybox" href="<?= h(SITEURL) ?>customdurotech/images/project_images/24274376_2003518576599332_8243324477740417024_n.jpg" title="" >
									<div class="item">
									<img src="<?= h(SITEURL) ?>customdurotech/images/project_images/24274376_2003518576599332_8243324477740417024_n.jpg" /><div class="info"><h2>Durotech Project </h2>
								  </div></div>
								</a>
								
								<a class="fancybox" href="<?= h(SITEURL) ?>customdurotech/images/project_images/23966908_236811296855571_457670542535688192_n.jpg" title="" >
									<div class="item">
									<img src="<?= h(SITEURL) ?>customdurotech/images/project_images/23966908_236811296855571_457670542535688192_n.jpg" /><div class="info"><h2>Durotech Project </h2>
								  </div></div>
								</a>
								
								<a class="fancybox" href="<?= h(SITEURL) ?>customdurotech/images/project_images/23825230_289386534903904_2511455901265690624_n.jpg" title="" >
									<div class="item">
									<img src="<?= h(SITEURL) ?>customdurotech/images/project_images/23825230_289386534903904_2511455901265690624_n.jpg" /><div class="info"><h2>Durotech Project </h2>
								  </div></div>
								</a>
								<a class="fancybox" href="<?= h(SITEURL) ?>customdurotech/images/project_images/23825158_1962145440667760_3328675765515452416_n.jpg" title="" >
									<div class="item">
									<img src="<?= h(SITEURL) ?>customdurotech/images/project_images/23825158_1962145440667760_3328675765515452416_n.jpg" /><div class="info"><h2>Durotech Project </h2>
								  </div></div>
								</a>
								<a class="fancybox" href="<?= h(SITEURL) ?>customdurotech/images/project_images/23824077_398964173853966_7099736216240652288_n.jpg" title="" >
									<div class="item">
									<img src="<?= h(SITEURL) ?>customdurotech/images/project_images/23824077_398964173853966_7099736216240652288_n.jpg" /><div class="info"><h2> Durotech Project</h2>
								  </div></div>
								</a>
								<a class="fancybox" href="<?= h(SITEURL) ?>customdurotech/images/project_images/23594329_460542551009104_5923777297332043776_n.jpg" title="" >
									<div class="item">
									<img src="<?= h(SITEURL) ?>customdurotech/images/project_images/23594329_460542551009104_5923777297332043776_n.jpg" /><div class="info"><h2> Durotech Project</h2>
								  </div></div>
								</a>
								<a class="fancybox" href="<?= h(SITEURL) ?>customdurotech/images/project_images/23279660_1788961471397267_5797136359793623040_n.jpg" title="" >
									<div class="item">
									<img src="<?= h(SITEURL) ?>customdurotech/images/project_images/23279660_1788961471397267_5797136359793623040_n.jpg" /><div class="info"><h2> Durotech Project</h2>
								  </div></div>
								</a>
								<a class="fancybox" href="<?= h(SITEURL) ?>customdurotech/images/project_images/23279301_132247677489651_433455559870513152_n.jpg" title="" >
									<div class="item">
									<img src="<?= h(SITEURL) ?>customdurotech/images/project_images/23279301_132247677489651_433455559870513152_n.jpg" /><div class="info"><h2>Durotech Project </h2>
								  </div></div>
								</a>
								<a class="fancybox" href="<?= h(SITEURL) ?>customdurotech/images/project_images/22858188_362050654216651_6599849516734611456_n.jpg" title="" >
									<div class="item">
									<img src="<?= h(SITEURL) ?>customdurotech/images/project_images/22858188_362050654216651_6599849516734611456_n.jpg" /><div class="info"><h2>Durotech Project </h2>
								  </div></div>
								</a>
								<a class="fancybox" href="<?= h(SITEURL) ?>customdurotech/images/project_images/22710293_1941582779426397_6436727509236056064_n.jpg" title="" >
									<div class="item">
									<img src="<?= h(SITEURL) ?>customdurotech/images/project_images/22710293_1941582779426397_6436727509236056064_n.jpg" /><div class="info"><h2> Durotech Project</h2>
								  </div></div>
								</a>
								<a class="fancybox" href="<?= h(SITEURL) ?>customdurotech/images/project_images/22709357_2386165134855601_8803433224396079104_n.jpg" title="" >
									<div class="item">
									<img src="<?= h(SITEURL) ?>customdurotech/images/project_images/22709357_2386165134855601_8803433224396079104_n.jpg" /><div class="info"><h2>Durotech Project </h2>
								  </div></div>
								</a>
							</div>
							 <?php } ?>
							 <?php if($page == 'brochure'){ ?>
								<div>									
									<a target="_blank" href="<?= h(SITEURL).'wp-content/uploads/Durotech_Brochure.pdf'?>" class="btn effect5">Company Profile</a>
									<a target="_blank" href="<?= h(SITEURL).'wp-content/uploads/Durotech Waterproofing System Catalogue 2025.pdf'?>"  class="btn effect5">Waterproofing Systems</a>
									<a target="_blank" href="<?= h(SITEURL).'wp-content/uploads/Epoxy Flooring Catalog 8 pages.pdf'?>"  class="btn effect5">Epoxy Flooring System</a>
									<a target="_blank" href="<?= h(SITEURL).'wp-content/uploads/Product Catalog- Yellow book.pdf'?>"  class="btn effect5">Product Catalogue </a>
								    <a target="_blank" href="<?= h(SITEURL).'wp-content/uploads/Distributor Catalogue 2025.pdf'?>"  class="btn effect5">Distributor Catalogue </a>

									<!--a target="_blank" href="<?= h(SITEURL).'wp-content/uploads/Dow Durotech Brochure 8 pages.pdf'?>"  class="btn effect5">Dow Spray Polyurea</a-->
								</div>
							 <?php } ?>	
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-12">
					<div class="tab" role="tabpanel">		
						<div class="sidebar_cate">
							<ul>
								<li><a href="<?= h(SITEURL).'technical-literature/datasheet'; ?>">Product Data Sheets</a></li>
								<li><a href="<?= h(SITEURL).'technical-literature/msds'; ?>">Product MSDS</a></li>
								<li><a href="<?= h(SITEURL).'technical-literature/brochure'; ?>">Product Brochure</a></li>
								<li><a href="<?= h(SITEURL).'technical-literature/project'; ?>">Project Reference</a></li>
								<li><a href="<?= h(SITEURL).'technical-literature'; ?>">Project Specification</a></li>
								<li><a href="<?= h(SITEURL).'technical-literature/warranty'; ?>">Project Warranty Request</a></li>
								<li><a href="<?= h(SITEURL).'technical-literature'; ?>">Quick Spec</a></li>
								<li><a href="<?= h(SITEURL).'technical-literature'; ?>">Method Statement</a></li>
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