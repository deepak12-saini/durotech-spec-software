<script src="<?php echo SITEURL; ?>ckeditor/ckeditor.js"></script>	
<div class="page-content">
	<div class="page-header">
	<h1>
	Calibration status of Instrument / Equipment
	<small>
		<i class="ace-icon fa fa-angle-double-right"></i>
		eDIT
	</small>
	<a href="<?php echo SITEURL; ?>documents/calibration_equipment" class="btn btn-mini btn-inverse" style="float:right;">Back</a>
	</h1>
	</div><!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
		
			<?php echo $this->Form->create('DocumentCalibration',array('class'=>'form-horizontal','role'=>'form','enctype'=>'multipart/form-data'));?>	
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Document Id: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('DocumentCalibration.documentid',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'documentid','placeholder'=>'Document Id','readonly'=>true,'style'=>'background-color: #ddd !important;'))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Date: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('DocumentCalibration.date',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'datepicker col-xs-10 col-sm-5','id'=>'datepicker','placeholder'=>'Date'))?>
					</div>
				</div>
				
				
				<div class="form-group">
					<label class="col-sm-1 control-label no-padding-right" for="form-field-1"></label>
					<div class="col-sm-12">
						<div class="table-responsive">
						<table style=" width:100% !important; ">
							<tr>								
								<th></th>
								<th>Tool/Equipment</th>
								<th>Location</th>
								<th>Test/Period</th>
								<th>Person Resonsible</th>
								<th>Date Added</th>
								<th>Standard</th>
							</tr>
							<?php 
							$j=0;
							for($i=1; $i < 9; $i++){
								if($i ==1){
									$req = 'required';
								}else{
									$req = '';
								}
								
								isset($docArr['DocumentCalibrationReocrd'][$j]['tool_equipment_description'])? $tool_equipment_description = $docArr['DocumentCalibrationReocrd'][$j]['tool_equipment_description'] : $tool_equipment_description = '';
								isset($docArr['DocumentCalibrationReocrd'][$j]['location'])? $location = $docArr['DocumentCalibrationReocrd'][$j]['location'] : $location = '';
								isset($docArr['DocumentCalibrationReocrd'][$j]['test_period'])? $test_period = $docArr['DocumentCalibrationReocrd'][$j]['test_period'] : $test_period = '';
								isset($docArr['DocumentCalibrationReocrd'][$j]['person_responsible'])? $person_responsible = $docArr['DocumentCalibrationReocrd'][$j]['person_responsible'] : $person_responsible = '';
								isset($docArr['DocumentCalibrationReocrd'][$j]['date_added'])? $date_added = $docArr['DocumentCalibrationReocrd'][$j]['date_added'] : $date_added = '';
								isset($docArr['DocumentCalibrationReocrd'][$j]['standard_identification'])? $standard_identification = $docArr['DocumentCalibrationReocrd'][$j]['standard_identification'] : $standard_identification = '';
								
								
							?>
								<tr>									
									<td><?php echo $i; ?></td>
									<td> <input type="text" name="data[tool_equipment_description][<?php echo $i ?>]"  value="<?php echo $tool_equipment_description; ?>" placeholder="Tool/Equipment" style="margin:5px;" <?php echo $req; ?>  /></td>
									<td> <input type="text" name="data[location][<?php echo $i ?>]"  value="<?php echo $location; ?>" placeholder="Location" style="margin:5px;"  <?php echo $req; ?> /></td>													
									<td> <input type="text" name="data[test_period][<?php echo $i ?>]"  value="<?php echo $test_period; ?>"  class="" placeholder="Test/Period" style="margin:5px;"   <?php echo $req; ?> /></td>
									<td> <input type="text" name="data[person_responsible][<?php echo $i ?>]"  value="<?php echo $person_responsible; ?>"  placeholder="Person Resonsible" style="margin:5px;"  <?php echo $req; ?>  /></td>
									<td> <input type="text" name="data[date_added][<?php echo $i ?>]"  value="<?php echo $date_added; ?>" class="datepicker" placeholder="Date Added"  style="margin:5px;"  <?php echo $req; ?>  /></td>
									<td> <input type="text" name="data[standard_identification][<?php echo $i ?>]"  value="<?php echo $standard_identification; ?>"   placeholder="Standard" style="margin:5px;"   <?php echo $req; ?> /></td>
								</tr>
							<?php $j++; } ?>
							

						</table>
					</div>
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