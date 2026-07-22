	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<div class="login-container">
				<div class="center dt-brand">
					<h1>
						<a href="<?= h(SITEURL) ?>">
							<img src="<?= h(SITEURL) ?>customdurotech/images/durotech_logo_new.png?v=20260520" alt="Durotech — Commercial Waterproofing &amp; Sealants"/>
						</a>
					</h1>
					<h4 class="blue dt-panel-label" id="id-company-text">Admin Panel</h4>
				</div>

				<div class="space-6"></div>

				<div class="position-relative">
					<div id="login-box" class="login-box visible widget-box no-border">
						<div class="widget-body">
							<div class="widget-main">
								<h4 class="header blue lighter bigger">
									<i class="ace-icon fa fa-coffee green"></i>
									Please Enter Your Information
								</h4>
								<p class="dt-subtitle">Sign in to access the admin panel</p>

						<?= $this->Form->create(null, ['url' => rtrim(SITEURL, '/') . '/admin', 'name' => 'loginForm', 'id' => 'loginForm']) ?>
						<?= $this->Flash->render() ?>
							<fieldset>
								<label class="block clearfix">
									<span class="block input-icon input-icon-right">
										<?= $this->Form->control('User.username', ['div' => false, 'label' => false, 'class' => 'form-control', 'placeholder' => 'Username', 'id' => 'username', 'autocomplete' => 'username']) ?>
										<i class="ace-icon fa fa-user"></i>
									</span>
								</label>

								<label class="block clearfix">
									<span class="block input-icon input-icon-right">
										<?= $this->Form->control('User.password', ['div' => false, 'label' => false, 'class' => 'form-control', 'placeholder' => 'Password', 'type' => 'password', 'id' => 'password', 'autocomplete' => 'current-password']) ?>
										<i class="ace-icon fa fa-lock"></i>
									</span>
								</label>

								<div class="space"></div>

								<div class="clearfix">
									<?= $this->Form->button('Login', ['class' => 'width-35 pull-right btn btn-sm btn-primary']) ?>
								</div>

								<div class="space-4"></div>
							</fieldset>
						<?= $this->Form->end() ?>
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

						<?= $this->Form->create(null, ['url' => ['action' => 'admin_forgot_password'], 'name' => 'forgotPasswordForm', 'id' => 'forgotPasswordForm']) ?>
						<?= $this->Flash->render() ?>
							<fieldset>
								<label class="block clearfix">
									<span class="block input-icon input-icon-right">
										<?= $this->Form->control('User.email', ['div' => false, 'label' => false, 'class' => 'form-control', 'placeholder' => 'Email', 'id' => 'email']) ?>
										<i class="ace-icon fa fa-envelope"></i>
									</span>
								</label>

								<div class="clearfix">
									<?= $this->Form->button('Send Me', ['class' => 'width-35 pull-right btn btn-xs btn-danger']) ?>
								</div>
							</fieldset>
						<?= $this->Form->end() ?>
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

		<p class="dt-footer-note">Durotech Industries &middot; Secure access</p>
			</div>
		</div><!-- /.col -->
	</div><!-- /.row -->

	<script type="text/javascript">
	jQuery(function(){
		$("#username").validate({
			expression: "if (VAL) return true; else return false;",
			message: "Please enter username"
		});
		$("#password").validate({
			expression: "if (VAL) return true; else return false;",
			message: "Please enter password"
		});
		$("#email").validate({
			expression: "if (VAL) return true; else return false;",
			message: "Please enter email"
		});
		jQuery("#email").validate({
			expression: "if (VAL.match(\/^([a-zA-Z0-9_\\.\\-])+\\@(([a-zA-Z0-9\\-])+\\.)+([a-zA-Z0-9]{2,4})+$\/) && VAL) return true; else return false;",
			message: "Please enter valid email"
		});
	});
	</script>
