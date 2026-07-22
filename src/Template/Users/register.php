	<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="login-container">
							<div class="center">
								<h1>
									<a href="<?php echo SITEURL; ?>"><img src="<?php echo SITEURL; ?>customdurotech/images/durotech_logo_new.png?v=20260520" alt="Durotech — Commercial Waterproofing &amp; Sealants"/></a>
								</h1>
								
							</div>

							<div class="space-6"></div>

							<div class="position-relative">
								

								<div id="signup-box" class="signup-box visible widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header green lighter bigger">
												<i class="ace-icon fa fa-users blue"></i>
												New Customer Registration
											</h4>

											<div class="space-6"></div>
											<p> Enter your details to begin: </p>

											<?= $this->Form->create(null, ['url' => ['controller' => 'Users', 'action' => 'register'], 'type' => 'post', 'id' => 'user-register-form']) ?>
											<?= $this->Flash->render() ?>
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<select name="data[NappUser][is_staff_id]" id="is_staff_id" class="form-control" required>
																<option value="">Select Register Type</option>
																<option value="0" >Customer</option>
																<option value="1" >Staff</option>
															</select>
															<!-- <i class="ace-icon fa fa-user"></i> -->
														</span>
													</label>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" class="form-control" name="data[NappUser][name]" id="Cname" placeholder="First Name" required />
															<i class="ace-icon fa fa-user"></i>
														</span>
													</label>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" class="form-control" name="data[NappUser][lname]" id="Clname" placeholder="Last Name" required />
															<i class="ace-icon fa fa-user"></i>
														</span>
													</label>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="email" class="form-control" name="data[NappUser][email]" id="Cemail" placeholder="Email" required />
															<i class="ace-icon fa fa-envelope"></i>
														</span>
													</label>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" class="form-control" name="data[NappUser][password]" id="Cpassword" placeholder="Password" required />
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
											<a href="<?php echo SITEURL.'login'; ?>"  class="back-to-login-link">
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
jQuery(function($) {
	// Form uses HTML5 required + server-side validation; custom .validate() was blocking submit
	$('#user-register-form').on('submit', function() {
		var $form = $(this);
		if (!$form[0].checkValidity || $form[0].checkValidity()) return true;
		// Ensure first invalid field gets focus and browser shows its message
		var firstInvalid = $form.find(':invalid').first();
		if (firstInvalid.length) firstInvalid.focus();
		return false;
	});
});
</script>