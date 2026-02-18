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
			<?= $this->Form->create($user ?? null, ['url' => ['action' => 'profile'], 'class' => 'form-horizontal']) ?>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">First Name: </label>
					<div class="col-sm-9">
						<?= $this->Form->control('name', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'username', 'placeholder' => 'Username']) ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Last Name: </label>
					<div class="col-sm-9">
						<?= $this->Form->control('lname', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'lname', 'placeholder' => 'Last Name']) ?>
					</div>
				</div>
				
				<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Email: </label>
						<div class="col-sm-9">
							<?= $this->Form->control('email', ['type' => 'email', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'email', 'placeholder' => 'Email']) ?>
						</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Mobile Number : </label>
					<div class="col-sm-9">
						<?= $this->Form->control('mobile_number', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'mobile_number', 'placeholder' => 'Mobile Number']) ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Fax: </label>
					<div class="col-sm-9">
						<?= $this->Form->control('fax', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'fax', 'placeholder' => 'Fax']) ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Company: </label>
					<div class="col-sm-9">
						<?= $this->Form->control('company', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'company', 'placeholder' => 'Company']) ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Position: </label>
					<div class="col-sm-9">
						<?= $this->Form->control('position', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'position', 'placeholder' => 'Position']) ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> zipcode: </label>
					<div class="col-sm-9">
						<?= $this->Form->control('zipcode', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'zipcode', 'placeholder' => 'zipcode']) ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Website: </label>
					<div class="col-sm-9">
						<?= $this->Form->control('website', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'website', 'placeholder' => 'website']) ?>
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