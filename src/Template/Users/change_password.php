<div class="page-content">
	<div class="page-header">
	<h1>
	Profile Setting
	<small>
	<i class="ace-icon fa fa-angle-double-right"></i>
	Change Password
	</small>
	</h1>
	</div><!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
			<?= $this->Form->create(null, ['url' => ['action' => 'change_password'], 'class' => 'form-horizontal']) ?>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Current Password </label>
					<div class="col-sm-9">
						<?= $this->Form->control('NappUser.current_password', ['type' => 'password', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'current_password', 'placeholder' => 'Current Password']) ?>
					</div>
				</div>
				<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> New Password </label>
						<div class="col-sm-9">
							<?= $this->Form->control('NappUser.new_password', ['type' => 'password', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'new_password', 'placeholder' => 'New Password']) ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Confirm Password </label>
						<div class="col-sm-9">
							<?= $this->Form->control('NappUser.confirm_password', ['type' => 'password', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'confirm_password', 'placeholder' => 'Confirm Password']) ?>
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
	

				$("#current_password").validate({
                     expression: "if (VAL) return true; else return false;",
                    message: "Please enter current password"
                });$("#new_password").validate({
                     expression: "if (VAL) return true; else return false;",
                    message: "Please enter new password"
                });$("#confirm_password").validate({
                     expression: "if (VAL) return true; else return false;",
                    message: "Please enter confirm password"
                }); 
			});
			</script>