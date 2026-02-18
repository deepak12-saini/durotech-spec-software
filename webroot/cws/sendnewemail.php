<?php

	require 'sendgrid/vendor/autoload.php';	
	isset($_REQUEST['inserIndivdualtname'])? $inserIndivdualtname = $_REQUEST['inserIndivdualtname']:$inserIndivdualtname = '';
	isset($_REQUEST['insertcompanyname'])? $insertcompanyname = $_REQUEST['insertcompanyname']:$insertcompanyname = '';
	isset($_REQUEST['insertbuildersname'])? $insertbuildersname = $_REQUEST['insertbuildersname']:$insertbuildersname = '';
	isset($_REQUEST['projectname'])? $projectname = $_REQUEST['projectname']:$projectname = '';
	isset($_REQUEST['date'])? $date = $_REQUEST['date']:$date = '';
	isset($_REQUEST['insertname'])? $insertname = $_REQUEST['insertname']:$insertname = '';
	isset($_REQUEST['mailer_id'])? $mailer_id = $_REQUEST['mailer_id']:$mailer_id = '';
	isset($_REQUEST['senderemail'])? $senderemail = $_REQUEST['senderemail']:$senderemail = 'marketing@durotechindustries.com.au';
	
	if(!empty($_REQUEST['subject'])){
		
		$subject = $_REQUEST['subject']; 
		
	}else{
		$subject = ' Durotech Australian Made Construction Chemicals For 42 Years'; 
	}	

	$message = '<div class="certificate_container" style="width: 90%; margin: 0 auto;">
	   <div class="thanku_page">
		    <img style="width:100%; margin-bottom:5px;" src="https://www.durotechindustries.com.au/cws/Durotech_banner.jpg" >
		    <div  class="content" style="padding:20px 0px 5px 10px;font-size:14px;font-family:lato,sans-serif;border: none; color:#353535; z-index: -999999;margin-top: -41px;margin-left:10px;margin-right: 20px;" > 
		    <p style="float:right;">Rference Id: '.$mailer_id.'</p>
		    <p>Attn: '.$insertname.'</p>
			<p>Company: '.$insertcompanyname.'</p>
			<p>Project Name: '.$projectname.'</p>
			<p>Specification: Waterproofing and Epoxy Flooring</p>
			<p>Email: '.$insertbuildersname.'</p>
			<p style="margin-bottom:40px">Date: '.$date.'</p>
			

			<p style="margin-bottom:10px">Hello '.$inserIndivdualtname.',</p>
						
			<p>On behalf of Durotech Australia, we are writing to express our interest in providing detailed product specifications and quotations for supply and installation for the waterproofing and Epoxy Flooring for the following project (Upcoming projects) and projects you have coming up immediately or in the future.</p>

			<p>Durotech industries is a leading manufacturer and supplier of waterproofing and coating solutions. Durotech Systems have been widely used in the construction industry for the sealing of wet areas, decks, roofs and other substrates providing protection against moisture and weather damage for over 42 years. </p>

			<p>All products are proudly Australian Made for the last 42 years we have tested both to Australian Standard and Internationally. </p>
			
			<p>Being n proven and tested technology for the last 42years Durotech has quickly become the largest construction chemical manufacturer in Australia and with our local footprint it sets us apart from the rest of the competition.</p>

			<p>Durotech head office and manufacturing plant is based in Sydney but has a national reach having offices all around Australia. We are able to cater to both statewide and national projects hence making Durotech Products an ideal choice for customers.</p>

			<p>We would greatly appreciate any opportunity to provide pricing and products on any upcoming project – all specifications and quotations are free of charge. We’d be happy to meet at your office or on-site as required to provide more information about ourselves and our vision. To show case some of our technology I have attached a quick summary of our Flagship product a Waterproofing membrane that dries in less than 30seconds.</p>

			<p>Our Hybrid Polyurea Spray system Durospray PU 340. </p>

			<p>The quality raw materials are sourced from DOW chemicals the largest chemical manufacterer in the world. </p>

			<p>Durotech Polymers is an approved partner of DOW spray waterproofing systems.</p>

			<p>In Australia the most recent project Durotech has worked on are;</p>

			<p>&nbsp;&nbsp; 1) Star City casino refurbishment</p>

			<p>&nbsp;&nbsp; 2) RAAF base sewerage water treatment containment tanks</p>

			<p>This  Waterproofing system is touch dry in less than 15 seconds allowing it to become trafficable in almost real time.</p>

			<p>I have attached brochures and data sheets with options of a wide range of primers to suit any project.</p>

			<p>Link below shows some of our projects and the curing ability:</p>
			<h4 style="text-decoration:underline;">Rapid cure video below:</h4>

			<p><a href="https://www.instagram.com/p/BptQTF0lGPY">https://www.instagram.com/p/BptQTF0lGPY</a></p>

			<p>TDS (attached) for the spray system Durospray PU340.</p>

			<p>For More information and news on all the latest products and projects follow us on Instagram</p><table><tbody><tr>';
		?>
		<?php
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
		$message .= '<td><a href="'.$linknew.'"><img src="'.$img[3].'" style="height:100px; width:100px; margin:0px 3px; float:left;border:1px solid #ddd;"></a></td>';
		?>
		<?php  } $i++; }  ?>
		<?php	
		$message .= '</tr></tbody></table><p>Please feel free to contact us anytime should you wish to discuss anything in more detail, or if you’d like any further information.</p>
			<br/><br/>
			<p>Best Regards,</p>
			<p>THE DUTOTECH TEAM - Protecting Your Future</p>
			<p>Phone: (02) 9603 1177</p>
			<p>Web: www.durotechindustries.com.au</p>
			<p>Email: sales@durotechindustries.com.au</p>
			
			</div>	
		   <br>  <br>
		   <p><img  style="width:100%;" src="https://www.durotechindustries.com.au/cws/header-01.jpg"></p>  	   
	  </div>  
	</div>';
	
	$fileName = 'Dow-Durotech-Brochure.pdf';
	$fileName_1 = 'DUROSPRAY-PU340–Hybrid-Polyurea.pdf';
	$fileName_2 = '1.jpg';
	$fileName_3 = '2.jpg';
	$fileName_4 = '3.jpeg';
	$fileName_5 = '4.jpg';
	$filePath = dirname(__FILE__).'/PU340/'.$fileName;
	$filePath_1 = dirname(__FILE__).'/PU340/'.$fileName_1;
	$filePath_2 = dirname(__FILE__).'/PU340/'.$fileName_2;
	$filePath_3 = dirname(__FILE__).'/PU340/'.$fileName_3;
	$filePath_4 = dirname(__FILE__).'/PU340/'.$fileName_4;
	$filePath_5 = dirname(__FILE__).'/PU340/'.$fileName_5;
	
	try{
		#$subject = 'Durotech :- Waterproofing and Epoxy Flooring';
		$from = new SendGrid\Email(" Durotech Industries", $senderemail);
		$to = new SendGrid\Email(" Durotech Industries", $insertbuildersname);
		$content = new SendGrid\Content("text/html", $message);
		
		$file_encoded = base64_encode(file_get_contents($filePath));
		$attachment = new SendGrid\Attachment();
        $attachment->setContent($file_encoded);
        $attachment->setContentId("123");
        $attachment->setType("pdf");
        $attachment->setDisposition("attachment");
        $attachment->setFilename("Dow-Durotech-Brochure.pdf");	 
		
		$file_encoded_1 = base64_encode(file_get_contents($filePath_1));
		$attachment2 = new SendGrid\Attachment();
        $attachment2->setContent($file_encoded_1);
        $attachment2->setContentId("123");
        $attachment2->setType("pdf");
        $attachment2->setDisposition("attachment");
        $attachment2->setFilename("DUROSPRAY-PU340–Hybrid-Polyurea.pdf");	 
		
		$file_encoded_2 = base64_encode(file_get_contents($filePath_2));
		$attachment3 = new SendGrid\Attachment();
        $attachment3->setContent($file_encoded_2);
        $attachment3->setContentId("123");
        $attachment3->setType("image/jpg");
        $attachment3->setDisposition("attachment");
        $attachment3->setFilename("1.jpg");
		
		$file_encoded_3 = base64_encode(file_get_contents($filePath_3));
		$attachment4 = new SendGrid\Attachment();
        $attachment4->setContent($file_encoded_3);
        $attachment4->setContentId("123");
        $attachment4->setType("image/jpg");
        $attachment4->setDisposition("attachment");
        $attachment4->setFilename("2.jpg");	

		$file_encoded_4 = base64_encode(file_get_contents($filePath_4));
		$attachment5 = new SendGrid\Attachment();
        $attachment5->setContent($file_encoded_4);
        $attachment5->setContentId("123");
        $attachment5->setType("image/jpeg");
        $attachment5->setDisposition("attachment");
        $attachment5->setFilename("3.jpeg");	
		
		$file_encoded_5 = base64_encode(file_get_contents($filePath_5));
		$attachment6 = new SendGrid\Attachment();
        $attachment6->setContent($file_encoded_5);
        $attachment6->setContentId("123");
        $attachment6->setType("image/jpg");
        $attachment6->setDisposition("attachment");
        $attachment6->setFilename("4.jpg");
				
		$mail = new SendGrid\Mail($from, $subject, $to, $content);
		$mail->addAttachment($attachment);
		$mail->addAttachment($attachment2);
		$mail->addAttachment($attachment3);
		$mail->addAttachment($attachment4);
		$mail->addAttachment($attachment5);
		$mail->addAttachment($attachment6);
		
		
		$apiKey = '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';
		$sg = new \SendGrid($apiKey);
		
		$response = $sg->client->mail()->send()->post($mail); 
	}catch(Exception $e){
		
	}
		
	echo 'success';
?>