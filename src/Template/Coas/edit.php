
	<div class="page-content">
		<div class="page-header">
		<div class="right_btn pull-right" ><a href="javascript:window.history.back();" class="btn btn-inverse" >Back</a></div>
		<h1>COA Durotech <small><i class="ace-icon fa fa-angle-double-right"></i>Edit COA </small>
		</h1>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
		<?php echo $this->Form->create('COA',array('class'=>'form-horizontal','enctype'=>'multipart/form-data')); ?>
		
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Product:</label>
				<div class="col-sm-9">
					<input type="text" name="product" value="<?php echo $CoaArr['Coa']['product'];?>" id="product" class = "col-xs-10 col-sm-8">
				</div>
			</div>	
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Batch No:</label>
				<div class="col-sm-9">
					<input type="text" name="batch_no" id="batch_no" value="<?php echo $CoaArr['Coa']['batch_no'];?>"  class = "col-xs-10 col-sm-8">
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Date of Manu:</label>
				<div class="col-sm-9">
					<input type="text" name="date_of_manu" id="date_of_manu" value="<?php echo $CoaArr['Coa']['date_of_manu'];?>"  class = "datepicker col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Expiry Date:</label>
				<div class="col-sm-9">
					<input type="text" name="expiry_date"  id='expiry_date' value="<?php echo $CoaArr['Coa']['expiry_date'];?>"  class = "datepicker col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Form No:</label>
				<div class="col-sm-9">
					<input type="text" name="form_no"  id='form_no' value="<?php echo $CoaArr['Coa']['form_no'];?>"  class = "col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Sign Date:</label>
				<div class="col-sm-9">
					<input type="text" name="signature_date" value="<?php echo $CoaArr['Coa']['signature_date'];?>" id="signature_date"  class = "datepicker col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Receiver Email:</label>
				<div class="col-sm-9">
					<input type="text" name="email" value="<?php echo $CoaArr['Coa']['email'];?>" id="email"  class = "col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Receiver Name:</label>
				<div class="col-sm-9">
					<input type="text" name="name" value="<?php echo $CoaArr['Coa']['name'];?>" id="name"  class = "col-xs-10 col-sm-8">
				</div>
			</div>
		
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Subject:</label>
				<div class="col-sm-9">
					<input type="text" name="subject" value="Durotech: COA Result" id="subject" class = "col-xs-10 col-sm-8">
				</div>
			</div>
			
			<div class="form-group" >
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
				<div class="col-sm-9">
					<table>
						<tr>
							<th>Test</th>
							<th>Result</th>
							<th>Specfication</th>
						</tr>
						<?php if(!empty($CoaArr['CoaResult'])){  foreach($CoaArr['CoaResult'] as $CoaResult){ ?>
						<tr>
							<td><input type="text" style="width:250px;" name="test[]" value="<?php echo $CoaResult['test']; ?>"></td>
							<td><input type="text" style="width:80px;" name="result[]" value="<?php echo $CoaResult['result']; ?>"></td>
							<td><input type="text" style="width:320px;" name="specfication[]" value="<?php echo $CoaResult['specfication']; ?>"></td>
						</tr>
						<?php } } ?>
					</table>
				</div>
			</div>
		
			<div id="newdiv"></div>
			<div class="form-group">
				<div class="col-md-offset-3 col-md-9">
					<?php echo $this->Form->submit('Submit',array('div'=>false,'label'=>false, 'class' => 'btn btn-mini  btn-success','id'=>'add_ser_prd_btn','value'=>'Submit'));?>&nbsp;
				
				</div>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>	
	</div>	
	
<script type="text/javascript">
	
	/*function checkornot(){
		var isChecked = $("#use_area").is(":checked");
		if (isChecked) {
			$("#userArea").show();
		} else {
			$("#userArea").hide();
		}
	}	
	function setsubject(type_id){
		
		if(type_id == 1){
			$("#subject").val('DUROTECH: INSTALLATION OF DUROMASTIC P-15 WATERPROOFING MEMBRANE');
		}else if(type_id == 2){
			$("#subject").val('Durotech: Waterproofing Specification – Wet area shower');
		}else if(type_id == 3){
			$("#subject").val('Durotech: External Liquid WPM');
		}
	}	*/
	jQuery(function(){ //short for $(document).ready(function(){

		$('.datepicker').datepicker({
			format: "yyyy-mm-dd",			
		});
		$("#product").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter product"
		});$("#batch_no").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter batch no"
		});	$("#emails").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter email"
		}); $("#names").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter name/attn"
		});; $("#form_no").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter form no"
		}); $("#subject").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter subject"
		});
	});

</script>