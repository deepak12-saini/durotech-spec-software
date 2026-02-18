	<style>	.btn{margin-bottom: 5px; }	</style>	
	<div class="page-content">

		<div class="page-header">
			<h1><b><?= h(ucfirst($NappUser->name ?? '') . ' ' . ucfirst($NappUser->lname ?? '')) ?></b>: <small>Price List Access</small>
				<a href="<?= $this->Url->build(['action' => 'admin_customer']) ?>" style="float:right" class="btn btn-xs btn-inverse">Back</a>
			</h1>
		</div>
	
		<div class="row">
			<div class="col-xs-12">
			<?php
			$labsid = [];
			if (!empty($LabAssign)) {
				foreach ($LabAssign as $LabAssigns) {
					$item = is_array($LabAssigns) ? ($LabAssigns['LabAssign'] ?? $LabAssigns) : $LabAssigns->toArray();
					$labsid[] = $item['lab_id'] ?? null;
				}
			}
			echo $this->Form->create(null, ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) ?>
				<input type="hidden" name="new" value="1">
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Assign Price List</label>
					<div class="col-sm-9">
						<?php if (!empty($labfile)) foreach ($labfile as $labfiles):
							$lf = is_array($labfiles) ? ($labfiles['LabFile'] ?? $labfiles) : $labfiles->toArray();
							if (empty($lf['filename'] ?? null)) continue; ?>
							<label class="block">
								<input class="ace input-lg" <?= in_array($lf['id'] ?? null, $labsid) ? 'checked' : '' ?> value="<?= h($lf['id'] ?? '') ?>" name="lab_id[]" type="checkbox">
								<span class="lbl bigger-120"><?= h($lf['label'] ?? '') ?></span>
							</label>
						<div style="clear:both;"></div>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-offset-3 col-md-9">
						<?= $this->Form->button('Update', ['class' => 'btn btn-xs btn-success', 'id' => 'add_ser_prd_btn']) ?>
					</div>
				</div>
				<?= $this->Form->end() ?>
			</div>
		</div>		
		
</div>		