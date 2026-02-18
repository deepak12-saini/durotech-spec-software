<script src="<?php echo SITEURL; ?>ckeditor/ckeditor.js"></script>	
<div class="page-content">
	<div class="page-header">
	<h1>
	Document Title Records of Library
	<small>
		<i class="ace-icon fa fa-angle-double-right"></i>
		Edit
	</small>
	<a href="<?php echo SITEURL; ?>documents" class="btn btn-mini btn-inverse" style="float:right;">Back</a>
	</h1>
	</div><!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
		
			<?php echo $this->Form->create('DocumentLibrary',array('class'=>'form-horizontal','role'=>'form','enctype'=>'multipart/form-data'));?>	
				<?php echo $this->Form->input('id',array('type'=>'hidden'))?>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Document Id: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('documentid',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'documentid','placeholder'=>'Document Id','readonly'=>true,'style'=>'background-color: #ddd !important;'))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Date: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('date',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'datepicker col-xs-10 col-sm-5','id'=>'actioned_by_date','placeholder'=>'Audit Date'))?>
					</div>
				</div>
							
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Designation: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('desigaration',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'desigaration','placeholder'=>'Designation'))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Department: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('department',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'department','placeholder'=>'Department'))?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Name of Indentor: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('name_of_indentor',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'name_of_indentor','placeholder'=>'Name of Indentor'))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Date of Requisition: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('date_of_requisition',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'datepicker col-xs-10 col-sm-5','id'=>'date_of_requisition','placeholder'=>'Date of Requisition'))?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Co-ordinator: </label>
					<div class="col-sm-9">
						<select class="col-xs-10 col-sm-5" name="data[DocumentLibrary][sign_of_coordinator]">
							<option value="">Sign of Co-ordinator</option>
							<?php foreach($cuser as $userArrs){ ?>
								<option value="<?php echo $userArrs['NappUser']['id']; ?>" <?php if($userArrs['NappUser']['id'] == $docArr['DocumentLibrary']['sign_of_coordinator']){ echo 'selected'; }?> ><?php echo $userArrs['NappUser']['name'].' '.$userArrs['NappUser']['lname']; ?></option>
							<?php } ?>
						</select>
						
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Sign of Hod: </label>
					<div class="col-sm-9">
						<select class="col-xs-10 col-sm-5" name="data[DocumentLibrary][sign_of_hod]" >
							<option value="">Sign of Hod</option>
							<?php foreach($cuser as $userArrs){ ?>
								<option  <?php if($userArrs['NappUser']['id'] == $docArr['DocumentLibrary']['sign_of_hod']){ echo 'selected'; }?> value="<?php echo $userArrs['NappUser']['id']; ?>"><?php echo $userArrs['NappUser']['name'].' '.$userArrs['NappUser']['lname']; ?></option>
							<?php } ?>
						</select>						
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