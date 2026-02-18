<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'vendor/autoload.php';

require_once 'lib/html5lib/Parser.php';
require_once 'lib/php-font-lib/src/FontLib/Autoloader.php';
require_once 'lib/php-svg-lib/src/autoload.php';
require_once 'src/Autoloader.php';

$db['hostname'] = 'localhost';
$db['username'] = 'root';
$db['password'] = ''; 
$db['database'] = 'customer_durotech';

// $db['hostname'] = 'localhost';
// $db['username'] = 'customer_duro';
// $db['password'] = 'fI06li!2'; 
// $db['database'] = 'customer_durotech';
$con = mysqli_connect($db['hostname'], $db['username'], $db['password'], $db['database']);


isset($_REQUEST['pdfname'])? $pdfname = $_REQUEST['pdfname'] :  $pdfname = '';
isset($_REQUEST['name'])? $name = $_REQUEST['name'] :  $name = '';
isset($_REQUEST['email'])? $email = $_REQUEST['email'] :  $email = '';
isset($_REQUEST['address'])? $address = $_REQUEST['address'] :  $address = '';
isset($_REQUEST['company'])? $company = $_REQUEST['company'] :  $company = '';
isset($_REQUEST['specification'])? $specification = $_REQUEST['specification'] :  $specification = '';
isset($_REQUEST['date'])? $date = $_REQUEST['date'] :  $date = '';
isset($_REQUEST['use_area'])? $use_area = $_REQUEST['use_area'] :  $use_area = 0;
isset($_REQUEST['mailer_id'])? $mailer_id = (int)$_REQUEST['mailer_id'] :  $mailer_id = 0;
isset($_REQUEST['tracknumber'])? $tracknumber = $_REQUEST['tracknumber'] :  $tracknumber = '';
//isset($_REQUEST['mft'])? $mft = $_REQUEST['mft'] :  $mft = '';
//isset($_REQUEST['warranty_period'])? $warranty_period = $_REQUEST['warranty_period'] :  $warranty_period = '';

// Debug: Log mailer_id to check if it's being passed
// error_log("generatepdf_v1.php: mailer_id = " . $mailer_id);

if ($mailer_id <= 0) {
	die('Error: Invalid mailer_id. Received: ' . htmlspecialchars($_REQUEST['mailer_id'] ?? 'not set'));
}

$sql = mysqli_query($con,"SELECT DISTINCT title FROM spec_useareas WHERE mailer_id=".$mailer_id." ORDER BY id");
if (!$sql) {
	die('Database query error: ' . mysqli_error($con));
}
$num = mysqli_num_rows($sql);

/* if($num > 0)
{
	$i=0;
	while($row = mysqli_fetch_assoc($sql))
	{		
		echo '<pre>';
		print_r($row);
		die();
		
	}
		
} */

$path = $_SERVER['DOCUMENT_ROOT']; 
$header = $path.'/app/webroot/project_document/header.jpg';
$header = 'https://durotechindustries.com.au/project_document/header.jpg';
$footer = $path.'/app/webroot/project_document/footer.jpg';
$footer = 'https://durotechindustries.com.au/project_document/footer.jpg';


$html ='<!doctype html><html><head><meta charset="utf-8"><title>Waterproofing Spec</title>
	<style type="text/css">
	@page {
	   size: 21cm 29.7cm;
	   margin-top: 0cm;
	   margin-left: 0cm;
	   margin-right: 0cm;
	   margin-bottom: 0cm;   
	   padding:0cm;
	   page-break-inside: auto;
	   page-break-before: always;
	   page-break-after: always;
	}	
	@font-face {
    font-family: "Anton";
    font-style: normal;
    font-weight: 400;    
	}
	body{font-family:Arial, Helvetica, sans-serif; color:#333; background:#fff; margin-left:auto; margin-right:auto; max-width:210mm; max-height:297mm;}
	.clear{clear:both;}
	.blue{color:#0099CC;}
	h1,
	h2{ color:#0099CC; margin-bottom:0; font-weight: normal; }
	p{margin-top:0;}	
	
	#head .line{font-size:1.4em; font-style: italic; color:#999;}
	h1.features{text-align: center; font-family:Anton, sans-serif; text-transform: uppercase;}
	.feature{float:left; width:45%;}
	.feature h2{font-size:1.1em; text-transform: uppercase;}
	.feature p{color:#555;}
	.feature:nth-child(even){float:right;}
	
	ul li{
		font-size: 14px;		
		font-style: normal;
	}
	#page-break {			
		text-align: center;
		width: 100%;
		max-width: 800px;
		position: relative;
		bottom: 0;
	}
	.footer {
		clear: both;
		position: relative;		
		margin-top: 0px;
	}
	p{ font-size:14px; }
	table tr td,th{ padding:2px 5px; font-size:13px;} 
	</style>
</head>
<body>

		<div class="header">	
			<img  src="'.$header.'" style="width: 100%;" />		
		</div>	
		<div class="body" style="height:730px; border-left: 5px solid #2789c8;">
			<div class="feature" style="text-align: center;width: 100%;" >
				<div style="color:#555555;font-family:Arial,   Helvetica, sans-serif;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px; margin-top:100px;">
				<table cellpadding="0" cellspacing="0" style="margin:0;  padding:6px 30%; width: 100%; ;">
						<tr>
							<td align="left" style="padding:0px 9px;"  >
								<table style="text-align: left; color: #4f4b50;  font-family: arial;">
									<tr>
										<th style="width:120px; font-size:15px;">Attn:</th>
										<th style="font-size:15px;">'.$name.'</th>
									</tr>
									<tr>
										<th style="width:120px; font-size:15px;">Company:</th>
										<th style="font-size:15px;">'.$company.'</th>
									</tr>
									<tr>
										<th style="width:120px; font-size:15px;">Address:</th>
										<th style="font-size:15px;">'.$address.'</th>
									</tr>
									<tr>
										<th style="font-size:15px;">Specification</th>
										<th style="width:120px; font-size:15px;">'.$specification.'</th>
									</tr>
									<tr>
										<th style="width:120px; font-size:15px;">Email:</th>
										<th style="font-size:15px;">'.$email.'</th>
									</tr>
									<tr>
										<th style="width:120px; font-size:15px;">Date:</th>
										<th style="font-size:15px;">'.date('d/m/Y',strtotime($date)).'</th>
									</tr>
									
									<tr>
										<th style="width:120px; font-size:15px;">Reference id:</th>
										<th style="font-size:15px;">'.$tracknumber.'</th>
									</tr>
								</table>						
							</td>
						</tr>				
					</table>
				</div>		
			</div>
		</div>
	
	<div class="footer" id="page-break">		
		<img  src="'.$footer.'" style="width: 100%;" />			
	</div>
	<br class="clear" />		
	<div class="header">	
		<img  src="'.$header.'" style="width: 100%;" />		
	</div>	
	<div class="body"  style="height:730px; border-left: 5px solid #2789c8;" >
		<div class="features" style="padding: 0px 23px;">
			<h2  style="padding: 8px 0px;">Scope</h2>
			<p>Prepare and apply a waterproofing or protective coating system to areas listed below.</p>
		</div>

		<div class="features" style="padding: 0px 23px;">
			<h2  style="padding: 8px 0px;">Waterproofing</h2>
			<ul>';
			if($num > 0)
			{
				// Reset result pointer - we'll query again below for full data
				mysqli_data_seek($sql, 0);
				$i=0;
				while($row = mysqli_fetch_assoc($sql))
				{
					// Get first record for this title to get types
					$titleSql = mysqli_query($con,"SELECT types, title FROM spec_useareas WHERE mailer_id=".$mailer_id." AND title='".mysqli_real_escape_string($con, $row['title'])."' ORDER BY id LIMIT 1");
					if ($titleSql && $titleRow = mysqli_fetch_assoc($titleSql)) {
						$html .= '<li>DWPS 10.'.$titleRow['types'].' – '.htmlspecialchars($titleRow['title']).'</li>';
					}
				}				
			}				
			$html .= '</ul>
		</div>
		<div class="features" style="padding: 0px 23px;">
			<h2  style="padding: 8px 0px;">Scope Requirements</h2>
			<p>This specification details the substrate preparation, priming and installation details of Enviro 200P Ultra, Enviro 700X, Enviro Hydrostatic 1 (waterproofing membranes); Enviro Shield, Enviro Epoxy B-LV, Enviro Prime SB (primers); Enviro 800 TC. Application is to be by accredited applicators only and strictly in accordance with the product data sheet.</p>
			<p>Please refer to the respective Product Data Sheets for further information including product description, typical uses and application details.</p>
			<p>Alternatively, and dependent of substrate conditions, primer can be selected in consultation with Envirosystems depending on environmental conditions.</p>
			<p>All warranty periods quoted are when installation is by Envirosystems accredited applicators.details.</p>
		</div>		
	</div>
	
	<div class="footer" id="page-break">		
		<img  src="'.$footer.'" style="width: 100%;" />			
	</div>	
	<br class="clear" />	
	<div class="header">	
		<img  src="'.$header.'" style="width: 100%;" />		
	</div>	
	<div class="body"  style="height:730px; border-left: 5px solid #2789c8;">
		<div class="features" style="padding: 0px 23px;">
			<h2  style="padding: 8px 0px;">Substrate Preparation</h2>
			<p>Ensure that the concrete substrate is free from contaminants by mechanical profiling such as captive shot blast cleaning or vacuum grinding.</p>
			<p>Fill all bug holes and defects in concrete with the Enviro Epoxy B range of concrete repair products and allow curing.</p>
			<p>Vee out cracks and fill with a polyurethane joint sealant such as Enviro Flex PRO or Enviro Flex FC. Moisture content of concrete is to be below 10%</p>
			<p>Use Enviro DeSalin range to prepare substrate, such as, Enviro DeSalin AM to disinfect the surface from any mould, algae or microorganisms; Enviro DeSalin DG to remove any grease, oil, grime; Enviro DeSalin C to remove residues, salt deposits and efflorescence.</p>
		</div>
	</div>
	<br class="clear" />	
	<div class="footer" id="page-break">		
		<img  src="'.$footer.'" style="width: 100%;" />			
	</div>';

	// Get distinct titles for this mailer
	$sql = mysqli_query($con,"SELECT DISTINCT title FROM spec_useareas WHERE mailer_id=".$mailer_id." ORDER BY id");
	if (!$sql) {
		die('Database query error: ' . mysqli_error($con));
	}
	$num = mysqli_num_rows($sql);
	if($num > 0)
	{
		$i=0;
		while($row = mysqli_fetch_assoc($sql))
		{
			$i++;
			$title = mysqli_real_escape_string($con, $row['Title']);
			
			// Get first record for this title to get types
			$titleInfoSql = mysqli_query($con,"SELECT types FROM spec_useareas WHERE mailer_id=".$mailer_id." AND Title='".$title."' ORDER BY id LIMIT 1");
			$titleInfo = mysqli_fetch_assoc($titleInfoSql);
			$types = $titleInfo['types'] ?? '';
			
			$html .= '<br class="clear" /><div class="header">	
				<img  src="'.$header.'" style="width: 100%;" />		
			</div>	
			<div class="body"  style="height:700px; border-left: 5px solid #2789c8;">';
			
			// Count products for this title to set correct rowspan
			$countSql = mysqli_query($con,"SELECT COUNT(*) as cnt FROM spec_useareas WHERE mailer_id=".$mailer_id." AND Title='".$title."'");
			$countRow = mysqli_fetch_assoc($countSql);
			$productCount = (int)$countRow['cnt'];
			$rowspan = $productCount + 1; // +1 for the primer row
			
			$html .= '<table border="1" cellpadding="0" cellspacing="0" style="margin:0;  padding:0; width: 100%; ;margin-left: 19px; margin-right: 32px;">
				<tr>
					<th></th>
					<th>SYSTEM</th>
					<th>ENVIROSYSTEMS PRODUCT</th>
					<th>DESCRIPTION</th>
				</tr>				
				<tr>
					<th rowspan="'.$rowspan.'">DWPS 10'.$i.' – '.htmlspecialchars($row['Title']).'</th>
					<td>Primer (below screed)</td>
					<td>Enviro Shield</td>
					<td>Enviro Shield is a two-part, water-based epoxy that acts as a hydrostatic barrier and primer coating in applications requiring a protection against water ingress from the negative side. In addition, Enviro Shield can also be used as a moisture tolerant primer. It is to be applied at a rate of 0.32 L/m² to a dry film thickness (DFT) of 0.150mm.</td>
				</tr>';
				
				$sqls = mysqli_query($con,"SELECT * FROM spec_useareas WHERE mailer_id=".$mailer_id." AND title='".$title."' ORDER BY id");
				if (!$sqls) {
					$html .= '<tr><td colspan="3">Error: ' . mysqli_error($con) . '</td></tr>';
				} else {
					$nums = mysqli_num_rows($sqls);
					if($nums > 0)
					{
						while($rows = mysqli_fetch_assoc($sqls))
						{
							$html .= '<tr>
								<td>'.htmlspecialchars($rows['product'] ?? '').'</td>
								<td>'.htmlspecialchars($rows['coverage'] ?? '').'</td>
								<td>'.htmlspecialchars($rows['description'] ?? '').'</td>
							</tr>';
						}
					} else {
						$html .= '<tr><td colspan="3">No products found for this title.</td></tr>';
					}
				}
				
			$html .= '</table>';
			
			$html .= '</div>
			<br class="clear" />	
			<div class="footer" id="page-break">		
				<img  src="'.$footer.'" style="width: 100%;" />			
			</div>'; 
		
		
		}
	}
	
	
$html .= '</body>
</html>';
///echo $html; die();
//echo $html;
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
// Always save inside webroot/dompdf so download links resolve as /dompdf/<file>.
$targetFile = __DIR__ . DIRECTORY_SEPARATOR . $pdfname . '-V2.pdf';
file_put_contents($targetFile, $output);
return 'success';
?>