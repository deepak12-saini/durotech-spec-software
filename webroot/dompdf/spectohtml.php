<?php
require 'vendor/autoload.php';

require_once 'lib/html5lib/Parser.php';
require_once 'lib/php-font-lib/src/FontLib/Autoloader.php';
require_once 'lib/php-svg-lib/src/autoload.php';
require_once 'src/Autoloader.php';

// $db['hostname'] = 'localhost';
// $db['username'] = 'customer_duro';
// $db['password'] = 'fI06li!2'; 
// $db['database'] = 'customer_durotech';

$db['hostname'] = 'localhost';
$db['username'] = 'root';
$db['password'] = ''; 
$db['database'] = 'custom_durotech';

$con = mysqli_connect($db['hostname'], $db['username'], $db['password'], $db['database']);

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
										<th style="font-size:15px;">Ranjit</th>
									</tr>
									<tr>
										<th style="width:120px; font-size:15px;">Company:</th>
										<th style="font-size:15px;">Kodexglobal</th>
									</tr>
									<tr>
										<th style="width:120px; font-size:15px;">Address:</th>
										<th style="font-size:15px;">E-121</th>
									</tr>
									<tr>
										<th style="font-size:15px;">Specification</th>
										<th style="width:120px; font-size:15px;">Waterproofing</th>
									</tr>
									<tr>
										<th style="width:120px; font-size:15px;">Email:</th>
										<th style="font-size:15px;">Web@xoroglobal.com</th>
									</tr>
									<tr>
										<th style="width:120px; font-size:15px;">Date:</th>
										<th style="font-size:15px;">01/05/2022</th>
									</tr>
									
									<tr>
										<th style="width:120px; font-size:15px;">Reference id:</th>
										<th style="font-size:15px;">DTSPEC-20</th>
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
			<ul>
				<li>WPS 101 – Waterproofing for internal wet areas (bathrooms and laundries)</li>
				<li>WPS 102 – Waterproofing for balconies</li>
				<li>WPS 103 – Waterproofing for roof slab</li>
				<li>WPS 104 – Waterproofing for lift pit</li>
				<li>WPS 105 – Waterproofing for water tanks</li>
				<li>WPS 106 – Epoxy flooring for service areas</li>
				<li>WPS 107 – Concrete Sealer</li>
				<li>WPS 108 – Planter Boxes</li>
			</ul>
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
	
	for($i=0; $i<3; $i++)
	{
	
		$html .= '<br class="clear" /><div class="header">	
			<img  src="'.$header.'" style="width: 100%;" />		
		</div>	
		<div class="body"  style="height:700px; border-left: 5px solid #2789c8;">';
		
		$html .= '<table border="1" cellpadding="0" cellspacing="0" style="margin:0;  padding:0; width: 100%; ;margin-left: 19px; margin-right: 32px;">
			<tr>
				<th></th>
				<th>SYSTEM</th>
				<th>ENVIROSYSTEMS PRODUCT</th>
				<th>DESCRIPTION</th>
			</tr>				
			<tr>
				<th rowspan="9">WPS 10'.$i.' – WATERPROOFING FOR INTERNAL WET AREAS</th>
				<td>Primer (below screed)</td>
				<td>Enviro Shield</td>
				<td>Enviro Shield is a two-part, water-based epoxy that acts as a hydrostatic barrier and primer coating in applications requiring a protection against water ingress from the negative side. In addition, Enviro Shield can also be used as a moisture tolerant primer. It is to be applied at a rate of 0.32 L/m² to a dry film thickness (DFT) of 0.150mm.</td>
			</tr>
			<tr>
				<td>Bond Breaker</td>
				<td>Enviro FL + Deck Web</td>
				<td>The coverage of Enviro Flex FL will depend on the type of substrate, the substrate conditions and the size of the cove. When prepared and primed in accordance with the instructions above, the following coverage rates should be expected.</td>
			</tr>
			<tr>
				<td>Membrane(below screed)</td>
				<td>Enviro 700X</td>
				<td>Enviro 700X is a single component, low odour polyurethane elastomer waterproofing membrane. It is to be applied to the prepared and primed substrate to a minimum dry film thickness (DFT) of 1.5mm (typically achieved in 2 coats).</td>
			</tr>
			<tr>
				<td>Primer (walls)</td>
				<td>Enviro Shield</td>
				<td>Enviro Shield is a two-part, water-based epoxy that acts as a hydrostatic barrier and primer coating in applications requiring a protection against water ingress from the negative side. In addition, Enviro Shield can also be used as a moisture tolerant primer. It is to be applied at a rate of 0.32 L/m² to a dry film thickness (DFT) of 0.150mm.</td>
			</tr>
			<tr>
				<td>Membrane (walls)</td>
				<td>Enviro 200P ULTRA</td>
				<td>Enviro 200P ULTRA is an ultra-flexible, class III waterproofing membrane formulated on a water-based copolymer system that is urethane modified. It is fast drying and exhibits very good elasticity, excellent adhesion and outstanding elongation. It is to be applied to the primed substrate at a rate of 1.5 L/m² to a dry film thickness (DFT) of 1.0mm in 2 coats.</td>
			</tr>
			<tr>
				<td>Warranty Period</td>
				<td>10 Years</td>
				<td>15 years for Envirosystems accredited applicators.</td>
			</tr>
		</table>';
		
			$html .= '</div>
			<br class="clear" />	
			<div class="footer" id="page-break">		
				<img  src="'.$footer.'" style="width: 100%;" />			
			</div>'; 
		
		
	}
	
$html .= '</body>
</html>';
echo $html; 
// reference the Dompdf namespace
use Dompdf\Dompdf;
$pdfname = 'test';
// instantiate and use the dompdf class
$dompdf = new Dompdf(array('enable_remote' => true));
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
//$dompdf->stream();

$output = $dompdf->output();
file_put_contents($pdfname.'.pdf', $output);
return 'success';

?>
