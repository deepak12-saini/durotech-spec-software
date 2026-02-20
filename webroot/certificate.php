<?php


// Database connection details from app_local.php
$db['hostname'] = 'localhost';
$db['username'] = 'customer_durotech';
$db['password'] = '_XTH3oe3wm~ajnp6'; 
$db['database'] = 'xoroglobal_customer_durotech';
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
$options->set('isRemoteEnabled', false);
$dompdf = new Dompdf($options);
$name  = base64_decode(base64_decode($_REQUEST['userid'])); 
$name  =  ucfirst($name);
$date = date('d/M/Y');
// Minimal block-only HTML to avoid dompdf "No block-level parent" error. All text in <p> only.
$safeName = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
$safeDate = htmlspecialchars($date, ENT_QUOTES, 'UTF-8');
$html = '<!DOCTYPE html><html><head><meta charset="utf-8"></head><body>'
  . '<div style="display:block; margin:0 auto; width:80%;">'
  . '<p style="display:block;">Date: ' . $safeDate . '</p>'
  . '<p style="display:block; margin:0;">[Certificate Header]</p>'
  . '<div style="display:block; padding:20px 0 5px 20px; font-size:15px;">'
  . '<p style="display:block;">This is to certify that ' . $safeName . '</p>'
  . '<p style="display:block;">Attended and successfully completed the CPD workshop assessment.</p>'
  . '<p style="display:block;">CPD Formal Points awarded: 1.0</p>'
  . '<p style="display:block;">AACA competence standards: Documention</p>'
  . '</div>'
  . '<p style="display:block; margin:0;">[Certificate Footer]</p>'
  . '</div></body></html>';

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