
	<div class="page-content">
		<div class="page-header">
		<div class="right_btn pull-right" ><a href="javascript:window.history.back();" class="btn btn-inverse" >Back</a></div>
		<h1>COA Durotech <small><i class="ace-icon fa fa-angle-double-right"></i>Create COA </small>
		</h1>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
		<?php echo $this->Form->create('COA',array('class'=>'form-horizontal','enctype'=>'multipart/form-data')); ?>
		
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Product:</label>
				<div class="col-sm-9">
					<input type="text" name="product" value="" id="product" class = "col-xs-10 col-sm-8">
				</div>
			</div>	
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Batch No:</label>
				<div class="col-sm-9">
					<input type="text" name="batch_no" id="batch_no" value=""  class = "col-xs-10 col-sm-8">
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Date of Manu:</label>
				<div class="col-sm-9">
					<input type="text" name="date_of_manu" id="date_of_manu" value="<?php echo date('Y-m-d');?>"  class = "datepicker col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Expiry Date:</label>
				<div class="col-sm-9">
					<input type="text" name="expiry_date"  id='expiry_date' value="<?php echo date('Y-m-d');?>"  class = "datepicker col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Form No:</label>
				<div class="col-sm-9">
					<input type="text" name="form_no"  id='form_no' value=""  class = "col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Sign Date:</label>
				<div class="col-sm-9">
					<input type="text" name="signature_date" value="<?php echo date('Y-m-d');?>" id="signature_date"  class = "datepicker col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Receiver Email:</label>
				<div class="col-sm-9">
					<input type="text" name="email" value="" id="email"  class = "col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Receiver Name:</label>
				<div class="col-sm-9">
					<input type="text" name="name" value="" id="name"  class = "col-xs-10 col-sm-8">
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
						<tr>
							<td><input type="text" style="width:225px;" name="test[]" value="APPEARANCE"></td>
							<td><input type="text" style="width:225px;" name="result[]" value="TYPICAL"></td>
							<td><input type="text" style="width:225px;" name="specfication[]" value="WHITE TO BEIGE FREE FLOWING DISPERSION "></td>
						</tr>
						<tr>
							<td><input type="text" style="width:225px;" name="test[]" value="DENSITY (20<sup>0</sup>C)"></td>
							<td><input type="text" style="width:225px;" name="result[]" value="7.15"></td>
							<td><input type="text" style="width:225px;" name="specfication[]" value="5.0 – 7.5"></td>
						</tr>
						<tr>
							<td><input type="text" style="width:225px;" name="test[]" value="pH @ 20<sup>0</sup>C"></td>
							<td><input type="text" style="width:225px;" name="result[]" value="1.186"></td>
							<td><input type="text" style="width:225px;" name="specfication[]" value="1.100 – 1.200"></td>
						</tr>
						<tr>
							<td><input type="text" style="width:225px;" name="test[]" value="ACETONE INSOLUBLE"></td>
							<td><input type="text" style="width:225px;" name="result[]" value="18.3"></td>
							<td><input type="text" style="width:225px;" name="specfication[]" value="17.5 – 20.0"></td>
						</tr>
						<tr>
							<td><input type="text" style="width:225px;" name="test[]" value="GRAIN SIZE (μm)"></td>
							<td><input type="text" style="width:225px;" name="result[]" value="30"></td>
							<td><input type="text" style="width:225px;" name="specfication[]" value="0 - 35"></td>
						</tr>
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