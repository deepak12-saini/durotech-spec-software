<script src="<?php echo SITEURL; ?>ckeditor/ckeditor.js"></script>	
<div class="page-content">
	<div class="page-header">
	<h1>
	Preventive Maintenance
	<small>
		<i class="ace-icon fa fa-angle-double-right"></i>
		Add New
	</small>
	<a href="<?php echo SITEURL; ?>documents/preventive_maintenance" class="btn btn-mini btn-inverse" style="float:right;">Back</a>
	</h1>
	</div><!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
		
			<?php echo $this->Form->create('DocumentPreventiveMaintenance',array('class'=>'form-horizontal','role'=>'form','enctype'=>'multipart/form-data'));?>	
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Document Id: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('DocumentPreventiveMaintenance.documentid',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'documentid','placeholder'=>'Document Id','readonly'=>true,'style'=>'background-color: #ddd !important;','value'=>$docId))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Machine Id Number: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('DocumentPreventiveMaintenance.machine_id',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'machine_id','placeholder'=>'Machine Id Number'))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Location: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('DocumentPreventiveMaintenance.location',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'location','placeholder'=>'Location'))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Period of Record From: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('DocumentPreventiveMaintenance.period_from',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'period_from','placeholder'=>'Period of Record From','value'=>date('Y-m-d')))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Period of Record To: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('DocumentPreventiveMaintenance.period_to',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'period_to','placeholder'=>'Period of Record From','value'=>date('Y-m-d')))?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-1 control-label no-padding-right" for="form-field-1"></label>
					<div class="col-sm-11">
						<table style=" width:50% !important; ">
							<tr>								
								<th></th>
								<th>Job To Be Done</th>
								<th>Frequency</th>
								<th>Date</th>
								<th>Major job <br>details/Parts changed</th>
								<th>Sign</th>
							</tr>
							<?php 
							
							for($i=1; $i < 9; $i++){
								if($i ==1){
									$req = 'required';
								}else{
									$req = '';
								}
							?>
								<tr>								
									
									<td><?php echo $i; ?></td>
									<td> <input type="text" name="data[jobtobedone][<?php echo $i ?>]"  value="" placeholder="Job To Be Done" style="margin:5px;" <?php echo $req; ?>  /></td>
									<td> <input type="text" name="data[frequency][<?php echo $i ?>]"  value="" placeholder="Frequency" style="margin:5px;"  <?php echo $req; ?> /></td>								
									<td> <input type="text" name="data[date][<?php echo $i ?>]"  value=""  class="datepicker" placeholder="Date" style="margin:5px;"   <?php echo $req; ?> /></td>
									<td> <input type="text" name="data[major_job_detail][<?php echo $i ?>]"  value=""  placeholder="Major job  details/Parts changed" style="margin:5px;"  <?php echo $req; ?>  /></td>
									<td> <input type="text" name="data[sign][<?php echo $i ?>]"  value="" placeholder="Sign"  style="margin:5px;"  <?php echo $req; ?>  /></td>
								</tr>
							<?php } ?>
							

						</table>
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
	</div>
</div>
<script type="text/javascript">
	
	jQuery(function(){ 
		$('.datepicker').datepicker({
			format: 'yyyy-mm-dd',			
		});
		
		$("#machine_id").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter Machine Id Number"
		});$("#desigaration").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter designation"
		});$("#department").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter  department"
		});$("#name_of_indentor").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter name of indentor"
		});$("#auditor").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter auditor"
		});$("#auditee").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter auditee"
		}); 
	});
</script>