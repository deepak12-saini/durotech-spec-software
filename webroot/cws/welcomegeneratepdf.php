<?php

	require 'sendgrid/vendor/autoload.php';	
	
	isset($_REQUEST['tracknumber'])? $tracknumber = $_REQUEST['tracknumber']:$tracknumber = '';
	isset($_REQUEST['mailer_id'])? $mailer_id = $_REQUEST['mailer_id']:$mailer_id = '';
	isset($_REQUEST['subject'])? $subject = $_REQUEST['subject']:$subject = '';

	$db['hostname'] = 'localhost';
	$db['username'] = 'root';
	$db['password'] = ''; 
	$db['database'] = 'customer_durotech';
	
	// $db['username'] = 'root';
	// $db['password'] = ''; 
	// $db['database'] = 'custom_durotech';
	
	
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
	
	$html = 
	
	'<html>
	
	<style type="text/css">
		body {
			margin: 0;
			padding: 0;
		}

		table,
		td,
		tr {
			vertical-align: top;
			border-collapse: collapse;
		}

		* {
			line-height: inherit;
		}

		a[x-apple-data-detectors=true] {
			color: inherit !important;
			text-decoration: none !important;
		}

		.ie-browser table {
			table-layout: fixed;
		}

		[owa] .img-container div,
		[owa] .img-container button {
			display: block !important;
		}

		[owa] .fullwidth button {
			width: 100% !important;
		}

		[owa] .block-grid .col {
			display: table-cell;
			float: none !important;
			vertical-align: top;
		}

		.ie-browser .block-grid,
		.ie-browser .num12,
		[owa] .num12,
		[owa] .block-grid {
			width: 600px !important;
		}

		.ie-browser .mixed-two-up .num4,
		[owa] .mixed-two-up .num4 {
			width: 200px !important;
		}

		.ie-browser .mixed-two-up .num8,
		[owa] .mixed-two-up .num8 {
			width: 400px !important;
		}

		.ie-browser .block-grid.two-up .col,
		[owa] .block-grid.two-up .col {
			width: 300px !important;
		}

		.ie-browser .block-grid.three-up .col,
		[owa] .block-grid.three-up .col {
			width: 300px !important;
		}

		.ie-browser .block-grid.four-up .col [owa] .block-grid.four-up .col {
			width: 150px !important;
		}

		.ie-browser .block-grid.five-up .col [owa] .block-grid.five-up .col {
			width: 120px !important;
		}

		.ie-browser .block-grid.six-up .col,
		[owa] .block-grid.six-up .col {
			width: 100px !important;
		}

		.ie-browser .block-grid.seven-up .col,
		[owa] .block-grid.seven-up .col {
			width: 85px !important;
		}

		.ie-browser .block-grid.eight-up .col,
		[owa] .block-grid.eight-up .col {
			width: 75px !important;
		}

		.ie-browser .block-grid.nine-up .col,
		[owa] .block-grid.nine-up .col {
			width: 66px !important;
		}

		.ie-browser .block-grid.ten-up .col,
		[owa] .block-grid.ten-up .col {
			width: 60px !important;
		}

		.ie-browser .block-grid.eleven-up .col,
		[owa] .block-grid.eleven-up .col {
			width: 54px !important;
		}

		.ie-browser .block-grid.twelve-up .col,
		[owa] .block-grid.twelve-up .col {
			width: 50px !important;
		}
	</style>
<style id="media-query" type="text/css">
		@media only screen and (min-width: 620px) {
			.block-grid {
				width: 600px !important;
			}

			.block-grid .col {
				vertical-align: top;
			}

			.block-grid .col.num12 {
				width: 600px !important;
			}

			.block-grid.mixed-two-up .col.num3 {
				width: 150px !important;
			}

			.block-grid.mixed-two-up .col.num4 {
				width: 200px !important;
			}

			.block-grid.mixed-two-up .col.num8 {
				width: 400px !important;
			}

			.block-grid.mixed-two-up .col.num9 {
				width: 450px !important;
			}

			.block-grid.two-up .col {
				width: 300px !important;
			}

			.block-grid.three-up .col {
				width: 200px !important;
			}

			.block-grid.four-up .col {
				width: 150px !important;
			}

			.block-grid.five-up .col {
				width: 120px !important;
			}

			.block-grid.six-up .col {
				width: 100px !important;
			}

			.block-grid.seven-up .col {
				width: 85px !important;
			}

			.block-grid.eight-up .col {
				width: 75px !important;
			}

			.block-grid.nine-up .col {
				width: 66px !important;
			}

			.block-grid.ten-up .col {
				width: 60px !important;
			}

			.block-grid.eleven-up .col {
				width: 54px !important;
			}

			.block-grid.twelve-up .col {
				width: 50px !important;
			}
		}

		@media (max-width: 620px) {

			.block-grid,
			.col {
				min-width: 320px !important;
				max-width: 100% !important;
				display: block !important;
			}

			.block-grid {
				width: 100% !important;
			}

			.col {
				width: 100% !important;
			}

			.col>div {
				margin: 0 auto;
			}

			img.fullwidth,
			img.fullwidthOnMobile {
				max-width: 100% !important;
			}

			.no-stack .col {
				min-width: 0 !important;
				display: table-cell !important;
			}

			.no-stack.two-up .col {
				width: 50% !important;
			}

			.no-stack .col.num4 {
				width: 33% !important;
			}

			.no-stack .col.num8 {
				width: 66% !important;
			}

			.no-stack .col.num4 {
				width: 33% !important;
			}

			.no-stack .col.num3 {
				width: 25% !important;
			}

			.no-stack .col.num6 {
				width: 50% !important;
			}

			.no-stack .col.num9 {
				width: 75% !important;
			}

			.video-block {
				max-width: none !important;
			}

			.mobile_hide {
				min-height: 0px;
				max-height: 0px;
				max-width: 0px;
				display: none;
				overflow: hidden;
				font-size: 0px;
			}

			.desktop_hide {
				display: block !important;
				max-height: none !important;
			}
		}
	</style>
	<style id="media-query-bodytag" type="text/css">
@media (max-width: 620px) {
  .block-grid {
    min-width: 320px!important;
    max-width: 100%!important;
    width: 100%!important;
    display: block!important;
  }
  .col {
    min-width: 320px!important;
    max-width: 100%!important;
    width: 100%!important;
    display: block!important;
  }
  .col > div {
    margin: 0 auto;
  }
  img.fullwidth {
    max-width: 100%!important;
    height: auto!important;
  }
  img.fullwidthOnMobile {
    max-width: 100%!important;
    height: auto!important;
  }
  .no-stack .col {
    min-width: 0!important;
    display: table-cell!important;
  }
  .no-stack.two-up .col {
    width: 50%!important;
  }
  .no-stack.mixed-two-up .col.num4 {
    width: 33%!important;
  }
  .no-stack.mixed-two-up .col.num8 {
    width: 66%!important;
  }
  .no-stack.three-up .col.num4 {
    width: 33%!important
  }
  .no-stack.four-up .col.num3 {
    width: 25%!important
  }
}
</style>
<body class="clean-body" style="margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #C9E1ED;">
	<table bgcolor="#C9E1ED" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="table-layout: fixed; vertical-align: top; min-width: 320px; max-width: 700px; Margin: 0 auto; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #C9E1ED; width: 100%;" valign="top" width="100%">
	<tbody>
	<tr style="vertical-align: top;" valign="top">
	<td style="word-break: break-word; vertical-align: top; border-collapse: collapse;" valign="top">
	<div style="background-color:transparent;">
		<div class="block-grid" style="Margin: 0 auto;   overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #FFFFFF;;">
			<div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">
				<div class="col num12" style="  display: table-cell; vertical-align: top;;">
					<div style="width:100% !important;">
						<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
							<div align="center" class="img-container center autowidth fullwidth" style="padding-right: 0px;padding-left: 0px;">
								<a href="https://durotechindustries.com.au"><img align="center" alt="Image" border="0" class="center autowidth fullwidth" src="https://www.durotechindustries.com.au/project_document/header.jpg" style="outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; clear: both; border: 0; height: auto; float: none; width: 100%; max-width: 700px; display: block;" title="Image" width="600"/></a>
							</div>
														
							<div style="color:#555555;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:150%;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px; text-align:right;">
								<div style="font-size: 12px; line-height: 18px; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; color: #555555; margin-top:40px;">
								<p>
									<span  style="font-size: 14px; line-height: 21px; text-align: left; margin: 0;font-weight:bold;">Ref.Id: '.$tracknumberId.'</span> 	
									
								</p>							
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div style="background-color:transparent;">
		<div class="block-grid" style="Margin: 0 auto;   overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #FFFFFF;;">
			<div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">

				<div class="col num12" style="  display: table-cell; vertical-align: top;;">
					<div style="width:100% !important;">
						<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:0px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">

							
							<div style="color:#555555;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:120%;padding-top:10px;padding-right:10px;padding-left:10px;padding-bottom:10px;">
								<div style="font-size: 12px; line-height: 14px; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; color: #555555;">
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
								<p style="text-align:center; font-size:12px; font-weight:bold;"> Have a think, of what you want or need for your business and how we can help.<br>
									Also PFA link to our marketing project instagram 
								</p>	
								'; ?>
								<?php
								$html .= '<ul>';
								$data = file_get_contents('http://lightwidget.com/widgets/6b59d0e0b09e59d1bbfadd63c7a3ed43.html');
								$datas = htmlspecialchars($data);			
										
								preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $datas, $match);	
								$images  = array_chunk($match[0],5);
								$i=0;	
								foreach($images as $img){
									if($i < 8){	
								$linknew = str_replace('"','',$img[0]);
								$linknew = str_replace('&quot','',$linknew); 				
								?>
								<?php	
								$html .= '<li style="display:inline;"><a href="'.$linknew.'"><img src="'.$img[3].'" style="height:125px; width:125px; margin:0px 0px 0px 0px; float:left;border:1px solid #ddd;"></a></li>';
								?>
								
								<?php  } $i++; }  
								$html .= '</ul><style="clear:both;">';								
								?>
								
							<?php $html .= '</div>
							</div>						
							
						</div>
						
						
						
					</div>
				</div>
			</div>
		</div>
	</div>

	<div style="background-color:transparent;">
		<div class="block-grid" style="Margin: 0 auto;   overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #FFFFFF;;">
			<div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">

				<div class="col num12" style="  display: table-cell; vertical-align: top;;">
					<div style="width:100% !important;">
						<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:0px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">

							
							<div style="color:#555555;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:120%;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
								<div style="font-size: 12px; line-height: 14px; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; color: #555555;">
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
	//echo $html;
	//die();
	$fileName = 'Product-system.pdf';	
	$filePath = dirname(__FILE__).'/'.$fileName;	
	
	$senderemail = 'sales@durotechindustries.com.au';
	try{
		//$email = 'ranjitsingh.ranjit7@gmail.com';	
		#$subject = 'Durotech :- Waterproofing and Epoxy Flooring';
		$from = new SendGrid\Email(" Durotech ", $senderemail);
		$to = new SendGrid\Email(" Durotech ", $email);
		$content = new SendGrid\Content("text/html", $html);
		
		// $file_encoded = base64_encode(file_get_contents($filePath));
		// $attachment = new SendGrid\Attachment();
        // $attachment->setContent($file_encoded);
        // $attachment->setContentId("123");
        // $attachment->setType("pdf");
        // $attachment->setDisposition("attachment");
        // $attachment->setFilename("Product-system.pdf");	 
				
		$mail = new SendGrid\Mail($from, $subject, $to, $content);
		//$mail->addAttachment($attachment);
		
		
		$apiKey = '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';
		$sg = new \SendGrid($apiKey);
		
		$response = $sg->client->mail()->send()->post($mail); 
	}catch(Exception $e){
		
	}
	
	echo 'success';
?>