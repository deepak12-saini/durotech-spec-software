<script src="<?php echo SITEURL; ?>ckeditor/ckeditor.js"></script>	
<div class="page-content">
	<div class="page-header">
	<h1>
	Document Receive Inspection 
	<small>
		<i class="ace-icon fa fa-angle-double-right"></i>
		Edit 
	</small>
	<a href="<?php echo SITEURL; ?>documents/receiving_insepction" class="btn btn-mini btn-inverse" style="float:right;">Back</a>
	</h1>
	</div><!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
		
				<?php echo $this->Form->create('Document',array('class'=>'form-horizontal','role'=>'form','enctype'=>'multipart/form-data'));?>	
				<?php echo $this->Form->input('DocumentReceiveInspection.id',array('type'=>'hidden'))?>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Document Id: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('DocumentReceiveInspection.documentid',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'documentid','placeholder'=>'Document Id','readonly'=>true,'style'=>'background-color: #ddd !important;'))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Product Name: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('DocumentReceiveInspection.product_name',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'product_name','placeholder'=>'product_name'))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
					<div class="col-sm-9">
						<table style=" width:100%; ">
							<tr>
								<th>Property</th>
								<th>Result From Certificate</th>
								<th>Actual Result</th>
							</tr>
							
							<tr>								
								<td>pH	 <input type="hidden" name="data[ph][propery][]"  value="<?php echo $docArr['DocumentReceiveInspection']['ph_property']; ?>" style="margin:5px;" required /></td>
								<td> <input type="text" name="data[ph][certificate_result][]"  value="<?php echo $docArr['DocumentReceiveInspection']['ph_certificate_result']; ?>" style="margin:5px;" required /></td>								
								<td> <input type="text" name="data[ph][actual_result][]"  value="<?php echo $docArr['DocumentReceiveInspection']['ph_actual_result']; ?>"  style="margin:5px;"  required /></td>
							</tr>
							<tr>								
								<td>%Solids	 <input type="hidden" name="data[solids][propery][]"  value="<?php echo $docArr['DocumentReceiveInspection']['solid_property']; ?>" style="margin:5px;" required /></td>
								<td> <input type="text" name="data[solids][certificate_result][]"  value="<?php echo $docArr['DocumentReceiveInspection']['solid_certificate_result']; ?>" style="margin:5px;" required /></td>								
								<td> <input type="text" name="data[solids][actual_result][]"  value="<?php echo $docArr['DocumentReceiveInspection']['solid_actual_result']; ?>"  style="margin:5px;" required  /></td>
							</tr>
							<tr>								
								<td>Specific Gravity @ 25 C	 <input type="hidden" name="data[gravity][propery][]"   value="<?php echo $docArr['DocumentReceiveInspection']['gravity_property']; ?>"  style="margin:5px;" required /></td>
								<td> <input type="text" name="data[gravity][certificate_result][]"   value="<?php echo $docArr['DocumentReceiveInspection']['gravity_certificate_result']; ?>"  style="margin:5px;" required /></td>								
								<td> <input type="text" name="data[gravity][actual_result][]"   value="<?php echo $docArr['DocumentReceiveInspection']['gravity_actual_result']; ?>"   style="margin:5px;"  required /></td>
							</tr>
							<tr>								
								<td>Viscosity  @ 25 C <input type="hidden" name="data[viscosity][propery][]"   value="<?php echo $docArr['DocumentReceiveInspection']['viscosity_property']; ?>" style="margin:5px;"  required  /></td>
								<td> <input type="text" name="data[viscosity][certificate_result][]"   value="<?php echo $docArr['DocumentReceiveInspection']['viscosity_certificate_result']; ?>"  style="margin:5px;" required  /></td>								
								<td> <input type="text" name="data[viscosity][actual_result][]"  value="<?php echo $docArr['DocumentReceiveInspection']['viscosity_actual_result']; ?>"   style="margin:5px;"  required  /></td>
							</tr>


						</table>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">signature: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('DocumentReceiveInspection.signature',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'signature','placeholder'=>'signature'))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Final Date: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('DocumentReceiveInspection.finaldate',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'finaldate','placeholder'=>'finaldate'))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Pass Fail: </label>
					<div class="col-sm-9">
						<input type="radio" value="Yes" name="data[DocumentReceiveInspection][pass_fail]" <?php if($docArr['DocumentReceiveInspection']['pass_fail'] ==  'Yes'){ echo 'checked'; } ?> > Yes
						<input type="radio" value="No" name="data[DocumentReceiveInspection][pass_fail]"  <?php if($docArr['DocumentReceiveInspection']['pass_fail'] ==  'No'){ echo 'checked'; } ?> > No
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Concessional Pass: </label>
					<div class="col-sm-9">
						<input type="radio" value="Yes" name="data[DocumentReceiveInspection][concessional_pass]"   <?php if($docArr['DocumentReceiveInspection']['concessional_pass'] ==  'Yes'){ echo 'checked'; } ?> > Yes
						<input type="radio" value="No" name="data[DocumentReceiveInspection][concessional_pass]"   <?php if($docArr['DocumentReceiveInspection']['concessional_pass'] ==  'No'){ echo 'checked'; } ?> > No
					</div>
				</div>
					<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Status: </label>
					<div class="col-sm-9">
						<input type="radio" value="1" name="data[DocumentReceiveInspection][status]"   <?php if($docArr['DocumentReceiveInspection']['status'] ==  1){ echo 'checked'; } ?> > Pending
						<input type="radio" value="2" name="data[DocumentReceiveInspection][status]"   <?php if($docArr['DocumentReceiveInspection']['status'] ==  2){ echo 'checked'; } ?> > Complete
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