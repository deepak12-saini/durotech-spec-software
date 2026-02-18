<script src="<?php echo SITEURL; ?>ckeditor/ckeditor.js"></script>
<?php 
	$name = $this->Session->read('Customer.name').' '.$this->Session->read('Customer.lname');
?>	
<div class="page-content">
	<div class="page-header">
	<h1>
	Durotech orders 
	<small>
		<i class="ace-icon fa fa-angle-double-right"></i>
		Add New Order
	</small>
	<a href="<?php echo SITEURL; ?>hrs" class="btn btn-mini btn-inverse" style="float:right;">Back</a>
	</h1>
	</div><!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
		
			<?php echo $this->Form->create('DuroOrder',array('class'=>'form-horizontal','role'=>'form','enctype'=>'multipart/form-data'));?>	
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">OrderId: </label>
					<div class="col-sm-9">
						<?php 
						
						echo $this->Form->input('DuroDelivery.order_id',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'order_id','placeholder'=>'OrderId','readonly'=>true,'style'=>'background-color: #ddd !important;','value'=>$docId))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Docket Number: </label>
					<div class="col-sm-9">
						<?php 
						
						echo $this->Form->input('DuroDelivery.docket_number',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'docket_number','placeholder'=>'Docket Number'))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Date of Order: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('DuroDelivery.date_of_order',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'datepicker col-xs-10 col-sm-5','id'=>'date_of_order','placeholder'=>'Date of Order','value'=>date('Y-m-d')))?>
					</div>
				</div>
				
				
				
				<!--div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Pickup Address: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('DuroDelivery.pickup_address',array('div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'pickup_address','placeholder'=>'Pickup Address'))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Deliver Address: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('DuroDelivery.deliver_address',array('div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'deliver_address','placeholder'=>'Deliver Address'))?>
					</div>
				</div-->
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Pickup Name: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('DuroDelivery.pickup_name',array('div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'pickup_name','placeholder'=>'Pickup Name','value'=>$name))?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Pickup Date: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('DuroDelivery.pickup_date',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'datepicker col-xs-10 col-sm-5','id'=>'pickup_date','placeholder'=>'Pickup date','value'=>date('Y-m-d')))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Pickup Time: </label>
					<div class="col-sm-4">
						<div class='input-group date' id='datetimepicker3'>
							<input type='text' class="form-control" name="data[DuroDelivery][pickup_time]" vaLue="<?php echo date('h:i A'); ?>"  />
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-time"></span>
							</span>
						</div>						
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Deliver Date: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('DuroDelivery.deliver_date',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'datepicker col-xs-10 col-sm-5','id'=>'deliver_date','placeholder'=>'Date of Order','value'=>date('Y-m-d')))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Deliver Time: </label>
					<div class="col-sm-4">
						<div class='input-group date' id='datetimepicker4'>
							<input type='text' class="form-control" name="data[DuroDelivery][deliver_time]" vaLue="<?php echo date('h:i A'); ?>"  />
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-time"></span>
							</span>
						</div>						
					</div>
				</div>
			
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Upload Docket File: </label>
					<div class="col-sm-9">
						<input type="file" name="docket_file" id="docketfile" class="col-xs-10 col-sm-5">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Driver: </label>
					<div class="col-sm-9">
						<select name="data[DuroDelivery][driver_id]" id="driver_id" class ='col-xs-10 col-sm-5'>
							<option value="">Select Driver</option>
							<?php foreach($driver as $drivers){ ?>
								<option value="<?php echo $drivers['Driver']['id']; ?>">
								<?php echo $drivers['Driver']['driver_name']; ?></option>
							<?php } ?>
						</select>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script type="text/javascript" src="<?php echo SITEURL; ?>datetimepicker/bootstrap-datetimepicker.min.js"></script>

<script type="text/javascript">
	
	$(function () {
		$('#datetimepicker3').datetimepicker({
			format: 'LT'
		});
		$('#datetimepicker4').datetimepicker({
			format: 'LT'
		});
	});
	jQuery(function(){ 
		$('.datepicker').datepicker({
			format: 'yyyy-mm-dd',			
		});		
		$("#pickup_name").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter pickup name"
		});$("#account_name").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter account name"
		});$("#docketfile").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please select docketfile"
		});$("#docket_number").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter docket number"
		});$("#driver_id").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter driver id"
		});
	});
</script>