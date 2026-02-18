<script src="<?php echo SITEURL; ?>ckeditor/ckeditor.js"></script>	
<div class="page-content">
	<div class="page-header">
	<h1>
	Durotech orders 
	<small>
		<i class="ace-icon fa fa-angle-double-right"></i>
		Add New Order
	</small>
	<a href="<?php echo SITEURL; ?>duro_orders" class="btn btn-mini btn-inverse" style="float:right;">Back</a>
	</h1>
	</div><!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
		
			<?php echo $this->Form->create('DuroOrder',array('class'=>'form-horizontal','role'=>'form','enctype'=>'multipart/form-data'));?>	
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Customer Order Number: </label>
					<div class="col-sm-9">
						<?php 
						
						echo $this->Form->input('DuroOrder.customer_order_no',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'customer_order_no','placeholder'=>'Customer Order Number','readonly'=>true,'style'=>'background-color: #ddd !important;','value'=>$docId))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Date of Order: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('DuroOrder.date_of_order',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'datepicker col-xs-10 col-sm-5','id'=>'date_of_order','placeholder'=>'Date of Order','value'=>date('Y-m-d')))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Account Name: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('DuroOrder.account_name',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'account_name','placeholder'=>'Account Name'))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Order Taken By: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('DuroOrder.order_taken_by',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'order_taken_by','placeholder'=>'Order Taken By'))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Customer Name: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('DuroOrder.contact_name',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'contact_name','placeholder'=>'Customer Name'))?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Customer Phone: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('DuroOrder.contact_phone',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'contact_phone','placeholder'=>'Customer Phone'))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Deliver Address: </label>
					<div class="col-sm-9">
						<textarea name="data[DuroOrder][deliver_address]" id="deliver_address" class="col-xs-10 col-sm-5" placeholder="Deliver Address"></textarea>
					
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Deliver Date: </label>
					<div class="col-sm-9">
							<?php echo $this->Form->input('DuroOrder.delivery_date',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'datepicker col-xs-10 col-sm-5','id'=>'delivery_date','placeholder'=>'Deliver Date'))?>					
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Sign Authority: </label>
					<div class="col-sm-9">
							<?php echo $this->Form->input('DuroOrder.sign_authority',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'sign_authority','placeholder'=>'Sign Authority'))?>					
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Delivery Instruction: </label>
					<div class="col-sm-9">
							<?php echo $this->Form->input('DuroOrder.delivery_instruction',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'delivery_instruction','placeholder'=>'Delivery Instruction'))?>					
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Deliver Requirement: </label>
					<div class="col-sm-9">
							<?php echo $this->Form->input('DuroOrder.deliver_requirement',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'deliver_requirement','placeholder'=>'Deliver Requirement'))?>					
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Pallet Required: </label>
					<div class="col-sm-9">
							<?php echo $this->Form->input('DuroOrder.pallet_required',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'pallet_required','placeholder'=>'Pallet Required'))?>					
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Payment Mode: </label>
					<div class="col-sm-9">
							<?php echo $this->Form->input('DuroOrder.payment_mode',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'payment_mode','placeholder'=>'Payment Mode'))?>					
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Payment Mode: </label>
					<div class="col-sm-9">
							<?php echo $this->Form->input('DuroOrder.payment_mode',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'payment_mode','placeholder'=>'Payment Mode'))?>					
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Comment: </label>
					<div class="col-sm-9">
						<textarea name="data[DuroOrder][comment]" id="comment" class="col-xs-10 col-sm-5" placeholder="Comment"></textarea>
					
					</div>
				</div>
				
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
					<div class="col-sm-9">
						<div class="table-responsive">
						<table style=" width:100% !important; ">
							<tr>		
								<th>Product Name</th>
								<th>Color</th>
								<th>Size</th>
								<th>Quantity</th>
								<th></th>
							</tr>
							<tbody>
								<tr>									
									<td> <input type="text" name="data[product_name][]"  value="" placeholder="Product Name" style="margin:5px;" required  /></td>
									<td> <input type="text" name="data[color][]"  value="" placeholder="Product Color" style="margin:5px;"  required /></td>					
									<td> <input type="text" name="data[size][]"  value="" placeholder="Product Size" style="margin:5px;"  required /></td>						
									<td> <input type="text" name="data[qty][]"  value="" placeholder="Product Quantity" style="margin:5px;"  required /></td>					
									<td>&nbsp;&nbsp; </td>					
								</tr>
							</tbody>
														
						</table>
						<div class="tblrow"></div>
						</div>
						<a href="#null" class="btn btn-mini btn-info" onclick="addmore()"> Add More</a>
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
	
	function deletetrow(noid){
		$("#tbl_"+noid).remove();
	}
	function addmore(){
	
		var n = $("#center div").length + 1;
		var  tablevew = '<table style=" width:100% !important; " id="tbl_'+n+'"><tbody><tr><td> <input type="text" name="data[product_name][]"  value="" placeholder="Product Name" style="margin:5px;" required  /></td><td> <input type="text" name="data[color][]"  value="" placeholder="Product Color" style="margin:5px;"  required /></td><td> <input type="text" name="data[size][]"  value="" placeholder="Product Size" style="margin:5px;"  required /></td><td> <input type="text" name="data[qty][]"  value="" placeholder="Product Quantity" style="margin:5px;"  required /></td><td> <a href="#null" onclick="deletetrow('+n+')"><i class="fa fa-close" style="color:red;"> </i></a></td>		</tr></tbody></table>';
		$(".tblrow").append(tablevew);
	}
	
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