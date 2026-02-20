	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<div class="login-container">
				<div class="center">
					<h1>
						<a href="<?php echo SITEURL; ?>"><img src="<?php echo SITEURL; ?>customdurotech/images/durotech_logo.png"/></a>
					</h1>
					
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

								<div class="space-6"></div>

								<?php echo $this->Form->create(null, ['url' => ['action' => 'login'], 'name' => 'loginForm', 'id' => 'loginForm']); ?>
								<?php echo $this->Flash->render(); ?>
									<fieldset>
										<label class="block clearfix">
											<span class="block input-icon input-icon-right">
												<?php echo $this->Form->control('Employee.name', ['div' => false, 'label' => false, 'class' => 'form-control', 'placeholder' => 'username', 'id' => 'username']); ?>
												<i class="ace-icon fa fa-user"></i>
											</span>
										</label>

										<label class="block clearfix">
											<span class="block input-icon input-icon-right">
												<?php echo $this->Form->control('Employee.password', ['div' => false, 'label' => false, 'class' => 'form-control', 'placeholder' => 'Password', 'type' => 'password', 'id' => 'password']); ?>
												<i class="ace-icon fa fa-lock"></i>
											</span>
										</label>

										<div class="space"></div>

										<div class="clearfix">
											<?php echo $this->Form->submit('Login', ['div' => false, 'class' => 'width-35 pull-right btn btn-sm btn-primary']); ?>
											<!--button type="button" class="width-35 pull-right btn btn-sm btn-primary">
												<i class="ace-icon fa fa-key"></i>
												<span class="bigger-110">Login</span>
											</button-->
										</div>

										<div class="space-4"></div>
									</fieldset>
								<?php echo $this->Form->end();?>

								
							</div><!-- /.widget-main -->

							<!-- <div class="toolbar clearfix">
								<div>
									<a href="#" data-target="#forgot-box" class="forgot-password-link">
										<i class="ace-icon fa fa-arrow-left"></i>
										I forgot my password
									</a>
								</div>

								<div>
									<a href="<?php echo SITEURL.'employees/register'?>" class="user-signup-link">
										I want to register
										<i class="ace-icon fa fa-arrow-right"></i>
									</a>
								</div>
							</div> -->
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
											<!--button type="button" class="width-35 pull-right btn btn-sm btn-danger">
												<i class="ace-icon fa fa-lightbulb-o"></i>
												<span class="bigger-110">Send Me!</span>
											</button-->
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