
	<div class="page-content">
		<div class="page-header">
		<div class="right_btn pull-right" ><a href="javascript:window.history.back();" class="btn btn-inverse" >Back</a></div>
		<h1>DuroEzy Specification  <small><i class="ace-icon fa fa-angle-double-right"></i>Edit Spec</small>
		</h1>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
		<?php echo $this->Form->create('Mailer',array('class'=>'form-horizontal','enctype'=>'multipart/form-data')); ?>
		
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Track Number:</label>
				<div class="col-sm-9">
					<input type="text" name="tracknumber" value="<?php echo $refernce; ?>" readonly id="tracknumber" class = "col-xs-10 col-sm-8" style="background:#ddd !important; cursor:pointer;" >
				</div>
			</div>
		
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Name/Attn:</label>
				<div class="col-sm-9">
					<input type="text" name="name"  id="name" value="<?php echo $MailerArr['Mailer']['name']; ?>" class = "col-xs-10 col-sm-8">
				</div>
			</div>	
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Company:</label>
				<div class="col-sm-9">
					<input type="text" name="company" value="<?php echo $MailerArr['Mailer']['company']; ?>"  class = "col-xs-10 col-sm-8">
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Address:</label>
				<div class="col-sm-9">
					<input type="text" name="address"  value="<?php echo $MailerArr['Mailer']['address']; ?>" class = "col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Specification:</label>
				<div class="col-sm-9">
					<input type="text" name="specification" value="<?php echo $MailerArr['Mailer']['specification']; ?>"  class = "col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Email:</label>
				<div class="col-sm-9">
					<input type="text" name="email" id="email" value="<?php echo $MailerArr['Mailer']['email']; ?>"  class = "col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Date:</label>
				<div class="col-sm-9">
					<input type="text" name="date" id="date" value="<?php echo $MailerArr['Mailer']['date']; ?>"   class = "datepicker col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Mailer Type:</label>
				<div class="col-sm-9">
					<select name="type" class="col-xs-10 col-sm-8"  onchange="setsubject(this.value)"  >
						<!-- <option value="">Select Client Requested</option> -->
						<!--option value="1">INSTALLATION OF DUROMASTIC P-15 WATERPROOFING MEMBRANE</option>
						<option value="2">Waterproofing Specification – Wet area shower</option-->
						<option <?php if($MailerArr['Mailer']['date'] == 3){ echo 'selected'; } ?> value="3">External Liquid WPM</option> 
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Subject:</label>
				<div class="col-sm-9">
					<input type="text" name="subject" value="<?php echo $MailerArr['Mailer']['subject']; ?>" id="subject" class = "col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Is Use Area:</label>
				<div class="col-sm-1">
					<input type="checkbox" name="use_area" <?php if($MailerArr['Mailer']['use_area'] == 1){ echo 'checked'; } ?> value="1" id="use_area" class = "col-xs-10 col-sm-8" onclick="checkornot()" style="margin-top: 12px;">
				</div>
			</div>
			
				<div class="form-group" id="userArea" style="display:<?php if($MailerArr['Mailer']['use_area'] == 0){ echo 'none'; } ?>;">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
				<div class="col-sm-9">
					<table>
						<tr>
							<th>Product</th>
							<th>Coverage</th>
							<th>Coverage By Pack</th>
						</tr>
						<?php if(!empty($MailerArr['SpecUsearea'])){ foreach($MailerArr['SpecUsearea'] as $SpecUsearea){ ?>
						<tr>
							<td><input type="text" style="width:225px;" name="product[]" value="<?php echo $SpecUsearea['product']; ?>"></td>
							<td><input type="text" style="width:225px;" name="coverage[]" value="<?php echo $SpecUsearea['coverage']; ?>"></td>
							<td><input type="text" style="width:225px;" name="coverage_by_pack[]" value="<?php echo $SpecUsearea['coverage_by_pack']; ?>"></td>
						</tr>
						<?php } }else{ ?>
						<tr>
							<td><input type="text" style="width:225px;" name="product[]" value="Primer - Duromix WBE Hibuild"></td>
							<td><input type="text" style="width:225px;" name="coverage[]" value="5m<sup>2</sup>/L"></td>
							<td><input type="text" style="width:225px;" name="coverage_by_pack[]" value="20L Kit = 100m<sup>2</sup>"></td>
						</tr>
						<tr>
							<td><input type="text" style="width:225px;" name="product[]" value="Detailing: Polyurethance Joint Sealant"></td>
							<td><input type="text" style="width:225px;" name="coverage[]" value="1LM/100ml"></td>
							<td><input type="text" style="width:225px;" name="coverage_by_pack[]" value="600ml = 6LM"></td>
						</tr>
						<tr>
							<td><input type="text" style="width:225px;" name="product[]" value="Membrane: Duromastic P15"></td>
							<td><input type="text" style="width:225px;" name="coverage[]" value=" 2L/m<sup>2</sup> (2 Coats min)"></td>
							<td><input type="text" style="width:225px;" name="coverage_by_pack[]" value="15L/7.5m<sup>2</sup>"></td>
						</tr>
						<tr>
							<td><input type="text" style="width:225px;" name="product[]" value="Screed"></td>
							<td><input type="text" style="width:225px;" name="coverage[]" value=""></td>
							<td><input type="text" style="width:225px;" name="coverage_by_pack[]" value=""></td>
						</tr>
						<?php } ?>
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
	function checkornot(){
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
	}	
	jQuery(function(){ //short for $(document).ready(function(){

		$('.datepicker').datepicker({
			format: "dd/mm/yyyy",			
		});
		$("#tracknumber").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter tracknumber"
		});
		$("#email").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter email"
		}); $("#name").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter name/attn"
		});; $("#company").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter company"
		}); $("#subject").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter subject"
		});
	});

</script>