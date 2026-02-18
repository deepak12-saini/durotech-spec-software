<?php
require 'vendor/autoload.php';

require_once 'lib/html5lib/Parser.php';
require_once 'lib/php-font-lib/src/FontLib/Autoloader.php';
require_once 'lib/php-svg-lib/src/autoload.php';
require_once 'src/Autoloader.php';

// Database connection details from app_local.php
$db['hostname'] = 'localhost';
$db['username'] = 'customer_durotech';
$db['password'] = '_XTH3oe3wm~ajnp6'; 
$db['database'] = 'xoroglobal_customer_durotech';
$con = mysqli_connect($db['hostname'], $db['username'], $db['password'], $db['database']);


isset($_REQUEST['coa_id'])? $coa_id = $_REQUEST['coa_id'] :  $coa_id = '';
isset($_REQUEST['pdfname'])? $pdfname = $_REQUEST['pdfname'] :  $pdfname = '';
isset($_REQUEST['name'])? $name = $_REQUEST['name'] :  $name = '';
isset($_REQUEST['email'])? $email = $_REQUEST['email'] :  $email = '';
isset($_REQUEST['product'])? $product = $_REQUEST['product'] :  $product = '';
isset($_REQUEST['batch_no'])? $batch_no = $_REQUEST['batch_no'] :  $batch_no = '';
isset($_REQUEST['form_no'])? $form_no = $_REQUEST['form_no'] :  $form_no = '';
isset($_REQUEST['date_of_manu'])? $date_of_manu = $_REQUEST['date_of_manu'] :  $date_of_manu = '';
isset($_REQUEST['date'])? $expiry_date = $_REQUEST['date'] :  $expiry_date = '';
isset($_REQUEST['signature_date'])? $signature_date = $_REQUEST['signature_date'] :  $signature_date = 0;

if($coa_id > 0){
		$trow = '<table cellpadding="0" cellspacing="0" style=" padding:6px 0px 6px 0px; width: 100%; margin-top:0px; ;"><tr><td></td>';
		$sql = mysqli_query($con,"select * from coa_results where coa_id=".$coa_id."");
		$num = mysqli_num_rows($sql);
		$trow .= '<tr style="padding: 4px;">
					<td style="padding: 4px 10px 0px;font-size: 14px;font-weight: bold;font-family: arial;">Test</td>
					<td style="padding: 4px 10px 0px;font-size: 14px;font-weight: bold;font-family: arial;">Result</td>
					<td style="padding: 4px 10px 0px;font-size: 14px;font-weight: bold;font-family: arial;">Specfication</td>
					</tr>';
		if($num > 0){
			$i=0;
			while($row = mysqli_fetch_assoc($sql)){
				if($i % 2 == 0){ $tclass="#ffffff"; }else{ $tclass="#ffffff";  }
				$trow .= '<tr style="background: '.$tclass.';padding: 4px;">
			<td style="padding: 4px 10px 0px;font-size: 12px;font-family: arial;">'.$row['test'].'</td>
			<td style="padding: 4px 10px 0px;font-size: 12px;font-family: arial;">'.$row['result'].'</td>
			<td style="padding: 4px 10px 0px;font-size: 12px;font-family: arial;">'.$row['specfication'].'</td>
		</tr>';
				$i++;
			}	
		}
		$trow .= '</tr></table>';	
}	


$html  = '<html>
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head> 
<body bgcolor="#fff">
<table class="head-wrap" style="width: 100%;"  border="0" cellspacing="0" cellpadding="0" style="background: #e7f5f9;color:##353339;opacity:0.8;">
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
					
				
				<table cellpadding="0" cellspacing="0" style="margin:0;  padding:6px 0px 6px 0px; width: 100%; ;"><tr><td><h3 style="border-bottom: 2px solid #000 !important;width: 100%;  font-family: arial;">TECHNICAL SERVICE</h3></td></tr>		
				</table>
				<table cellpadding="0" cellspacing="0" style="margin:0;  padding:6px 0px 6px 0px; width: 100%; ;"><tr><td><h3 style="text-decoration: underline !important; text-align:center; font-family: arial;">CERTIFICATE OF ANALYSIS</h3></td></tr>		
				</table>				
				<table cellpadding="0" cellspacing="0" style="margin:0;  padding:6px 0px 6px 0px; width: 900px;">
				<tr>
					<td align="left" style="padding:0px 9px;"  >
						<table cellpadding="0" cellspacing="0" style="margin:0;width: 95%; margin-top:0px; ">
						
							<tr>
								<th style="padding: 4px 9px;font-size: 12px;text-align: left;font-family: arial;">Product:</th>
								<th style="padding: 4px 9px;font-size: 12px;text-align: center;font-family: arial;">'.$product.'</th>
							</tr>
							<tr>
								<th style="padding: 4px 9px;font-size: 12px;text-align: left;font-family: arial;">Batch No.:</th>
								<th style="padding: 4px 9px;font-size: 12px;text-align: center;font-family: arial;">'.$batch_no.'</th>
							</tr>
							<tr>
								<th style="padding: 4px 9px;font-size: 12px;text-align: left;font-family: arial;">Date of Manu: </th>
								<th style="padding: 4px 9px;font-size: 12px;text-align: center;font-family: arial;">'.$date_of_manu.'</th>
							</tr>
							<tr>
							
								<th style="padding: 4px 9px;font-size: 12px;text-align: left;font-family: arial;">Expiry Date:</th>
								<th style="padding: 4px 9px;font-size: 12px;text-align: center;font-family: arial;">'.$expiry_date.'</th>
							</tr>							
						</table>						
					</td>
				</tr>				
				</table>
				<table cellpadding="0" cellspacing="0" style="margin:0;width: 95%; margin-top:18px;  width: 900px">
				<tr>
					<td align="left" style="padding:0px 9px;"  >';
				
				$html  .= $trow;
					
				$html  .= '</td></tr></table>
				<table cellpadding="0" cellspacing="0" style="margin:0;width: 95%; margin-top:18px; ">
					<tr>
						<td align="left" style="padding:0px 9px;"  >
						<table cellpadding="0" cellspacing="0" style="margin:0;  padding:6px 0px 6px 0px; width: 100%; ;"><tr><td><p style="padding: 0px 9px; font-size: 12px; font-family: arial; color:#353336;"><br/>PRINTED ELECTRONICALLY, NO SIGNATURE REQUIRED</p></td></tr>
						</tr>				
				</table>';	

				$html  .= '<tr><td style="width: 100%;  font-family: arial; font-size: 12px; color:#353336;text-align: right; margin-left:-0px; ">FORM NO: '.$form_no.'</p><p style="width: 100%;  font-family: arial; font-size: 12px; color:#353336;text-align: right; margin-left:-0px; ">'.strtoupper($signature_date).'</td></tr>		
			
				
				<table cellpadding="0" cellspacing="0" style="clear:both; margin:0;  padding:6px 0px 6px 0px; width: 100%; ;"><tr><td><p style="width: 100%;  font-family: arial; font-size: 8px; color:#353336;text-align: left; margin-left:-0px; ">Disclaimer:</p><p style="width: 100%;  font-family: arial; font-size: 8px; color:#353336;text-align: justify; margin-left:-0px; ">“This document, including any attached files, is strictly confidential and intended solely for the use of the individual or entity to which it is addressed. Durotech Industries prohibits the right to publish, copy, distribute or disclose any information contained in this document, or its attachments, by any party other than the intended recipient. If you have received this document in error, please notify the sender and delete it from your system immediately. No employee or agent is authorised to conclude any binding agreement or make any representation on behalf of Durotech Industries. The views or opinions presented in this document are solely those of the author and do not necessarily represent those of Durotech Industries, except where the sender expressly, and with clear authority, states them to be the views of Durotech Industries. Durotech Industries accepts no liability for any loss or damage (direct or indirect or consequential) arising from the use of or in connection with this document and any attachments and suggests that the recipient check this document and any attached files for the presence of viruses.”</p></td></tr></table>	
	
				</table>';	
				$html  .=' 
				</div>				
		</td>
		<td></td>
	</tr>
</table>';

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
$pdfPath = __DIR__ . DIRECTORY_SEPARATOR . $pdfname . '.pdf';
file_put_contents($pdfPath, $output);
return 'success';
?>