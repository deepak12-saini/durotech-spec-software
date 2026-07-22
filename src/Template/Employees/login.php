	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<div class="login-container">
				<div class="center dt-brand">
					<h1>
						<a href="<?php echo SITEURL; ?>">
							<img src="<?php echo SITEURL; ?>customdurotech/images/durotech_logo_new.png?v=20260520" alt="Durotech — Commercial Waterproofing &amp; Sealants"/>
						</a>
					</h1>
					<h4 class="blue dt-panel-label">Employee Login</h4>
				</div>

				<div class="space-6"></div>

				<div class="position-relative">
					<div id="login-box" class="login-box visible widget-box no-border">
						<div class="widget-body">
							<div class="widget-main">
								<h4 class="header blue lighter bigger">
									<i class="ace-icon fa fa-coffee green"></i>
									Employee Login
								</h4>
								<p class="dt-subtitle">Sign in to continue to your workspace</p>

						<?php echo $this->Form->create(null, ['url' => ['action' => 'login'], 'name' => 'loginForm', 'id' => 'loginForm']); ?>
						<?php echo $this->Flash->render(); ?>
							<fieldset>
								<label class="block clearfix">
									<span class="block input-icon input-icon-right">
										<?php echo $this->Form->control('Employee.name', ['div' => false, 'label' => false, 'class' => 'form-control', 'placeholder' => 'Username', 'id' => 'username', 'autocomplete' => 'username']); ?>
										<i class="ace-icon fa fa-user"></i>
									</span>
								</label>

								<label class="block clearfix">
									<span class="block input-icon input-icon-right">
										<?php echo $this->Form->control('Employee.password', ['div' => false, 'label' => false, 'class' => 'form-control', 'placeholder' => 'Password', 'type' => 'password', 'id' => 'password', 'autocomplete' => 'current-password']); ?>
										<i class="ace-icon fa fa-lock"></i>
									</span>
								</label>

								<div class="space"></div>

								<div class="clearfix">
									<?php echo $this->Form->submit('Login', ['div' => false, 'class' => 'width-35 pull-right btn btn-sm btn-primary']); ?>
								</div>

								<div class="space-4"></div>
							</fieldset>
						<?php echo $this->Form->end(); ?>
					</div><!-- /.widget-main -->
				</div><!-- /.widget-body -->
			</div><!-- /.login-box -->

			<div id="forgot-box" class="forgot-box widget-box no-border">
				<div class="widget-body">
					<div class="widget-main">
						<h4 class="header red lighter bigger">
							<i class="ace-icon fa fa-key"></i>
							Retrieve Password
						</h4>
						<p class="dt-subtitle">Enter your email to receive instructions</p>

						<form action="<?php echo SITEURL.'employees/send_forgot_password'?>" method="post">
						<?php echo $this->Flash->render(); ?>
							<fieldset>
								<label class="block clearfix">
									<span class="block input-icon input-icon-right">
										<?php echo $this->Form->input('Employee.email',array('div'=>false,'label'=>false, 'class' => array('form-control'),'placeholder'=>'Email','id'=>'uemail'))?>
										<i class="ace-icon fa fa-envelope"></i>
									</span>
								</label>

								<div class="clearfix">
								<?php echo $this->Form->submit('Send Me',array('div'=>false,'class'=>'width-35 pull-right btn btn-xs btn-danger'));?>
								</div>
							</fieldset>
						</form>
					</div><!-- /.widget-main -->

					<div class="toolbar center">
						<a href="#" data-target="#login-box" class="back-to-login-link">
							Back to login
							<i class="ace-icon fa fa-arrow-right"></i>
						</a>
					</div>
				</div><!-- /.widget-body -->
			</div><!-- /.forgot-box -->
		</div><!-- /.position-relative -->

		<p class="dt-footer-note">Durotech Industries &middot; Employee access</p>
			</div>
		</div><!-- /.col -->
	</div><!-- /.row -->

	<script type="text/javascript">
	jQuery(function(){
		jQuery("#password").validate({
			expression: "if (VAL) return true; else return false;",
			message: "Please enter password"
		});
		jQuery("#uemail").validate({
			expression: "if (VAL) return true; else return false;",
			message: "Please enter email"
		});
		jQuery("#uemail").validate({
			expression: "if (VAL.match(\/^([a-zA-Z0-9_\\.\\-])+\\@(([a-zA-Z0-9\\-])+\\.)+([a-zA-Z0-9]{2,4})+$\/) && VAL) return true; else return false;",
			message: "Please enter valid email"
		});
		jQuery("#username").validate({
			expression: "if (VAL) return true; else return false;",
			message: "Please enter username"
		});
	});
	</script>
