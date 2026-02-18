<style>
tr td input[type="text"]{ margin-bottom:13px !important;}
</style>
<script src="<?php echo SITEURL; ?>ckeditor/ckeditor.js"></script>	
<div class="page-content">
	<div class="page-header">
	<h1>
		Hr Format Evaluation Employee
	<small>
		<i class="ace-icon fa fa-angle-double-right"></i>
		Add New
	</small>
	<a href="<?php echo SITEURL; ?>hrs/format_evaluation_employe" class="btn btn-mini btn-inverse" style="float:right;">Back</a>
	</h1>
	</div><!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
		
			<?php echo $this->Form->create('HrFormatEvaluationEmployee',array('class'=>'form-horizontal','role'=>'form','enctype'=>'multipart/form-data'));?>	
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Documentid: </label>
					<div class="col-sm-9">
						<?php 						
						echo $this->Form->input('HrFormatEvaluationEmployee.documentid',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'documentid','placeholder'=>'Documentid','readonly'=>true,'style'=>'background-color: #ddd !important;','value'=>$docId));
						?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Name of expert advisor: </label>
					<div class="col-sm-9">
						<?php 						
						echo $this->Form->input('HrFormatEvaluationEmployee.name_of_expert_advisor',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'name_of_expert_advisor','placeholder'=>'Name of expert advisor'));
						?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Area of Expertise: </label>
					<div class="col-sm-9">
						<?php 						
						echo $this->Form->input('HrFormatEvaluationEmployee.area_of_expertise',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'area_of_expertise','placeholder'=>'Area of Expertise'));
						?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Total Experience: </label>
					<div class="col-sm-9">
						<?php 						
						echo $this->Form->input('HrFormatEvaluationEmployee.total_experience',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'total_experience','placeholder'=>'Total Experience'));
						?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Other: </label>
					<div class="col-sm-9">
						<?php 						
						echo $this->Form->input('HrFormatEvaluationEmployee.other',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'other','placeholder'=>'Other'));
						?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Remark: </label>
					<div class="col-sm-9">
						<?php 						
						echo $this->Form->input('HrFormatEvaluationEmployee.remark',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'remark','placeholder'=>'Remark'));
						?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Reviewed By: </label>
					<div class="col-sm-9">
						<?php 						
						echo $this->Form->input('HrFormatEvaluationEmployee.reviewed_by',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'reviewed_by','placeholder'=>'Reviewed By'));
						?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Date: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('HrFormatEvaluationEmployee.date',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'datepicker col-xs-10 col-sm-5','id'=>'date','placeholder'=>'Date','value'=>date('Y-m-d')))?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
					<div class="col-sm-9">
						<div class="table-responsive">
						<table style=" width:100% !important; ">
							<tr>		
								<th>Detail</th>								
								<th>Acceptable</th>
								<th>Not Acceptable</th>
								<th>To Be Improved</th>
								
							</tr>
							<tbody>
								
								<tr>									
									<td> <input type="hidden" name="data[detail][]"  value="Area of Expertise"   /> Area of Expertise </td>					
									<td> <input type="text" name="data[acceptable][]"  value=""  placeholder="Enter acceptable"    /></td>					
									<td> <input type="text" name="data[not_acceptable][]"  value=""  placeholder="not acceptable"    /></td>										
									<td> <input type="text" name="data[to_be_improved][]"  value=""  placeholder="to be improved"    /></td>										
								</tr>
								<tr>									
									<td> <input type="hidden" name="data[detail][]"  value="Experience"   /> Experience </td>					
									<td> <input type="text" name="data[acceptable][]"  value=""  placeholder="Enter acceptable"    /></td>					
									<td> <input type="text" name="data[not_acceptable][]"  value=""  placeholder="not acceptable"    /></td>										
									<td> <input type="text" name="data[to_be_improved][]"  value=""  placeholder="to be improved"    /></td>										
								</tr>
								<tr>									
									<td> <input type="hidden" name="data[detail][]"  value="Commmunication"    /> Commmunication </td>					
									<td> <input type="text" name="data[acceptable][]"  value=""  placeholder="Enter acceptable"    /></td>					
									<td> <input type="text" name="data[not_acceptable][]"  value=""  placeholder="not acceptable"    /></td>										
									<td> <input type="text" name="data[to_be_improved][]"  value=""  placeholder="to be improved"    /></td>										
								</tr>
								<tr>									
									<td> <input type="hidden" name="data[detail][]"  value="Computer Skill"    /> Computer Skill </td>					
									<td> <input type="text" name="data[acceptable][]"  value=""  placeholder="Enter acceptable"    /></td>					
									<td> <input type="text" name="data[not_acceptable][]"  value=""  placeholder="not acceptable"    /></td>										
									<td> <input type="text" name="data[to_be_improved][]"  value=""  placeholder="to be improved"    /></td>										
								</tr>
								<tr>									
									<td> <input type="hidden" name="data[detail][]"  value="Knowledge / Skill Relevant To US"  /> Knowledge / Skill Relevant To US </td>					
									<td> <input type="text" name="data[acceptable][]"  value=""  placeholder="Enter acceptable"    /></td>					
									<td> <input type="text" name="data[not_acceptable][]"  value=""  placeholder="not acceptable"    /></td>										
									<td> <input type="text" name="data[to_be_improved][]"  value=""  placeholder="to be improved"    /></td>										
								</tr>
								<tr>									
									<td> <input type="hidden" name="data[detail][]"  value="Any other"  />Any other </td>					
									<td> <input type="text" name="data[acceptable][]"  value=""  placeholder="Enter acceptable"    /></td>					
									<td> <input type="text" name="data[not_acceptable][]"  value=""  placeholder="not acceptable"    /></td>										
									<td> <input type="text" name="data[to_be_improved][]"  value=""  placeholder="to be improved"    /></td>										
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