<?php
/**
 * Custom Duro layout (duplicate of customduro_layout.php).
 * AppView sets $_ext = '.php' — the live layout is customduro_layout.php.
 */
?>
<!DOCTYPE html>
<html lang='en'>
<head>

	<?php
	header_remove("X-Powered-By");
	echo $this->Html->charset();
	?>

	<title><?php if (isset($meta_title)) { echo h($meta_title); } else { echo h(META_TITLE); } ?></title>
	<meta name="description" content="<?php if (isset($meta_description)) { echo h($meta_description); } else { echo h(META_DESCRIPTION); } ?>" />
	<meta name="keywords" content="<?php if (isset($meta_keyword)) { echo h($meta_keyword); } else { echo h(META_KEYWORD); } ?>">
	<meta name="google-site-verification" content="wmHiC6zArKxSWd5E5_z9yXPZRFjjsCmR94TlFP266MA" />

	<link href="<?= h(SITEURL) ?>favicon.png" type="image/x-icon" rel="icon" /><link href="<?= h(SITEURL) ?>favicon.png" type="image/x-icon" rel="shortcut icon" />

	<link rel="stylesheet" type="text/css" href="<?= h(SITEURL) ?>customdurotech/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="<?= h(SITEURL) ?>customdurotech/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?= h(SITEURL) ?>customdurotech/css/style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Raleway" />
	<link href='https://fonts.googleapis.com/css?family=Raleway:800' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Raleway:100' rel='stylesheet' type='text/css'>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width,initial-scale=1" />

	<script src="https://osvaldas.info/examples/main.js"></script>
	<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script src="<?= h(SITEURL) ?>theme/js/jquery.validate.js"></script>
	<style>
	.ValidationErrors{
		color: #d00;
		display: inline-block;
		font-size: 12px;
		font-style: italic;
		padding-left: 10px;
	}
	.footer_section {
		background: #585A5A;
	}
	.footer_section h4 {
		color: #fff;
	}
	.footer_section .fa {
		color: #fff;
	}
	.box > .icon > .image > i {
		font-size: 36px !important;
		color: #fff !important;
		margin-top: -11px;
	}

	a[title]::after {
		content: attr(title);
		position: absolute;
		bottom: 70px;
		background: rgba(0,0,0,0.75);
		color: #fff;
		padding: 4px 8px;
		border-radius: 4px;
		font-size: 12px;
		opacity: 0;
		transition: opacity 0.3s;
	}
	a[title]:hover::after {
		opacity: 1;
	}
	</style>

</head>
<body>
	<div class="durotech col-lg-12 col-md-12 col-sm-12">
		<?= $this->element('customduro_header') ?>
		<?= $this->fetch('content') ?>
		<?php
		$ctaController = (string)$this->request->getParam('controller');
		$ctaAction = (string)$this->request->getParam('action');
		$isContactPage = (strcasecmp($ctaController, 'Fronts') === 0 && $ctaAction === 'contact');
		if (!$isContactPage) {
			echo $this->element('customduro_applicator_cta');
		}
		?>
		<?= $this->element('customduro_footer') ?>
	</div>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-106559946-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());
	  gtag('config', 'UA-106559946-1');
	</script>

	<!-- Floating Call Button (Right Side) -->
	<a href="tel:1300434272"
	style="
		position: fixed;
		bottom: 20px;
		right: 5px;
		background: #2889c8;
		color: white;
		width: 55px;
		height: 55px;
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 24px;
		box-shadow: 0 4px 8px rgba(0,0,0,0.3);
		z-index: 9999;
	">
		<i class="fa fa-phone"></i>
	</a>
</body>
</html>
