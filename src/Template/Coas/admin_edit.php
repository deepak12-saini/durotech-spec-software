<?php
$coa = $CoaArr;
$coaResults = $coa->coa_results ?? [];
?>
<div class="page-content">
	<div class="page-header">
		<div class="right_btn pull-right"><a href="<?= $this->Url->build(['controller' => 'Coas', 'action' => 'admin_index']); ?>" class="btn btn-inverse">Back</a></div>
		<h1>COA Durotech <small><i class="ace-icon fa fa-angle-double-right"></i> Edit COA</small></h1>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<?= $this->Form->create(null, ['class' => 'form-horizontal', 'type' => 'file', 'url' => ['controller' => 'Coas', 'action' => 'admin_edit', $coa->id]]); ?>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Product:</label>
				<div class="col-sm-9">
					<input type="text" name="product" value="<?= h($coa->product ?? ''); ?>" id="product" class="col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Batch No:</label>
				<div class="col-sm-9">
					<input type="text" name="batch_no" id="batch_no" value="<?= h($coa->batch_no ?? ''); ?>" class="col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Date of Manu:</label>
				<div class="col-sm-9">
					<input type="text" name="date_of_manu" id="date_of_manu" value="<?= h($coa->date_of_manu ?? ''); ?>" class="datepicker col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Expiry Date:</label>
				<div class="col-sm-9">
					<input type="text" name="expiry_date" id="expiry_date" value="<?= h($coa->expiry_date ?? ''); ?>" class="datepicker col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Form No:</label>
				<div class="col-sm-9">
					<input type="text" name="form_no" id="form_no" value="<?= h($coa->form_no ?? ''); ?>" class="col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Sign Date:</label>
				<div class="col-sm-9">
					<input type="text" name="signature_date" value="<?= h($coa->signature_date ?? ''); ?>" id="signature_date" class="datepicker col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Receiver Email:</label>
				<div class="col-sm-9">
					<input type="text" name="email" value="<?= h($coa->email ?? ''); ?>" id="email" class="col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Receiver Name:</label>
				<div class="col-sm-9">
					<input type="text" name="name" value="<?= h($coa->name ?? ''); ?>" id="name" class="col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Subject:</label>
				<div class="col-sm-9">
					<input type="text" name="subject" value="<?= h($coa->subject ?? 'Durotech: COA Result'); ?>" id="subject" class="col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
				<div class="col-sm-9">
					<table>
						<tr>
							<th>Test</th>
							<th>Result</th>
							<th>Specfication</th>
						</tr>
						<?php foreach ($coaResults as $row): ?>
						<tr>
							<td><input type="text" style="width:250px;" name="test[]" value="<?= h($row->test ?? $row['test'] ?? ''); ?>"></td>
							<td><input type="text" style="width:80px;" name="result[]" value="<?= h($row->result ?? $row['result'] ?? ''); ?>"></td>
							<td><input type="text" style="width:320px;" name="specfication[]" value="<?= h($row->specfication ?? $row['specfication'] ?? ''); ?>"></td>
						</tr>
						<?php endforeach; ?>
					</table>
				</div>
			</div>

			<div id="newdiv"></div>
			<div class="form-group">
				<div class="col-md-offset-3 col-md-9">
					<?= $this->Form->button('Submit', ['class' => 'btn btn-mini btn-success', 'id' => 'add_ser_prd_btn']); ?>
				</div>
			</div>
			<?= $this->Form->end(); ?>
		</div>
	</div>
</div>

<script type="text/javascript">
jQuery(function(){
	$('.datepicker').datepicker({ format: "yyyy-mm-dd" });
});
</script>
