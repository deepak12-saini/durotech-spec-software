	
	<div class="page-content">
		<div class="page-header">
		<div class="right_btn pull-right"><a href="<?php echo $this->Url->build(['controller' => 'Materials', 'action' => 'order', $type ?? 'pending']); ?>" class="btn btn-inverse">Back</a></div>
		<h1>Material <small><i class="ace-icon fa fa-angle-double-right"></i> Complete Order</small></h1>
	</div>

	<div class="row">
		<div class="col-xs-12">
		<?php echo $this->Form->create(null, ['class' => 'form-horizontal', 'type' => 'file', 'url' => ['controller' => 'Materials', 'action' => 'update', $status ?? 2, $orderid ?? '', $type ?? '']]); ?>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> DT PO Number:</label>
				<div class="col-sm-9">
					<?php echo $this->Form->control('MaterialOrder.dt_po_number', ['div' => false, 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'dt_po_number', 'placeholder' => 'DT PO Number']); ?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-offset-3 col-md-9">
					<?php echo $this->Form->submit('Complete Order', ['div' => false, 'label' => false, 'class' => 'btn btn-success', 'id' => 'add_ser_prd_btn']); ?>
				</div>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>	
	</div>	
<script type="text/javascript">
			jQuery(function(){ //short for $(document).ready(function(){

				$("#dt_po_number").validate({
                     expression: "if (VAL) return true; else return false;",
                    message: "Please enter dt po number"
                }); $("#imagse").validate({
                     expression: "if (VAL) return true; else return false;",
                    message: "Please select image"
                }); 
			});
			</script>
