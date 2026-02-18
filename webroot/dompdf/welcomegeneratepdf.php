<?php

	require 'vendor/autoload.php';
	require_once 'lib/html5lib/Parser.php';
	require_once 'lib/php-font-lib/src/FontLib/Autoloader.php';
	require_once 'lib/php-svg-lib/src/autoload.php';
	require_once 'src/Autoloader.php';
	
	
	isset($_REQUEST['tracknumber'])? $tracknumber = $_REQUEST['tracknumber']:$tracknumber = '';
	isset($_REQUEST['mailer_id'])? $mailer_id = $_REQUEST['mailer_id']:$mailer_id = '';
	isset($_REQUEST['subject'])? $subject = $_REQUEST['subject']:$subject = '';

	 $db['hostname'] = 'localhost';
	// $db['username'] = 'customer_duro';
	// $db['password'] = 'fI06li!2'; 
	// $db['database'] = 'customer_durotech';
	
	$db['username'] = 'root';
	$db['password'] = ''; 
	$db['database'] = 'custom_durotech';
	
	
	$con = mysqli_connect($db['hostname'], $db['username'], $db['password'], $db['database']);
	$sql = mysqli_query($con,"select * from welcomes where id=".$mailer_id."");
	$row = mysqli_fetch_assoc($sql);
	$name = $row['name'];
	$price_url = $row['price_url'];
	$price_password = $row['price_password'];
	isset($row['email'])? $email = $row['email']:$email = '';
	//$email =  'ranjitsingh.ranjit7@gmail.com';
	$tracknumberId = $row['tracknumber'];
	$mesg = str_replace('###NAME###',ucfirst($name),$row['message']);
	
	$welcome_products = mysqli_query($con,"select * from welcome_products where welcome_id=".$mailer_id."");
	$num = mysqli_num_rows($welcome_products);
	if($num > 0){
		$trow = '<table cellpadding="0" cellspacing="0" style="  margin:15px 0px 20px;  padding:6px 0px 6px 0%; width:100%; "><tr><td></td>';
			
		if($num > 0){
			$i=0;
			while($row = mysqli_fetch_assoc($welcome_products)){
				if($i % 2 == 0){ $tclass="#9dc1e3"; }else{ $tclass="#ffffff";  }
				$trow .= '<tr style="background: '.$tclass.';padding: 4px;">
			<td style="padding: 9px;font-size: 12px;text-align: center;font-family: Arial, Helvetica Neue, Helvetica, sans-serif;">'.$row['product_name'].'</td>
			<td style="padding: 9px;font-size: 12px;text-align: center;font-family: Arial, Helvetica Neue, Helvetica, sans-serif;">'.$row['weight'].'</td>
			<td style="padding: 9px;font-size: 12px;text-align: center;font-family: Arial, Helvetica Neue, Helvetica, sans-serif;">'.$row['price'].'</td>
		</tr>';
				$i++;
			}	
		}
		$trow .= '</tr></table>';	
	}
	
$html ='<html>	
<style>
@page {
   size: 21cm 29.7cm;
   margin-top: 0cm;
   margin-left: 0cm;
   margin-right: 0cm;
   margin-bottom: 0cm;   
   padding:0cm;
}
</style>
<body class="clean-body" style="margin: 0; padding: 0; -webkit-text-size-adjust: 100%;">
	<table bgcolor="#C9E1ED" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="table-layout: fixed; vertical-align: top; min-width: 320px; max-width: 700px; Margin: 0 auto; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #C9E1ED; width: 100%;" valign="top" width="100%">
	<tbody>
	<tr style="vertical-align: top;" valign="top">
	<td style="word-break: break-word; vertical-align: top; border-collapse: collapse;" valign="top">
	<table  border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td><a href="https://durotechindustries.com.au"><img src="https://www.durotechindustries.com.au/project_document/header.jpg" style="width: 100% !important;" /></a></td>
			<td align="right"></td>
			
		</tr>					
	</table>
		
		<div class="block-grid" style="Margin: 0 auto;   overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #FFFFFF;;">
			<div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">

				<div class="col num12" style="  isplay: table-cell; vertical-align: top;;">
					<div style="width:100% !important;">
						<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:0px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">

							
							<div style="color:#555555;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:120%;padding-top:10px;padding-right:10px;padding-left:10px;padding-bottom:10px;">
								<div style="font-size: 12px; line-height: 14px; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; color: #555555;">
								<span  style="float:right; font-size: 12px; line-height: 21px; text-align: left; margin: 0;font-weight:bold;">Ref.Id: '.$tracknumberId.'</span> 
								
									'.$mesg.'';
								?>
								<?php
								if($num > 0){
									$html  .= $trow;
								}
								?>							
								<?php 
								$html  .= '
								<div style="clear:both;"></div><div style="color:#555555;font-family:Arial,   Helvetica, sans-serif;line-height:100%;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;padding: 0px 0%;text-align: justify;">
								<div style="font-size: 12px; line-height: 15px; font-family: Arial,   Helvetica, sans-serif; color: #555555;"><p style="font-size: 12px;line-height: 23px;font-family: Arial, Helvetica, sans-serif;color: #555555; ">
								
								<div style="width:50%; float:left;">
									<ul style="margin-top: 20px;">
										<li style="font-weight:bold; font-size:12px; margin-bottom:10px; color:#499dd2;">For all the lastest Durotech Waterproofing system from brlow ground to roof top Waterproofing.</li>
										<li  style="font-weight:bold; font-size:12px; margin-bottom:10px; color:#499dd2;">Click the below  link to get access to the Durotech system brochure.</li>	
										
										<li  style="font-weight:bold; font-size:12px; margin-bottom:10px; color:#499dd2;"><a style="color:#2c5671;" href="https://durotechindustries.com.au/cws/productsystem.pdf">Click Here To Download Brochure</a></li>';
										if(!empty($price_url)){										
										
											$html  .='<li  style="font-weight:bold; font-size:12px; margin-bottom:10px; color:#499dd2;">Once again thank you for showing support  to Durotech Australia.</li>	
											
											<li  style="font-weight:bold; font-size:12px; margin-bottom:10px; color:#499dd2;">Please click below link to get access to your most recent product price list</li>	
												
											
											<li  style="font-weight:bold; font-size:12px; margin-bottom:10px; color:#499dd2;"><a style="color:#2c5671;" href="'.$price_url.'">Click Here To Download Price List</a></li>';										
										}
									$html  .='</ul>
								</div>
								<div style="width:50%; float:left; text-align:right;">
									<a href="https://durotechindustries.com.au/cws/productsystem.pdf"><img 
									src="https://durotechindustries.com.au/cws/2019-05-09.png"></a>
								</div>
								</div>
								
								</div>
								<div style="clear:both;"></div>								
								'; ?>
								
								
							<?php $html .= '</div>
							</div>						
							
						</div>
						<div  style="width:100% !important; padding-right:20px; padding-left:20px">					
							<p style="font-size: 10px; line-height: 16px; margin: 0; color: #676767;">Disclaimer:</p>
							<p style="font-size: 10px; line-height: 16px; margin: 0;color: #676767;"><span style="font-size: 10px; line-height: 16px;  text-align:justify;">  </span>“This document, including any attached files, is strictly confidential and intended solely for the use of the individual or entity to which it is addressed. Durotech Industries prohibits the right to publish, copy, distribute or disclose any information contained in this document, or its attachments, by any party other than the intended recipient. If you have received this document in error please notify the sender and delete it from your system immediately. No employee or agent is authorised to conclude any binding agreement or make any representation on behalf of Durotech Industries. The views or opinions presented in this document are solely those of the author and do not necessarily represent those of Durotech Industries, except where the sender expressly, and with clear authority, states them to be the views of Durotech Industries. Durotech Industries accepts no liability for any loss or damage (direct or indirect or consequential) arising from the use of or in connection with this document and any attachments and suggests that the recipient check this document and any attached files for the presence of viruses.”</p>
						</div>						
					</div>
				</div>
			</div>
		</div>
	</div>

	
	</td>
	</tr>
	</tbody>
	</table>
	</body>
</html>';
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf(array('enable_remote' => true));
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');
//$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

$tracknumber = str_replace(' ','-',$tracknumber);
$output = $dompdf->output('F');
file_put_contents($tracknumber.'.pdf', $output);

mysqli_query($con,"update welcomes set pdffile='".$tracknumber.".pdf' where id=".$mailer_id."");

?>