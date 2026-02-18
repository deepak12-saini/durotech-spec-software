<style>
tr td input[type="text"]{ margin-bottom:13px !important;}
</style>
<script src="<?php echo SITEURL; ?>ckeditor/ckeditor.js"></script>	
<div class="page-content">
	<div class="page-header">
	<h1>
		 Hr Format Training Calendars
	<small>
		<i class="ace-icon fa fa-angle-double-right"></i>
		Edit
	</small>
	<a href="<?php echo SITEURL; ?>hrs/format_training_calendars" class="btn btn-mini btn-inverse" style="float:right;">Back</a>
	</h1>
	</div><!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
		
			<?php echo $this->Form->create('HrFormatTrainingCalendar',array('class'=>'form-horizontal','role'=>'form','enctype'=>'multipart/form-data'));?>	
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Documentid: </label>
					<div class="col-sm-9">
						<?php 						
						echo $this->Form->input('HrFormatTrainingCalendar.documentid',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'documentid','placeholder'=>'Documentid','readonly'=>true,
						'style'=>'background-color: #ddd !important;'));
						?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Date: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('HrFormatTrainingCalendar.date',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'datepicker col-xs-10 col-sm-5','id'=>'date','placeholder'=>'Date'))?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
					<div class="col-sm-9">
						<div class="table-responsive">
						<table style=" width:100% !important; ">
							<tr>		
								<th>Month</th>								
								<th>Planed</th>
								<th>Actual</th>
								
							</tr>
							<tbody>
								<?php foreach($docArr['HrFormatTrainingCalendarRecord'] as $HrFormatTrainingCalendarRecords){?>
								<tr>									
									<td> <input type="hidden" name="data[month][]"  value="<?php echo $HrFormatTrainingCalendarRecords['month']; ?>"  placeholder="Enter Month"    /> <?php echo $HrFormatTrainingCalendarRecords['month']; ?> </td>					
									<td> <input type="text" name="data[planed][]"  value="<?php echo $HrFormatTrainingCalendarRecords['planed']; ?>" placeholder="Enter Planed"    /></td>					
									<td> <input type="text" name="data[actual][]"  value="<?php echo $HrFormatTrainingCalendarRecords['actual']; ?>" placeholder="Actual"    /></td>										
								</tr>
								<?php } ?>
							</tbody>
														
						</table>
						<div class="tblrow"></div>
						
						</div>
						<br>
						
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