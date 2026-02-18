<?php
require 'vendor/autoload.php';

require_once 'lib/html5lib/Parser.php';
require_once 'lib/php-font-lib/src/FontLib/Autoloader.php';
require_once 'lib/php-svg-lib/src/autoload.php';
require_once 'src/Autoloader.php';
	
	isset($_REQUEST['company_name'])? $company_name = $_REQUEST['company_name']:$company_name = '';
	isset($_REQUEST['customer_name'])? $customer_name = $_REQUEST['customer_name']:$customer_name = '';
	isset($_REQUEST['project_name'])? $project_name = $_REQUEST['project_name']:$project_name = '';
	isset($_REQUEST['subject'])? $subject = $_REQUEST['subject']:$subject = '';
	isset($_REQUEST['send_from'])? $send_from = $_REQUEST['send_from']:$send_from = '';
	isset($_REQUEST['date'])? $date = $_REQUEST['date']:$date = '';
	isset($_REQUEST['email'])? $email = $_REQUEST['email']:$email = '';
	isset($_REQUEST['userarea'])? $userarea = $_REQUEST['userarea']:$userarea = '';
	isset($_REQUEST['sale_reps'])? $sale_reps = $_REQUEST['sale_reps']:$sale_reps = '';
	isset($_REQUEST['pdfname'])? $pdfname = $_REQUEST['pdfname']:$pdfname = '';
	//$date = date('F d,Y',strtotime($date));
	
	$html = '<html>
	<body>
	<table bgcolor="#C9E1ED" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="table-layout: fixed; vertical-align: top; min-width: 320px; Margin: 0 auto; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #FFF; width: 100%; border: 1px solid #f3eded;" valign="top" width="100%">
	<tbody>
	<tr style="vertical-align: top;" valign="top">
	<td style="word-break: break-word; vertical-align: top; border-collapse: collapse;" valign="top">
	<div style="background-color:transparent;">
		<div class="block-grid" style="Margin: 0 auto; min-width: 320px; max-width: 700px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #FFFFFF;;">
			<div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">
				<div class="col num12" style="min-width: 320px; max-width: 700px; display: table-cell; vertical-align: top;;">
					<div style="width:100% !important;">
						<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
							<div align="center" class="img-container center autowidth fullwidth" style="padding-right: 0px;padding-left: 0px;">
								<img align="center" alt="Image" border="0" class="center autowidth fullwidth" src="https://www.durotechindustries.com.au/project_document/header.jpg" style="outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; clear: both; border: 0; height: auto; float: none; width: 100%; max-width: 700px; display: block;" title="Image" width="600"/>
							</div>
							
							<div style="color:#555555;font-family:Arial,  , Helvetica, sans-serif;line-height:150%;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
								<div style="font-size: 12px; line-height: 18px; font-family: Arial,  , Helvetica, sans-serif; color: #555555; margin-top:40px;">
								<p>
									<span  style="font-size: 14px; line-height: 21px; text-align: left; margin: 0;font-weight:bold;">Att: '.$customer_name.'</span> 	
									<span  style="font-size: 14px; line-height: 21px; float: right; margin: 0; font-weight:bold;"> '.$date.'</span> 	
								</p>								
								</div>
							</div>
							
							<div style="color:#555555;font-family:Arial,  , Helvetica, sans-serif;line-height:150%;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
								<div style="font-size: 12px; line-height: 18px; font-family: Arial,  , Helvetica, sans-serif; color: #555555; margin-top:20px;">
								<p style="font-size: 14px; line-height: 21px; text-align: left; margin: 0;">Company Name: '.$company_name.'</p>
								<p style="font-size: 14px; line-height: 21px; text-align: left; margin: 0;">Project Name: '.$project_name.'</p>
								<p style="font-size: 14px; line-height: 21px; text-align: left; margin: 0;">Product Name: '.$userarea.'</p>
								</div>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div style="background-color:transparent;">
		<div class="block-grid" style="Margin: 0 auto; min-width: 320px; max-width: 700px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #FFFFFF;;">
			<div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">

				<div class="col num12" style="min-width: 320px; max-width: 700px; display: table-cell; vertical-align: top;;">
					<div style="width:100% !important;">
						<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:0px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">

							
							<div style="color:#555555;font-family:Arial,  , Helvetica, sans-serif;line-height:120%;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
								<div style="font-size: 12px; line-height: 14px; font-family: Arial,  , Helvetica, sans-serif; color: #555555;">
									<p style="font-size: 14px; line-height: 16px; margin: 0;"><span style="font-size: 14px; line-height: 16px;">  </span></p>
									<p style="font-size: 12px; line-height: 16px; margin: 0;"><span style="font-size: 14px;">Dear '.$customer_name.',</span></p>
									<p style="font-size: 12px; line-height: 14px; margin: 0;"> </p>
									<p style="font-size: 12px; line-height: 16px; margin: 0;"><span style="font-size: 14px;">This letter confirms a site visit was made by '.$sale_reps.', representing Durotech Australia Pty Ltd, on the '.$date.', to visually inspect the installation of the '.$userarea.'.</span></p>
									<p style="font-size: 12px; line-height: 14px; margin: 0;"> </p>
									<p style="font-size: 12px; line-height: 16px; margin: 0;"><span style="font-size: 14px;">On visual inspection, it was viewed that the system was installed in accordance to Durotech standard method statements. Recommendations were made to '.$customer_name.' Australia to conduct final repairs and inspections to the membrane for any damage prior to commencing further work.</span></p>
									<p style="font-size: 12px; line-height: 14px; margin: 0;"> </p>
									<p style="font-size: 12px; line-height: 16px; margin: 0;"><span style="font-size: 14px;">Please note however that this site visit in no way represents supervision of the work carried out, and the responsibility lies with the applicator to continue to install the Durotech system in accordance to installation guidelines.</span></p>
									<p style="font-size: 12px; line-height: 14px; margin: 0;"> </p>
									<p style="font-size: 12px; line-height: 16px; margin: 0;"><span style="font-size: 14px;">Hope all is understood and please feel free to contact for any other info.</span></p>
									<p style="font-size: 12px; line-height: 14px; margin: 0;"> </p>
									<p style="font-size: 12px; line-height: 14px; margin: 0;"> </p>
									<p style="font-size: 12px; line-height: 16px; margin: 0;"><span style="font-size: 14px;">Kind regards,</span></p>
									<p style="font-size: 12px; line-height: 14px; margin: 0;"> </p>
									<p style="font-size: 12px; line-height: 16px; margin: 0;"><span style="font-size: 14px;">Kal Bhinder</span>
									<br/><span style="font-size: 14px; line-height: 16px;"><strong>Technical Sales Representative</strong></span>
									<br/><span style="font-size: 14px; line-height: 16px;"><strong>Durotech Industries / 14 Essex Street, Minto NWS 2566 Australia</strong></span>
									<br/><span style="font-size: 14px; line-height: 16px;"><strong>Mobile</strong>: 0421670636 | <strong>Fax</strong>: 02 9475 5059</span>
									<br/><span style="font-size: 14px; line-height: 16px;">kal@durotechindustries.com.au</span>
									</p>
									<p style="font-size: 14px; line-height: 16px; margin: 0;"><span style="font-size: 14px; line-height: 16px;"> </span></p>
								</div>
							</div>						
							
						</div>
						
						
						
					</div>
				</div>
			</div>
		</div>
	</div>

	<div style="background-color:transparent;">
		<div class="block-grid" style="Margin: 0 auto; min-width: 320px; max-width: 700px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #FFFFFF;;">
			<div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">

				<div class="col num12" style="min-width: 320px; max-width: 700px; display: table-cell; vertical-align: top;;">
					<div style="width:100% !important;">
						<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:0px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">

							
							<div style="color:#555555;font-family:Arial,  , Helvetica, sans-serif;line-height:120%;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
								<div style="font-size: 12px; line-height: 14px; font-family: Arial,  , Helvetica, sans-serif; color: #555555;">
									<p style="font-size: 10px; line-height: 16px; margin: 0;"><span style="font-size: 10px; line-height: 16px;">  </span>Disclaimer:</p>
									<p style="font-size: 10px; line-height: 16px; margin: 0;"><span style="font-size: 10px; line-height: 16px;  text-align:justify;">  </span>“This document, including any attached files, is strictly confidential and intended solely for the use of the individual or entity to which it is addressed. Durotech Industries prohibits the right to publish, copy, distribute or disclose any information contained in this document, or its attachments, by any party other than the intended recipient. If you have received this document in error please notify the sender and delete it from your system immediately. No employee or agent is authorised to conclude any binding agreement or make any representation on behalf of Durotech Industries. The views or opinions presented in this document are solely those of the author and do not necessarily represent those of Durotech Industries, except where the sender expressly, and with clear authority, states them to be the views of Durotech Industries. Durotech Industries accepts no liability for any loss or damage (direct or indirect or consequential) arising from the use of or in connection with this document and any attachments and suggests that the recipient check this document and any attached files for the presence of viruses.”</p>
								</div>
							</div>						
							
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

// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf(array('enable_remote' => true));
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');
//$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
//$dompdf->stream();

$output = $dompdf->output();
file_put_contents($pdfname.'.pdf', $output);
return 'success';
?>