<style>
tr td input[type="text"]{ width:139px !important;}
</style>
<script src="<?php echo SITEURL; ?>ckeditor/ckeditor.js"></script>	
<div class="page-content">
	<div class="page-header">
	<h1>
		Handling/Taking Over Duties & Responsibilties During Leave
	<small>
		<i class="ace-icon fa fa-angle-double-right"></i>
		Edit
	</small>
	<a href="<?php echo SITEURL; ?>hrs/res_during_leave" class="btn btn-mini btn-inverse" style="float:right;">Back</a>
	</h1>
	</div><!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
		
			<?php echo $this->Form->create('HrDuringLeave',array('class'=>'form-horizontal','role'=>'form','enctype'=>'multipart/form-data'));?>	
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Documentid: </label>
					<div class="col-sm-9">
						<?php 						
						echo $this->Form->input('HrDuringLeave.documentid',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'documentid','placeholder'=>'Documentid','readonly'=>true,'style'=>'background-color: #ddd !important;'));
						?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Leave Period From: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('HrDuringLeave.leave_from',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'datepicker col-xs-10 col-sm-5','id'=>'leave_from','placeholder'=>'Leave Period From'))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Leave Period To: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('HrDuringLeave.leave_to',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'datepicker col-xs-10 col-sm-5','id'=>'leave_to','placeholder'=>'Leave Period To'))?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Name of Employee: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('HrDuringLeave.name_of_employee',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'name_of_employee','placeholder'=>'Name of Employee'))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Designation: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('HrDuringLeave.designation',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'designation','placeholder'=>'Designation'))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Department: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('HrDuringLeave.department',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'department','placeholder'=>'Department'))?>
					</div>
				</div>
				
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
					<div class="col-sm-9">
						<div class="table-responsive">
						<table style=" width:100% !important; ">
							<tr>		
								<th>Description of Duties</th>
								<th>Responsibilities</th>
								<th>Handed over</th>
								<th>Assigned To</th>
								<th>Signature</th>
								<th></th>
							</tr>
							<tbody>
								
							</tbody>
														
						</table>
						<?php 	
						$i=0;	
						foreach ($docArr['HrDuringLeaveRecord'] as $docArrs){ 						
						?>
							<table style=" width:100% !important; " id="tbl_<?php echo $i; ?>"><tbody><tr>
							
							<td> <input type="text" name="data[description_of_duty][]"  value="<?php echo $docArrs['description_of_duty']; ?>"  placeholder="Description of duty"  required /></td>		
							<td> <input type="text" name="data[description_of_responsibility][]"  value="<?php echo $docArrs['description_of_responsibility']; ?>"  placeholder="Enter responsibility"  required /></td>					
							<td> <input type="text" name="data[handed_over][]"  value="<?php echo $docArrs['handed_over']; ?>"  placeholder="handed over"  required /></td>					
							<td> <input type="text" name="data[assigned_to][]"  value="<?php echo $docArrs['assigned_to']; ?>" placeholder="Assigned To" required /></td>	
							<td> <input type="text" name="data[signature][]"  value="<?php echo $docArrs['signature']; ?>" placeholder="Signature" required /></td>	
							<td><a style="visibility:hidden;" href="#null" onclick="deletetrow('+n+')"><i class="fa fa-close" style="color:red;"> </i></a> </td>	
							</tr></tbody></table><br>
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
		var  tablevew = '<table style=" width:100% !important; " id="tbl_'+n+'"><tbody><tr><td> <input type="text" name="data[description_of_duty][]"  placeholder="Description of duty"  value=""  required /></td><td> <input type="text" name="data[description_of_responsibility][]"  placeholder="Enter Responsibility"  value=""  required /></td><td> <input type="text" name="data[handed_over][]"  value="" placeholder="Handed over"  required /></td>	<td> <input type="text" name="data[assigned_to][]"  value="" placeholder="assigned to" required /></td><td> <input type="text" name="data[signature][]"  value="" placeholder="signature" required /></td><td><a href="#null" onclick="deletetrow('+n+')"><i class="fa fa-close" style="color:red;"> </i></a> </td></tr></tbody></table>';
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