<?php
require 'vendor/autoload.php';

require_once 'lib/html5lib/Parser.php';
require_once 'lib/php-font-lib/src/FontLib/Autoloader.php';
require_once 'lib/php-svg-lib/src/autoload.php';
require_once 'src/Autoloader.php';
//Dompdf\Autoloader::register();

isset($_REQUEST['pdfname'])? $pdfname = $_REQUEST['pdfname'] :  $pdfname = 'test';
isset($_REQUEST['name'])? $name = $_REQUEST['name'] :  $name = 'Kal ';
isset($_REQUEST['email'])? $email = $_REQUEST['email'] :  $email = 'web@xoroglobal.com';
isset($_REQUEST['address'])? $address = $_REQUEST['address'] :  $address = '84 Darling St Greystanes - Childcare';
isset($_REQUEST['company'])? $company = $_REQUEST['company'] :  $company = 'Universe Seal';
isset($_REQUEST['specification'])? $specification = $_REQUEST['specification'] :  $specification = 'Exposed Balcony Wate';
isset($_REQUEST['date'])? $date = $_REQUEST['date'] :  $date = '01/01/2019';

$html  = '<html>
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head> 
<body bgcolor="#fff">
<table class="head-wrap" style="width: 100%;"  border="0" cellspacing="0" cellpadding="0" style="background: #e7f5f9;">
	<tr>
		<td></td>
		<td class="header container" style="display:block!important;max-width:900px !important;margin:0 auto!important;clear:both!important;">
				<div class="content" style="padding:15px;	max-width:900px;	margin:0 auto;	display:block; " >
				<table  border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td><a href="https://durotechindustries.com.au"><img src="https://www.durotechindustries.com.au/dompdf/img/page 1 header-01.jpg" style="width: 100% !important;" /></a></td>
						<td align="right"></td>
						
					</tr>					
				</table>					
				<table cellpadding="0" cellspacing="0" style="margin:0;  padding:6px 0px 6px 120px; width: 100%; ;">
				<tr>
					<td align="left" style="padding:0px 9px;"  >
						<table style="text-align: left; color: #4f4b50;  font-family: arial;">
							<tr>
								<th style="width:120px;">Attn:</th>
								<th>'.$name.'</th>
							</tr>
							<tr>
								<th style="width:120px;">Company:</th>
								<th>'.$company.'</th>
							</tr>
							<tr>
								<th style="width:120px;">Address:</th>
								<th>'.$address.'</th>
							</tr>
							<tr>
								<th style="width:120px;">Specfication:</th>
								<th>'.$specification.'</th>
							</tr>
							<tr>
								<th style="width:120px;">Email:</th>
								<th>'.$email.'</th>
							</tr>
							<tr>
								<th style="width:120px;">Date:</th>
								<th>'.$date.'</th>
							</tr>
						</table>						
					</td>
				</tr>				
				</table>				
				<table border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td><a href=""><img src="https://www.durotechindustries.com.au/dompdf/img/page1_03.jpg" style="width: 100% !important;" /></a></td>
						<td align="right"></td>
					</tr>		
				</table>
				<table border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td><a href=""><img src="https://www.durotechindustries.com.au/dompdf/img/page2-02.jpg" style="width: 100% !important;" /></a></td>
						<td align="right"></td>
					</tr>		
				</table>
				<table border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td><a href=""><img src="https://www.durotechindustries.com.au/dompdf/img/page2-03.jpg" style="width: 100% !important;" /></a></td>
						<td align="right"></td>
					</tr>		
				</table>
				<table border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td><a href=""><img src="https://www.durotechindustries.com.au/dompdf/img/page3-03.jpg" style="width: 100% !important;" /></a></td>
						<td align="right"></td>
					</tr>		
				</table>
				<table border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td><a href=""><img src="https://www.durotechindustries.com.au/dompdf/img/page3-04-03.jpg" style="width: 100% !important;" /></a></td>
						<td align="right"></td>
					</tr>		
				</table>
				</div>				
		</td>
		<td></td>
	</tr>
</table>';
echo $html;
die();
// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf(array('enable_remote' => true));
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
//$dompdf->stream();

$output = $dompdf->output();
file_put_contents($pdfname.'.pdf', $output);
return 'success';
?>