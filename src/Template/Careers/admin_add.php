	
	<div class="page-content">
		<div class="page-header">
		<div class="right_btn pull-right" ><a href="javascript:window.history.back();" class="btn btn-inverse" >Back</a></div>
		<h1>Career<small><i class="ace-icon fa fa-angle-double-right"></i> Add New Job</small>
		</h1>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
		<?php echo $this->Form->create(null, ['url' => ['controller' => 'Careers', 'action' => 'admin_add'], 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']); ?>
		
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Job Title:</label>
				<div class="col-sm-9">
					<?php echo $this->Form->control('Career.title', ['div' => false, 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'title', 'placeholder' => 'Job Title']); ?>
				</div>
			</div>	
		
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Description: </label>
				<div class="col-sm-9">
					<?php echo $this->Form->control('Career.description', ['type' => 'textarea', 'div' => false, 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'description', 'placeholder' => 'Job Description']); ?>
				
				</div>
			</div>
					
			<div class="form-group">
				<label for="form-field-2" class="col-sm-3 control-label no-padding-right"> Status: </label>
				<div class="col-sm-9">		
				
				<div class="radio"><label>
				<input type="radio" checked="checked" value="1" class="ace" id="CareerActive1" name="Career[status]"><span class="lbl"> Active</span>
				</label></div>
				
				<div class="radio"><label>
					<input type="radio" value="0" class="ace" id="CareerActive0" name="Career[status]"><span class="lbl"> Inactive</span>
				</label></div>				
				</div>
			</div>				
			<div class="form-group">
				<div class="col-md-offset-3 col-md-9">
					<?php echo $this->Form->button('Submit', ['type' => 'submit', 'div' => false, 'label' => false, 'class' => 'btn btn-success', 'id' => 'add_ser_prd_btn']); ?>&nbsp;
					<?php echo $this->Html->link('Cancel', 'javascript:window.history.back();', ['class' => 'btn btn-danger']); ?>

				</div>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>	
	</div>	
<script type="text/javascript">
			jQuery(function(){ //short for $(document).ready(function(){

				$("#title").validate({
                     expression: "if (VAL) return true; else return false;",
                    message: "Please enter title"
                }); $("#description").validate({
                     expression: "if (VAL) return true; else return false;",
                    message: "Please enter description"
                }); 
			});
			</script>
