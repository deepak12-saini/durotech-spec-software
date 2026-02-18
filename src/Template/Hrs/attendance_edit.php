<style>
tr td input[type="text"]{ width:139px !important;}
</style>
<script src="<?php echo SITEURL; ?>ckeditor/ckeditor.js"></script>	
<div class="page-content">
	<div class="page-header">
	<h1>
		Hr Training Attendance
	<small>
		<i class="ace-icon fa fa-angle-double-right"></i>
		Edit
	</small>
	<a href="<?php echo SITEURL; ?>hrs/attendence" class="btn btn-mini btn-inverse" style="float:right;">Back</a>
	</h1>
	</div><!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
		
			<?php echo $this->Form->create('HrTrainingAttendance',array('class'=>'form-horizontal','role'=>'form','enctype'=>'multipart/form-data'));?>	
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Documentid: </label>
					<div class="col-sm-9">
						<?php 						
						echo $this->Form->input('HrTrainingAttendance.documentid',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'documentid','placeholder'=>'Documentid','readonly'=>true,'style'=>'background-color: #ddd !important;'));
						?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Date: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('HrTrainingAttendance.date',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'datepicker col-xs-10 col-sm-5','id'=>'date','placeholder'=>'Date of Order'))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Training Date: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('HrTrainingAttendance.training_date',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'datepicker col-xs-10 col-sm-5','id'=>'training_date','placeholder'=>'Training Date'))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Training Title: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('HrTrainingAttendance.training_title',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'training_title','placeholder'=>'Training Title'))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Trainers Name: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('HrTrainingAttendance.trainers_name',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'trainers_name','placeholder'=>'Trainers Name'))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Duration: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('HrTrainingAttendance.duration',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'duration','placeholder'=>'Duration'))?>
					</div>
				</div>
				
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
					<div class="col-sm-9">
						<div class="table-responsive">
						<table style=" width:100% !important; ">
							<tr>		
								<th>Trainee Name</th>								
								<th>Department</th>
								<th>Signature</th>
								<th>Date</th>
								<th></th>
							</tr>
							<tbody>
								
							</tbody>
														
						</table>
						<?php 	
						$i=1;	
						foreach ($docArr['HrTrainingAttendanceRecord'] as $docArrs){ 						
						?>
							<table style=" width:100% !important; " id="tbl_<?php echo $i; ?>"><tbody><tr><td> <input name="data[trainee_name][]" placeholder="Enter Trainee Name" value="<?php echo $docArrs['trainee_name']; ?>" required="" type="text"></td><td> <input name="data[department][]" placeholder="Enter Deptarment" value="<?php echo $docArrs['department']; ?>" required="" type="text"></td><td> <input name="data[signature][]" value="<?php echo $docArrs['signature']; ?>" placeholder="Signature" required="" type="text"></td>	<td> <input name="data[date][]" value="<?php echo $docArrs['date']; ?>" placeholder="YYYY-MM-DD" required="" type="text"></td><td><a  <?php if($i == 1){ ?> style="visibility:hidden;" <?php } ?> href="#null" onclick="deletetrow(<?php echo $i; ?>)"><i class="fa fa-close" style="color:red;"> </i></a> </td></tr></tbody></table><br>
						<?php $i++; } ?>
						<div class="tblrow"></div>
						
						</div>
						<br>
						<a href="#null" class="btn btn-mini btn-info" onclick="addmore()"> Add More</a>
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
	
	function deletetrow(noid){
		$("#tbl_"+noid).remove();
	}
	function addmore(){
	
		var n = $("#center div").length + 1;
		var  tablevew = '<table style=" width:100% !important; " id="tbl_'+n+'"><tbody><tr><td> <input type="text" name="data[trainee_name][]"  placeholder="Enter Trainee Name"  value=""  required /></td><td> <input type="text" name="data[department][]"  placeholder="Enter Deptarment"  value=""  required /></td><td> <input type="text" name="data[signature][]"  value="" placeholder="Signature"  required /></td>	<td> <input type="text" name="data[date][]"  value="" placeholder="YYYY-MM-DD" required /></td><td><a href="#null" onclick="deletetrow('+n+')"><i class="fa fa-close" style="color:red;"> </i></a> </td></tr></tbody></table>';
		$(".tblrow").append('<br/>'+tablevew);
	}
	
	
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