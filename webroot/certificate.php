<?php


$db['hostname'] = 'localhost';
$db['username'] = 'root';
$db['password'] = ''; 
$db['database'] = 'customer_durotech';
$link = mysqli_connect($db['hostname'], $db['username'], $db['password'], $db['database']);
isset($_REQUEST['id'])? $id = $_REQUEST['id'] : $id = 0;
if($id > 0){
	$insrt = "update question_submits set is_open='1' where id = '".$id."'";	
	mysqli_query($link,$insrt);
}	

// include autoloader
require_once 'dompdf/autoload.inc.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;
use Dompdf\Options;
// instantiate and use the dompdf class

$options = new Options();
$options->set('isRemoteEnabled', TRUE);
$dompdf = new Dompdf($options);
$name  = base64_decode(base64_decode($_REQUEST['userid'])); 
$name  =  ucfirst($name);
$date = date('d/M/Y');
$html = '<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

	<div class="certificate_container" style="margin: 0 auto;	width: 80%;" > 
	<p>Date: '.$date.'</p>
	<div class="thanku_page">
		   <img style="width:100%;" src="https://www.durotechindustries.com.au/wp-content/uploads/image_cerificate.jpg">
		   <div  class="content" style="padding:20px 0px 5px 82px;font-size:15px;font-family:lato,sans-serif;border: none; color:#353535;"> 
		   <p>This is to certify that <b>'.$name.'</b> </p>	   
		  <p> Attended and successfully completed the CPD workshop assessment.</p>		
		   <p>CPD Formal Points awarded: 1.0  </p>
		  <p> AACA competence standards: Documention </p></div>			   
		   <img style="width:100%;" src="https://www.durotechindustries.com.au/wp-content/uploads/refel.jpg">         
	  </div>  
	</div>
</body> 
</html>';

$dompdf->loadHtml($html);
//$dompdf->loadHtml('<h1>INPATI</h1>');


// (Optional) Setup the paper size and orientation
//$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();
$filename='cpdcertification'.time().'.pdf';
// Output the generated PDF to Browser
$dompdf->stream($filename); 

?>