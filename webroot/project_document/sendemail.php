<?php

	require '../cws/sendgrid/vendor/autoload.php';	

	isset($_REQUEST['contractors'])? $contractors = $_REQUEST['contractors']:$contractors = '';
	isset($_REQUEST['contact_person'])? $contact_person = $_REQUEST['contact_person']:$contact_person = '';
	isset($_REQUEST['phone'])? $phone = $_REQUEST['phone']:$phone = '';

	isset($_REQUEST['project_name'])? $project_name = $_REQUEST['project_name']:$project_name = '';	
	isset($_REQUEST['project_id'])? $project_id = $_REQUEST['project_id']:$project_id = '';
	isset($_REQUEST['contact_person_name'])? $contact_person_name = $_REQUEST['contact_person_name']: $contact_person_name = '';
	isset($_REQUEST['contact_person_email'])? $contact_person_email = $_REQUEST['contact_person_email']: $contact_person_email = '';
	isset($_REQUEST['contact_person_phone'])? $contact_person_phone = $_REQUEST['contact_person_phone']: $contact_person_phone = '';
	isset($_REQUEST['discription'])? $discription = $_REQUEST['discription']: $discription = '';
	isset($_REQUEST['url'])? $url = $_REQUEST['url']:$url = '';
	isset($_REQUEST['is_open_url'])? $is_open_url = $_REQUEST['is_open_url']:$is_open_url = '';
	
	// echo '<pre>';
	// print_r($_REQUEST);
	// die();

	$message = '<html>
	<body>
	<table bgcolor="#C9E1ED" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="table-layout: fixed; vertical-align: top; min-width: 320px; Margin: 0 auto; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #FFF; width: 100%; border: 1px solid #f3eded;" valign="top" width="100%">
	<tbody>
	<tr style="vertical-align: top;" valign="top">
	<td style="word-break: break-word; vertical-align: top; border-collapse: collapse;" valign="top">
	<div style="background-color:transparent;">
		<div class="block-grid" style="Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #FFFFFF;;">
			<div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">
				<div class="col num12" style="min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top;">
					<div style="width:100% !important;">
						<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
							<div align="center" class="img-container center autowidth fullwidth" style="padding-right: 0px;padding-left: 0px;">
								<img align="center" alt="Image" border="0" class="center autowidth fullwidth" src="https://www.durotechindustries.com.au/project_document/header.jpg" style="outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; clear: both; border: 0; height: auto; float: none; width: 100%; max-width: 600px; display: block;" title="Image" width="600"/>
							</div>
							<div style="color:#555555;font-family:Arial, Helvetica, sans-serif;line-height:150%;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
								<div style="font-size: 12px; line-height: 18px; font-family:Arial, Helvetica, sans-serif; color: #555555;">
								<p style="font-size: 14px; line-height: 21px; text-align: center; margin: 0;">Durotech Industries has Invited you to Tender.</p>
							</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div style="background-color:transparent;">
		<div class="block-grid" style="Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #FFFFFF;;">
			<div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">

				<div class="col num12" style="min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top;;">
					<div style="width:100% !important;">
						<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:0px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">

							<div style="color:#0684c7;font-family:Arial, Helvetica, sans-serif;line-height:120%;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
								<div style="font-size: 12px; line-height: 14px; font-family: Arial,  Helvetica, sans-serif; color: #0684c7;">
									<p style="font-size: 14px; line-height: 33px; text-align: center; margin: 0;"><span style="font-size: 28px;"><strong><span style="line-height: 33px; font-size: 28px;">'.$project_name.'</span></strong></span><br/><br/></p>
								</div>
							</div>

							<div align="center" class="img-container center autowidth">
								<img align="center" alt="Image" border="0" class="center autowidth" src="https://www.durotechindustries.com.au/project_document/divider.png" style="outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; clear: both; border: 0; height: auto; float: none; width: 100%; max-width: 316px; display: block;" title="Image" width="316"/>
							</div>
							<div align="center" class="button-container" style="padding-top:25px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
								<a href="'.$url.'"><div style="text-decoration:none;display:inline-block;color:#ffffff;background-color:#0684c7;border-radius:4px;-webkit-border-radius:4px;-moz-border-radius:4px;width:auto; width:auto;;border-top:1px solid #0684c7;border-right:1px solid #0684c7;border-bottom:1px solid #0684c7;border-left:1px solid #0684c7;padding-top:15px;padding-bottom:15px;font-family:Arial,Helvetica, sans-serif;text-align:center;mso-border-alt:none;word-break:keep-all;"><span style="padding-left:15px;padding-right:15px;font-size:16px;display:inline-block;">
								<span style="font-size: 16px; line-height: 32px;">Access Documentation →</span>
								</span></div></a>
							</div>

							<div style="color:#555555;font-family:Arial,Helvetica, sans-serif;line-height:120%;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
								<div style="font-size: 12px; line-height: 14px; font-family: Arial, Helvetica, sans-serif; color: #555555;">
									<p style="font-size: 14px; line-height: 16px; margin: 0;"><span style="font-size: 14px; line-height: 16px;">  </span></p>
									<p style="font-size: 12px; line-height: 16px; margin: 0;"><span style="font-size: 14px;">Dear '.$contact_person.',</span></p>
									<p style="font-size: 12px; line-height: 14px; margin: 0;"> </p>
									<p style="font-size: 12px; line-height: 16px; margin: 0;"><span style="font-size: 14px;">Durotech Industries is inviting '.$contractors.' to Tender on the '.$project_name.'. Please use the button above to access tender documentation. If you cannot see that button, please use this direct link instead.</span></p>
									<p style="font-size: 12px; line-height: 14px; margin: 0;"> </p>
									<p style="font-size: 12px; line-height: 16px; margin: 0;"><span style="font-size: 14px;">Kindly forward through your quotations to Kal Bhinder (kal@durotechindustries.com.au).</span></p>
									<p style="font-size: 12px; line-height: 14px; margin: 0;"> </p>
									<p style="font-size: 12px; line-height: 16px; margin: 0;"><span style="font-size: 14px;">We sincerely appreciate you supporting Durotech Industries in this tender.</span></p>
									<p style="font-size: 12px; line-height: 14px; margin: 0;"> </p>
									<p style="font-size: 12px; line-height: 16px; margin: 0;"><span style="font-size: 14px;">Kind regards,</span></p>
									
									<p style="font-size: 12px; line-height: 16px; margin: 0;"><span style="font-size: 14px;">Kal Bhinder</span><br/><span style="font-size: 14px; line-height: 16px;">Durotech Industries</span></p>
									<p style="font-size: 14px; line-height: 16px; margin: 0;"><span style="font-size: 14px; line-height: 16px;"> </span></p>
								</div>
							</div>						
							
						</div>
						
						<div style="color:#0684c7;font-family:Arial, Helvetica, sans-serif;line-height:120%;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px; margin-bottom:150px;">
							<div style="font-size: 12px; line-height: 14px; font-family: Arial,  Helvetica, sans-serif; color: #0684c7;">
								<p style="font-size: 14px;  text-align: center; margin: 0;"><span style="font-size: 20px;"><strong><span style=" font-size: 20px;">Follow Our Instagram</span></strong></span><br/><br/></p>
							</div><div style="width:100%;">';
							
		?>
		<?php
			$data = file_get_contents('http://lightwidget.com/widgets/6b59d0e0b09e59d1bbfadd63c7a3ed43.html');
			$datas = htmlspecialchars($data);			
					
			preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $datas, $match);	
			$images  = array_chunk($match[0],5);
			$i=0;	
			foreach($images as $img){
				if($i < 4){	
			$linknew = str_replace('"','',$img[0]);
			$linknew = str_replace('&quot','',$linknew); 				
		?>
		<?php									
				$message .= '<div style="max-width:140px; max-height:140px; margin-left:10px;  float:left;">
					<a target="_blank" href="'.$linknew.'"><img src="'.$img[3].'"   style="width:100%; height:140px;"/></a></div>';
		?>		
		<?php  } $i++; }  ?>
		<?php	
		$message .= '</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>

	<div style="background-color:transparent;">
	<div class="block-grid three-up" style="Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #0684c7;">
	<div style="border-collapse: collapse;display: table;width: 100%;background-color:#0684c7;">

	<div class="col num4" style="max-width: 320px; min-width: 200px; display: table-cell; vertical-align: top;;">
		<div style="width:100% !important;">
			<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:0px; padding-bottom:0px; padding-right: 0px; padding-left: 0px;">

				<table cellpadding="0" cellspacing="0" class="social_icons" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;" valign="top" width="100%">
					<tbody>
						<tr style="vertical-align: top;" valign="top">
							<td style="word-break: break-word; vertical-align: top; padding-top: 15px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; border-collapse: collapse;" valign="top">
							<table activate="activate" align="center" alignment="alignment" cellpadding="0" cellspacing="0" class="social_table" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: undefined; mso-table-tspace: 0; mso-table-rspace: 0; mso-table-bspace: 0; mso-table-lspace: 0;" to="to" valign="top">
							<tbody>
							<tr align="center" style="vertical-align: top; display: inline-block; text-align: center;" valign="top">
							<td style="word-break: break-word; vertical-align: top; padding-bottom: 5px; padding-right: 3px; padding-left: 3px; border-collapse: collapse;" valign="top"><a href="https://www.facebook.com/DurotechIndustries" target="_blank"><img alt="Facebook" height="32" src="https://www.durotechindustries.com.au/project_document/facebook@2x.png" style="outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; clear: both; height: auto; float: none; border: none; display: block;" title="Facebook" width="32"/></a></td>
							
							<td style="word-break: break-word; vertical-align: top; padding-bottom: 5px; padding-right: 3px; padding-left: 3px; border-collapse: collapse;" valign="top"><a href="https://twitter.com/Durotech_au" target="_blank"><img alt="Twitter" height="32" src="https://www.durotechindustries.com.au/project_document/twitter@2x.png" style="outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; clear: both; height: auto; float: none; border: none; display: block;" title="Twitter" width="32"/></a></td>
						
							<td style="word-break: break-word; vertical-align: top; padding-bottom: 5px; padding-right: 3px; padding-left: 3px; border-collapse: collapse;" valign="top"><a href="https://www.google.com/maps/place/Durotech+Industries/@-34.0206014,150.8401609,17z/data=!3m1!4b1!4m5!3m4!1s0x6b12ec14b95fb3e5:0x849fcaeff6aba18e!8m2!3d-34.0206014!4d150.8423496?hl=en/" target="_blank"><img alt="Google+" height="32" src="https://www.durotechindustries.com.au/project_document/googleplus@2x.png" style="outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; clear: both; height: auto; float: none; border: none; display: block;" title="Google+" width="32"/></a></td>
							</tr>
							</tbody>
							</table>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="col num4" style="max-width: 320px; min-width: 150px; display: table-cell; vertical-align: top;;">
		<div style="width:100% !important;">
			<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
			<div style="color:#ffffff;font-family:Arial;line-height:120%;padding-top:20px;padding-right:0px;padding-bottom:0px;padding-left:0px;">
				<div style="font-size: 12px; line-height: 14px; color: #ffffff; font-family: Tahoma, sans-serif;">
					<p style="font-size: 12px; line-height: 14px; text-align: center; margin: 0;"><span style="color: #ffffff; font-size: 12px; line-height: 14px;"><span style="font-size: 12px; line-height: 14px; color: #ffffff;">Tel.:</span> 02 9603 1177</span><br/></p>
				</div>
			</div>
			</div>
		</div>
	</div>

	<div class="col num4" style="max-width: 320px; min-width: 244px; display: table-cell; vertical-align: top;">
		<div style="width:100% !important;">
			<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
				<div style="color:#ffffff;font-family: Tahoma, sans-serif;line-height:120%;padding-top:20px;padding-right:0px;padding-bottom:0px;padding-left:0px;">
					<div style="font-size: 12px; line-height: 14px; color: #ffffff; font-family: Tahoma, sans-serif;">
						<p style="font-size: 12px; line-height: 14px; text-align: center; margin: 0;">Email: <span style="color: #ffffff; font-size: 12px; line-height: 14px;">kal@durotechindustries.com.au</span></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
	</div>
	<img src="'.$is_open_url.'" / style="display:none;" >
	</div>
	</td>
	</tr>
	</tbody>
	</table>
	
	</body>
</html>';

try{
		$from = 'noreply@durotechindustries.com.au';
		$to = 'web@xoroglobal.com';
		$subject = 'Durotech:- Invitation to Tender ('.$project_name.')';
		$from = new SendGrid\Email(" Durotech Industries", $from);
		$to = new SendGrid\Email(" Durotech Industries", $to);
		$content = new SendGrid\Content("text/html", $message);
		
		$mail = new SendGrid\Mail($from, $subject, $to, $content);
		$apiKey = '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';
		$sg = new \SendGrid($apiKey);
		
		$response = $sg->client->mail()->send()->post($mail); 
	}catch(Exception $e){
		
	}
?>
