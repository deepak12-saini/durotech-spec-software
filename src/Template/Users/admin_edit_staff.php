<div class="page-content">
	<div class="page-header">
	<h1>
	Durotech Employee 
	<small>
	<i class="ace-icon fa fa-angle-double-right"></i>
		Edit Employee
	</small>
	
	<a href="<?= $this->Url->build(['action' => 'admin_staff']) ?>" class="btn btn-mini btn-inverse" style="float:right;">Back</a>
	</h1>
	</div><!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
			<?php
				$deptOptions = [];
				foreach ((array)$departmentArr as $d) {
					if (isset($d['Department']['id'], $d['Department']['department_title'])) {
						$deptOptions[$d['Department']['id']] = $d['Department']['department_title'];
					}
				}
				$sid = isset($staffArr['NappUser']['id']) ? $staffArr['NappUser']['id'] : null;
				echo $this->Form->create(null, ['url' => ['action' => 'admin_edit_staff', $sid], 'class' => 'form-horizontal']);
			?>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Select Department: </label>
					<div class="col-sm-9">
						<?= $this->Form->control('NappUser.dept_id', ['options' => $deptOptions, 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'dept_id', 'empty' => 'Select Department', 'value' => $staffArr['NappUser']['dept_id'] ?? '']) ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Name: </label>
					<div class="col-sm-9">
						<?= $this->Form->control('NappUser.name', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'name', 'placeholder' => 'Enter Name', 'value' => $staffArr['NappUser']['name'] ?? '']) ?>
					</div>
				</div>
			
				<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Email: </label>
						<div class="col-sm-9">
							<?= $this->Form->control('NappUser.email', ['type' => 'email', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'email', 'placeholder' => 'Email', 'value' => $staffArr['NappUser']['email'] ?? '']) ?>
						</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Phone Number: </label>
					<div class="col-sm-9">
						<?= $this->Form->control('NappUser.mobile_number', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'phone', 'placeholder' => 'Phone Number', 'value' => $staffArr['NappUser']['mobile_number'] ?? '']) ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Production App Login Key: </label>
					<div class="col-sm-9">
						<?= $this->Form->control('NappUser.productionlogin_key', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'productionlogin_key', 'placeholder' => 'Production App Login Key', 'value' => $staffArr['NappUser']['productionlogin_key'] ?? '']) ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> KPI: </label>
					<div class="col-sm-9">
						<?= $this->Form->control('NappUser.kpi', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'kpi', 'placeholder' => 'KPI', 'value' => $staffArr['NappUser']['kpi'] ?? '']) ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Status: </label>
					<div class="col-sm-9">
						<input type="radio" name="NappUser[is_approved]" <?= (isset($staffArr['NappUser']['is_approved']) && (int)$staffArr['NappUser']['is_approved'] === 1) ? 'checked' : '' ?> value="1"> Active
						<input type="radio" name="NappUser[is_approved]" <?= (isset($staffArr['NappUser']['is_approved']) && (int)$staffArr['NappUser']['is_approved'] === 0) ? 'checked' : '' ?> value="0"> Deactive
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> OTP:<br><small>IS SMS OTP ACTIVE</small></label>
					<div class="col-sm-9">
						<input type="radio" name="NappUser[is_active_otp]" <?= (isset($staffArr['NappUser']['is_active_otp']) && (int)$staffArr['NappUser']['is_active_otp'] === 1) ? 'checked' : '' ?> value="1"> Active
						<input type="radio" name="NappUser[is_active_otp]" <?= (isset($staffArr['NappUser']['is_active_otp']) && (int)$staffArr['NappUser']['is_active_otp'] === 0) ? 'checked' : '' ?> value="0"> Deactive
					</div>
				</div>
				
				<div class="form-group">
				<div class="col-md-offset-3 col-md-9">
					<?= $this->Form->button('Submit', ['class' => 'btn btn-success', 'id' => 'add_ser_prd_btn']) ?>&nbsp;
					<?= $this->Html->link('Cancel', 'javascript:window.history.back();', ['class' => 'btn btn-danger']) ?>

				</div>
				</div>
			<?= $this->Form->end() ?>
		</div>
	</div>
</div>
		<script type="text/javascript">
			jQuery(function(){ //short for $(document).ready(function(){
	

				$("#name").validate({
                     expression: "if (VAL) return true; else return false;",
                    message: "Please enter name"
                });$("#dept_id").validate({
                     expression: "if (VAL) return true; else return false;",
                    message: "Please select deptatment"
                });$("#email").validate({
                     expression: "if (VAL) return true; else return false;",
                    message: "Please enter email"
                });
			});
			</script>