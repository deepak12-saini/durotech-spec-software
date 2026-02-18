<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'vendor/autoload.php';

require_once 'lib/html5lib/Parser.php';
require_once 'lib/php-font-lib/src/FontLib/Autoloader.php';
require_once 'lib/php-svg-lib/src/autoload.php';
require_once 'src/Autoloader.php';

// Database connection details from app_local.php
$db['hostname'] = 'localhost';
$db['username'] = 'customer_durotech';
$db['password'] = '_XTH3oe3wm~ajnp6'; 
$db['database'] = 'xoroglobal_customer_durotech';
$con = mysqli_connect($db['hostname'], $db['username'], $db['password'], $db['database']);



isset($_REQUEST['pdfname'])? $pdfname = $_REQUEST['pdfname'] :  $pdfname = '';
isset($_REQUEST['name'])? $name = $_REQUEST['name'] :  $name = '';
isset($_REQUEST['email'])? $email = $_REQUEST['email'] :  $email = '';
isset($_REQUEST['address'])? $address = $_REQUEST['address'] :  $address = '';
isset($_REQUEST['company'])? $company = $_REQUEST['company'] :  $company = '';
isset($_REQUEST['specification'])? $specification = $_REQUEST['specification'] :  $specification = '';
isset($_REQUEST['date'])? $date = $_REQUEST['date'] :  $date = '';
isset($_REQUEST['use_area'])? $use_area = $_REQUEST['use_area'] :  $use_area = 0;
isset($_REQUEST['mailer_id'])? $mailer_id = $_REQUEST['mailer_id'] :  $mailer_id = 0;
isset($_REQUEST['tracknumber'])? $tracknumber = $_REQUEST['tracknumber'] :  $tracknumber = '';
//isset($_REQUEST['mft'])? $mft = $_REQUEST['mft'] :  $mft = '';
//isset($_REQUEST['warranty_period'])? $warranty_period = $_REQUEST['warranty_period'] :  $warranty_period = '';

$path = $_SERVER['DOCUMENT_ROOT']; 
$header = $path.'/app/webroot/project_document/header.jpg';
$header = 'https://durotechindustries.com.au/project_document/header.jpg';
$footer = $path.'/app/webroot/project_document/footer.jpg';
$footer = 'https://durotechindustries.com.au/project_document/footer.jpeg';

$trow = '';
$comments = '';
if($mailer_id > 0){
		$trow = '<table border="1" cellpadding="0" cellspacing="0" style=" padding:0px 20px 0px 20px; width: 100%;   margin-top:0px;"><tr><td colspan="4" ><h3 style="margin-bottom:1px; padding: 0px 9px;font-size: 12px;font-weight: bold;font-family: Arial,   Helvetica, sans-serif; color:#353336;">Use Area</h3></td><td style="border-right:0px !important;"></td></tr>';
		$sql = mysqli_query($con,"select * from spec_useareas where  mailer_id=".$mailer_id."");
		$num = mysqli_num_rows($sql);
		
		
		$trow .= '<tr style="background: #9dc1e3;padding: 4px;">
					
					<td style="padding: 1px 9px;font-size: 12px;font-weight: bold;text-align: center;font-family: Arial,   Helvetica, sans-serif;"></td>
					<td style="padding: 1px 9px;font-size: 12px;font-weight: bold;text-align: center;font-family: Arial,   Helvetica, sans-serif;">Product Type</td>
					<td style="padding:1px 9px;font-size: 12px;font-weight: bold;text-align: center;font-family: Arial,   Helvetica, sans-serif;">Product</td>
					<td style="padding: 1px 9px;font-size: 12px;font-weight: bold;text-align: center;font-family: Arial,   Helvetica, sans-serif;">MDFT</td>
					<td style="padding: 1px 9px;font-size: 12px;font-weight: bold;text-align: center;font-family: Arial,   Helvetica, sans-serif;">Warranty</td>
					
					<td></td>
					</tr>';
		if($num > 0){
			$i=0;
			while($row = mysqli_fetch_assoc($sql)){
				
				// echo '<pre>';
				// print_r($row);
				// die();
				if (strpos($row['serial'], '.') !== false) {		
					$tclass="#ffffff";
				}else{
					
					if($i > 0){
						//$trow .= '<tr style="background: #ffffff;padding: 4px;"><td style="padding: 2px 9px;font-size: 15px;text-align: center;font-family: Arial,   Helvetica, sans-serif;">&nbsp;</td>';
					}
					
					$trow .= '<tr style="background: #bed4ea; padding: 0px;"><td colspan="5" style="padding: 0px 11px;font-size: 15px;text-align: left;font-family: Arial, Helvetica, sans-serif; font-weight:600;">'.$row['title'].'</td></tr>';					
					$tclass="#fff";
				}
				//if($i % 2 == 0){ $tclass="#ffffff"; }else{ $tclass="#e0eaf6";  }
				$trow .= '<tr style="background: '.$tclass.';padding: 4px;">
														
							<td style="padding: 0px 9px;font-size: 12px;text-align: center;font-family: Arial,   Helvetica, sans-serif;">'.$row['serial'].'</td>
							<td style="padding: 0px 9px;font-size: 12px;text-align: center;font-family: Arial,   Helvetica, sans-serif;">'.$row['coverage'].'</td>
							<td style="padding: 0px 9px;font-size: 12px;text-align: center;font-family: Arial,   Helvetica, sans-serif;">'.$row['product'].'</td>							
							<td style="padding:0px 9px;font-size: 12px;text-align: center;font-family: Arial,   Helvetica, sans-serif;">'.$row['coverage_by_pack'].'</td>
							<td style="padding:0px 9px;font-size: 12px;text-align: center;font-family: Arial,   Helvetica, sans-serif;">'.$row['Warranty'].'</td>
							
							<td></td>
						</tr>';
				$i++;
			}	
		}
		$trow .= '</tr></table>';	
				
		$mailer_commentssql = mysqli_query($con,"select * from mailer_comments where mailer_id=".$mailer_id."");
		$mailer_commentsnum = mysqli_num_rows($mailer_commentssql);
		$comments = '';
		if($mailer_commentsnum > 0){
			$comments .= '<div style="page-break-after:always;"></div><table  border="0" cellspacing="0" cellpadding="0"><tr><td><a href="https://durotechindustries.com.au"><img src="'.$header.'" style="width: 100% !important;" /></a></td><td align="right"></td></tr></table><table cellpadding="0" cellspacing="0" style=" padding:0px 45px 6px 45px ; margin-top:60px; width: 900px; margin-top:20px;"><tr><td><h3 style="padding: 0px 9px;font-size: 12px;font-weight: bold;font-family: Arial, Helvetica, sans-serif; color:#353336;">Comment:</h3></td></tr>';
			$i=1;
			while($mailer_comment_row = mysqli_fetch_assoc($mailer_commentssql)){
				$comments .= '<tr><td style="padding: 0px 9px;font-size:12px; font-weight: normal;font-family: Arial, Helvetica, sans-serif; color:#353336;">'.$i.'. '.$mailer_comment_row['comment'].'</td></tr>';				
				$i++;
			}
			$comments .= '</table>';
		}
}

$html = '
<style>
@page {
   size: 21cm 29.7cm;
   margin-top: 0cm;
   margin-left: 0cm;
   margin-right: 0cm;
   margin-bottom: 0cm;   
   padding:0cm;
   page-break-inside: auto;
}

</style>
<table class="head-wrap" style="width: 900px; margin: 0px; padding:0px;background: #fff;color:##353339;opacity:0.8;"  border="0" cellspacing="0" cellpadding="0" >
	<tr>
		
		<td class="header container" style="display:block!important;max-width:900px !important;margin:0 auto!important;clear:both!important;">
					<div class="content" style="padding:0px;	max-width:900px;	margin:0 auto;	display:block; " >
						<table  border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><a href="https://durotechindustries.com.au"><img src="'.$header.'" style="width: 100% !important;" /></a></td>
							<td align="right"></td>
							
						</tr>					
						</table>
						<div style="color:#555555;font-family:Arial,   Helvetica, sans-serif;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
							<table cellpadding="0" cellspacing="0" style="margin:0;  padding:6px 20%; width: 100%; ;">
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
													<th style="width:120px; font-size:15px;">Specfication:</th>
													<th style="font-size:15px;">'.$specification.'</th>
												</tr>
												<tr>
													<th style="width:120px; font-size:15px;">Email:</th>
													<th style="font-size:15px;">'.$email.'</th>
												</tr>
												<tr>
													<th style="width:120px; font-size:15px;">Date:</th>
													<th style="font-size:15px;">'.$date.'</th>
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
							<div style="color:#555555;font-family:Arial,   Helvetica, sans-serif;line-height:120%;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;padding: 0px 6%;text-align: justify;">
								<div style="font-size: 12px; line-height: 15px; font-family: Arial,   Helvetica, sans-serif; color: #555555;">
									<p style="font-size: 15px; line-height: 14px; margin: 0;"><span style="font-size: 15px; line-height: 14px;">  </span></p>
									
									<p style="font-size: 12px; line-height: 14px; margin: 0;"><span style="font-size: 15px;">Thank you for the opportunity to specify Durotech Waterproofing membranes for the above mentioned project. With this in mind we have pleasure in submitting our product specification to carry out works. The warranty will be in the form of a Materials Warranty.</span></p>
									
									<p style="font-size: 12px; line-height: 15px; margin: 0;"> </p>
									<p style="font-size: 12px; line-height: 14px; margin: 0;"><span style="font-size: 14px; font-weight:bold; text-decoration:underline;">Substrate Preparation & Treatment of Cracks: For Liquid applied membranes</span></p>
									<p style="font-size: 12px; line-height: 5px; margin: 15px;"> </p>
									<p style="font-size: 12px; line-height: 8px; margin: 2px 0px;"><span style="font-size: 15px;">
									1. All concrete, masonry should be cured for 28 days.</span></p>
									
									<p style="font-size: 12px; line-height: 14px; margin: 2px 0px;"><span style="font-size: 15px;">
									2. Surface to receive coating, sealant or liquid applied flashing material shall be
									sound, dry, clean and free of all dirt, dust, oil, grease, wax, tar, asphalt, mildew, mold, paint, sealers, coatings, curing agents, loose particles, laitance and other contaminants. The substrate must not contain any flaky/powdery cement or residues	that may affect the membrane adhesion.Ensure that all protrusions have been removed.</span></p>
									
									<p style="font-size: 12px; line-height: 14px; margin: 2px 0px;"><span style="font-size: 15px;">3. Voids and honeycomb areas should be patched with a non-shrinking, quick setting grout. Allow the patched/ rendered areas to fully cure. Jack	hammered areas should be filled to provide smooth substrate.</span></p>
									
									<p style="font-size: 12px; line-height: 14px; margin: 2px 0px;"><span style="font-size: 15px;">4. All surfaces shall be made free of defects which may telegraph and showthrough the coating.</span></p>
									<p style="font-size: 12px; line-height: 14px; margin: 2px 0px;"><span style="font-size: 15px;">5. Movement joints should be treated in the appropriate manner.</span></p>
									<p style="font-size: 12px; line-height: 14px; margin: 2px 0px;"><span style="font-size: 15px;">6. Positive falls and adequate drainage is required.</span></p>
									<p style="font-size: 12px; line-height: 14px; margin: 2px 0px;"><span style="font-size: 15px;">7. Allow substrate to dry completely.</span></p>
									<p style="font-size: 12px; line-height: 14px; margin: 2px 0px;"><span style="font-size: 15px;">8. Broom clean substrate.</span></p>
									<p style="font-size: 15px; line-height: 14px; margin: 15px 0px;"></p>
									
									<p style="font-size: 15px; line-height: 14px; margin: 0;"><span style="font-size: 15px; line-height: 14px;">Concrete finish shall be a light steel trowel followed by a fine hair broom, or equivalent finish. All surfaces shall be made free of defects which may telegraph and show through the coating. </span></p>
									<p style="font-size: 15px; line-height: 14px; margin: 0;"><span style="font-size: 15px; line-height: 14px;">Prior to applying membranes make sure that the substrate contains less than 5% moisture.</span></p>
									
									
									<p style="font-size: 12px; line-height: 8px; margin: 2px;"> </p>
									<p style="font-size: 12px; line-height: 14px; margin: 0;"><span style="font-size: 14px; font-weight:bold; text-decoration:underline;">Treatment of Cracks for Liquid applied membranes</span></p>									
									<p style="font-size: 12px; line-height: 8px; margin: 2px;"> </p>
									<p style="font-size: 15px; line-height: 14px; margin: 0;"><span style="font-size: 15px; line-height: 14px;">Cracks —Non Movement: Hairline cracks less than 1.5mm may be pre-treated with a 1mm detail coating of the specified DuroMastic membrane 150mm wide centered over the crack.</span></p>
																
									<p style="font-size: 12px; line-height: 15px; margin: 0px;"> </p>
									<p style="font-size: 15px; line-height: 14px; margin: 0;"><span style="font-size: 15px; line-height: 14px;"><strong>Movement cracks:</strong> Greater than 1.5mm shall be routed out, install a backer rod and fill with DuroFlex FC Polyurethane sealant then coat with a 1mm detail coat of the specified DuroMastic water based Polyurethane membrane.</span></p>
									</div>								
								</div>
								<p style="font-size: 12px; line-height: 15px; margin: 0px;"> </p>
								<table  border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td><a href="https://durotechindustries.com.au"><img src="'.$footer.'" style="width: 100% !important;" /></a></td>
										<td align="right"></td>
										
									</tr>					
								</table>
								<div style="color:#555555;font-family:Arial,   Helvetica, sans-serif;line-height:120%;padding-right:10px;padding-bottom:10px;padding-left:10px;padding: 0px 0%;text-align: justify;">
									
									<div style="font-size: 12px; line-height: 15px; font-family: Arial,   Helvetica, sans-serif; color: #555555;">
									<p style="font-size: 12px; line-height: 15px; margin: 0px;"> </p>
									<div style="color:#555555;font-family:Arial,   Helvetica, sans-serif;line-height:120%;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;padding: 0px 6%;text-align: justify;">
									
									<div style="font-size: 12px; line-height: 15px; font-family: Arial,   Helvetica, sans-serif; color: #555555;">	
									<p style="font-size: 12px; line-height: 15px; margin: 0px;"> </p>
									<p style="font-size: 15px; line-height: 16px; margin: 0;"><span style="font-size: 15px; line-height: 16px;"><strong>Reinforcement Steel:</strong> In the event of exposed reinforcing steel, the exposed portions of steel shall be ground to expose clean, bright, metal and primed with a Duroproof Non Porous Primer.</span></p>
									
									<p style="font-size: 12px; line-height: 15px; margin: 0px;"> </p>
									<p style="font-size: 15px; line-height: 16px; margin: 0;"><span style="font-size: 15px; line-height: 16px;"><strong>Drainage:</strong> All drains shall be cleaned and operative. Drain flanges shall be recessed lower than the deck surface. The surface shall be sloped to the drain to Australian standard falls for positive drainage. Non Porous Primer is required if fittings are PVC or metal.</span></p>
									<p style="font-size: 12px; line-height: 15px; margin: 0px;"> </p>
									<p style="font-size: 12px; line-height: 15px; margin: 0px;"> </p>
									
									<p style="font-size: 15px; line-height: 16px; margin: 0;"><span style="font-size: 15px; line-height: 16px;"><strong>Substrate Moisture:</strong> The condition of “dry” shall be determined by moisture meter devise or fastening a rubber mat to the concrete deck for a minimum of six hours. The mat shall be located in an area exposed to the sun. After six hours (minimum), the surface beneath the rubber mat shall show minimal evidence of moisture or dampness. 12% moisture content or less is acceptable when using Duromastic Hibuild Epoxy Primers. Possible 2-3 coat epoxy priming process depending on moisture content and porosity of substrates.</span></p>
									
									<p style="font-size: 12px; line-height: 15px; margin: 0px;"> </p>
									<p style="font-size: 15px; line-height: 16px; margin: 0;"><span style="font-size: 15px; line-height: 16px;"><strong>Water Testing:</strong> When water testing, make sure it is carried out to the relevant Australian standard and allow for the membrane to dry prior to water testing. Allow membrane to dry after removing water. Ensure membrane is dry before applying further coatings or finishing with other coverings.</span></p>
									
									<p style="font-size: 12px; line-height: 15px; margin: 0px;"> </p>
									<p style="font-size: 15px; line-height: 16px; margin: 0;"><strong>Refer to all technical data sheets and Application Instruction Manuals for further details prior to carrying out works.</strong></p>
									
									<p style="font-size: 12px; line-height: 15px; margin: 6px;"> </p>
									<p style="font-size: 15px; line-height: 16px; margin: 0;"><strong>Observations</strong></p>
									
									<p style="font-size: 12px; line-height: 15px; margin: 0px;"> </p>
									<p style="font-size: 15px; line-height: 16px; margin: 0;">
									Periodical observations can be carried out during the membrane application by applicator, however it is the responsibility of the builder/ applicator to supervise and maintain the quality of the works. The applicator/ builder will inform Durotech should the need arise for an inspection by a Durotech representative.</p>
									
									<p style="font-size: 12px; line-height: 15px; margin: 0px;"> </p>
									<p style="font-size: 15px; line-height: 16px; margin: 0;"><strong>Contractor Applicator</strong></p>
									
									<p style="font-size: 12px; line-height: 15px; margin: 0px;"> </p>
									<p style="font-size: 15px; line-height: 16px; margin: 0;">
									Durotech waterproofing systems must be applied by competent applicators who have a minimum of 5 years installing Durotech systems. A list of applicators can be provided to the builder upon request to the undersigned below.</p>
									<p style="font-size: 12px; line-height: 15px; margin: 0px;"> </p>
									<p style="font-size: 15px; line-height: 16px; margin: 0;">
									Any alterations to the above product specification without approval from Durotech may void warranties.</p>
																		
									
								</div></div></div></div>
								<p style="font-size: 12px; line-height: 15px; margin: 0px;"> </p><p style="font-size: 12px; line-height: 15px; margin: 0px;"> </p><p style="font-size: 12px; line-height: 15px; margin: 0px;"> </p><p style="font-size: 12px; line-height: 15px; margin: 0px;"> </p><p style="font-size: 12px; line-height: 15px; margin: 0px;"> </p><p style="font-size: 12px; line-height: 15px; margin: 0px;"> </p>
								<p style="font-size: 12px; line-height: 15px; margin: 0px;"> </p>
								<table  border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td><a href="https://durotechindustries.com.au"><img src="'.$footer.'" style="width: 100% !important;" /></a></td>
										<td align="right"></td>
										
									</tr>					
								</table>
								';
								// Only add second page (Use Area / Comments) when there is content - no blank page with office locations (Kal requirement)
								if ($trow !== '' || $comments !== '') {
									$html .= '<div style="page-break-before:always;"></div>
								<table  border="0" cellspacing="0" cellpadding="0" >
									<tr>
										<td><a href="https://durotechindustries.com.au"><img src="'.$header.'" style="width: 100% !important;" /></a></td>
										<td align="right"></td>
									</tr>					
								</table>';
									$html .= $trow;
									$html .= $comments;
								}
							
								$html  .= '<p style="font-size: 12px; line-height: 15px; margin: 0px; ">  </p><p style="font-size: 12px; line-height: 15px; margin: 0px;"> </p><p style="font-size: 12px; line-height: 15px; margin: 0px;"> </p>
								<p style="font-size: 12px; line-height: 15px; margin: 0px;"> </p>
								<footer>
								<div  style="position: absolute; bottom: 0;">
								<table  border="0" cellspacing="0" cellpadding="0" >
									<tr>
										<td><a href="https://durotechindustries.com.au"><img 
										src="'.$footer.'" style="width: 100% !important;"  /></a></td>
										<td align="right"></td>
									</tr>					
								</table></div></footer>';				
				$html  .='</td>
		<td></td>
	</tr>
</table>';

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
file_put_contents($pdfname.'.pdf', $output);
return 'success';
?>