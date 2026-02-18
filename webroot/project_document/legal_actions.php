<?php

	require '../cws/sendgrid/vendor/autoload.php';	

	isset($_REQUEST['visit_id'])? $visit_id = $_REQUEST['visit_id']:$visit_id = '';
	isset($_REQUEST['company_name'])? $company_name = $_REQUEST['company_name']:$company_name = '';
	isset($_REQUEST['subject'])? $subject = $_REQUEST['subject']:$subject = '';
	isset($_REQUEST['send_from'])? $send_from = $_REQUEST['send_from']:$send_from = '';
	isset($_REQUEST['date'])? $date = $_REQUEST['date']:$date = '';
	isset($_REQUEST['email'])? $email = $_REQUEST['email']:$email = '';
	isset($_REQUEST['address'])? $address = $_REQUEST['address']:$address = '';
	isset($_REQUEST['amount'])? $amount = $_REQUEST['amount']:$amount = '';
	isset($_REQUEST['date'])? $date = $_REQUEST['date']:$date = '';
	
	$html = '
	<style>
	@page {
	size: 20cm 27.7cm;
	margin-top: 0cm;
	margin-left: 0cm;
	margin-right: 0cm;
	margin-bottom: 0cm;   
	padding:0cm;
	}

	</style>
	<html>

	<body>
	<table bgcolor="#C9E1ED" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="table-layout: fixed; vertical-align: top; min-width: 320px; Margin: 0 auto; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #FFF; width: 100%; border: 1px solid #f3eded;" valign="top" >
	<tbody>
	
	<tr style="vertical-align: top;" valign="top">
	<td style="word-break: break-word; vertical-align: top; border-collapse: collapse;" valign="top">
	<div style="background-color:transparent;">
		<div class="block-grid" style="Margin: 0 auto; min-width: 320px; max-width: 700px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #FFFFFF;;">
			<div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">
				<div class="col num12" style="min-width: 320px; max-width: 700px; display: table-cell; vertical-align: top;">
					<div style="width:100% !important;">
						<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent;  padding-right: 0px; padding-left: 0px;">
							<div align="center" class="img-container center autowidth fullwidth" style="padding-right: 0px; padding-left: 0px;">
								<img align="center" alt="Image" border="0" class="center autowidth fullwidth" src="https://www.durotechindustries.com.au/project_document/header.jpg" style=" max-width: 700px;" title="company Profile "/>
							</div>
							
							<div style="color:#555555;font-family:Arial,  , Helvetica, sans-serif;line-height:150%;padding-bottom:10px;">
								<div style="font-size: 12px; line-height: 18px; font-family: Arial,  , Helvetica, sans-serif; color: #555555; margin-top:40px;">
								<p>
									<span  style="font-size: 14px; line-height: 21px; text-align: left; margin: 0;font-weight:bold;"></span> 	
									<span  style="font-size: 14px; line-height: 21px; float: right; margin: 0; font-weight:bold;"> '.$date.'</span> 	
								</p>								
								</div>
							</div>
							
							<div style="color:#555555;font-family:Arial,  , Helvetica, sans-serif;line-height:150%;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
								<div style="font-size: 12px; line-height: 18px; font-family: Arial,  , Helvetica, sans-serif; color: #555555; margin-top:20px;">
								<p style="font-size: 14px; line-height: 21px; text-align: left; margin: 0;">'.$company_name.'</p>
								<p style="font-size: 14px; line-height: 21px; text-align: left; margin: 0;">'.$address.'</p>
								
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
									<p style="font-size: 12px; line-height: 16px; margin: 0;"><span style="font-size: 14px;">Dear Sir / Madam,</span></p>
									<br>
									<p style="font-size: 12px; line-height: 16px; margin: 0;"><span style="font-size: 18px; font-wight:bold !important;text-decoration: underline;">Ref: Outstanding Account - $'.$amount.'</span></p>
																		
									<p style="font-size: 12px; line-height: 14px; margin: 0;"> </p>
									<p style="font-size: 12px; line-height: 16px; margin: 0;"><span style="font-size: 14px;">In relation to the above, our company has made a numerous attempt in working with you to finalize the
above outstanding. Despite our previous efforts to settle this matter, your account remains unpaid and
is long overdue.</span></p>
									<p style="font-size: 12px; line-height: 14px; margin: 0;"> </p>
									<p style="font-size: 12px; line-height: 16px; margin: 0;"><span style="font-size: 14px;">Unless we receive full payment of the $'.$amount.' in seven days (7 days), we will have no choice but to
commence legal recovery and report the overdue debt to Veda Advantage (Credit reporting Agent).
As you know, such action is likely to damage your credit rating and your ability to do business with
other companies. We don’t wish for that to happen, however we seemed to have no other choice.</span></p>

									<p style="font-size: 12px; line-height: 14px; margin: 0;"> </p>
									<p style="font-size: 12px; line-height: 16px; margin: 0;"><span style="font-size: 14px;">Please pay your account within the 7 days. Please contact us if you require further information.</span></p>
									
									<p style="font-size: 12px; line-height: 14px; margin: 0;"> </p>
									<p style="font-size: 12px; line-height: 16px; margin: 0;"><span style="font-size: 14px;">We look forward to hear from you soon</span></p>
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

try{
		$from = 'kal@durotechindustries.com.au';
		$to = $email;
		//$to = $email;
		//$subject = 'Durotech:- Invitation to Tender ('.$project_name.')';
		$from = new SendGrid\Email(" Durotech Industries", $from);
		$to = new SendGrid\Email(" Durotech Industries", $to);
		$content = new SendGrid\Content("text/html", $html);
		
		$mail = new SendGrid\Mail($from, $subject, $to, $content);
		$apiKey = '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';
		$sg = new \SendGrid($apiKey);
		
		$response = $sg->client->mail()->send()->post($mail); 
	}catch(Exception $e){
		
	}
?>
