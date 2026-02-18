
	<div class="page-content">
		<div class="page-header">
		<div class="right_btn pull-right" ><a href="javascript:window.history.back();" class="btn btn-inverse" >Back</a></div>
		<h1>DuroEzy Specification  <small><i class="ace-icon fa fa-angle-double-right"></i>Create New Spec</small>
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
					<input type="text" name="name" value="" id="name" class = "col-xs-10 col-sm-8">
				</div>
			</div>	
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Company:</label>
				<div class="col-sm-9">
					<input type="text" name="company" value=""  class = "col-xs-10 col-sm-8">
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Address:</label>
				<div class="col-sm-9">
					<input type="text" name="address" value=""  class = "col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Specification:</label>
				<div class="col-sm-9">
					<input type="text" name="specification" value=""  class = "col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Email:</label>
				<div class="col-sm-9">
					<input type="text" name="email" value="" id="email"  class = "col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Date:</label>
				<div class="col-sm-9">
					<input type="text" name="date" value="<?php echo date('d/m/Y');?>" id="date"  class = "datepicker col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Mailer Type:</label>
				<div class="col-sm-9">
					<select name="type" class="col-xs-10 col-sm-8"  onchange="setsubject(this.value)"  >
						<!-- <option value="">Select Client Requested</option> -->
						<!--option value="1">INSTALLATION OF DUROMASTIC P-15 WATERPROOFING MEMBRANE</option>
						<option value="2">Waterproofing Specification – Wet area shower</option-->
						<option value="3">External Liquid WPM</option> 
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Subject:</label>
				<div class="col-sm-9">
					<input type="text" name="subject" value="Durotech: External Liquid WPM" id="subject" class = "col-xs-10 col-sm-8">
				</div>
			</div>
			<!--div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">MFT(Minimum Film Thickness):</label>
				<div class="col-sm-9">
					<input type="text" name="mft" placeholder="MFT(Minimum Film Thickness)" id="mft" class = "col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Warranty Period:</label>
				<div class="col-sm-9">
					<input type="text" name="warranty_period" placeholder="Warrenty Period" id="warranty_period" class = "col-xs-10 col-sm-8">
				</div>
			</div-->
			<!--div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Is Use Area:</label>
				<div class="col-sm-1">
					<input type="checkbox" name="use_area" value="1" id="use_area" class = "col-xs-10 col-sm-8" onclick="checkornot()" style="margin-top: 12px;">
				</div>
			</div-->
			
			
			<div id="addsection"></div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
				<div class="col-sm-1">
					<a href="javascript:void(0);" class="btn btn-xs btn-primary" style="margin-top:10px;" onclick="addnewsection()"><i class="fa fa-plus"></i> Add Section</a>
				</div>
			</div>
			<!--div class="form-group" id="userArea" style="display:none;">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
				<div class="col-sm-9">				
					<table>
						<tr>							
							<th></th>
							<th>Product</th>
							<th>Coverage</th>
							<th>MFT</th>
							<th>Warranty Period</th>
						</tr>
						<tr>							
							<td><input type="text" style="width:30px;" name="serial[]" value="1"></td>
							<td><input type="text" style="width:225px;" name="product[]" value=""></td>
							<td><input type="text" style="width:225px;" name="coverage[]" value=""></td>
							<td><input type="text" style="width:100px;" name="coverage_by_pack[]" value="1"></td>
							<td><input type="text" style="width:100px;" name="Warranty[]" value="5 Year"></td>
						</tr>
						
					</table>
					<div id="addnew"></div>
					<a href="javascript:void(0);" class="btn btn-xs btn-primary" style="margin-top:10px;" onclick="addmore()"><i class="fa fa-plus"></i> Add More</a>
				</div>
			</div-->
		
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
	function addmore(id){
		var numItems = $('.newitem_'+id).length;		
		var newdiv = 	numItems + 1;
		var dtserial = id+'.'+newdiv;
		var addnew ='<table class="newitem_'+id+'"  id="div_'+id+'_'+newdiv+'" ><tr><td><input type="text" style="width:30px;" name="serial[]" value="'+dtserial+'"></td><td><input type="text" style="width:225px;" name="product[]" value=""></td><td><input type="text" style="width:225px;" name="coverage[]" value=""></td><td><input type="text" style="width:100px;" name="coverage_by_pack[]" value=""></td><td><input type="text" style="width:100px;" name="Warranty[]" value=""></td><td><a href="javascript:void(0);" style="color:red;" onclick="remove('+id+','+newdiv+')">&nbsp;&nbsp; X </a></td></tr></table>';
		$("#addnew_"+id).append(addnew);
	}	
	function remove(id,newdiv){	
		$("#div_"+id+"_"+newdiv).remove();
	}
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

	function addnewsection(){
		var numItems = $('.addsection').length;		
		var newdiv = 	numItems + 1;
		var varhtml = '<div class="form-group addsection" id="section_'+newdiv+'"><label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label><div class="col-sm-9"><table><tr><th></th><th>Product</th><th>Coverage</th><th>MFT</th><th>Warranty Period</th></tr><tr><td><input type="text" style="width:30px;" name="serial[]" value="'+newdiv+'"></td><td><input type="text" style="width:225px;" name="product[]" value=""></td><td><input type="text" style="width:225px;" name="coverage[]" value=""></td><td><input type="text" style="width:100px;" name="coverage_by_pack[]" value=""></td><td><input type="text" style="width:100px;" name="Warranty[]" value=""></td></tr></table><div id="addnew_'+newdiv+'"></div><a href="javascript:void(0);" class="btn btn-xs btn-primary" style="margin-top:10px;" onclick="addmore('+newdiv+')"><i class="fa fa-plus"></i> Add More</a></div></div>';	
		
		$("#addsection").append(varhtml);	
	}
</script>