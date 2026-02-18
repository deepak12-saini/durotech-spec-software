
	<div class="page-content">
		<div class="page-header">
		<div class="right_btn pull-right" ><a href="javascript:window.history.back();" class="btn btn-inverse" >Back</a></div>
		<h1>Duortech <?php echo ucfirst($acctype); ?> Stock Return Logs <small><i class="ace-icon fa fa-angle-double-right"></i>Add New</small>
		</h1>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
		<?php echo $this->Form->create('StockReturn',array('class'=>'form-horizontal','enctype'=>'multipart/form-data')); ?>
		
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Return Id:</label>
				<div class="col-sm-9">
					<input type="text" name="return_id" value="<?php echo $refernce; ?>" id="return_id" class = "col-xs-10 col-sm-8" readonly style="background:#eee; ">
				</div>
			</div>	
			
			<div class="form-group" >				
				<div class="col-sm-12">
					<table>
						<tr>
							<th>Date</th>
							<th>Customer</th>
							<th>Item</th>
							<th>Reason For Return</th>
							<th>Condition OF Good<br><small>Saleable,Saleable with discount,<br>not saleable,reworkable</small></th>
							<th>Batch Number</th>
							<th>Received By</th>
						</tr>
						<tr>
							<td><input type="text" class="datepicker" style="width:100px;" name="date[]" value="<?php echo date('Y-m-d');?>" ></td>
							<td><input type="text" style="width:100px;" name="customer[]" value=""></td>
							<td><input type="text" style="width:200px;" name="items[]" value=""></td>
							<td><input type="text" style="width:250px;" name="reason[]" value=""></td>
							<td><input type="text" style="width:250px;" name="conditions[]" value=""></td>
							<td><input type="text" style="width:100px;" name="batch[]" value=""></td>
							<td><input type="text" style="width:100px;" name="received[]" value=""></td>
						</tr>
						
					</table>
					<div id="addnew"></div>
					<a href="javascript:void(0);" class="btn btn-xs btn-primary" style="margin-top:10px;" onclick="addmore()"><i class="fa fa-plus"></i> Add</a>
				</div>
			</div>
		
			<div id="newdiv"></div>
			<div class="form-group">
				<div class="col-md-9">
					<?php echo $this->Form->submit('Submit',array('div'=>false,'label'=>false, 'class' => 'btn btn-mini  btn-success','id'=>'add_ser_prd_btn','value'=>'Submit'));?>&nbsp;
				
				</div>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>	
	</div>	
	
	
<script type="text/javascript">
	function addmore(){
		var numItems = $('.newitem').length;		
		var newdiv = 	numItems + 1;
		
		var addnew ='<tr  class="newitem" id="div_'+newdiv+'"><td><input type="text"  class="datepickerS"  style="width:100px;" name="date[]" value="<?php echo date('Y-m-d');?>" ></td><td><input type="text" style="width:100px;" name="customer[]" value=""></td><td><input type="text" style="width:200px;" name="items[]" value=""></td><td><input type="text" style="width:250px;" name="reason[]" value=""></td><td><input type="text" style="width:250px;" name="conditions[]" value=""></td><td><input type="text" style="width:100px;" name="batch[]" value=""></td><td><input type="text" style="width:100px;" name="received[]" value=""></td><td><a href="javascript:void(0);" style="color:red;" onclick="remove('+newdiv+')">&nbsp;&nbsp; X </a></td></tr>';
		$("#addnew").append(addnew);
	}	
	function remove(id){	
		$("#div_"+id).remove();
	}
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