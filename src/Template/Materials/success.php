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
								<i class="ace-icon fa fa-thumbs-up"></i>
								Your material order request has been sent successfully.
							</h4>

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