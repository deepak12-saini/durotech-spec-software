<style>
tr td input[type="text"]{ width:139px !important;}
</style>
<script src="<?php echo SITEURL; ?>ckeditor/ckeditor.js"></script>	
<div class="page-content">
	<div class="page-header">
	<h1>
	Hr Training Need Assessment
	<small>
		<i class="ace-icon fa fa-angle-double-right"></i>
		Edit 
	</small>
	<a href="<?php echo SITEURL; ?>hrs" class="btn btn-mini btn-inverse" style="float:right;">Back</a>
	</h1>
	</div><!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
		
			<?php echo $this->Form->create('HrTrainingNeedAssessment',array('class'=>'form-horizontal','role'=>'form','enctype'=>'multipart/form-data'));?>	
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Documentid: </label>
					<div class="col-sm-9">
						<?php 						
						echo $this->Form->input('HrTrainingNeedAssessment.documentid',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'documentid','placeholder'=>'Documentid','readonly'=>true,'style'=>'background-color: #ddd !important;'));
						?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Date: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('HrTrainingNeedAssessment.date',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'datepicker col-xs-10 col-sm-5','id'=>'date','placeholder'=>'Date of Order'))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Employee Name: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('HrTrainingNeedAssessment.employee_name',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'employee_name','placeholder'=>'Employee Name'))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Qualification: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('HrTrainingNeedAssessment.qualification',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'qualification','placeholder'=>'Qualification'))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Department: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('HrTrainingNeedAssessment.department',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'department','placeholder'=>'Department'))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Designation: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('HrTrainingNeedAssessment.designation',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'designation','placeholder'=>'Designation'))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Experience: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('HrTrainingNeedAssessment.experience',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'experience','placeholder'=>'Experience'))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Signature: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('HrTrainingNeedAssessment.signature',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'signature','placeholder'=>'Signature'))?>
					</div>
				</div>
				<div class="form-group">
				
					<div class="col-sm-12">
						<div class="table-responsive">
						<table style=" width:100% !important; ">
							<tr>		
								<th>Performance/Rating</th>
								<th>1</th>
								<th>2</th>
								<th>3</th>
								<th>4</th>
								<th>5</th>
								<th>Remarks</th>
							</tr>
							<tbody>
								<?php foreach($docArr['HrTrainingNeedAssessmentRecord'] as $records){ ?>
								<tr>									
									<td> <input type="text" name="data[performance_rating][]"  value="<?php echo $records['performance_rating']; ?>"  style="margin:5px; background-color:#ddd;" readonly    /></td>
									<td> <input type="text" name="data[record_1][]"  value="<?php echo $records['record_1']; ?>" placeholder="Result_1" style="margin:5px;"   /></td>	
									<td> <input type="text" name="data[record_2][]"  value="<?php echo $records['record_2']; ?>" placeholder="Result_2" style="margin:5px;"   /></td>	
									<td> <input type="text" name="data[record_3][]"  value="<?php echo $records['record_3']; ?>" placeholder="Result_3" style="margin:5px;"   /></td>	<td> <input type="text" name="data[record_4][]"  value="<?php echo $records['record_4']; ?>" placeholder="Result_4" style="margin:5px;"   /></td>
									<td> <input type="text" name="data[record_5][]"  value="<?php echo $records['record_5']; ?>" placeholder="Result_5" style="margin:5px;"   /></td>
									<td> <input type="text" name="data[remark][]"  value="<?php echo $records['remark']; ?>" placeholder="Remark" style="margin:5px;"   /></td>		
											
								</tr>
								<?php } ?>
							</tbody>
														
						</table>
						
						</div>
						
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
		
		$("#machine_id").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter Machine Id Number"
		});$("#account_name").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter account name"
		});$("#order_taken_by").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter  order taken by"
		});$("#contact_name").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter contact name"
		});$("#deliver_address").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter deliver address"
		});$("#auditee").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter auditee"
		}); 
	});
</script>