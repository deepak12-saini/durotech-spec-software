	<style>
	.frmSearch {}
	#country-list{float:left;list-style:none;margin-top:-3px;padding:0;width:190px;position: absolute;z-index: 99;}
	#country-list li{padding: 10px; background: #e6fddd; border-bottom: #bbb9b9 1px solid; }
	#country-list li:hover{background:#ece3d2;cursor: pointer;}
	#search-box{padding: 10px;border: #a8d4b1 1px solid;border-radius:4px;}

	/* Title suggestions dropdown from /admin/mailers/title_list */
	.title-dropdown {
		list-style: none;
		padding-left: 0;
		margin: 0;
		position: absolute;
		z-index: 999;
		background: #fff;
		border: 1px solid #ccc;
		width: 100%;
		max-height: 200px;
		overflow-y: auto;
	}
	.title-dropdown li {
		padding: 5px 10px;
		background: #e6fddd;
		border-bottom: 1px solid #bbb9b9;
		cursor: pointer;
	}
	.title-dropdown li:hover {
		background-color: #f0f0f0;
	}

	/* Suggestion container used across product/title search UIs */
	.suggesstion-box {
		display: block;
	}
	.addsection > .col-sm-9 {
		background: #fff;
		border: 1px solid #dbe5f1;
		border-radius: 12px;
		box-shadow: 0 6px 18px rgba(36, 92, 154, 0.08);
		margin-bottom: 18px;
		overflow-x: auto;
		padding: 15px;
		scroll-behavior: smooth;
	}
	.addsection > .col-sm-9:focus {
		border-color: #9fb5ce;
		outline: 2px solid rgba(159, 181, 206, 0.25);
	}
	.addsection table {
		border-collapse: separate;
		border-spacing: 0 8px;
		width: 100%;
	}
	.addsection th {
		color: #4f5f6f;
		font-size: 12px;
		font-weight: 600;
		padding: 0 6px;
	}
	.addsection td {
		padding: 0 6px;
		vertical-align: top;
	}
	.addsection input[type="text"] {
		background: #fff;
		border: 1px solid #cfd8e3 !important;
		border-radius: 7px !important;
		box-shadow: none !important;
		height: 34px;
		line-height: 20px;
		padding: 6px 8px;
	}
	@media (min-width: 768px) and (max-width: 1300px) {
		.form-horizontal .form-group > .col-sm-3 {
			width: 16%;
		}
		.form-horizontal .form-group > .col-sm-9 {
			width: 84%;
		}
		.addsection > label {
			display: none;
		}
		.addsection > .col-sm-9 {
			margin-left: 8%;
			width: 92%;
		}
		.addsection input[name="serial[]"] {
			width: 55px !important;
		}
		.addsection input[name="coverage[]"],
		.addsection input[name="product[]"] {
			width: 190px !important;
		}
		.addsection input[name="coverage_by_pack[]"],
		.addsection input[name="Warranty[]"] {
			width: 90px !important;
		}
	}
	
	</style>
	<div class="page-content">
		<div class="page-header">
		<div class="right_btn pull-right" ><a href="javascript:window.history.back();" class="btn btn-inverse" >Back</a></div>
		<h1>DuroEzy Specification  <small><i class="ace-icon fa fa-angle-double-right"></i>Edit Spec</small>
		</h1>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
		<?php echo $this->Form->create('Mailer',array('class'=>'form-horizontal','enctype'=>'multipart/form-data')); ?>
		<input type="hidden" name="return_page" value="<?php echo isset($returnPage) ? (int)$returnPage : 1; ?>">
		
			<div class="form-group">
				<label for="form-field-2" class="col-sm-3 control-label no-padding-right"> Is Create New One: </label>
					<div class="col-sm-9">					
				
					<div class="radio"><label>
						<input type="radio" value="0" class="ace" checked id="form_type1" name="form_type"><span class="lbl"> No</span>
					</label></div>		

					<div class="radio"><label>
					<input type="radio"  value="1" class="ace" id="form_type0" name="form_type"><span class="lbl"> Yes</span>
					</label></div>					
				</div>
			</div>
					
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Track Number:</label>
				<div class="col-sm-9">
					<input type="text" name="tracknumber" value="<?php echo $refernce; ?>" readonly id="tracknumber" class = "col-xs-10 col-sm-8" style="background:#ddd !important; cursor:pointer;" >
				</div>
			</div>
		
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Name/Attn:</label>
				<div class="col-sm-9">
					<input type="text" name="name"  id="name" value="<?php echo $MailerArr['Mailer']['name']; ?>" class = "col-xs-10 col-sm-8">
				</div>
			</div>	
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Project:</label>
				<div class="col-sm-9">
					<input type="text" name="company" value="<?php echo $MailerArr['Mailer']['company']; ?>"  class = "col-xs-10 col-sm-8">
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Address:</label>
				<div class="col-sm-9">
					<input type="text" name="address"  value="<?php echo $MailerArr['Mailer']['address']; ?>" class = "col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Specification:</label>
				<div class="col-sm-9">
					<input type="text" name="specification" value="<?php echo $MailerArr['Mailer']['specification']; ?>"  class = "col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Email:</label>
				<div class="col-sm-9">
					<input type="text" name="email" id="email" value="<?php echo $MailerArr['Mailer']['email']; ?>"  class = "col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Date:</label>
				<div class="col-sm-9">
					<input type="text" name="date" id="date" value="<?php echo $MailerArr['Mailer']['date']; ?>"   class = "datepicker col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Mailer Type:</label>
				<div class="col-sm-9">
					<select name="type" class="col-xs-10 col-sm-8"  onchange="setsubject(this.value)"  >
						<!-- <option value="">Select Client Requested</option> -->
						<!--option value="1">INSTALLATION OF DUROMASTIC P-15 WATERPROOFING MEMBRANE</option>
						<option value="2">Waterproofing Specification – Wet area shower</option-->
						<option <?php if($MailerArr['Mailer']['date'] == 3){ echo 'selected'; } ?> value="3">External Liquid WPM</option> 
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Subject:</label>
				<div class="col-sm-9">
					<input type="text" name="subject" value="<?php echo $MailerArr['Mailer']['subject']; ?>" id="subject" class = "col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Spec Type:</label>
				<div class="col-sm-9">
					<?php
					// use_area: 0=With Warranty → spectype 1; 1=Without Warranty → spectype 0
					$savedSpectype = isset($MailerArr['Mailer']['use_area'])
						? (string)(1 - (int)$MailerArr['Mailer']['use_area'])
						: '1';
					?>
					<select name="spectype" class="col-xs-10 col-sm-8">						
						<option value="1"<?php echo $savedSpectype === '1' ? ' selected' : ''; ?>>With Warranty Column</option> 
						<option value="0"<?php echo $savedSpectype === '0' ? ' selected' : ''; ?>>Without Warranty Column</option> 
					</select>
				</div>
			</div>
			<!--div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">MFT(Minimum Film Thickness):</label>
				<div class="col-sm-9">
					<input type="text" name="mft" placeholder="MFT(Minimum Film Thickness)" value="<?php echo $MailerArr['Mailer']['mft']; ?>" id="mft" class = "col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Warrenty Period:</label>
				<div class="col-sm-9">
					<input type="text" name="warranty_period" value="<?php echo $MailerArr['Mailer']['warranty_period']; ?>" placeholder="Warrenty Period" id="warranty_period" class = "col-xs-10 col-sm-8">
				</div>
			</div-->
			<!--div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Is Use Area:</label>
				<div class="col-sm-1">
					<input type="checkbox" name="use_area" <?php if($MailerArr['Mailer']['use_area'] == 1){ echo 'checked'; } ?> value="1" id="use_area" class = "col-xs-10 col-sm-8" onclick="checkornot()" style="margin-top: 12px;">
				</div>
			</div-->
			<?php
		
			if(!empty($product)){
				$i=1;
				$j=0;
				foreach($product as $products){
			?>
			<div class="form-group addsection" id="section_<?php echo $i; ?>">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
				<div class="col-sm-9" tabindex="0" aria-label="Product section; use left and right arrow keys to scroll">
				<table>
					<tbody>
						<tr><td colspan="5">
							<div class="frmSearch" style="position:relative;">
								<input class="newitem_<?php echo $i; ?>" type="text" style="width:100%;" name="title[<?php echo $i; ?>]" id="title_<?php echo $i; ?>"
									value="<?php echo $products[0]['title']; ?>"
									placeholder="enter title e,g Wet area or planter box"
									required
									onkeyup="onTitleSearch(<?php echo $i; ?>)"
									onkeydown="if(event.keyCode === 13){ event.preventDefault(); return false; }"
								>
								<div class="suggesstion-box" id="title-suggestion-box_<?php echo $i; ?>"></div>
							</div>
						</td></tr>
						<tr>
							<th></th>
							<th>Product Type</th>
							<th>Product</th>
							
							<th>MFT</th><th>Warranty Period</th>
						</tr>
						
						<?php
							$k=0;
							foreach($products as $key=>$pro){
						?>	
						<tr <?php if($k > 0){ ?> class="newitem_<?php echo $i; ?>" id="div_<?php echo $i; ?>_<?php echo $k; ?>" <?php } ?>>
							<td><input type="hidden" style="width:30px;" name="types[]" value="<?php echo $i; ?>"><input type="text" style="width:63px;" name="serial[]" value="<?php echo $pro['serial'];  ?>"></td>
							<td><input type="text" style="width:225px;" name="coverage[]" value="<?php echo $pro['coverage'];  ?>" id="coverage_<?php echo $i; ?>_<?php echo $key; ?>"></td>
							<td><div class="frmSearch"><input type="text" autocomplete="off" style="width:225px;" name="product[]" id="pro_<?php echo $i; ?>_<?php echo $key; ?>" value="<?php echo $pro['product'];  ?>" onkeyup="onkeyups(<?php echo $i; ?>,<?php echo $key; ?>)"><div id="suggesstion-box_<?php echo $i; ?>_<?php echo $key; ?>"></div></div></td>
							
							<td><input type="text" style="width:100px;" name="coverage_by_pack[]" value="<?php echo $pro['coverage_by_pack'];  ?>" id="coverage_by_pack_<?php echo $i; ?>_<?php echo $key; ?>"></td>
							<td><input type="text" style="width:100px;" name="Warranty[]" value="<?php echo $pro['Warranty'];  ?>" id="warranty_<?php echo $i; ?>_<?php echo $key; ?>"></td>
							<td>
								<?php if($k == 0){ ?> 
									<a href="javascript:void(0);" style="color:red;" onclick="removesection('<?php echo $i; ?>')">&nbsp;&nbsp; X </a>
								<?php }else if($k > 0){ ?>
									<a href="javascript:void(0);" style="color:red;" onclick="remove('<?php echo $i; ?>','<?php echo $k; ?>')">&nbsp;&nbsp; X </a>
								<?php } ?>
							</td>
						</tr>
						<?php $k++; } ?>
					</tbody>
				</table>
				<div id="addnew_<?php echo $i; ?>"></div>
				<a href="javascript:void(0);" class="btn btn-xs btn-primary" style="margin-top:10px;" onclick="addmore(<?php echo $i; ?>)"><i class="fa fa-plus"></i> Add More</a>
				</div>	
			</div>
			<?php $i++; } }?>
			<div id="addsection"></div>
			
			<div class="form-group" style="margin-top:40px;">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
				<div class="col-sm-9">
					<?php
					if(!empty($MailerArr['MailerComment'])){
						$m=1;				
						foreach($MailerArr['MailerComment'] as $MailerComments){
					?>			
					<table  class="commentdiv" id="commentdiv_<?php echo $m; ?>">
						<tr>	
							<th>Comments <?php echo $m; ?>.</th>							
							<th></th>							
						</tr>
						<tr>							
							<td><input type="text" style="width:400px;" name="comment[]" value="<?php echo $MailerComments['comment']; ?>"></td>
							<td><a href="javascript:void(0);" style="color:red;" onclick="commnetdivremove('<?php echo $m; ?>')">&nbsp;&nbsp; X </a></td>
						</tr>
					</table>
					<?php $m++; }}else{ ?>
						<table  class="commentdiv">
							<tr>	
								<th>Comments 1.</th>							
							</tr>
							<tr>							
								<td><input type="text" style="width:400px;" name="comment[]" value=""></td>
								
							</tr>
						</table>
					<?php } ?>
					<div id="addcommentnew"></div>
					<a href="javascript:void(0);" class="btn btn-xs btn-primary" style="margin-top:10px;" onclick="addmorecomment()"><i class="fa fa-plus"></i> Add More Comment</a>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
				<div class="col-sm-1">
					<a href="javascript:void(0);" class="btn btn-xs btn-primary" style="margin-top:10px;" onclick="addnewsection()"><i class="fa fa-plus"></i> Add Section</a>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="pdf_datasheet">PDF Datasheet:</label>
				<div class="col-sm-9">
					<input type="file" name="datasheet_pdf" id="datasheet_pdf" class="col-xs-10 col-sm-8" accept="application/pdf">
					<?php if (!empty($MailerArr['Mailer']['pdf_attachment'])): ?>
						<a href="<?php echo h($this->Pdf->url(ltrim((string)$MailerArr['Mailer']['pdf_attachment'], '/'))); ?>" target="_blank">View Existing PDF</a>
					<?php endif; ?>
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
	function addmorecomment(){
		var numItems = $('.commentdiv').length; 
		var newdiv = 	numItems + 1;
		//var dtserial = id+'.'+newdiv;	
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
			$("#suggesstion-box_"+id+"_"+newdiv+"").show();
			$("#suggesstion-box_"+id+"_"+newdiv+"").html(data);
			$("#pro_"+id+"_"+newdiv).css("background","#FFF");
		}
		});
	}
	function selectCountry(product,coverage,coverage_by_pack,Warranty,id,newdiv) {
		var normalizedProduct = (product || '').toString().toLowerCase().replace(/\s+/g, ' ').trim();
		var isWbeHiBuild = normalizedProduct.indexOf('wbe') !== -1 && normalizedProduct.indexOf('hi-build') !== -1;
		if (!isWbeHiBuild) {
			isWbeHiBuild = normalizedProduct.indexOf('wbe') !== -1 && normalizedProduct.indexOf('hi build') !== -1;
		}
		if (isWbeHiBuild) {
			coverage_by_pack = 'SC';
			Warranty = '10 years';
		}

		$("#pro_"+id+"_"+newdiv).val(product);
		$("#coverage_by_pack_"+id+"_"+newdiv).val(coverage_by_pack);
		$("#coverage_"+id+"_"+newdiv).val(coverage);
		$("#warranty_"+id+"_"+newdiv).val(Warranty);
		$("#suggesstion-box_"+id+"_"+newdiv+"").hide();
	}

	function addmore(id){
		var numItems = $('.newitem_'+id).length;		
		var newdiv = 	numItems + 1;
		var dtserial = id+'.'+newdiv;
			
		var addnew ='<table class="newitem_'+id+'"  id="div_'+id+'_'+newdiv+'"><tr><td><input type="hidden" style="width:30px;" name="types[]" value="'+id+'"><input type="text" style="width:63px;" name="serial[]" value="'+dtserial+'"></td><td><input type="text" style="width:225px;" name="coverage[]" value=""  id="coverage_'+id+'_'+newdiv+'"></td><td><div class="frmSearch"><input autocomplete="off" type="text" style="width:225px;" name="product[]" value="" id="pro_'+id+'_'+newdiv+'" onkeyup="onkeyups('+id+','+newdiv+')"><div id="suggesstion-box_'+id+'_'+newdiv+'"></div></div></td><td><input type="text" style="width:100px;" name="coverage_by_pack[]" value=""  id="coverage_by_pack_'+id+'_'+newdiv+'"></td><td><input type="text" style="width:100px;" name="Warranty[]" value=""  id="warranty_'+id+'_'+newdiv+'"></td><td><a href="javascript:void(0);" style="color:red;" onclick="remove('+id+','+newdiv+')">&nbsp;&nbsp; X </a></td></tr></table>';
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
	function setsubject(type_id){
		
		if(type_id == 1){
			$("#subject").val('DUROTECH: INSTALLATION OF DUROMASTIC P-15 WATERPROOFING MEMBRANE');
		}else if(type_id == 2){
			$("#subject").val('Durotech: Waterproofing Specification – Wet area shower');
		}else if(type_id == 3){
			$("#subject").val('Durotech: External Liquid WPM');
		}
	}	
	
	// ===== Title suggestions (title_list AJAX) =====
	function debounce(func, delay) {
		let timer;
		return function(...args) {
			clearTimeout(timer);
			timer = setTimeout(() => func.apply(this, args), delay);
		};
	}

	var titleSuggestMinChars = 3;
	var titleSuggestXhrById = {};
	var lastTitleKeywordById = {};

	function fetchTitleSuggestions(id) {
		var keyword = ($("#title_" + id).val() || '').trim();

		if (keyword.length < titleSuggestMinChars) {
			$("#title-suggestion-box_" + id).hide().html('');
			lastTitleKeywordById[id] = '';
			if (titleSuggestXhrById[id] && titleSuggestXhrById[id].readyState !== 4) {
				titleSuggestXhrById[id].abort();
			}
			titleSuggestXhrById[id] = null;
			return;
		}

		if (lastTitleKeywordById[id] === keyword) {
			return;
		}
		lastTitleKeywordById[id] = keyword;

		if (titleSuggestXhrById[id] && titleSuggestXhrById[id].readyState !== 4) {
			titleSuggestXhrById[id].abort();
		}

		titleSuggestXhrById[id] = $.ajax({
			type: "GET",
			url: "<?php echo rtrim(SITEURL, '/').'/admin/mailers/title_list' ?>/" + id,
			data: { keyword: keyword },
			success: function(data) {
				var suggestionBox = $("#title-suggestion-box_" + id);
				if (data.trim() !== '') {
					suggestionBox.show().html(data);
					$("#title_" + id).css("background", "#FFF");
				} else {
					suggestionBox.hide().html('');
				}
			}
		});
	}

	const debouncedFetchTitle = debounce(fetchTitleSuggestions, 500);

	function onTitleSearch(id) {
		debouncedFetchTitle(id);
	}

	function selectTitle(title, id) {
		$("#title_" + id).val(title);
		$("#title-suggestion-box_" + id).hide().html('');
	}
	
	jQuery(function(){ //short for $(document).ready(function(){

		$('.datepicker').datepicker({
			format: "dd/mm/yyyy",
			autoclose: true,
			todayHighlight: true
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
	function removesection(id){
		$("#section_"+id).remove();
	}
	function addnewsection(){
		var numItems = $('.addsection').length;		
		var newdiv = 	numItems + 1;
		var varhtml = '' +
			'<div class="form-group addsection" id="section_'+newdiv+'">' +
				'<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>' +
				'<div class="col-sm-9" tabindex="0" aria-label="Product section; use left and right arrow keys to scroll">' +
					'<table>' +
						'<tr>' +
							'<td colspan="5">' +
								'<div class="frmSearch" style="position:relative;">' +
									'<input type="text" style="width:100%;" name="title['+newdiv+']" id="title_'+newdiv+'" value="" placeholder="enter title e,g Wet area or planter box" required onkeyup="onTitleSearch('+newdiv+')" onkeydown="if(event.keyCode === 13){ event.preventDefault(); return false; }">' +
									'<div class="suggesstion-box" id="title-suggestion-box_'+newdiv+'"></div>' +
								'</div>' +
							'</td>' +
						'</tr>' +
						'<tr><th></th><th>Product Type</th><th>Product</th><th>MFT</th><th>Warranty Period</th></tr>' +
						'<tr><td><input type="hidden" style="width:30px;" name="types[]" value="'+newdiv+'"><input type="text" style="width:63px;" name="serial[]" value="'+newdiv+'"></td>' +
							'<td><input type="text" style="width:225px;" name="coverage[]" value="" id="coverage_'+newdiv+'_0"></td>' +
							'<td><div class="frmSearch"><input type="text" autocomplete="off" style="width:225px;" name="product[]" id="pro_'+newdiv+'_0" value="" onkeyup="onkeyups('+newdiv+',0)" ><div id="suggesstion-box_'+newdiv+'_0"></div></div></td>' +
							'<td><input type="text" style="width:100px;" name="coverage_by_pack[]" value="" id="coverage_by_pack_'+newdiv+'_0"></td>' +
							'<td><input type="text" style="width:100px;" name="Warranty[]" value="" id="warranty_'+newdiv+'_0"></td>' +
							'<td><a href="javascript:void(0);" style="color:red;" onclick="removesection('+newdiv+')">&nbsp;&nbsp; X </a></td>' +
						'</tr>' +
					'</table>' +
					'<div id="addnew_'+newdiv+'"></div>' +
					'<a href="javascript:void(0);" class="btn btn-xs btn-primary" style="margin-top:10px;" onclick="addmore('+newdiv+')"><i class="fa fa-plus"></i> Add More</a>' +
				'</div>' +
			'</div>';	
		
		$("#addsection").append(varhtml);	
	}
</script>