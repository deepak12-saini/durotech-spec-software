	<div class="page-content">
		<div class="page-header">
			<div class="right_btn pull-right" ><a href="javascript:window.history.back();" class="btn btn-inverse" >Back</a></div>
			<h1>Services<small><i class="ace-icon fa fa-angle-double-right"></i>	Edit Service</small>
			</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<?php echo $this->Form->create('Service',array('type'=>'file','class'=>'form-horizontal'));echo $this->Form->input('id',array('type'=>'hidden')); ?>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Category : </label>
				<div class="col-sm-3">
				<select  name="data[Service][category_id]" id="category_id" class="form-control" >
							<option value="-1" selected="selected">Select Category</option>
							<?php foreach($categories as $Category){
							if($Category['Category']['id']==$Service['Service']['category_id']){ $selected='selected';}else{ $selected=''; }
							?>
							<option <?php echo $selected;?> value="<?php echo $Category['Category']['id'];?>"><?php echo $Category['Category']['category_name'];?></option>
							<?php 
							} ?>
				</select>
			</div>		</div>	
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Name </label>
					<div class="col-sm-8">
						<?php echo $this->Form->input('service_name',array('div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'service_name','placeholder'=>'Service Name'))?>
					</div>
				</div>
				<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Description : </label>
				<div class="col-sm-9">
					<?php echo $this->Form->input('service_description',array('div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'service_description'))?>
				</div>
			</div>	
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Price : </label>
				<div class="col-sm-9">
					<?php echo $this->Form->input('price',array('div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'price','placeholder'=>'Price'))?>
				</div>
			</div>		
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Price for shop: </label>
				<div class="col-sm-9">
					<?php echo $this->Form->input('price_for_shop',array('div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'price_for_shop','placeholder'=>'Price for shop'))?>
				</div>
			</div>		
			
			
				<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Image: </label>
				<div class="col-sm-9">
				<?php if($Service['Service']['image'] !='') {?>
                            <img src="<?php echo SITEURL;?>services_img/<?php echo $Service['Service']['image'];?>" class="file-preview-image" width="100px" />
							<a href="<?php echo SITEURL;?>admin/services/delete_image/<?php echo $Service['Service']['id'];?>">Delete</a>
							<?php }else{?>
								<?php echo $this->Form->input('image',array('type'=>'file','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'image'))?>
							<?php }?>
					
				</div>
			</div>	
			
		
				<div class="form-group">
					<label for="form-field-2" class="col-sm-3 control-label no-padding-right"> Status : </label>
						<div class="col-sm-9">
						<?php if($Service['Service']['status'] == 1) { $active='checked';$inactive='';}else{  $active='';$inactive='checked';}?>
						
						<div class="radio"><label>
						<input type="radio"  value="1" <?php echo $active; ?>  class="ace" id="ServiceCategoryActive1" name="data[Service][status]"><span class="lbl">Active</span>
						</label></div>
						
						<div class="radio"><label>
							<input type="radio" value="0" class="ace" <?php echo $inactive; ?> id="ServiceCategoryActive0" name="data[Service][status]"><span class="lbl">Inactive</span>
						</label></div>
						
						
					</div>
			</div>				
		</div>
		<div class="form-group">
			<div class="col-md-offset-3 col-md-9">
				<?php echo $this->Form->submit('Submit',array('div'=>false,'label'=>false, 'class' => 'btn btn-success','id'=>'add_ser_prd_btn','value'=>'Submit'));?>&nbsp;
				<?php echo $this->Html->link('Cancel','javascript:window.history.back();',array('class' => 'btn btn-danger'));?>

			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		</div>
				<script type="text/javascript">
			jQuery(function(){ //short for $(document).ready(function(){
	

				$("#category_id").validate({
                     expression: "if (VAL >= 0) return true; else return false;",
                    message: "Please select category name"
                }); 
				$("#name").validate({
                     expression: "if (VAL) return true; else return false;",
                    message: "Please enter sub-category name"
                });$("#price").validate({
                     expression: "if (VAL) return true; else return false;",
                    message: "Please enter price name"
                });$("#price_for_shop").validate({
                     expression: "if (VAL) return true; else return false;",
                    message: "Please enter price for shop"
                }); 
			});
			</script>
