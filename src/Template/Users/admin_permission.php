	<style>	.btn{margin-bottom: 5px; }	</style>	
	<div class="page-content">

		<div class="page-header">
			<h1><b><?= h(ucfirst($NappUser['NappUser']['name'] ?? '') . ' ' . ucfirst($NappUser['NappUser']['lname'] ?? '')) ?></b>: <small>Staff Permissions</small>
				<a href="<?= $this->Url->build(['action' => 'admin_staff']) ?>" style="float:right" class="btn btn-xs btn-inverse">Back</a>
			</h1>
		</div>
	
		<div class="row">
			<div class="col-xs-12">
			<?php
			
			$permssionId = [];
			if (!empty($upermission)) {
				foreach ($upermission as $upItem) {
					$u = $upItem['UserPermission'] ?? $upItem;
					$permssionId[] = $u['permssion_id'] ?? null;
				}
			}		
			echo $this->Form->create(null, ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) ?>
				<input type="hidden" name="new" value="1">
				
				
					<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Staff Document Permission</small> </label>
					<div class="col-sm-9">
						<?php foreach ($permission as $permissions): $p = $permissions['Permission'] ?? $permissions; ?>
							<label class="block">
								<input class="ace input-lg" <?= in_array($p['id'] ?? null, $permssionId) ? 'checked' : '' ?> value="<?= h(($p['id'] ?? '') . '-' . ($p['meta_key'] ?? '')) ?>" name="permssion_id[]" type="checkbox">
								<span class="lbl bigger-120"><?= h($p['meta_val'] ?? '') ?></span>
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