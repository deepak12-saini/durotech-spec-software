	<style>
	.frmSearch { }
	#country-list{float:left;list-style:none;margin-top:-3px;padding:0;width:190px;position: absolute;z-index: 99; }
	#country-list li{padding: 10px; background: #e6fddd; border-bottom: #bbb9b9 1px solid; }
	#country-list li:hover{background:#ece3d2;cursor: pointer;}
	#search-box{padding: 10px;border: #a8d4b1 1px solid;border-radius:4px;}
	.hide_div{ display:none;}
	</style>	
	<?php
	
		$spcLocation  = array();
		if(!empty($SpecArr))
		{
			foreach($SpecArr as $Specs)
			{
				$specRow = is_array($Specs) ? ($Specs['Spec'] ?? $Specs) : $Specs;
				$specKey = is_array($specRow) ? ($specRow['spec_1'] ?? '') : ($specRow->spec_1 ?? '');
				if ($specKey !== '') {
					$spcLocation[$specKey][] = is_array($specRow) ? $specRow : $specRow->toArray();
				}
			}
		}
		//echo '<pre>'; print_r($spcLocation); die();		
	?>
	
	<div class="page-content">
		<div class="page-header">
		<div class="right_btn pull-right" ><a href="javascript:window.history.back();" class="btn btn-inverse" >Back</a></div>
		<h1>DuroEzy Specification  <small><i class="ace-icon fa fa-angle-double-right"></i>Create New Spec</small>
		</h1>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
		<?php echo $this->Form->create('Mailer',array('class'=>'form-horizontal','enctype'=>'multipart/form-data')); ?>
		
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Track Number:</label>
				<div class="col-sm-9">
					<input type="text" name="tracknumber" value="<?php echo $refernce; ?>" readonly id="tracknumber" class = "col-xs-10 col-sm-8" style="background:#ddd !important; cursor:pointer;" >
				</div>
			</div>
		
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Name/Attn:</label>
				<div class="col-sm-9">
					<input type="text" name="name" value="" id="name" class = "col-xs-10 col-sm-8">
				</div>
			</div>	
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Company:</label>
				<div class="col-sm-9">
					<input type="text" name="company" value=""  class = "col-xs-10 col-sm-8">
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Address:</label>
				<div class="col-sm-9">
					<input type="text" name="address" value=""  class = "col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Specification:</label>
				<div class="col-sm-9">
					<input type="text" name="specification" value=""  class = "col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Email:</label>
				<div class="col-sm-9">
					<input type="text" name="email" value="" id="email"  class = "col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Date:</label>
				<div class="col-sm-9">
					<input type="text" name="date" value="<?php echo date('d/m/Y');?>" id="date"  class = "datepicker col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Mailer Type:</label>
				<div class="col-sm-9">					<select name="type" class="col-xs-10 col-sm-8"  onchange="setsubject(this.value)"  >
						
						<option value="3">External Liquid WPM</option> 
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Subject:</label>
				<div class="col-sm-9">
					<input type="text" name="subject" value="Durotech: External Liquid WPM" id="subject" class = "col-xs-10 col-sm-8">
				</div>
			</div>
								
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
				<div class="col-sm-9">
					<ul>
						<li>DWPS-001 <input type="checkbox" name="dwps[1]" id="dwps_001" value="1" onclick="addnewsection(1)"> Waterproofing for internal wet areas (bathrooms and laundries) </li>
						<li>DWPS-002 <input type="checkbox" name="dwps[2]" id="dwps_002"  value="2" onclick="addnewsection(2)"> Waterproofing for balconies </li>
						<li>DWPS-003 <input type="checkbox" name="dwps[3]" id="dwps_003"  value="3" onclick="addnewsection(3)"> Waterproofing for roof slab </li>
						<li>DWPS-004 <input type="checkbox" name="dwps[4]" id="dwps_004"  value="4" onclick="addnewsection(4)"> Waterproofing for lift pi</li>
						<li>DWPS-005 <input type="checkbox" name="dwps[5]" id="dwps_005"  value="5" onclick="addnewsection(5)"> Waterproofing for water tanks</li>
						<li>DWPS-006 <input type="checkbox" name="dwps[6]" id="dwps_006"  value="6" onclick="addnewsection(6)"> Epoxy flooring for service areas</li>
						<li>DWPS-007 <input type="checkbox" name="dwps[7]" id="dwps_007"  value="7" onclick="addnewsection(7)"> Concrete Sealer </li>
						<li>DWPS-008 <input type="checkbox" name="dwps[8]" id="dwps_008"  value="8" onclick="addnewsection(8)"> Planter Boxes</li>
					</ul>
				</div>
			</div>
			
				<?php
				if(!empty($spcLocation))
				{
					foreach($spcLocation as $j=>$Spec)
					{		
				?>
				<div class="hide_div" id="add_<?php echo $j; ?>">
					<div class="form-group addsection" id="section_<?php echo $j; ?>">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>				
						<div class="col-sm-9">						
							<table>
								<tr>
									<td colspan="5"><input type="text" style="width:100%;" name="title[<?php echo $j; ?>]" value="<?php echo trim($Spec[0]['title']);  ?>" placeholder="enter title e,g Wet area or planter box" required></td>							
								</tr>
								<tr>
									<th></th>
									<th>Product Type</th>
									<th>Product</th>
									<th>Coverage Rate</th>
									<th>Description</th>
								</tr>
									<?php 
										foreach($Spec as $k=>$sl)
										{  
										
										$del_key = $j;
										$serial = $j;
										if($k > 0)
										{
											$del_key = $j.'_'.$k;
											$serial = $j.'.'.$k;
										}
									?>											
									<tr id="tr_<?php echo $del_key; ?>">
										<td><input type="hidden" style="width:30px;" name="types[]" value="<?php echo $j; ?>"><input type="text" style="width:63px;" name="serial[]" value="<?php echo $serial; ?>"></td>
										<td><input type="text" style="width:225px;" name="coverage[]" value="<?php echo $sl['system'];?>" id="coverage_<?php echo $j; ?>_<?php echo $k; ?>"></td>
										<td><div class="frmSearch"><input type="text" autocomplete="off" style="width:225px;" name="product[]" id="pro_<?php echo $j; ?>_<?php echo $k; ?>" value="<?php echo $sl['product'];?>" ><div class="suggesstion-box" id="suggesstion-box_<?php echo $j; ?>_<?php echo $k; ?>"></div></div></td>
										<td><input type="text" style="width:100px;" name="coverage_by_pack[]" value="<?php echo $sl['coverage'];?>" id="coverage_by_pack_<?php echo $j; ?>_<?php echo $k; ?>"></td>
										<td><input type="text" style="width:100px;" name="description[]" value="<?php echo $sl['descri'];?>" id="description_<?php echo $j; ?>_<?php echo $k; ?>"></td>
										<td><a href="javascript:void(0);" style="color:red;" onclick="removesection('<?php echo $del_key; ?>')">&nbsp;&nbsp; X </a></td>
									</tr>						
								<?php } ?>
							</table>
							<!--div id="addnew_<?php echo $j; ?>"></div><a href="javascript:void(0);" class="btn btn-xs btn-primary" style="margin-top:10px;" onclick="addmore(<?php echo $j; ?>)"><i class="fa fa-plus"></i> Add More</a></div></div-->
						</div>
					</div>	
				</div>	
				<?php } } ?>			
				<div id="addsection_002"></div>
				<div id="addsection_003"></div>
			
				<!--div id="newdiv"></div-->
			
				<div class="form-group" style="margin-top:40px;">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
				<div class="col-sm-9">				
					<table  class="commentdiv">
						<tr>	
							<th>Comments 1.</th>							
						</tr>
						<tr>							
							<td><input type="text" style="width:400px;" name="comment[]" value=""></td>
						</tr>
					</table>
					<div id="addcommentnew"></div>
					<a href="javascript:void(0);" class="btn btn-xs btn-primary" style="margin-top:10px;" onclick="addmorecomment()"><i class="fa fa-plus"></i> Add More Comment</a>
				</div>
				</div>
			
				<div class="form-group">
					<div class="col-md-offset-3 col-md-9">
						<?php echo $this->Form->submit('Submit',array('div'=>false,'label'=>false, 'class' => 'btn btn-mini  btn-success','id'=>'add_ser_prd_btn','value'=>'Submit'));?>&nbsp;
					
					</div>
				</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>	
	</div>	
	
	
<script type="text/javascript">
	
	function removesection(id){
		$("#section_"+id).remove();
		$("#tr_"+id).remove();
	}
	function addnewsection(arg)
	{
		
		var classidv = "dwps_00"+arg;
		if ($("#"+classidv).prop('checked')==true)
		{ 
			$("#add_"+arg).show();
		}else{
			$("#add_"+arg).hide();
		}
	}

	function addmore(id)
	{
		var numItems = $('.newitem_'+id).length;		
		var newdiv = 	numItems + 1;
		var dtserial = id+'.'+newdiv;
				
		var addnew ='<table class="newitem_'+id+'"  id="div_'+id+'_'+newdiv+'"><tr><td><input type="hidden" style="width:30px;" name="types[]" value="'+id+'"><input type="text" style="width:63px;" name="serial[]" value="'+dtserial+'"></td><td><input type="text" style="width:225px;" name="coverage[]" value=""  id="coverage_'+id+'_'+newdiv+'"></td><td><div class="frmSearch"><input autocomplete="off" type="text" style="width:225px;" name="product[]" value="" id="pro_'+id+'_'+newdiv+'" onkeyup="onkeyups('+id+','+newdiv+')"><div class="suggesstion-box" id="suggesstion-box_'+id+'_'+newdiv+'"></div></div></td><td><input type="text" style="width:100px;" name="coverage_by_pack[]" value=""  id="coverage_by_pack_'+id+'_'+newdiv+'"></td><td><input type="text" style="width:100px;" name="Warranty[]" value=""  id="warranty_'+id+'_'+newdiv+'"></td><td><a href="javascript:void(0);" style="color:red;" onclick="remove('+id+','+newdiv+')">&nbsp;&nbsp; X </a></td></tr></table>';
		$("#addnew_"+id).append(addnew);
	}	
	function remove(id,newdiv){	
		$("#div_"+id+"_"+newdiv).remove();
	}
	function checkornot(){
		var isChecked = $("#use_area").is(":checked");
		if (isChecked) {
			$("#userArea").show();
		} else {
			$("#userArea").hide();
		}
	}
	
	jQuery(function(){ //short for $(document).ready(function(){

		$('.datepicker').datepicker({
			format: "dd/mm/yyyy",			
		});
		$("#tracknumber").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter tracknumber"
		});
		$("#email").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter email"
		}); $("#name").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter name/attn"
		});; $("#company").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter company"
		}); $("#subject").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter subject"
		});
	});
	
	
	function addmorecomment(){
		var numItems = $('.commentdiv').length; 
		var newdiv = 	numItems + 1;
		var html = '<table class="commentdiv" id="commentdiv_'+newdiv+'"><tr><th>Comments '+newdiv+'.</th><th><th></tr><tr><td><input type="text" style="width:400px;" name="comment[]" value=""></td><td><a href="javascript:void(0);" style="color:red;" onclick="commnetdivremove('+newdiv+')">&nbsp;&nbsp; X </a></td></tr></table>';
		$("#addcommentnew").append(html);
	}	
	function commnetdivremove(newdiv){
		$("#commentdiv_"+newdiv).remove();
	}
	function onkeyups(id,newdiv){
		var csrfToken = $('input[name="_csrfToken"]').val() || '';
		$.ajax({
		type: "POST",
		url: "<?php echo SITEURL.'admin/mailers/list' ?>/"+id+"/"+newdiv,
		data: {
			keyword: $("#pro_"+id+"_"+newdiv).val(),
			_csrfToken: csrfToken
		},
		beforeSend: function(){
			//$("#search-box").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
		},
		success: function(data){
			if(data != ''){
				$("#suggesstion-box_"+id+"_"+newdiv+"").show();
				$("#suggesstion-box_"+id+"_"+newdiv+"").html(data);
				$("#pro_"+id+"_"+newdiv).css("background","#FFF");
			}else{
				$("#suggesstion-box_"+id+"_"+newdiv+"").hide();
				$("#suggesstion-box_"+id+"_"+newdiv+"").html('');
				$("#pro_"+id+"_"+newdiv).css("background","#FFF");
			}
		}
		});
	}
	function selectCountry(product,coverage,coverage_by_pack,Warranty,id,newdiv) {
		
		$("#pro_"+id+"_"+newdiv).val(product);
		$("#coverage_by_pack_"+id+"_"+newdiv).val(coverage_by_pack);
		$("#coverage_"+id+"_"+newdiv).val(coverage);
		$("#warranty_"+id+"_"+newdiv).val(Warranty);
		$("#suggesstion-box_"+id+"_"+newdiv+"").hide();
		$(".suggesstion-box").hide();
	}
</script>