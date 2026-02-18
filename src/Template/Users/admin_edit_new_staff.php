<div class="page-content">
	<div class="page-header">
	<h1>
	Durotech Employee 
	<small>
	<i class="ace-icon fa fa-angle-double-right"></i>
		Add Employee
	</small>
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
				$sid = isset($staffArr['Staff']['id']) ? $staffArr['Staff']['id'] : null;
			?>
			<?= $this->Form->create(null, ['url' => ['action' => 'admin_edit_new_staff', $sid], 'class' => 'form-horizontal']) ?>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Select Department: </label>
					<div class="col-sm-9">
						<?= $this->Form->control('Staff.dept_id', ['options' => $deptOptions, 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'dept_id', 'empty' => 'Select Department', 'value' => $staffArr['Staff']['dept_id'] ?? '']) ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Name: </label>
					<div class="col-sm-9">
						<?= $this->Form->control('Staff.name', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'name', 'placeholder' => 'Enter Name', 'value' => $staffArr['Staff']['name'] ?? '']) ?>
					</div>
				</div>
			
				<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Email: </label>
						<div class="col-sm-9">
							<?= $this->Form->control('Staff.email', ['type' => 'email', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'email', 'placeholder' => 'Email', 'value' => $staffArr['Staff']['email'] ?? '']) ?>
						</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Phone Number: </label>
					<div class="col-sm-9">
						<?= $this->Form->control('Staff.phone', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'phone', 'placeholder' => 'Phone Number', 'value' => $staffArr['Staff']['phone'] ?? '']) ?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Designation: </label>
					<div class="col-sm-9">
						<?= $this->Form->control('Staff.designation', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'designation', 'placeholder' => 'Designation', 'value' => $staffArr['Staff']['designation'] ?? '']) ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Status: </label>
					<div class="col-sm-9">
						<input type="radio" name="Staff[status]" <?= (isset($staffArr['Staff']['status']) && (int)$staffArr['Staff']['status'] === 1) ? 'checked' : '' ?> value="1"> Active
						<input type="radio" name="Staff[status]" <?= (isset($staffArr['Staff']['status']) && (int)$staffArr['Staff']['status'] === 0) ? 'checked' : '' ?> value="0"> Deactive
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