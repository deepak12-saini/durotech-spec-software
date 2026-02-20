<script src="<?php echo SITEURL; ?>ckeditor/ckeditor.js"></script>	
<div class="page-content">
	<div class="page-header">
	<h1>
	Internal Audit Planning  
	<small>
		<i class="ace-icon fa fa-angle-double-right"></i>
		Add New
	</small>
	<a href="<?php echo SITEURL; ?>audits" class="btn btn-mini btn-inverse" style="float:right;">Back</a>
	</h1>
	</div><!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
		
			<?php echo $this->Form->create('Audit',array('class'=>'form-horizontal','role'=>'form','enctype'=>'multipart/form-data'));?>	
				
				
					
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Audit Number: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('audit_number',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'audit_number','placeholder'=>'Audit Number','value'=>$auditnumber,'readonly'=>true,'style'=>'background-color: #ddd !important;'))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Date: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('date',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'datepicker col-xs-10 col-sm-5','id'=>'actioned_by_date','placeholder'=>'Audit Date','value'=>date('Y-m-d')))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Department To Be Audited: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('department_to_be_audited',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'department_to_be_audited','placeholder'=>'Department To Be Audited','value'=>''))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">A.I Planning Date: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('ai_planing_date',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'datepicker col-xs-10 col-sm-5','id'=>'ai_planing_date','placeholder'=>'A.I Planning Date','value'=>date('Y-m-d')))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">A.I Conducted Date: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('ai_conducted_date',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'datepicker col-xs-10 col-sm-5','id'=>'ai_conducted_date','placeholder'=>'A.I Conducted Date','value'=>date('Y-m-d')))?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Auditor: </label>
					<div class="col-sm-9">
						<select class="col-xs-10 col-sm-5" name="data[Audit][auditor]">
							<option value="">Select Auditor</option>
							<?php foreach($userArr as $userArrs){ ?>
								<option value="<?php echo $userArrs['NappUser']['id']; ?>"><?php echo $userArrs['NappUser']['name'].' '.$userArrs['NappUser']['lname']; ?></option>
							<?php } ?>
						</select>
						
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Auditee: </label>
					<div class="col-sm-9">
						<select class="col-xs-10 col-sm-5" name="data[Audit][auditee]">
							<option value="">Select Auditee</option>
							<?php foreach($userArr as $userArrs){ ?>
								<option value="<?php echo $userArrs['NappUser']['id']; ?>"><?php echo $userArrs['NappUser']['name'].' '.$userArrs['NappUser']['lname']; ?></option>
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
		
		$("#audit_number").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter audit number"
		});$("#department_to_be_audited").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter departmen to be audited"
		});$("#ai_planing_date").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter  A.I planing date"
		});$("#ai_conducted_date").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter  A.I conducted date"
		});$("#auditor").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter auditor"
		});$("#auditee").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter auditee"
		}); 
	});
</script>