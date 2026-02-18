	<script src="<?php echo SITEURL; ?>ckeditor/ckeditor.js"></script>
	
	<div class="page-content">
		<div class="page-header">			
			<h1><small> Comments - Recent Activities</small>
			<a href="<?php echo SITEURL.'stocks/addcomment/'.$argu ?>" class="btn btn-mini btn-inverse" style="float:right;">Add Comment</a>
			</h1>
		</div>	
		<div>
		<div class="col-xs-12">	
					
			<div id="user-profile-12" class="user-profile row-fluid">
				<div class="span9">
					<div class="widget-box transparent">					
					<div class="widget-body">
						<div class="widget-main padding-8">
							<div id="profile-feed-1" class="profile-feed">
								<?php
								
									
									if(!empty($clientArr)){
									foreach($clientArr as $TaskAssigns){
																	
									if($TaskAssigns['StockReturnComment']['type'] == 1){
										$name = $TaskAssigns['User']['name'];
									}else{
										$name = $TaskAssigns['NappUser']['name'];
									}	
									$shortname = substr($name,0,1);
									
								?>
								<div class="profile-activity clearfix">
									<div>
										<?php if($TaskAssigns['StockReturnComment']['type'] == 1){ ?>
											<i class="pull-left thumbicon icon-picture btn-info no-hover"><?php echo strtoupper($shortname); ?></i>
										<?php }else{ ?>
											<i class="pull-left thumbicon icon-picture btn-warning no-hover"><?php echo strtoupper($shortname); ?></i>
										<?php } ?>
										<a class="user" href="#"> <?php echo $name; ?>: </a>
										<?php echo $TaskAssigns['StockReturnComment']['comment']; ?>
										<?php if(!empty($TaskAssigns['StockReturnComment']['documents'])){ ?>
											<a href="<?php echo SITEURL.'admin/sheets/commentdownload/'.base64_encode(base64_encode($TaskAssigns['StockReturnComment']['documents']));?>"><i class="fa fa-download"></i></a>
										<?php } ?>
										<div class="time">
											<i class="icon-time bigger-110"></i>
											<?php  
												echo date('d M Y h:i a',strtotime($TaskAssigns['StockReturnComment']['created']));
											?>
										</div>
									</div>
									<div class="tools action-buttons">
										<a href="#" class="blue">
											<i class="icon-pencil bigger-125"></i>
										</a>

										<a href="#" class="red">
											<i class="icon-remove bigger-125"></i>
										</a>
									</div>
								</div>
								<?php } }else{ ?>
								<div class="profile-activity clearfix">
									<div>
										<p> No Comment Found</p>
									</div>
								</div>
								<?php } ?>
							</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>		
	</div>	
</div>	
<script type="text/javascript">
jQuery(function(){ 

	$('.datepicker').datepicker({
		format: 'yyyy-mm-dd',			
	});
	
	$("#title").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please enter  employe id"
	}); $("#assignedto").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please select employee"
	}); $("#assignedby").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please eneter assigned by user"
	}); 
	
	
});
</script>
