<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

?>
<!DOCTYPE html>
<html lang='en'>
<head>

	<?php 
	header_remove("X-Powered-By");
	echo $this->Html->charset(); ?>
	
	<title><?php  if(isset($meta_title)){ echo $meta_title; } else{ echo  META_TITLE; }?></title>
	<meta name="description" content="<?php  if(isset($meta_description)){ echo $meta_description; } else{ echo  META_DESCRIPTION; }?>" />
	<meta name="keywords" content="<?php  if(isset($meta_keyword)){ echo $meta_keyword; } else{ echo  META_KEYWORD; }?>">	
	<meta name="google-site-verification" content="wmHiC6zArKxSWd5E5_z9yXPZRFjjsCmR94TlFP266MA" />
	<?php
	
		//echo $this->Html->meta('icon');
	?>
	<link href="<?php echo SITEURL ;?>favicon.png" type="image/x-icon" rel="icon" /><link href="<?php echo SITEURL ;?>favicon.png" type="image/x-icon" rel="shortcut icon" />	
	
	<link rel="stylesheet" type="text/css" href="<?php echo SITEURL ;?>customdurotech/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="<?php echo SITEURL ;?>customdurotech/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo SITEURL ;?>customdurotech/css/style.css">
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
	<script src="<?php echo SITEURL ;?>theme/js/jquery.validate.js"></script>
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

	h3.h2cl {
    text-transform: uppercase;
}
	</style>
	

</head>
<body>

	<div class="durotech col-lg-12 col-md-12 col-sm-12">    
		<?php echo $this->element('customduro_header'); ?>
		<?php echo $this->fetch('content'); ?>
		<?php
		$ctaController = (string)$this->request->getParam('controller');
		$ctaAction = (string)$this->request->getParam('action');
		$isContactPage = (strcasecmp($ctaController, 'Fronts') === 0 && $ctaAction === 'contact');
		if (!$isContactPage) {
			echo $this->element('customduro_applicator_cta');
		}
		?>
		<?php echo $this->element('customduro_footer'); ?>	
		<?php //echo $this->element('sql_dump'); ?>
	</div>
	<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-106559946-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-106559946-1');
  
  
</script>

<!-- Floating CTA Buttons -->
<div style="position:fixed; left:20px; bottom:20px; z-index:9999; display:flex; flex-direction:column; gap:10px;">

	<!-- <a href="https://web.whatsapp.com/send?phone=1300434272" target="_blank"
	style="
		position: fixed;
		bottom: 20px;
		left: 20px;
		background: #25D366;
		color: white;
		width: 55px;
		height: 55px;
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 26px;
		box-shadow: 0 4px 8px rgba(0,0,0,0.3);
		z-index: 9999;
	">
	<i class="fa fa-whatsapp"></i>
	</a> -->


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
</div>
</body>
</html>
