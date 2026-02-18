	<div class="page-content">
		<div class="page-header">
		<div class="right_btn pull-right"><a href="<?php echo $this->Url->build(['controller' => 'Productions', 'action' => 'adminIndex']); ?>" class="btn btn-inverse">Back</a></div>
		<h1>Batches Made <small><i class="ace-icon fa fa-angle-double-right"></i> Edit</small></h1>
		</div>	
	<div class="row">
		<div class="col-xs-12">
		<?php
		$br = is_object($batchRegister) ? $batchRegister : (object)($batchRegisterArr['BatchRegister'] ?? []);
		$brId = $br->id ?? $batchRegisterArr['BatchRegister']['id'] ?? $id ?? null;
		$brArray = is_object($br) ? $br->toArray() : ($batchRegisterArr['BatchRegister'] ?? []);
		echo $this->Form->create(null, ['class' => 'form-horizontal', 'type' => 'file', 'url' => ['controller' => 'Productions', 'action' => 'adminBatchRegisterEdit', $brId]]);
		?>
		
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">User:</label>
				<div class="col-sm-9">
					<?php echo $this->Form->control('BatchRegister.user_id', [
						'type' => 'select',
						'options' => $users ?? [],
						'empty' => 'Select User',
						'div' => false,
						'label' => false,
						'class' => 'col-xs-10 col-sm-5',
						'id' => 'user_id',
						'value' => $brArray['user_id'] ?? ''
					]); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Batch Number:</label>
				<div class="col-sm-9">
					<?php echo $this->Form->control('BatchRegister.batch_no', [
						'div' => false,
						'label' => false,
						'class' => 'col-xs-10 col-sm-5',
						'id' => 'batch_no',
						'placeholder' => 'Batch Number',
						'value' => $brArray['batch_no'] ?? ''
					]); ?>
				</div>
			</div>	
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Date:</label>
				<div class="col-sm-9">
					<?php echo $this->Form->control('BatchRegister.date', [
						'type' => 'text',
						'div' => false,
						'label' => false,
						'class' => 'datepicker col-xs-10 col-sm-5',
						'id' => 'date',
						'placeholder' => 'Date',
						'value' => $brArray['date'] ?? ''
					]); ?>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Product Name:</label>
				<div class="col-sm-9">
					<?php echo $this->Form->control('BatchRegister.product', [
						'div' => false,
						'label' => false,
						'class' => 'col-xs-10 col-sm-5',
						'id' => 'product_name',
						'placeholder' => 'Product Name',
						'value' => $brArray['product'] ?? ''
					]); ?>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Apearance:</label>
				<div class="col-sm-9">
					<?php echo $this->Form->control('BatchRegister.apearance', [
						'div' => false,
						'label' => false,
						'class' => 'col-xs-10 col-sm-5',
						'id' => 'apearance',
						'placeholder' => 'Apearance',
						'value' => $brArray['apearance'] ?? ''
					]); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Viscosity:</label>
				<div class="col-sm-9">
					<?php echo $this->Form->control('BatchRegister.viscosity', [
						'div' => false,
						'label' => false,
						'class' => 'col-xs-10 col-sm-5',
						'id' => 'viscosity',
						'placeholder' => 'viscosity',
						'value' => $brArray['viscosity'] ?? ''
					]); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">T<sup>o</sup>C:</label>
				<div class="col-sm-9">
					<?php echo $this->Form->control('BatchRegister.t_degree_c', [
						'div' => false,
						'label' => false,
						'class' => 'col-xs-10 col-sm-5',
						'id' => 't_degree_c',
						'placeholder' => 'T Degree c',
						'value' => $brArray['t_degree_c'] ?? ''
					]); ?>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">S.G:</label>
				<div class="col-sm-9">
					<?php echo $this->Form->control('BatchRegister.s_g', [
						'div' => false,
						'label' => false,
						'class' => 'col-xs-10 col-sm-5',
						'id' => 's_g',
						'placeholder' => 'S.G',
						'value' => $brArray['s_g'] ?? ''
					]); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Check Test:</label>
				<div class="col-sm-9">
					<?php echo $this->Form->control('BatchRegister.check_test', [
						'div' => false,
						'label' => false,
						'class' => 'col-xs-10 col-sm-5',
						'id' => 'check_test',
						'placeholder' => 'Check Test',
						'value' => $brArray['check_test'] ?? ''
					]); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Test By:</label>
				<div class="col-sm-9">
					<?php echo $this->Form->control('BatchRegister.test_by', [
						'div' => false,
						'label' => false,
						'class' => 'col-xs-10 col-sm-5',
						'id' => 'test_by',
						'placeholder' => 'Test By',
						'value' => $brArray['test_by'] ?? ''
					]); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Comments:</label>
				<div class="col-sm-9">
					<?php echo $this->Form->control('BatchRegister.comments', [
						'div' => false,
						'label' => false,
						'class' => 'col-xs-10 col-sm-5',
						'id' => 'comments',
						'placeholder' => 'Comments',
						'value' => $brArray['comments'] ?? ''
					]); ?>
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-md-offset-3 col-md-9">
					<?php echo $this->Form->submit('Submit', ['div' => false, 'label' => false, 'class' => 'btn btn-success', 'id' => 'add_ser_prd_btn']); ?>&nbsp;
					<?php echo $this->Html->link('Cancel', $this->Url->build(['controller' => 'Productions', 'action' => 'adminIndex']), ['class' => 'btn btn-danger']); ?>
				</div>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>	
	</div>	
<script type="text/javascript">
jQuery(function(){
	$('.datepicker').datepicker({
		format: "yyyy-mm-dd",
	});	
	$("#product_name").validate({
		expression: "if (VAL) return true; else return false;",
		message: "Please enter product name"
	});
	$("#batch_no").validate({
		expression: "if (VAL) return true; else return false;",
		message: "Please enter batch no."
	});
	$("#apearance").validate({
		expression: "if (VAL) return true; else return false;",
		message: "Please enter apearance"
	});
	$("#viscosity").validate({
		expression: "if (VAL) return true; else return false;",
		message: "Please enter viscosity"
	});
	$("#check_test").validate({
		expression: "if (VAL) return true; else return false;",
		message: "Please enter check test"
	});
	$("#test_by").validate({
		expression: "if (VAL) return true; else return false;",
		message: "Please enter test by"
	});
});
</script>
