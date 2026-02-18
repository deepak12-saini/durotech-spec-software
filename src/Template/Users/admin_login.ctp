	<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="login-container">
							<div class="center">
								<h1>
									<a href="<?= h(SITEURL) ?>"><img src="<?= h(SITEURL) ?>customdurotech/images/durotech_logo.png" alt="Logo"/></a>
								</h1>
								<h4 class="blue" id="id-company-text">Admin Panel</h4>
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

											<div class="space-6"></div>

											<?= $this->Form->create(null, ['url' => ['action' => 'adminLogin'], 'name' => 'loginForm', 'id' => 'loginForm']) ?>
											<?= $this->Flash->render() ?>
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<?= $this->Form->control('User.username', ['div' => false, 'label' => false, 'class' => 'form-control', 'placeholder' => 'Username', 'id' => 'username']) ?>
															<i class="ace-icon fa fa-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<?= $this->Form->control('User.password', ['div' => false, 'label' => false, 'class' => 'form-control', 'placeholder' => 'Password', 'type' => 'password', 'id' => 'password']) ?>
															<i class="ace-icon fa fa-lock"></i>
														</span>
													</label>

													<div class="space"></div>

													<div class="clearfix">
<?= $this->Form->button('Login', ['class' => 'width-35 pull-right btn btn-sm btn-primary']) ?>
														<!--button type="button" class="width-35 pull-right btn btn-sm btn-primary">
															<i class="ace-icon fa fa-key"></i>
															<span class="bigger-110">Login</span>
														</button-->
													</div>

													<div class="space-4"></div>
												</fieldset>
											<?= $this->Form->end() ?>

											<!--div class="social-or-login center">
												<span class="bigger-110">Or Login Using</span>
											</div>

											<div class="space-6"></div>

											<div class="social-login center">
												<a class="btn btn-primary">
													<i class="ace-icon fa fa-facebook"></i>
												</a>

												<a class="btn btn-info">
													<i class="ace-icon fa fa-twitter"></i>
												</a>

												<a class="btn btn-danger">
													<i class="ace-icon fa fa-google-plus"></i>
												</a>
											</div-->
										</div><!-- /.widget-main -->

										<!--div class="toolbar clearfix">
											<div>
												<a href="#" data-target="#forgot-box" class="forgot-password-link">
													<i class="ace-icon fa fa-angle-left"></i>
													I forgot my password
												</a>
											</div>

											<div>
												<a href="#" data-target="#signup-box" class="user-signup-link">
													I want to register
													<i class="ace-icon fa fa-angle-right"></i>
												</a>
											</div>
										</div-->
									</div><!-- /.widget-body -->
								</div><!-- /.login-box -->

								<div id="forgot-box" class="forgot-box widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header red lighter bigger">
												<i class="ace-icon fa fa-key"></i>
												Retrieve Password
											</h4>

											<div class="space-6"></div>
											<p>
												Enter your email and to receive instructions
											</p>

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
														<!--button type="button" class="width-35 pull-right btn btn-sm btn-danger">
															<i class="ace-icon fa fa-lightbulb-o"></i>
															<span class="bigger-110">Send Me!</span>
														</button-->
													</div>
												</fieldset>
											<?= $this->Form->end() ?>
										</div><!-- /.widget-main -->

										<div class="toolbar center">
											<a href="#" data-target="#login-box" class="back-to-login-link">
												Back to login
												<i class="ace-icon fa fa-angle-right"></i>
											</a>
										</div>
									</div><!-- /.widget-body -->
								</div><!-- /.forgot-box -->

								<div id="signup-box" class="signup-box widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header green lighter bigger">
												<i class="ace-icon fa fa-users blue"></i>
												New User Registration
											</h4>

											<div class="space-6"></div>
											<p> Enter your details to begin: </p>

											<form>
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="email" class="form-control" placeholder="Email" />
															<i class="ace-icon fa fa-envelope"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" class="form-control" placeholder="Username" />
															<i class="ace-icon fa fa-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" class="form-control" placeholder="Password" />
															<i class="ace-icon fa fa-lock"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" class="form-control" placeholder="Repeat password" />
															<i class="ace-icon fa fa-retweet"></i>
														</span>
													</label>

													<label class="block">
														<input type="checkbox" class="ace" />
														<span class="lbl">
															I accept the
															<a href="#">User Agreement</a>
														</span>
													</label>

													<div class="space-24"></div>

													<div class="clearfix">
														<button type="reset" class="width-30 pull-left btn btn-sm">
															<i class="ace-icon fa fa-refresh"></i>
															<span class="bigger-110">Reset</span>
														</button>

														<button type="button" class="width-65 pull-right btn btn-sm btn-success">
															<span class="bigger-110">Register</span>

															<i class="ace-icon fa fa-angle-right icon-on-right"></i>
														</button>
													</div>
												</fieldset>
											</form>
										</div>

										<div class="toolbar center">
											<a href="#" data-target="#login-box" class="back-to-login-link">
												<i class="ace-icon fa fa-angle-left"></i>
												Back to login
											</a>
										</div>
									</div><!-- /.widget-body -->
								</div><!-- /.signup-box -->
							</div><!-- /.position-relative -->

						
						</div>
					</div><!-- /.col -->
				</div><!-- /.row -->
		<script type="text/javascript">
				jQuery(function(){ //short for $(document).ready(function(){
	

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
