<div class="page-content">
	<div class="page-header">
	<h1>
	Settings
	<small>
	<i class="ace-icon fa fa-angle-double-right"></i>
	Website Setting
	</small>
	</h1>
	</div><!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
			<?= $this->Form->create(null, ['url' => ['action' => 'admin_web_setting'], 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) ?>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Email : </label>
					<div class="col-sm-9">
						<?= $this->Form->control('Config.mailto', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'mailto', 'placeholder' => 'Email', 'value' => $Config['Config']['mailto'] ?? '']) ?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Phone Number : </label>
					<div class="col-sm-9">
						<?= $this->Form->control('Config.phone', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'phone', 'placeholder' => 'Phone Number', 'value' => $Config['Config']['phone'] ?? '']) ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Address : </label>
					<div class="col-sm-9">
						<?= $this->Form->control('Config.address', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'address', 'placeholder' => 'Address', 'value' => $Config['Config']['address'] ?? '']) ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Facebook : </label>
					<div class="col-sm-9">
						<?= $this->Form->control('Config.facebook', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'facebook', 'placeholder' => 'Facebook', 'value' => $Config['Config']['facebook'] ?? '']) ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Google Plus : </label>
					<div class="col-sm-9">
						<?= $this->Form->control('Config.google_plus', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'google_plus', 'placeholder' => 'Google Plus', 'value' => $Config['Config']['google_plus'] ?? '']) ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Twitter : </label>
					<div class="col-sm-9">
						<?= $this->Form->control('Config.twiter', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'twiter', 'placeholder' => 'Twitter', 'value' => $Config['Config']['twiter'] ?? '']) ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> LinkedIN : </label>
					<div class="col-sm-9">
						<?= $this->Form->control('Config.linkdin', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'linkdin', 'placeholder' => 'LinkedIN', 'value' => $Config['Config']['linkdin'] ?? '']) ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Logo Image : </label>
					<div class="col-sm-9">
						<?= $this->Form->control('image', ['type' => 'file', 'label' => false, 'id' => 'image']) ?><br/>
						<p><img src="<?= h((defined('SITEURL') ? SITEURL : '') . 'img/' . (defined('LOGO') ? LOGO : 'logo.png')) ?>" alt="Logo" /></p>
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
	
				$("#image").validate({
                     expression: "if (VAL) return true; else return false;",
                    message: "Please select image"
                });$("#mailto").validate({
                     expression: "if (VAL) return true; else return false;",
                    message: "Please enter email"
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