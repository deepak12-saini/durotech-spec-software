<?php
/**
 * Admin / Employee login layout
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo h($title_for_layout); ?>
	</title>
	<?php echo $this->Html->meta('icon'); ?>
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<link rel="stylesheet" href="<?php echo SITEURL; ?>theme/css/bootstrap.css" />
	<link rel="stylesheet" href="<?php echo SITEURL; ?>theme/css/font-awesome.css" />
	<link rel="stylesheet" href="<?php echo SITEURL; ?>theme/css/ace-fonts.css" />
	<link rel="stylesheet" href="<?php echo SITEURL; ?>theme/css/ace.css" class="ace-main-stylesheet" id="main-ace-style" />
	<!--[if lte IE 9]>
		<link rel="stylesheet" href="<?php echo SITEURL; ?>theme/css/ace-part2.css" class="ace-main-stylesheet" />
		<link rel="stylesheet" href="<?php echo SITEURL; ?>theme/css/ace-ie.css" />
	<![endif]-->

	<script src="<?php echo SITEURL; ?>theme/js/ace-extra.js"></script>
	<script src="<?php echo SITEURL; ?>theme/js/jquery.js"></script>
	<script src="<?php echo SITEURL; ?>theme/js/jquery.validate.js"></script>
	<script src="<?php echo SITEURL; ?>theme/js/jquery-ui.js"></script>
	<!--[if lte IE 8]>
		<script src="<?php echo SITEURL; ?>theme/js/html5shiv.js"></script>
		<script src="<?php echo SITEURL; ?>theme/js/respond.js"></script>
	<![endif]-->

	<style>
	.ValidationErrors {
		color: #d00;
		display: inline-block;
		font-size: 12px;
		font-style: italic;
		padding-left: 10px;
	}

	@keyframes dt-card-in {
		from { opacity: 0; transform: translateY(12px); }
		to { opacity: 1; transform: translateY(0); }
	}

	@keyframes dt-logo-in {
		from { opacity: 0; transform: translateY(-8px); }
		to { opacity: 1; transform: translateY(0); }
	}

	.dt-brand {
		text-align: center;
		margin-bottom: 8px;
		animation: dt-logo-in 0.55s ease-out both;
	}

	.dt-brand a {
		display: inline-block;
		transition: transform 0.3s ease;
	}

	.dt-brand a:hover {
		transform: scale(1.03);
	}

	.dt-brand img {
		max-width: 280px;
		width: 100%;
		height: auto;
		display: block;
		margin: 0 auto;
	}

	.dt-panel-label {
		margin: 12px 0 0;
		font-size: 15px;
		font-weight: 600;
		color: #478fca;
	}

	.dt-subtitle {
		color: #777;
		font-size: 13px;
		margin: 0 0 14px;
	}

	.dt-footer-note {
		text-align: center;
		margin-top: 16px;
		font-size: 12px;
		color: #999;
	}

	.login-layout .position-relative {
		animation: dt-card-in 0.5s 0.08s ease-out both;
	}

	.login-layout .login-box .widget-body,
	.login-layout .forgot-box .widget-body {
		transition: box-shadow 0.25s ease;
	}

	.login-layout .login-box .widget-body:hover,
	.login-layout .forgot-box .widget-body:hover {
		box-shadow: 0 6px 24px rgba(0, 0, 0, 0.12);
	}

	.login-layout .form-control {
		transition: border-color 0.2s ease, box-shadow 0.2s ease;
	}

	.login-layout .form-control:focus {
		border-color: #478fca;
		box-shadow: 0 0 0 3px rgba(71, 143, 202, 0.2);
	}

	.login-layout .input-icon:focus-within > .ace-icon {
		color: #478fca;
	}

	.login-layout .btn-primary,
	.login-layout input.btn-primary,
	.login-layout button.btn-primary {
		transition: transform 0.15s ease, box-shadow 0.2s ease, background-color 0.2s ease;
	}

	.login-layout .btn-primary:hover,
	.login-layout input.btn-primary:hover,
	.login-layout button.btn-primary:hover {
		transform: translateY(-1px);
		box-shadow: 0 4px 12px rgba(66, 139, 202, 0.35);
	}

	@media (prefers-reduced-motion: reduce) {
		.dt-brand,
		.login-layout .position-relative {
			animation: none !important;
		}
	}
	</style>
</head>
<body class="login-layout light-login">
	<div class="main-container" id="main-container">
		<div class="main-content">
			<?php echo $this->fetch('content'); ?>
		</div>
	</div>

	<!--[if IE]>
	<script type="text/javascript">
	 window.jQuery || document.write("<script src='<?php echo SITEURL; ?>theme/js/jquery1x.js'>"+"<"+"/script>");
	</script>
	<![endif]-->
	<script type="text/javascript">
		if ('ontouchstart' in document.documentElement) document.write("<script src='<?php echo SITEURL; ?>theme/js/jquery.mobile.custom.js'>"+"<"+"/script>");
	</script>
	<script src="<?php echo SITEURL; ?>theme/js/bootstrap.js"></script>
	<script type="text/javascript">
		jQuery(function($) {
			$(document).on('click', '.toolbar a[data-target]', function(e) {
				e.preventDefault();
				var target = $(this).data('target');
				$('.widget-box.visible').removeClass('visible');
				$(target).addClass('visible');
			});
		});
	</script>
</body>
</html>
