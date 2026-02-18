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
		Add New
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
						echo $this->Form->input('HrFormatTrainingCalendar.documentid',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'documentid','placeholder'=>'Documentid','readonly'=>true,'style'=>'background-color: #ddd !important;','value'=>$docId));
						?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Date: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('HrFormatTrainingCalendar.date',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'datepicker col-xs-10 col-sm-5','id'=>'date','placeholder'=>'Date','value'=>date('Y-m-d')))?>
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
								
								<tr>									
									<td> <input type="hidden" name="data[month][]"  value="Jan"  placeholder="Enter Month"    /> January </td>					
									<td> <input type="text" name="data[planed][]"  value=""  placeholder="Enter Planed"    /></td>					
									<td> <input type="text" name="data[actual][]"  value=""  placeholder="Actual"    /></td>										
								</tr>
								<tr>									
									<td> <input type="hidden" name="data[month][]"  value="Feb"  placeholder="Enter Month"    /> February </td>					
									<td> <input type="text" name="data[planed][]"  value=""  placeholder="Enter Planed"    /></td>					
									<td> <input type="text" name="data[actual][]"  value=""  placeholder="Actual"    /></td>										
								</tr>
								<tr>									
									<td> <input type="hidden" name="data[month][]"  value="Mar"  placeholder="Enter Month"    /> March</td>					
									<td> <input type="text" name="data[planed][]"  value=""  placeholder="Enter Planed"    /></td>					
									<td> <input type="text" name="data[actual][]"  value=""  placeholder="Actual"    /></td>										
								</tr>
								<tr>									
									<td> <input type="hidden" name="data[month][]"  value="April"  placeholder="Enter Month"    /> April </td>					
									<td> <input type="text" name="data[planed][]"  value=""  placeholder="Enter Planed"    /></td>					
									<td> <input type="text" name="data[actual][]"  value=""  placeholder="Actual"    /></td>										
								</tr>
								<tr>									
									<td> <input type="hidden" name="data[month][]"  value="May"  placeholder="Enter Month"    /> May </td>					
									<td> <input type="text" name="data[planed][]"  value=""  placeholder="Enter Planed"    /></td>					
									<td> <input type="text" name="data[actual][]"  value=""  placeholder="Actual"    /></td>										
								</tr>
								<tr>									
									<td> <input type="hidden" name="data[month][]"  value="June"  placeholder="Enter Month"    /> June </td>					
									<td> <input type="text" name="data[planed][]"  value=""  placeholder="Enter Planed"    /></td>					
									<td> <input type="text" name="data[actual][]"  value=""  placeholder="Actual"    /></td>										
								</tr>
								<tr>									
									<td> <input type="hidden" name="data[month][]"  value="July"  placeholder="Enter Month"    /> July </td>					
									<td> <input type="text" name="data[planed][]"  value=""  placeholder="Enter Planed"    /></td>					
									<td> <input type="text" name="data[actual][]"  value=""  placeholder="Actual"    /></td>										
								</tr>
								<tr>									
									<td> <input type="hidden" name="data[month][]"  value="Aug"  placeholder="Enter Month"    /> Aug </td>					
									<td> <input type="text" name="data[planed][]"  value=""  placeholder="Enter Planed"    /></td>					
									<td> <input type="text" name="data[actual][]"  value=""  placeholder="Actual"    /></td>										
								</tr>
								<tr>									
									<td> <input type="hidden" name="data[month][]"  value="Sept"  placeholder="Enter Month"    /> Sept </td>					
									<td> <input type="text" name="data[planed][]"  value=""  placeholder="Enter Planed"    /></td>					
									<td> <input type="text" name="data[actual][]"  value=""  placeholder="Actual"    /></td>										
								</tr>
								
								<tr>									
									<td> <input type="hidden" name="data[month][]"  value="Oct"  placeholder="Enter Month"    /> October </td>					
									<td> <input type="text" name="data[planed][]"  value=""  placeholder="Enter Planed"    /></td>					
									<td> <input type="text" name="data[actual][]"  value=""  placeholder="Actual"    /></td>										
								</tr>
								
								<tr>									
									<td> <input type="hidden" name="data[month][]"  value="Nov"  placeholder="Enter Month"    /> November</td>					
									<td> <input type="text" name="data[planed][]"  value=""  placeholder="Enter Planed"    /></td>					
									<td> <input type="text" name="data[actual][]"  value=""  placeholder="Actual"    /></td>										
								</tr>
								<tr>									
									<td> <input type="hidden" name="data[month][]"  value="Dec"  placeholder="Enter Month"    /> December </td>					
									<td> <input type="text" name="data[planed][]"  value=""  placeholder="Enter Planed"    /></td>					
									<td> <input type="text" name="data[actual][]"  value=""  placeholder="Actual"    /></td>										
								</tr>
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