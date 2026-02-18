<script src="<?php echo SITEURL; ?>ckeditor/ckeditor.js"></script>	
<div class="page-content">
	<div class="page-header">
	<h1>
	Field Executive Duty Requisition
	<small>
		<i class="ace-icon fa fa-angle-double-right"></i>
		Add New
	</small>
	<a href="<?php echo SITEURL; ?>documents/executive_duty_requisition" class="btn btn-mini btn-inverse" style="float:right;">Back</a>
	</h1>
	</div><!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
		
			<?php echo $this->Form->create('DocumentFieldExecutiveDuty',array('class'=>'form-horizontal','role'=>'form','enctype'=>'multipart/form-data'));?>	
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Document Id: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('DocumentFieldExecutiveDuty.documentid',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'documentid','placeholder'=>'Document Id','readonly'=>true,'style'=>'background-color: #ddd !important;','value'=>$docId))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Name of the Requistioner: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('DocumentFieldExecutiveDuty.name_of_requistioner',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'name_of_requistioner','placeholder'=>'Name of the Requistioner'))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Contact no: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('DocumentFieldExecutiveDuty.contact_no',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'contact_no','placeholder'=>'Contact no'))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Designation: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('DocumentFieldExecutiveDuty.designation',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'designation','placeholder'=>'Designation'))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Deptartment: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('DocumentFieldExecutiveDuty.deptartment',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'deptartment','placeholder'=>'Deptartment'))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Date of Visit: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('DocumentFieldExecutiveDuty.date_of_visit',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'datepicker col-xs-10 col-sm-5','id'=>'date_of_visit','placeholder'=>'Date of Visit','value'=>date('Y-m-d')))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Place of Visit: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('DocumentFieldExecutiveDuty.place_of_visit',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'place_of_visit','placeholder'=>'Place of Visit'))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Priority: </label>
					<div class="col-sm-9">
						<select name="data[DocumentFieldExecutiveDuty][priority]">
							
							<option  value="Normal">Normal</option>
							<option  value="Urgent">Urgent</option>
						</select>
					</div>
				</div>
				
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Sign of Rrequisitoner: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('DocumentFieldExecutiveDuty.sign_of_requisitoner',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'sign_of_requisitoner','placeholder'=>'Sign of Rrequisitoner'))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Sign of hod: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('DocumentFieldExecutiveDuty.sign_of_hod',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'sign_of_hod','placeholder'=>'sign of hod'))?>
					</div>
				</div>
				
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Name of contact person meet: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('DocumentFieldExecutiveDuty.name_of_contact_person_meet',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'name_of_contact_person_meet','placeholder'=>'Name of contact person meet'))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Contact Address: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('DocumentFieldExecutiveDuty.contact_address',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'contact_address','placeholder'=>'contact address'))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Contact Number: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('DocumentFieldExecutiveDuty.particular_contact_no',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'datepicker col-xs-10 col-sm-5','id'=>'particular_contact_no','placeholder'=>'contact number'))?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Name Executive Alloted: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('DocumentFieldExecutiveDuty.name_executive_alloted',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'name_executive_alloted','placeholder'=>'Name Executive Alloted'))?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Dept. date of visit: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('DocumentFieldExecutiveDuty.dept_date_of_visit',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'datepicker col-xs-10 col-sm-5','id'=>'dept_date_of_visit','placeholder'=>'Dept. date of visit','value'=>date('Y-m-d')))?>
					</div>
				</div>
				
				
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Number of days of visit: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('DocumentFieldExecutiveDuty.no_of_days_of_visit',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'no_of_days_of_visit','placeholder'=>'Number of days of visit'))?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Sign. Admin Executive: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('DocumentFieldExecutiveDuty.sing_admin_executive',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'sing_admin_executive','placeholder'=>'Sign. Admin Executive'))?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Approved By: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('DocumentFieldExecutiveDuty.approved_by',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'approved_by','placeholder'=>'Approved By'))?>
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
		
		$("#documentid").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter document id"
		});$("#name_of_requistioner").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter name of requistioner"
		});$("#contact_no").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter  contact no"
		});$("#designation").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter designation"
		});$("#deptartment").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter deptartment"
		});$("#place_of_visit").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter  place  of visit"
		}); 
	});
</script>