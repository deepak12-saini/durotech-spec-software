<style>
tr td input[type="text"]{ margin-bottom:13px !important;}
</style>
<script src="<?php echo SITEURL; ?>ckeditor/ckeditor.js"></script>	
<div class="page-content">
	<div class="page-header">
	<h1>
		Performance Appraisal Form 
	<small>
		<i class="ace-icon fa fa-angle-double-right"></i>
		Add New
	</small>
	<a href="<?php echo SITEURL; ?>hrs/hr_appraisal_form" class="btn btn-mini btn-inverse" style="float:right;">Back</a>
	</h1>
	</div><!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
		
			<?php echo $this->Form->create('HrAppraisalForm',array('class'=>'form-horizontal','role'=>'form','enctype'=>'multipart/form-data'));?>	
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Documentid: </label>
					<div class="col-sm-9">
						<?php 						
						echo $this->Form->input('HrAppraisalForm.documentid',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'documentid','placeholder'=>'Documentid','readonly'=>true,'style'=>'background-color: #ddd !important;','value'=>$docId));
						?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Date: </label>
					<div class="col-sm-9">
						<?php 						
						echo $this->Form->input('HrAppraisalForm.date',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'datepicker col-xs-10 col-sm-5','id'=>'date','placeholder'=>'Date','value'=>date('Y-m-d')));
						?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Employee Name: </label>
					<div class="col-sm-9">
						<?php 						
						echo $this->Form->input('HrAppraisalForm.employee_name',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'employee_name','placeholder'=>'Employee Name'));
						?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Evaluation Period: </label>
					<div class="col-sm-9">
						<?php 						
						echo $this->Form->input('HrAppraisalForm.evaluation_period',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'evaluation_period','placeholder'=>'Evaluation Period'));
						?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Designation: </label>
					<div class="col-sm-9">
						<?php 						
						echo $this->Form->input('HrAppraisalForm.designation',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'designation','placeholder'=>'Designation'));
						?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Name of Appraiser: </label>
					<div class="col-sm-9">
						<?php 						
						echo $this->Form->input('HrAppraisalForm.name_appraiser',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'name_appraiser','placeholder'=>'Name of Appraiser'));
						?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Suitable For Confirmation: </label>
					<div class="col-sm-9">
						<input type="radio" name="data[HrAppraisalForm][suitable_for_confirmation]" value="Yes" checked> Yes 
						<input type="radio" name="data[HrAppraisalForm][suitable_for_confirmation]" value="No" > No 
						
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Suitable For Promition: </label>
					<div class="col-sm-9">
						<input type="radio" name="data[HrAppraisalForm][suitable_for_promition]" value="Yes" checked> Yes 
						<input type="radio" name="data[HrAppraisalForm][suitable_for_promition]" value="No" > No 
						
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Continue With Notice: </label>
					<div class="col-sm-9">
						<input type="radio" name="data[HrAppraisalForm][continue_with_notice]" value="Yes" checked> Yes 
						<input type="radio" name="data[HrAppraisalForm][continue_with_notice]" value="No" > No 
						
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Terminate: </label>
					<div class="col-sm-9">
						<input type="radio" name="data[HrAppraisalForm][terminate]" value="Yes" checked> Yes 
						<input type="radio" name="data[HrAppraisalForm][terminate]" value="No" > No 
						
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Signature: </label>
					<div class="col-sm-9">
						<?php 						
						echo $this->Form->input('HrAppraisalForm.signature',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'signature','placeholder'=>'Signature'));
						?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
					<div class="col-sm-9">
						<div class="table-responsive">
						<table style=" width:100% !important; ">
							<tr>		
								<th>Performance Citeria</th>
								<th>Applicabe For</th>
								<th>Rating</th>
								<th>Rating by Appraiser</th>
								
							</tr>
							<tbody>
								
								<tr>									
									<td> <input type="hidden" name="data[performance_criteria][]"  value="Analytical Thinking"   /> Analytical Thinking </td>					
									<td> <input type="text" name="data[applicabe_for][]"  value=""  placeholder="Enter Acceptable"    /></td>					
									<td> 
										<select name="rating[]">
											<option value="">Choose Rating</option>
											<option value="Excellent">Excellent</option>
											<option value="Very Good">Very Good</option>
											<option value="Good">Good</option>
											<option value="Average">Average</option>
											<option value="Poor">Poor</option>
											<option value="Worse">Worse</option>
										</select>
									</td>										
									<td> <input type="text" name="data[rating_by_appraiser][]"  value=""  placeholder="Rating By Appraiser"    /></td>										
								</tr>
								<tr>									
									<td> <input type="hidden" name="data[performance_criteria][]"  value="Business Minded"   /> Business Minded </td>					
									<td> <input type="text" name="data[applicabe_for][]"  value=""  placeholder="Enter Acceptable"    /></td>					
									<td> 
										<select name="rating[]">
											<option value="">Choose Rating</option>
											<option value="Excellent">Excellent</option>
											<option value="Very Good">Very Good</option>
											<option value="Good">Good</option>
											<option value="Average">Average</option>
											<option value="Poor">Poor</option>
											<option value="Worse">Worse</option>
										</select>
									</td>										
									<td> <input type="text" name="data[rating_by_appraiser][]"  value=""  placeholder="Rating By Appraiser"    /></td>										
								</tr>
								<tr>									
									<td> <input type="hidden" name="data[performance_criteria][]"  value="Innvoation and Creativity"   /> Innvoation and Creativity</td>					
									<td> <input type="text" name="data[applicabe_for][]"  value=""  placeholder="Enter Acceptable"    /></td>					
									<td> 
										<select name="rating[]">
											<option value="">Choose Rating</option>
											<option value="Excellent">Excellent</option>
											<option value="Very Good">Very Good</option>
											<option value="Good">Good</option>
											<option value="Average">Average</option>
											<option value="Poor">Poor</option>
											<option value="Worse">Worse</option>
										</select>
									</td>										
									<td> <input type="text" name="data[rating_by_appraiser][]"  value=""  placeholder="Rating By Appraiser"    /></td>										
								</tr>
								<tr>									
									<td> <input type="hidden" name="data[performance_criteria][]"  value="Communication"   /> Communication</td>					
									<td> <input type="text" name="data[applicabe_for][]"  value=""  placeholder="Enter Acceptable"    /></td>					
									<td> 
										<select name="rating[]">
											<option value="">Choose Rating</option>
											<option value="Excellent">Excellent</option>
											<option value="Very Good">Very Good</option>
											<option value="Good">Good</option>
											<option value="Average">Average</option>
											<option value="Poor">Poor</option>
											<option value="Worse">Worse</option>
										</select>
									</td>										
									<td> <input type="text" name="data[rating_by_appraiser][]"  value=""  placeholder="Rating By Appraiser"    /></td>										
								</tr>
								<tr>									
									<td> <input type="hidden" name="data[performance_criteria][]"  value="Flexibility"   /> Flexibility</td>					
									<td> <input type="text" name="data[applicabe_for][]"  value=""  placeholder="Enter Acceptable"    /></td>					
									<td> 
										<select name="rating[]">
											<option value="">Choose Rating</option>
											<option value="Excellent">Excellent</option>
											<option value="Very Good">Very Good</option>
											<option value="Good">Good</option>
											<option value="Average">Average</option>
											<option value="Poor">Poor</option>
											<option value="Worse">Worse</option>
										</select>
									</td>										
									<td> <input type="text" name="data[rating_by_appraiser][]"  value=""  placeholder="Rating By Appraiser"    /></td>										
								</tr>
								<tr>									
									<td> <input type="hidden" name="data[performance_criteria][]"  value="Goal/Result Orientated"   /> Goal/Result Orientated</td>					
									<td> <input type="text" name="data[applicabe_for][]"  value=""  placeholder="Enter Acceptable"    /></td>					
									<td> 
										<select name="rating[]">
											<option value="">Choose Rating</option>
											<option value="Excellent">Excellent</option>
											<option value="Very Good">Very Good</option>
											<option value="Good">Good</option>
											<option value="Average">Average</option>
											<option value="Poor">Poor</option>
											<option value="Worse">Worse</option>
										</select>
									</td>										
									<td> <input type="text" name="data[rating_by_appraiser][]"  value=""  placeholder="Rating By Appraiser"    /></td>										
								</tr>
								<tr>									
									<td> <input type="hidden" name="data[performance_criteria][]"  value="Internal And External Attitude"   /> Internal And External Attitude</td>					
									<td> <input type="text" name="data[applicabe_for][]"  value=""  placeholder="Enter Acceptable"    /></td>					
									<td> 
										<select name="rating[]">
											<option value="">Choose Rating</option>
											<option value="Excellent">Excellent</option>
											<option value="Very Good">Very Good</option>
											<option value="Good">Good</option>
											<option value="Average">Average</option>
											<option value="Poor">Poor</option>
											<option value="Worse">Worse</option>
										</select>
									</td>										
									<td> <input type="text" name="data[rating_by_appraiser][]"  value=""  placeholder="Rating By Appraiser"    /></td>										
								</tr>
								<tr>									
									<td> <input type="hidden" name="data[performance_criteria][]"  value="Knowledge About EIA"   /> Knowledge About EIA</td>					
									<td> <input type="text" name="data[applicabe_for][]"  value=""  placeholder="Enter Acceptable"    /></td>					
									<td> 
										<select name="rating[]">
											<option value="">Choose Rating</option>
											<option value="Excellent">Excellent</option>
											<option value="Very Good">Very Good</option>
											<option value="Good">Good</option>
											<option value="Average">Average</option>
											<option value="Poor">Poor</option>
											<option value="Worse">Worse</option>
										</select>
									</td>										
									<td> <input type="text" name="data[rating_by_appraiser][]"  value=""  placeholder="Rating By Appraiser"    /></td>										
								</tr>
								<tr>									
									<td> <input type="hidden" name="data[performance_criteria][]"  value="Proactive Working"   /> Proactive Working</td>					
									<td> <input type="text" name="data[applicabe_for][]"  value=""  placeholder="Enter Acceptable"    /></td>					
									<td> 
										<select name="rating[]">
											<option value="">Choose Rating</option>
											<option value="Excellent">Excellent</option>
											<option value="Very Good">Very Good</option>
											<option value="Good">Good</option>
											<option value="Average">Average</option>
											<option value="Poor">Poor</option>
											<option value="Worse">Worse</option>
										</select>
									</td>										
									<td> <input type="text" name="data[rating_by_appraiser][]"  value=""  placeholder="Rating By Appraiser"    /></td>										
								</tr>
								<tr>									
									<td> <input type="hidden" name="data[performance_criteria][]"  value="Problem Solving"   /> Problem Solving</td>					
									<td> <input type="text" name="data[applicabe_for][]"  value=""  placeholder="Enter Acceptable"    /></td>					
									<td> 
										<select name="rating[]">
											<option value="">Choose Rating</option>
											<option value="Excellent">Excellent</option>
											<option value="Very Good">Very Good</option>
											<option value="Good">Good</option>
											<option value="Average">Average</option>
											<option value="Poor">Poor</option>
											<option value="Worse">Worse</option>
										</select>
									</td>										
									<td> <input type="text" name="data[rating_by_appraiser][]"  value=""  placeholder="Rating By Appraiser"    /></td>										
								</tr>
								<tr>									
									<td> <input type="hidden" name="data[performance_criteria][]"  value="Teamwork"   /> Teamwork</td>					
									<td> <input type="text" name="data[applicabe_for][]"  value=""  placeholder="Enter Acceptable"    /></td>					
									<td> 
										<select name="rating[]">
											<option value="">Choose Rating</option>
											<option value="Excellent">Excellent</option>
											<option value="Very Good">Very Good</option>
											<option value="Good">Good</option>
											<option value="Average">Average</option>
											<option value="Poor">Poor</option>
											<option value="Worse">Worse</option>
										</select>
									</td>										
									<td> <input type="text" name="data[rating_by_appraiser][]"  value=""  placeholder="Rating By Appraiser"    /></td>										
								</tr>
								<tr>									
									<td> <input type="hidden" name="data[performance_criteria][]"  value="Leadership"   /> Leadership</td>					
									<td> <input type="text" name="data[applicabe_for][]"  value=""  placeholder="Enter Acceptable"    /></td>					
									<td> 
										<select name="rating[]">
											<option value="">Choose Rating</option>
											<option value="Excellent">Excellent</option>
											<option value="Very Good">Very Good</option>
											<option value="Good">Good</option>
											<option value="Average">Average</option>
											<option value="Poor">Poor</option>
											<option value="Worse">Worse</option>
										</select>
									</td>										
									<td> <input type="text" name="data[rating_by_appraiser][]"  value=""  placeholder="Rating By Appraiser"    /></td>										
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