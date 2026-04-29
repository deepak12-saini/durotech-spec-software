<div class="page-content">
	<div class="page-header">
	<h1>
	Complaint
	<small>
		<i class="ace-icon fa fa-angle-double-right"></i>
		Add Complaint
	</small>
	</h1>
	</div><!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
		
			<?php echo $this->Form->create('Complaint',array('class'=>'form-horizontal','role'=>'form','enctype'=>'multipart/form-data'));?>	
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Customer Name: </label>
					<div class="col-sm-9">
						<input type="text" name="data[Complaint][customer_name]" class='col-xs-10 col-sm-5' placeholder="Customer Name" id='customer_name'>					
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Customer Phone: </label>
					<div class="col-sm-9">
						<input type="text" name="data[Complaint][customer_phone]" class='col-xs-10 col-sm-5' placeholder="Customer Phone" id='customer_phone'>						
				</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Customer Email: </label>
					<div class="col-sm-9">
						<input type="text" name="data[Complaint][customer_email]" class='col-xs-10 col-sm-5' placeholder="Customer Email" id='customer_email'>					
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Customer Address: </label>
					<div class="col-sm-9">
						<input type="text" name="data[Complaint][customer_address]" class='col-xs-10 col-sm-5' placeholder="Customer Address" id='customer_address'>					
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Product Name: </label>
					<div class="col-sm-9">
						<input type="text" name="data[Complaint][product_name]" class='col-xs-10 col-sm-5' placeholder="Product Name" id='product_name'>					
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Product Color: </label>
					<div class="col-sm-9">
						<input type="text" name="data[Complaint][product_color]" class='col-xs-10 col-sm-5' placeholder="Product Color" id='product_color'>					
					</div>
				</div>
				
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Select Department: </label>
					<div class="col-sm-9">
						<select id="dept_id" name="data[Complaint][dept_id]" class="col-xs-10 col-sm-5" >
							<option value="">Select Department</option>
							<?php foreach($departmentArr as $departments){ ?>
								<?php $department = isset($departments['Department']) ? $departments['Department'] : $departments; ?>
								<?php if (!empty($department['id'])) { ?>
								<option value="<?php echo $department['id'];?>"><?php echo $department['department_title'] ?? '';?></option>
								<?php } ?>
							<?php  }  ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Complaint To: </label>
					<div class="col-sm-9">
						<select id="complaint_to" name="data[Complaint][complaint_to]" class="col-xs-10 col-sm-5" >
							<option value="">Select Employee</option>
							<?php foreach($NappUser as $NappUsers){ ?>
								<?php $user = isset($NappUsers['NappUser']) ? $NappUsers['NappUser'] : $NappUsers; ?>
								<?php $department = $NappUsers['Department'] ?? ($NappUsers['department'] ?? []); ?>
								<?php if (!empty($user['id'])) { ?>
								<option value="<?php echo $user['id'];?>">
									<?php echo ($user['name'] ?? '').' '.($user['lname'] ?? '').' ('.($department['department_title'] ?? '').')';?>
								</option>
								<?php } ?>
							<?php  }  ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Select Complaint Type: </label>
					<div class="col-sm-9">
						<select id="complaint_type" name="data[Complaint][complaint_type]" class="col-xs-10 col-sm-5" onchange="complaint(this.value)" >
							<option value="">Select Complaint Type</option>
							<?php foreach($ComplaintType as $ComplaintTypes){ ?>
								<?php $type = isset($ComplaintTypes['ComplaintType']) ? $ComplaintTypes['ComplaintType'] : $ComplaintTypes; ?>
								<?php if (!empty($type['id'])) { ?>
								<option value="<?php echo $type['id'];?>"><?php echo $type['title'] ?? '';?></option>
								<?php } ?>
							<?php  }  ?>
						</select>
					</div>
				</div>
				<div class="form-group" STYLE="display:none" id="other">
				
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Other:<br><small>Write other complaint type</small> </label>
					<div class="col-sm-9">
						<input type="text" name="data[Complaint][other]" class='col-xs-10 col-sm-5' placeholder="other complaint type" id="other">	
											
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Reason For Complaint: </label>
					<div class="col-sm-9">
						<textarea  name="data[Complaint][reason_for_complaint]" class='col-xs-10 col-sm-5' placeholder="Reason For Complaint" id='reason_for_complaint'></textarea>					
					</div>
				</div>
			
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Batch Number: </label>
					<div class="col-sm-9">
						<input type="text" name="data[Complaint][batch_number]" class='col-xs-10 col-sm-5' placeholder="Batch Number" id='batch_number'>					
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Return Location: </label>
					<div class="col-sm-9">
						<input type="text" name="data[Complaint][return_location]" class='col-xs-10 col-sm-5' placeholder="Return Location" id='return_location'>					
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Stock Transfer To Minto: </label>
					<div class="col-sm-9">
						<textarea  name="data[Complaint][stock_transfer_to_minto]" class='col-xs-10 col-sm-5' placeholder="Stock Transfer To Minto" id='stock_transfer_to_minto'></textarea>					
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">No Damaged Pails: </label>
					<div class="col-sm-9">
						<input type="text" name="data[Complaint][no_damaged_pails]" class='col-xs-10 col-sm-5' placeholder="No Damaged Pails" id='no_damaged_pails'>					
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Total Cost Durotech Solution: </label>
					<div class="col-sm-9">
						<input type="text" name="data[Complaint][total_cost_durotech_solution]" class='col-xs-10 col-sm-5' placeholder="Total Cost Durotech Solution" id='total_cost_durotech_solution'>					
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Value of Freight For Return: </label>
					<div class="col-sm-9">
						<input type="text" name="data[Complaint][value_of_freight_for_return]" class='col-xs-10 col-sm-5' placeholder="Value of Freight For Return" id='value_of_freight_for_return'>					
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Cost To Complaint($): </label>
					<div class="col-sm-9">
						<input type="text" name="data[Complaint][cost_to_complaint]" class='col-xs-10 col-sm-5' placeholder="Cost To Complaint" id='cost_to_complaint'>					
					</div>
				</div>
					<input type="hidden" name="data[Complaint][is_non_conformance]" value="1">		
				<!--div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Is Non-Conformance: </label>
					<div class="col-sm-9">
						
						<input onclick="change(1)" type="radio" name="data[Complaint][is_non_conformance]" value="1"  checked > No
						<input onclick="change(2)" type="radio" name="data[Complaint][is_non_conformance]" value="2" > Yes
					</div>
				</div-->
				<div class="form-group" id="actioned">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Actioned By Date: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('actioned_by_date',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'datepicker col-xs-10 col-sm-5','id'=>'actioned_by_date','placeholder'=>'Actioned By Date','value'=>date('Y-m-d')))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Upload Document: </label>
					<div class="col-sm-9">
						<input type="file" name="file" class='col-xs-10 col-sm-5' >					
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
	function complaint(type){
		if(type == 21){
			$("#other").show();
		}else{
			$("#other").hide();
		}
	}
	function change(type){
		if(type == 2){
			$("#actioned").hide();
		}else{
			$("#actioned").show();
		}
	}
	jQuery(function(){ 
		$('.datepicker').datepicker({
			format: 'yyyy-mm-dd',			
		});
		
		$("#complaint_type").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please select complaint type"
		});$("#dept_id").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please select department"
		});$("#non_conforance").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter non Conformance"
		});$("#customer_name").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter customer name"
		});$("#customer_email").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter customer email"
		});$("#product_name").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter product name"
		});$("#product_color").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter product color"
		}); $("#reason_for_complaint").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter reason for complaint "
		});  $("#batch_number").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter batch number"
		});   $("#complaint_to").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please select complaint to"
		});     
	});
</script>