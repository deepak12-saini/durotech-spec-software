<div class="page-content">
	<div class="page-header">
	<h1>
	Profile
	<small>
	<i class="ace-icon fa fa-angle-double-right"></i>
	Profile Setting
	</small>
	</h1>
	</div><!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
			<?= $this->Form->create($user ?? null, ['url' => ['action' => 'admin_profile'], 'class' => 'form-horizontal']) ?>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">User Name : </label>
					<div class="col-sm-9">
						<?= $this->Form->control('username', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'username', 'placeholder' => 'Username']) ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Name : </label>
					<div class="col-sm-9">
						<?= $this->Form->control('name', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'name', 'placeholder' => 'Name']) ?>
					</div>
				</div>
				
				<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Email : </label>
						<div class="col-sm-9">
							<?= $this->Form->control('email', ['type' => 'email', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'email', 'placeholder' => 'Email']) ?>
						</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Phone Number : </label>
					<div class="col-sm-9">
						<?= $this->Form->control('phone', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'phone', 'placeholder' => 'Phone Number']) ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Address : </label>
					<div class="col-sm-9">
						<?= $this->Form->control('address', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'address', 'placeholder' => 'Address']) ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> City : </label>
					<div class="col-sm-9">
						<?= $this->Form->control('city', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'city', 'placeholder' => 'City']) ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Postal Code : </label>
					<div class="col-sm-9">
						<?= $this->Form->control('postalcode', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'postalcode', 'placeholder' => 'Postal Code']) ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Country : </label>
					<div class="col-sm-9">
						<?= $this->Form->control('country', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'country', 'placeholder' => 'Country']) ?>
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
                });$("#username").validate({
                     expression: "if (VAL) return true; else return false;",
                    message: "Please enter username"
                });$("#email").validate({
                     expression: "if (VAL) return true; else return false;",
                    message: "Please enter email"
                });$("#phone").validate({
                     expression: "if (VAL) return true; else return false;",
                    message: "Please enter phone"
                }); 
			});
			</script>