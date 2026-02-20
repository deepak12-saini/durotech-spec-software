<script src="<?php echo SITEURL; ?>ckeditor/ckeditor.js"></script>	
<script type="text/javascript" src="<?php echo SITEURL; ?>jquery.timepicker.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo SITEURL; ?>jquery.timepicker.css" />
<div class="page-content">
	<div class="page-header">
	<h1>
	Circular Internal Audit
	<small>
		<i class="ace-icon fa fa-angle-double-right"></i>
		Result Circular Internal Audit
	</small>
	<a href="<?php echo SITEURL; ?>audits/circularinternalauditlist" class="btn btn-mini btn-inverse" style="float:right;">Back</a>
	</h1>
	</div><!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
		
			<?php 
			
			echo $this->Form->create('CircularInternalAudit',array('class'=>'form-horizontal','role'=>'form','enctype'=>'multipart/form-data'));?>	
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Audit Number: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('audi_no',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'audi_no','placeholder'=>'Audit Number','readonly'=>true,'style'=>'background-color: #ddd !important;','value'=>$InternalAuditPlan['CircularInternalAudit']['audi_no']))?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label no-padding-right" for="form-field-1"></label>
					<div class="col-sm-10">
					<table>
						<tr>
							<th style="text-align:center;">Department</th>
							<th style="text-align:center;">Date</th>
							<th style="text-align:center;">Time</th>
							<th style="text-align:center;">Auditor</th>
							<th style="text-align:center;" >Auditee</th>
						</tr>
						<tr>
						
							<td>Top Management</td>
							<td><input type="text" name="date[0][datetime]" value="<?php if(isset($CircularInternalAuditResult[0]['CircularInternalAuditResult']['date'])){ echo $CircularInternalAuditResult[0]['CircularInternalAuditResult']['date']; } ?>" class="datepicker" placeholder="Select Date"  style="margin:10px;"></td>
							
							<td><input type="text" name="date[0][time]" class="timepicker" value="<?php if(isset($CircularInternalAuditResult[0]['CircularInternalAuditResult']['time'])){ echo $CircularInternalAuditResult[0]['CircularInternalAuditResult']['time']; } ?>"  placeholder="Enter time  08:00 am"  style="margin:10px;"></td>
							<td>
								<select  name="date[0][auditor]"  style="margin:10px;">
									<option value="">Select Auditor</option>
									<?php foreach($userArr as $userArrs){ ?>
										<option <?php if(isset($CircularInternalAuditResult[0]['CircularInternalAuditResult']['auditor']) && ($CircularInternalAuditResult[0]['CircularInternalAuditResult']['auditor'] == $userArrs['NappUser']['id'])){ echo 'selected'; } ?> value="<?php echo $userArrs['NappUser']['id']; ?>"><?php echo $userArrs['NappUser']['name'].' '.$userArrs['NappUser']['lname']; ?></option>
									<?php } ?>
								</select>
							</td>
							<td>
								<select name="date[0][auditee]"  style="margin:10px;">
									<option value="">Select Auditee</option>
									<?php foreach($userArr as $userArrs){ ?>
										<option  <?php if(isset($CircularInternalAuditResult[0]['CircularInternalAuditResult']['auditee']) && ($CircularInternalAuditResult[0]['CircularInternalAuditResult']['auditee'] == $userArrs['NappUser']['id'])){ echo 'selected'; } ?> value="<?php echo $userArrs['NappUser']['id']; ?>"><?php echo $userArrs['NappUser']['name'].' '.$userArrs['NappUser']['lname']; ?></option>
									<?php } ?>
								</select>
							</td>
						</tr>
						<tr>
							<td>Management Represenative</td>
							<td><input type="text" value="<?php if(isset($CircularInternalAuditResult[1]['CircularInternalAuditResult']['date'])){ echo $CircularInternalAuditResult[1]['CircularInternalAuditResult']['date']; } ?>" name="date[1][datetime]" class="datepicker" placeholder="Select Date"  style="margin:10px;"></td>
							<td><input type="text" class="timepicker" value="<?php if(isset($CircularInternalAuditResult[1]['CircularInternalAuditResult']['time'])){ echo $CircularInternalAuditResult[1]['CircularInternalAuditResult']['time']; } ?>" name="date[1][time]" class="" placeholder="Enter time  08:00 am"  style="margin:10px;"></td>
							<td>
								<select  name="date[1][auditor]"  style="margin:10px;">
									<option value="">Select Auditor</option>
									<?php foreach($userArr as $userArrs){ ?>
										<option <?php if(isset($CircularInternalAuditResult[1]['CircularInternalAuditResult']['auditor']) && ($CircularInternalAuditResult[1]['CircularInternalAuditResult']['auditor'] == $userArrs['NappUser']['id'])){ echo 'selected'; } ?> value="<?php echo $userArrs['NappUser']['id']; ?>"><?php echo $userArrs['NappUser']['name'].' '.$userArrs['NappUser']['lname']; ?></option>
									<?php } ?>
								</select>
							</td>
							<td>
								<select name="date[1][auditee]"  style="margin:10px;">
									<option value="">Select Auditee</option>
									<?php foreach($userArr as $userArrs){ ?>
										<option  <?php if(isset($CircularInternalAuditResult[1]['CircularInternalAuditResult']['auditee']) && ($CircularInternalAuditResult[1]['CircularInternalAuditResult']['auditee'] == $userArrs['NappUser']['id'])){ echo 'selected'; } ?>  value="<?php echo $userArrs['NappUser']['id']; ?>"><?php echo $userArrs['NappUser']['name'].' '.$userArrs['NappUser']['lname']; ?></option>
									<?php } ?>
								</select>
							</td>
						</tr>
						<tr>
							<td>Marketing / Customer Relationship</td>
							<td><input type="text"  value="<?php if(isset($CircularInternalAuditResult[2]['CircularInternalAuditResult']['date'])){ echo $CircularInternalAuditResult[2]['CircularInternalAuditResult']['date']; } ?>"  class="datepicker" placeholder="Select Date"  name="date[2][datetime]" style="margin:10px;"></td>
							
							<td><input type="text" class="timepicker" value="<?php if(isset($CircularInternalAuditResult[2]['CircularInternalAuditResult']['time'])){ echo $CircularInternalAuditResult[2]['CircularInternalAuditResult']['time']; } ?>" name="date[2][time]" class="" placeholder="Enter time  08:00 am"  style="margin:10px;"></td>
							<td>
								<select  name="date[2][auditor]"  style="margin:10px;">
									<option value="">Select Auditor</option>
									<?php foreach($userArr as $userArrs){ ?>
										<option <?php if(isset($CircularInternalAuditResult[2]['CircularInternalAuditResult']['auditor']) && ($CircularInternalAuditResult[2]['CircularInternalAuditResult']['auditor'] == $userArrs['NappUser']['id'])){ echo 'selected'; } ?> value="<?php echo $userArrs['NappUser']['id']; ?>"><?php echo $userArrs['NappUser']['name'].' '.$userArrs['NappUser']['lname']; ?></option>
									<?php } ?>
								</select>
							</td>
							<td>
								<select name="date[2][auditee]"  style="margin:10px;">
									<option value="">Select Auditee</option>
									<?php foreach($userArr as $userArrs){ ?>
										<option   <?php if(isset($CircularInternalAuditResult[2]['CircularInternalAuditResult']['auditee']) && ($CircularInternalAuditResult[2]['CircularInternalAuditResult']['auditee'] == $userArrs['NappUser']['id'])){ echo 'selected'; } ?>  value="<?php echo $userArrs['NappUser']['id']; ?>"><?php echo $userArrs['NappUser']['name'].' '.$userArrs['NappUser']['lname']; ?></option>
									<?php } ?>
								</select>
							</td>
						</tr>
						<tr>
						<td>Purchase</td>
							<td><input type="text" value="<?php if(isset($CircularInternalAuditResult[3]['CircularInternalAuditResult']['date'])){ echo $CircularInternalAuditResult[3]['CircularInternalAuditResult']['date']; } ?>"  class="datepicker" placeholder="Select Date"  name="date[3][datetime]" style="margin:10px;"></td>
							<td><input type="text" class="timepicker" value="<?php if(isset($CircularInternalAuditResult[3]['CircularInternalAuditResult']['time'])){ echo $CircularInternalAuditResult[3]['CircularInternalAuditResult']['time']; } ?>" name="date[3][time]" class="" placeholder="Enter time 08:00 am"  style="margin:10px;"></td>
							<td>
								<select  name="date[3][auditor]"  style="margin:10px;">
									<option value="">Select Auditor</option>
									<?php foreach($userArr as $userArrs){ ?>
										<option <?php if(isset($CircularInternalAuditResult[3]['CircularInternalAuditResult']['auditor']) && ($CircularInternalAuditResult[3]['CircularInternalAuditResult']['auditor'] == $userArrs['NappUser']['id'])){ echo 'selected'; } ?>   value="<?php echo $userArrs['NappUser']['id']; ?>"><?php echo $userArrs['NappUser']['name'].' '.$userArrs['NappUser']['lname']; ?></option>
									<?php } ?>
								</select>
							</td>
							<td>
								<select name="date[3][auditee]"  style="margin:10px;">
									<option value="">Select Auditee</option>
									<?php foreach($userArr as $userArrs){ ?>
										<option <?php if(isset($CircularInternalAuditResult[3]['CircularInternalAuditResult']['auditee']) && ($CircularInternalAuditResult[3]['CircularInternalAuditResult']['auditee'] == $userArrs['NappUser']['id'])){ echo 'selected'; } ?>    value="<?php echo $userArrs['NappUser']['id']; ?>"><?php echo $userArrs['NappUser']['name'].' '.$userArrs['NappUser']['lname']; ?></option>
									<?php } ?>
								</select>
							</td>
						</tr>
						<tr>
						<td>HR/Training</td>
							<td><input type="text" value="<?php if(isset($CircularInternalAuditResult[4]['CircularInternalAuditResult']['date'])){ echo $CircularInternalAuditResult[4]['CircularInternalAuditResult']['date']; } ?>"  class="datepicker" placeholder="Select Date" name="date[4][datetime]" style="margin:10px;"></td>
							<td><input type="text" class="timepicker" value="<?php if(isset($CircularInternalAuditResult[4]['CircularInternalAuditResult']['time'])){ echo $CircularInternalAuditResult[4]['CircularInternalAuditResult']['time']; } ?>" name="date[4][time]" class="" placeholder="Enter time  08:00 am"  style="margin:10px;"></td>
							<td>
								<select  name="date[4][auditor]"  style="margin:10px;">
									<option value="">Select Auditor</option>
									<?php foreach($userArr as $userArrs){ ?>
										<option <?php if(isset($CircularInternalAuditResult[4]['CircularInternalAuditResult']['auditor']) && ($CircularInternalAuditResult[4]['CircularInternalAuditResult']['auditor'] == $userArrs['NappUser']['id'])){ echo 'selected'; } ?>  value="<?php echo $userArrs['NappUser']['id']; ?>"><?php echo $userArrs['NappUser']['name'].' '.$userArrs['NappUser']['lname']; ?></option>
									<?php } ?>
								</select>
							</td>
							<td>
								<select name="date[4][auditee]"  style="margin:10px;">
									<option value="">Select Auditee</option>
									<?php foreach($userArr as $userArrs){ ?>
										<option  <?php if(isset($CircularInternalAuditResult[4]['CircularInternalAuditResult']['auditee']) && ($CircularInternalAuditResult[4]['CircularInternalAuditResult']['auditee'] == $userArrs['NappUser']['id'])){ echo 'selected'; } ?>     value="<?php echo $userArrs['NappUser']['id']; ?>"><?php echo $userArrs['NappUser']['name'].' '.$userArrs['NappUser']['lname']; ?></option>
									<?php } ?>
								</select>
							</td>
						</tr>
						
						</table>
					</div>				
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Opening Held On: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('opening_held_on',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'datepicker col-xs-10 col-sm-5','id'=>'opening_held_on','placeholder'=>'Opening Held On','value'=>$InternalAuditPlan['CircularInternalAudit']['opening_held_on']))?>
					</div>
				</div>				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Opening Held At: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('opening_place_at',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'opening_place_at','placeholder'=>'Opening Held At','value'=>$InternalAuditPlan['CircularInternalAudit']['opening_place_at']))?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Closing Held On: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('closing_held_on',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'datepicker col-xs-10 col-sm-5','id'=>'closing_held_on','placeholder'=>'Closing Held On','value'=>$InternalAuditPlan['CircularInternalAudit']['closing_held_on']))?>
					</div>
				</div>				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Closing Held At: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('closing_place_at',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'closing_place_at','placeholder'=>'Closing Held At','value'=>$InternalAuditPlan['CircularInternalAudit']['closing_place_at']))?>
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
		
		$('.timepicker').timepicker();
		
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