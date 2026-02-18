<div class="page-content">
	<div class="page-header">
	<h1>
	Payment
	<small>
	<i class="ace-icon fa fa-angle-double-right"></i>
	Payment Setting
	</small>
	</h1>
	</div><!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
			<?= $this->Form->create(null, ['url' => ['action' => 'admin_payment_setting'], 'class' => 'form-horizontal']) ?>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Stripe Test Secret Key : </label>
					<div class="col-sm-9">
						<?= $this->Form->control('PaymentSetup.stripe_test_secret_key', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'stripe_test_secret_key', 'placeholder' => 'Stripe Test Secret Key', 'value' => $payment_setup['PaymentSetup']['stripe_test_secret_key'] ?? '']) ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Stripe Test Publish Key : </label>
					<div class="col-sm-9">
						<?= $this->Form->control('PaymentSetup.stripe_test_publish_key', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'stripe_test_publish_key', 'placeholder' => 'Stripe Test Publish Key', 'value' => $payment_setup['PaymentSetup']['stripe_test_publish_key'] ?? '']) ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Stripe Live Secret Key : </label>
					<div class="col-sm-9">
						<?= $this->Form->control('PaymentSetup.stripe_live_secret_key', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'stripe_live_secret_key', 'placeholder' => 'Stripe Live Secret Key', 'value' => $payment_setup['PaymentSetup']['stripe_live_secret_key'] ?? '']) ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Stripe Live Publish Key : </label>
					<div class="col-sm-9">
						<?= $this->Form->control('PaymentSetup.stripe_live_publish_key', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'stripe_live_publish_key', 'placeholder' => 'Stripe Live Publish Key', 'value' => $payment_setup['PaymentSetup']['stripe_live_publish_key'] ?? '']) ?>
					</div>
				</div>
				<div class="form-group">
					<label for="form-field-2" class="col-sm-3 control-label no-padding-right">Payment Mode : </label>
						<div class="col-sm-9">
						<?php $ptype = $payment_setup['PaymentSetup']['type'] ?? 0; $active = ($ptype == 1) ? 'checked' : ''; $inactive = ($ptype != 1) ? 'checked' : ''; ?>
						<div class="radio"><label>
						<input type="radio" value="1" <?= $active ?> class="ace" id="PaymentSetupactive1" name="PaymentSetup[type]"><span class="lbl">Live</span>
						</label></div>
						<div class="radio"><label>
							<input type="radio" value="0" class="ace" <?= $inactive ?> id="PaymentSetupactive0" name="PaymentSetup[type]"><span class="lbl">Test</span>
						</label></div>
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
		/*	jQuery(function(){ //short for $(document).ready(function(){
	

				$("#stripe_test_secret_key").validate({
                     expression: "if (VAL) return true; else return false;",
                    message: "Please enter stripe test secret key"
                });$("#stripe_test_publish_key").validate({
                     expression: "if (VAL) return true; else return false;",
                    message: "Please enter stripe test publish key"
                });$("#stripe_live_secret_key").validate({
                     expression: "if (VAL) return true; else return false;",
                    message: "Please enter stripe test secret key"
                });$("#stripe_live_secret_key").validate({
                     expression: "if (VAL) return true; else return false;",
                    message: "Please enter stripe test publish key"
                });
			}); */
			</script>