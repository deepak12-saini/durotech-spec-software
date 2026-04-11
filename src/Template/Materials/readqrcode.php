	<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="login-container">
							<div class="center">
								<h1>
									<a href="<?php echo $this->Url->build('/'); ?>"><img src="<?php echo $this->Url->build('/'); ?>customdurotech/images/durotech_logo.png" alt=""/></a>
								</h1>
								<!-- <h4 class="blue" id="id-company-text">Place Order </h4> -->
							</div>

							<div class="space-6"></div>

							<div class="position-relative">
								<div id="login-box" class="login-box visible widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header blue lighter bigger">
												<i class="ace-icon fa fa-coffee green"></i>
												Send Material Order Request 
											</h4>

											<div class="space-6"></div>

											<?php
											$mat = $MaterialArr['Material'] ?? $MaterialArr;
											$mid = $mat['id'] ?? (is_object($mat) ? $mat->id : '');
											$mtype = $mat['material_type'] ?? (is_object($mat) ? $mat->material_type : '');
											$mweight = $mat['weight'] ?? (is_object($mat) ? $mat->weight : '');
											$mqty = $mat['quantity'] ?? (is_object($mat) ? $mat->quantity : '');
											$mdesc = $mat['description'] ?? (is_object($mat) ? $mat->description : '');
											?>
											<?php
											$qrcodeParam = $this->request->getParam('pass.0');
											$formOpts = [];
											if ($qrcodeParam !== null) {
												$formOpts['url'] = ['action' => 'readqrcode', $qrcodeParam];
											}
											echo $this->Form->create(null, $formOpts);
											echo $this->Form->hidden('id', ['value' => $mid]);
											echo $this->Form->hidden('material_type', ['value' => $mtype]);
											echo $this->Form->hidden('weight', ['value' => $mweight]);
											echo $this->Flash->render();
											?>
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input class="form-control ErrorField" type="text" value="<?php echo h($mtype); ?>" readonly style="background: #ddd !important;">
														</span>
													</label>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input class="form-control ErrorField" type="text" value="<?php echo h($mweight); ?>" readonly style="background: #ddd !important;">
														</span>
													</label>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input name="quantity" class="form-control ErrorField" type="text" value="<?php echo h($mqty); ?>">
														</span>
													</label>
													<p><small>E.g : <?php echo h($mdesc); ?></small></p>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input name="name" class="form-control ErrorField" type="text" value="" placeholder="enter your name">
														</span>
													</label>
													<?php echo $this->Form->submit('Send Request', ['div' => false, 'class' => 'width-35 pull-right btn btn-sm btn-primary']); ?>
													<div class="space-4"></div>
												</fieldset>
											<?php echo $this->Form->end(); ?>										
										</div>
									</div><!-- /.widget-body -->
								</div><!-- /.login-box -->
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