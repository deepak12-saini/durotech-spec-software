	<!-- Add fancyBox main JS and CSS files -->
	
	<style>
		body{background:url(https://bootstraptema.ru/images/bg/bg-4.png)}
	
	</style>
	<div class="banner_durolab col-lg-12 col-md-12 col-sm-12">
		<img src="<?php echo SITEURL ;?>img/join team.jpg">
	</div>
	<div class="container faq">
<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12">
<?php 
$i=1;
if(!empty($careers)){ foreach($careers as $career){?>
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
	<div class="panel panel-default">
		<div class="panel-heading" role="tab" id="headingOne">
			<h4 class="panel-title">
				<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
					<?php echo $i.'. '.$career['Career']['title']; ?>
					<span style="float:right">Code: <?php echo $career['Career']['code']; ?></span>
				</a>
			</h4>
		</div>
		<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
			<div class="panel-body">
				<?php echo $career['Career']['description']; ?>
				
				<br></br>
				<a href="<?php echo SITEURL.'careers/apply/'.$career['Career']['code']; ?>" class="btn btn-primary">Apply Now</a>
			</div>
		</div>
	</div>
 </div><!-- /.panel-group -->
 <?php $i++;  }}else{ ?>
	<h2 style="text-align:center; font-weight:bold;">No Job Available </h2> 
 <?php } ?>
 </div><!-- /.col-md-offset-3 col-md-6 -->
</div><!-- /.row -->
</div><!-- /.container --> 