<style>
footer {
	padding-top: 50px;
}
.banner_durolab{ display:none; }
.header_fixed{ display:none; }
.footer_section {
	width: 100%;
	float: left;
	display: none;
}
</style>
	<?php
	$html ='<div  style="width:100%;">';	
		?>		
					<?php 			
					foreach($materials as $materialArr){
					$qrcode = SITEURL.'materials/readqrcode/'.$materialArr['Material']['id'];
					$material_type = $materialArr['Material']['material_type'];					
					$weight = $materialArr['Material']['weight'];					
					$package_type = $materialArr['Material']['package_type'];					
					$quantity = $materialArr['Material']['quantity'];					
					$description = $materialArr['Material']['description'];					
					?>	
					<?php 
					$html .='<div style="height:320px;width:100%;">
						
						<div style="padding: 0px 65px 0px 0px; float:right; width:70%;  margin-top: 22px;">							
																				
							<div class="userarea">
								<ul>
									<li style="background: #478cc0;color: #fff;padding: 12px 24px;	border-bottom: 1px solid #fff;	font-size: 24px;">Material Type: '.$material_type.'</li>
									<li style="background: #478cc0;color: #fff;padding: 12px 24px;		border-bottom: 1px solid #fff;	font-size: 24px;">Weight: '.$weight.'</li>
									<li style="background: #478cc0;color: #fff;padding: 12px 24px;		border-bottom: 1px solid #fff;	font-size: 24px;">Package Type: '.$package_type.'</li>
									<li style="background: #478cc0;color: #fff;padding: 12px 24px;		border-bottom: 1px solid #fff;	font-size: 24px;">Quantity: '.$quantity.'</li>
									<li style="background: #478cc0;color: #fff;padding: 12px 24px;		border-bottom: 1px solid #fff;	font-size: 24px;">Description: '.$description.'</li>
									
								</ul>
							</div>
						</div>	
						<div  style="padding: 0px 0px 0px 65px; width:30%; float:right; ">							
							<div style="max-width:300px; margin-top: 22px; "><img src="https://api.qrserver.com/v1/create-qr-code/?size=280x280&data='.$qrcode.'" alt="'.$material_type.'" style="width:100% !important;" /></div>									
						</div>	
					</div>'; ?>
				<?php } ?>
			<?php	
			$html .='</div>';
	
	echo $html;
	?>