<script src="<?php echo SITEURL; ?>ckeditor/ckeditor.js"></script>	
<div class="page-content">
	<div class="page-header">
	<h1>
	Project Reminders
	<small>
		<i class="ace-icon fa fa-angle-double-right"></i>
		Edit 
	</small>
		<a href="<?php echo SITEURL; ?>project_reminders" class="btn btn-mini btn-inverse" style="float:right;">Back</a>
	</h1>
	</div><!-- /.page-header -->
	<style>
	.template{ border:1px solid #000; padding:10px; margin:10px 0px; }
	</style>
	<div class="row">
		<div class="col-xs-12">
		
			<?php echo $this->Form->create('ProjectReminder',array('class'=>'form-horizontal','role'=>'form','enctype'=>'multipart/form-data'));?>	
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Project Code: </label>
					<div class="col-sm-9">
						<?php 
						echo $this->Form->input('ProjectReminder.project_code',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'project_code','placeholder'=>'project code','value'=>$ProjectReminder['ProjectReminder']['project_code']))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Project Name: </label>
					<div class="col-sm-9">
						<?php 
						echo $this->Form->input('ProjectReminder.project_name',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'project_name','placeholder'=>'Project Name','value'=>$ProjectReminder['ProjectReminder']['project_name']))?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Reminder: </label>
					<div class="col-sm-9">
						<input type="checkbox" <?php if($ProjectReminder['ProjectReminder']['is_email'] == 1){ echo 'checked'; } ?>  name="is_email" value="1" checked> Email Reminder
						<!--input type="checkbox" name="is_sms" value="1"> Sms Reminder-->
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Status: </label>
					<div class="col-sm-9">
						<input <?php if($ProjectReminder['ProjectReminder']['status'] == 0){ echo 'checked'; } ?> type="radio" name="data[ProjectReminder][status]" value="0" > Pending
						<input <?php if($ProjectReminder['ProjectReminder']['status'] == 1){ echo 'checked'; } ?> type="radio" name="data[ProjectReminder][status]" value="1"> Complete
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Status: </label>
					<div class="col-sm-9">
						<select name="data[ProjectReminder][important]" id="important" class="col-xs-10 col-sm-5">
							<option value="">Select Important Status</option>
							<option <?php if($ProjectReminder['ProjectReminder']['important'] == 'Normal'){ echo 'selected'; } ?> value="Normal">Normal</option>
							<option  <?php if($ProjectReminder['ProjectReminder']['important'] == 'Important'){ echo 'selected'; } ?> value="Important">Important</option>
							<option  <?php if($ProjectReminder['ProjectReminder']['important'] == 'Very Important'){ echo 'selected'; } ?>  value="Very Important">Very Important</option>
						</select>
					</div>
				</div>
				
				<div class="form-group">
				<div class="col-md-offset-3 col-md-9">
					<?php echo $this->Form->submit('Submit',array('div'=>false,'label'=>false, 'class' => 'btn btn-xs btn-success','id'=>'add_ser_prd_btn','value'=>'Submit'));?>&nbsp;
					<?php echo $this->Html->link('Cancel','javascript:window.history.back();',array('class' => 'btn btn-xs btn-danger'));?>

				</div>
				</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>
<script type="text/javascript">
	jQuery(function(){ 
		$('.datepicker').datepicker({
			format: 'yyyy-mm-dd',			
		});		
		$("#project_name").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter project name"
		});$("#project_code").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter project code"
		});$("#important").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please select project status"
		});$("#email").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter email"
		});
	});
</script>