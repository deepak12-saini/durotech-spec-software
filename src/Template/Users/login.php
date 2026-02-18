	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<div class="login-container">
				<div class="center">
					<h1>
						<a href="<?= h($this->Url->build('/')) ?>"><img src="<?= h($this->Url->build('/customdurotech/images/durotech_logo.png')) ?>" alt="Logo"/></a>
					</h1>
					
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

								<?= $this->Form->create(null, ['url' => ['action' => 'login'], 'name' => 'loginForm', 'id' => 'loginForm']) ?>
								<?= $this->Flash->render() ?>
									<fieldset>
										<label class="block clearfix">
											<span class="block input-icon input-icon-right">
												<?= $this->Form->control('NappUser.email', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Email', 'id' => 'email']) ?>
												<i class="ace-icon fa fa-user"></i>
											</span>
										</label>

										<label class="block clearfix">
											<span class="block input-icon input-icon-right">
												<?= $this->Form->control('NappUser.password', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Password', 'type' => 'password', 'id' => 'password']) ?>
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

							<div class="toolbar clearfix">
								<div>
									<a href="#" data-target="#forgot-box" class="forgot-password-link">
										<i class="ace-icon fa fa-arrow-left"></i>
										I forgot my password
									</a>
								</div>

								<div>
									<a href="<?= $this->Url->build(['action' => 'register']) ?>" class="user-signup-link">
										I want to register
										<i class="ace-icon fa fa-arrow-right"></i>
									</a>
								</div>
							</div>
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

								<?= $this->Form->create(null, ['url' => ['action' => 'send_forgot_password'], 'method' => 'post']) ?>
								<?= $this->Flash->render() ?>
									<fieldset>
										<label class="block clearfix">
											<span class="block input-icon input-icon-right">
												<?= $this->Form->control('User.email', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Email', 'id' => 'uemail']) ?>
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

					<div id="signup-box" class="signup-box widget-box no-border">
						<div class="widget-body">
							<div class="widget-main">
								<h4 class="header green lighter bigger">
									<i class="ace-icon fa fa-users blue"></i>
									New Customer Registration
								</h4>

								<div class="space-6"></div>
								<p> Enter your details to begin: </p>

								<?= $this->Form->create(null, ['url' => ['action' => 'register'], 'method' => 'post']) ?>
									<fieldset>
										<label class="block clearfix">
											<span class="block input-icon input-icon-right">
												<select name="NappUser[is_staff_id]" id="is_staff_id" class="form-control">
													<option value="">Select Register Type</option>
													<option value="0">Employee</option>
													<option value="1">Staff</option>
												</select>
											</span>
										</label>
										<label class="block clearfix">
											<span class="block input-icon input-icon-right">
												<input type="text" class="form-control" name="data[NappUser][name]" id="Cname" placeholder="First Name" />
												<i class="ace-icon fa fa-user"></i>
											</span>
										</label>
										<label class="block clearfix">
											<span class="block input-icon input-icon-right">
												<input type="text" class="form-control" name="data[NappUser][lname]" id="Clname" placeholder="Last Name" />
												<i class="ace-icon fa fa-user"></i>
											</span>
										</label>
										<label class="block clearfix">
											<span class="block input-icon input-icon-right">
												<input type="email" class="form-control" name="data[NappUser][email]" id="Cemail" placeholder="Email" />
												<i class="ace-icon fa fa-envelope"></i>
											</span>
										</label>
										<label class="block clearfix">
											<span class="block input-icon input-icon-right">
												<input type="password" class="form-control" name="data[NappUser][password]" id="Cpassword" placeholder="Password" />
												<i class="ace-icon fa fa-lock"></i>
											</span>
										</label>


										<div class="space-24"></div>

										<div class="clearfix">
											<button type="reset" class="width-30 pull-left btn btn-sm">
												<i class="ace-icon fa fa-refresh"></i>
												<span class="bigger-110">Reset</span>
											</button>

											<button type="submit" class="width-65 pull-right btn btn-sm btn-success">
												<span class="bigger-110">Register</span>

												<i class="ace-icon fa fa-arrow-right icon-on-right"></i>
											</button>
										</div>
									</fieldset>
								<?= $this->Form->end() ?>
							</div>

							<div class="toolbar center">
								<a href="#" data-target="#login-box" class="back-to-login-link">
									<i class="ace-icon fa fa-arrow-left"></i>
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
	jQuery(function(){


	jQuery("#Cname").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please enter name"
	}); jQuery("#is_staff_id").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please select register type"
	});
	jQuery("#Clname").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please enter last name"
	}); 
	jQuery("#password").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please enter password"
	});	jQuery("#Cpassword").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please enter password"
	}); jQuery("#uemail").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please enter email"
	});jQuery("#uemail").validate({
		expression: "if (VAL.match(\/^([a-zA-Z0-9_\\.\\-])+\\@(([a-zA-Z0-9\\-])+\\.)+([a-zA-Z0-9]{2,4})+$\/) && VAL) return true; else return false;",
		message: "Please enter valid email"
	}); jQuery("#email").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please enter email"
	});jQuery("#email").validate({
		expression: "if (VAL.match(\/^([a-zA-Z0-9_\\.\\-])+\\@(([a-zA-Z0-9\\-])+\\.)+([a-zA-Z0-9]{2,4})+$\/) && VAL) return true; else return false;",
		message: "Please enter valid email"
	}); 			


	});

	</script>