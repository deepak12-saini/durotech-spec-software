<script src="<?php echo SITEURL; ?>ckeditor/ckeditor.js"></script>	
<div class="page-content">
	<div class="page-header">
	<h1>
	Po Order List
	<small>
		<i class="ace-icon fa fa-angle-double-right"></i>
		Edit Order
	</small>
	<a href="<?php echo $this->Url->build(['controller' => 'Pos', 'action' => 'index']); ?>" class="btn btn-mini btn-inverse" style="float:right;">Back</a>
	</h1>
	</div><!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
		<?php
		$po = $PoOrderArr['PoOrder'] ?? [];
		$poId = $po['id'] ?? $id ?? null;
		echo $this->Form->create(null, ['class' => 'form-horizontal', 'role' => 'form', 'type' => 'file', 'url' => ['controller' => 'Pos', 'action' => 'edit', $poId]]);
		?>	
				
				<div class="form-group">
					<label class="col-sm-2 control-label no-padding-right" for="form-field-1">Supiler Name : </label>
					<div class="col-sm-6">
						<?php echo $this->Form->control('PoOrder.suplier_name', [
							'div' => false,
							'label' => false,
							'class' => 'col-xs-10 col-sm-5',
							'id' => 'suplier_name',
							'placeholder' => 'Supiler Name',
							'value' => $po['suplier_name'] ?? ''
						]); ?>
					</div>
				</div>	
				<div class="form-group">
					<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Status: </label>
					<div class="col-sm-6">					
						<?php $status = (int)($po['status'] ?? 0); ?>
						<select class="col-xs-10 col-sm-5" name="data[PoOrder][status]" id="status">						
							<option value="0" <?php echo $status == 0 ? 'selected' : ''; ?>>Pending</option>
							<option value="1" <?php echo $status == 1 ? 'selected' : ''; ?>>In-Process</option>
							<option value="2" <?php echo $status == 2 ? 'selected' : ''; ?>>Completed</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label no-padding-right" for="form-field-1"></label>
					<div class="col-sm-10">
						<div class="table-responsive">
						<table style=" width:100% !important; ">
							<tr>		
								<th>Item Name</th>							
								<th>Quantity</th>
								<th></th>
							</tr>
							<tbody>
								<?php if(empty($PoOrderArr['PoOrderDetail'])){	?>							
									<tr>									
										<td> <input type="text" name="data[item_name][]"  value="" placeholder="Item Name" style="margin:5px;width: 98%;" required  /></td>														
										<td> <input type="text" name="data[quantity][]"  value="" placeholder="Quantity" style="margin:5px;width:150px;"  required /></td>					
										<td>&nbsp;&nbsp; </td>					
									</tr>
								<?php } ?>
							</tbody>
														
						</table>
						<div class="tblrow">
						<?php 
						$i=1;
						$details = $PoOrderArr['PoOrderDetail'] ?? [];
						if(!empty($details)){ 
							foreach($details as $PoOrderDetails){	
								$detail = is_array($PoOrderDetails) ? $PoOrderDetails : (is_object($PoOrderDetails) ? $PoOrderDetails->toArray() : []);
						?>
							<table style=" width:100% !important;" id="tbl_<?php echo $i; ?>" class="tablenew"><tbody><tr><td> <input type="text" name="data[item_name][]" value="<?php echo h($detail['item_name'] ?? ''); ?>" placeholder="Item Name" style="margin:5px; width: 99%;" required=""></td><td> <input type="text" name="data[quantity][]"  value="<?php echo h($detail['quantity'] ?? ''); ?>" placeholder="Quantity" style="margin:1px 0px 0px 10px; width:150px;" required=""></td><td style="text-align:letf;"> <a href="#null" onclick="deletetrow(<?php echo $i; ?>)"><i class="fa fa-close" style="color:red;"> </i></a></td>		</tr></tbody></table>
						<?php $i++; } } ?>	
							
						</div>
						</div>
						<a href="#null" class="btn btn-mini btn-info" onclick="addmore()" style="margin-left: 5px;"> Add More</a>
					</div>
				</div>
				
				<div class="form-group">
				<div class="col-md-offset-2 col-md-9">
					<?php echo $this->Form->submit('Submit', ['class' => 'btn btn-xs btn-success', 'id' => 'add_ser_prd_btn', 'style' => 'margin-left: 5px;']); ?>&nbsp;
					<?php echo $this->Html->link('Cancel', $this->Url->build(['controller' => 'Pos', 'action' => 'index']), ['class' => 'btn btn-xs btn-danger']); ?>
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
	
		var n = $(".tablenew").length + 1;
		var  tablevew = '<table style=" width:100% !important; " id="tbl_'+n+'" class="tablenew"><tbody><tr><td> <input type="text" name="data[item_name][]"  value="" placeholder="Item Name" style="margin:5px; width: 99%;" required  /></td><td> <input type="text" name="data[quantity][]"  value="" placeholder="Quantity" style="margin:1px 0px 0px 10px; width:150px;"  required /></td><td style="text-align:letf;"> <a href="#null" onclick="deletetrow('+n+')"><i class="fa fa-close" style="color:red;"> </i></a></td>		</tr></tbody></table>';
		$(".tblrow").append(tablevew);
	}
	
	jQuery(function(){ 
		$('.datepicker').datepicker({
			format: 'yyyy-mm-dd',			
		});
		
		$("#suplier_name").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter suplier name"
		});
	});
</script>