<?php
require 'vendor/autoload.php';

require_once 'lib/html5lib/Parser.php';
require_once 'lib/php-font-lib/src/FontLib/Autoloader.php';
require_once 'lib/php-svg-lib/src/autoload.php';
require_once 'src/Autoloader.php';

isset($_REQUEST['docket_file'])? $docket_file = $_REQUEST['docket_file'] :  $docket_file = '';
$img = 'https://www.durotechindustries.com.au/docket_file/'.$docket_file;

$html = '<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml"><body>
<div align="center" class="button-container" style="padding-top:5px;padding-right:5px;padding-bottom:5px;padding-left:5px;">

<img src="'.$img.'" style="width: 100% !important; height:1000px;" /></div>
</body></html>';
// echo $html;
// die();
$exp = explode('.',$docket_file);
$path = $_SERVER['DOCUMENT_ROOT'].'/app/webroot/docket_file/'.$exp[0].'.pdf'; 
//unlink($path);

// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf(array('enable_remote' => true));
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
//$dompdf->setPaper('A4', 'landscape');
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
//$dompdf->stream();

$output = $dompdf->output();
file_put_contents($path, $output);
return 'success';
?>