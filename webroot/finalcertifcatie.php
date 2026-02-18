<?php 
require  __DIR__ . '/sendgrid/vendor/autoload.php';

$db['hostname'] = 'localhost';
$db['username'] = 'root';
$db['password'] = ''; 
$db['database'] = 'customer_durotech';



$link = mysqli_connect($db['hostname'], $db['username'], $db['password'], $db['database']);


	isset($_REQUEST['user_id'])? $user_id = $_REQUEST['user_id'] : $user_id = 0;

	if(!empty($user_id)){
		
		$napp_users = mysqli_query($link,"select * from question_submits where id = '".$user_id."'");				
		$fetch  =  mysqli_fetch_assoc($napp_users);	
		
	
		$fname = $fetch['name'];
		$lname = $fetch['lname'];
		$name = $fname.' '.$lname;
		$email = $fetch['email'];
		$phone = $fetch['phone'];
		$created = date('Y-m-d H:i:s');
		
		$insrt = "update question_submits set created='".$created."' where id = '".$user_id."'";	
		mysqli_query($link,$insrt);
		
	
			
		$useremail = base64_encode(base64_encode($name));
		$message = 'Hi '.ucfirst($name).',<br>';
		$message .= '<p> Great! You did it!</p>'; 
		$message .= '<p> You have successfully completed the Durotech presentation and questionnaire.</p>'; 
		$message .= 'We congratulate you on gaining 1 Refuel CPD point. You are entitled to gain our participation  certificate which is attached below : <br> <a href="https://www.durotechindustries.com.au/certificate.php?userid='.$useremail.'&id='.$user_id.'"> Download Certificate </a>. '; 
		$message .= '<p> We hope you enjoyed this presentation and look forward to assisting you in specifying Durotech system in your current and future projects. </p>'; 
		
		$message .= '<p></p>';
		$message .= '<p>Regards,</p>';
		$message .= '<p>Durotechindustries</p>';	
		
		try{
			$subject = 'Durotechindustries :: Natspec Presentation Certificate';
			$from = new SendGrid\Email("Durotech", "noreply@durotechindustries.com.au");
			$to = new SendGrid\Email("Durotech", $email);
			$content = new SendGrid\Content("text/html", $message);
			$mail = new SendGrid\Mail($from, $subject, $to, $content);
			
			#$bcc = new SendGrid\Email("Durotechindustries", 'rsb@durotechindustries.com.au');
			//$bcc = new SendGrid\Email("Durotechindustries", 'rsb@durotechindustries.com.au');
			//$mail->personalization[0]->addBcc($bcc);
		
		
			$apiKey = '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';
			$sg = new \SendGrid($apiKey);
			
			
			$response = $sg->client->mail()->send()->post($mail); 
		}catch(Exception $e){
			
		}	
		// send email to admin	
		$admin_message = 'Hi,<br>';
		$admin_message .= '<p>'.ucfirst($name).' has completed completed Natspec Questionairre Test. Here is detail :</p>';
		$admin_message .= '<p></p>';
		$admin_message .= '<p>Name  : '.$name.'</p>';
		$admin_message .= '<p>Email  : '.$email.'</p>';
		$admin_message .= '<p>Phone  : '.$phone.'</p>';
		$admin_message .= '<p></p>';
		$admin_message .= '<p>Thanks</p>';
		$admin_message .= '<p>Durotechindustries</p>';
		
		try{
			$subject_1 = 'Durotechindustries :: Natspec Presentation By '.$fname;		
			$from_1 = new SendGrid\Email("Durotech", "noreply@durotechindustries.com.au");
			$to_1 = new SendGrid\Email("Durotech", "kal@durotechindustries.com.au");
			$content = new SendGrid\Content("text/html", $admin_message);
			$mail = new SendGrid\Mail($from_1, $subject_1, $to_1, $content);
			$apiKey = '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';
			$sg = new \SendGrid($apiKey);
			$response = $sg->client->mail()->send()->post($mail);
		}catch(Exception $e){
			
		}
		
		$questionArr['status'] = true;
		$questionArr['certificate'] = 'https://www.durotechindustries.com.au/certificate.php?userid='.$useremail;
		$questionArr['message'] = 'please cehck email.';
	}else{
		$questionArr['status'] = false;
		$questionArr['message'] = 'all paramter required';
	}	
	echo  json_encode($questionArr);
	
?>
