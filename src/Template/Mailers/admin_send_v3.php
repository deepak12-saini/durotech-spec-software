	<style>
	.frmSearch { }
	#country-list{float:left;list-style:none;margin-top:0px;padding:0;width:225px;position: absolute;z-index: 999;margin-left:0px; }
	#country-list li{padding: 10px; background: #e6fddd; border-bottom: #bbb9b9 1px solid; }
	#country-list li:hover{background:#ece3d2;cursor: pointer;}
	#search-box{padding: 10px;border: #a8d4b1 1px solid;border-radius:4px;}


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
	.spec-adaptive-help {
		display: block;
		clear: both;
		color: #2c6aa0;
		margin-top: 8px;
		font-size: 12px;
	}
	#spec-source-track {
		display: none;
		margin-left: 15px;
		color: #2c6aa0;
		font-weight: 600;
	}

	</style>	
	<div class="page-content">
		<div class="page-header">
		<div class="right_btn pull-right" ><a href="javascript:window.history.back();" class="btn btn-inverse" >Back</a></div>
		<h1>DuroEzy Specification v3 <small><i class="ace-icon fa fa-angle-double-right"></i>Create New Spec</small>
		</h1>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
		<?php
		$draftIdVal = isset($draftId) ? (int)$draftId : 0;
		$draftName = isset($draft) ? h($draft->name) : '';
		$draftCompany = isset($draft) ? h($draft->company) : '';
		$draftAddress = isset($draft) ? h($draft->address) : '';
		$draftSpec = isset($draft) ? h($draft->specification) : '';
		$draftEmail = isset($draft) ? h($draft->email) : '';
		$draftDate = isset($draft) && $draft->date ? format_db_date('d/m/Y', $draft->date) : date('d/m/Y');
		$draftType = isset($draft) ? (string)$draft->type : '3';
		$draftSubject = isset($draft) ? h($draft->subject) : 'Durotech: External Liquid WPM';
		$isAdaptiveMode = !empty($adaptiveMode);
		$draftSectionsJson = '[]';
		$draftCommentsJson = '[]';
		if (!empty($draft) && isset($draft->spec_useareas)) {
			$bySection = [];
			foreach ($draft->spec_useareas as $row) {
				$tid = (int)$row->types;
				if (!isset($bySection[$tid])) $bySection[$tid] = ['title' => $row->title ?? '', 'rows' => []];
				$bySection[$tid]['rows'][] = [
					'serial' => $row->serial ?? '',
					'coverage' => $row->coverage ?? '',
					'product' => $row->product ?? '',
					'coverage_by_pack' => $row->coverage_by_pack ?? '',
					'Warranty' => $row->Warranty ?? '',
				];
			}
			$draftSectionsJson = json_encode(array_values($bySection));
		}
		if (!empty($draft) && isset($draft->comments)) {
			$draftCommentsJson = json_encode(array_map(function ($c) { return $c->comment ?? ''; }, $draft->comments->toArray()));
		}
		?>
		<?php echo $this->Form->create('Mailer',array('class'=>'form-horizontal','enctype'=>'multipart/form-data','id'=>'specForm')); ?>
		<input type="hidden" name="draft_id" id="draft_id" value="<?php echo $draftIdVal; ?>">
		<div id="spec-draft-status" class="alert alert-info" style="margin-top:10px;margin-bottom:10px;">
			<strong>Status:</strong> <span id="spec-status-text"><?php echo !empty($draftId) ? 'Draft (restored)' : ($isAdaptiveMode ? 'New (Smart Spec mode)' : 'New'); ?></span>
			<span id="spec-last-saved" style="margin-left:15px;"></span>
			<span id="spec-source-track"></span>
			<?php if (!empty($draftId)): ?>
				<span style="margin-left:15px;"><?php echo $this->Html->link('Start New Spec (discard this draft)', ['controller' => 'Mailers', 'action' => 'admin_send_v3', '?' => ['discard_draft' => '1']], ['class' => 'btn btn-default btn-xs']); ?></span>
			<?php endif; ?>
		</div>
		<?php if ($isAdaptiveMode): ?>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="adaptive_previous_spec_id">Load Previous Spec:</label>
				<div class="col-sm-9">
					<select id="adaptive_previous_spec_id" class="col-xs-10 col-sm-8">
						<option value="">Select previous submitted spec...</option>
						<?php foreach (($previousSpecList ?? []) as $prev): ?>
							<?php
								$parts = [];
								$parts[] = (string)($prev->tracknumber ?? ('#' . (int)$prev->id));
								if (!empty($prev->company)) { $parts[] = (string)$prev->company; }
								if (!empty($prev->name)) { $parts[] = (string)$prev->name; }
								$optionLabel = implode(' | ', $parts);
							?>
							<option value="<?php echo (int)$prev->id; ?>"><?php echo h($optionLabel); ?></option>
						<?php endforeach; ?>
					</select>
					<p class="spec-adaptive-help">Loads previous submitted spec data into this form for faster creation.</p>
				</div>
			</div>
		<?php endif; ?>
		
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Track Number:</label>
				<div class="col-sm-9">
					<input type="text" name="tracknumber" value="<?php echo $refernce; ?>" readonly id="tracknumber" class = "col-xs-10 col-sm-8" style="background:#ddd !important; cursor:pointer;" >
				</div>
			</div>
		
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Name/Attn:</label>
				<div class="col-sm-9">
					<input type="text" name="name" value="<?php echo $draftName; ?>" id="name" class = "col-xs-10 col-sm-8">
				</div>
			</div>	
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Project:</label>
				<div class="col-sm-9">
					<input type="text" name="company" value="<?php echo $draftCompany; ?>"  class = "col-xs-10 col-sm-8">
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Address:</label>
				<div class="col-sm-9">
					<input type="text" name="address" value="<?php echo $draftAddress; ?>"  class = "col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Specification:</label>
				<div class="col-sm-9">
					<input type="text" name="specification" value="<?php echo $draftSpec; ?>"  class = "col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Email:</label>
				<div class="col-sm-9">
					<input type="text" name="email" value="<?php echo $draftEmail; ?>" id="email"  class = "col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Date:</label>
				<div class="col-sm-9">
					<input type="text" name="date" value="<?php echo $draftDate; ?>" id="date"  class = "datepicker col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Mailer Type:</label>
				<div class="col-sm-9">
					<select name="type" class="col-xs-10 col-sm-8"  onchange="setsubject(this.value)"  >
						<!-- <option value="">Select Client Requested</option> -->
						<!--option value="1">INSTALLATION OF DUROMASTIC P-15 WATERPROOFING MEMBRANE</option>
						<option value="2">Waterproofing Specification – Wet area shower</option-->
						<option value="3"<?php echo $draftType === '3' ? ' selected' : ''; ?>>External Liquid WPM</option> 
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Subject:</label>
				<div class="col-sm-9">
					<input type="text" name="subject" value="<?php echo $draftSubject; ?>" id="subject" class = "col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Spec Type:</label>
				<div class="col-sm-9">
					<select name="spectype" class="col-xs-10 col-sm-8">						
						<option value="1">With Warranty Column</option> 
						<option value="0">Without Warranty Column</option> 
					</select>
				</div>
			</div>
			<!--div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">MFT(Minimum Film Thickness):</label>
				<div class="col-sm-9">
					<input type="text" name="mft" placeholder="MFT(Minimum Film Thickness)" id="mft" class = "col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Warranty Period:</label>
				<div class="col-sm-9">
					<input type="text" name="warranty_period" placeholder="Warrenty Period" id="warranty_period" class = "col-xs-10 col-sm-8">
				</div>
			</div-->
			<!--div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Is Use Area:</label>
				<div class="col-sm-1">
					<input type="checkbox" name="use_area" value="1" id="use_area" class = "col-xs-10 col-sm-8" onclick="checkornot()" style="margin-top: 12px;">
				</div>
			</div-->
			
			
			<div id="addsection"></div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
				<div class="col-sm-1">
					<a href="javascript:void(0);" class="btn btn-xs btn-primary" style="margin-top:10px;" onclick="addnewsection()"><i class="fa fa-plus"></i> Add Section</a>
				</div>
			</div>
			<div id="newdiv"></div>
			
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
					<button type="submit" name="submit_spec" value="1" class="btn btn-mini btn-success" id="add_ser_prd_btn">Submit / Publish</button>&nbsp;
				
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
	var productSuggestMinChars = 3;
	var productSuggestXhrByKey = {};
	var lastProductKeywordByKey = {};
	var productSuggestTimerByKey = {};

	function onkeyups(id,newdiv){
		var fieldKey = id + '_' + newdiv;
		var keyword = ($("#pro_"+id+"_"+newdiv).val() || '').trim();
		if (productSuggestTimerByKey[fieldKey]) {
			clearTimeout(productSuggestTimerByKey[fieldKey]);
		}
		if (keyword.length < productSuggestMinChars) {
			$("#suggesstion-box_"+id+"_"+newdiv+"").hide().html('');
			lastProductKeywordByKey[fieldKey] = '';
			if (productSuggestXhrByKey[fieldKey] && productSuggestXhrByKey[fieldKey].readyState !== 4) {
				productSuggestXhrByKey[fieldKey].abort();
			}
			productSuggestXhrByKey[fieldKey] = null;
			return;
		}
		var csrfToken = $('input[name="_csrfToken"]').val() || '';
		productSuggestTimerByKey[fieldKey] = setTimeout(function() {
			if (lastProductKeywordByKey[fieldKey] === keyword) {
				return;
			}
			lastProductKeywordByKey[fieldKey] = keyword;
			if (productSuggestXhrByKey[fieldKey] && productSuggestXhrByKey[fieldKey].readyState !== 4) {
				productSuggestXhrByKey[fieldKey].abort();
			}
			productSuggestXhrByKey[fieldKey] = $.ajax({
				type: "POST",
				url: "<?php echo SITEURL.'admin/mailers/list' ?>/"+id+"/"+newdiv,
				data: {
					keyword: keyword,
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
		}, 500);
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
		$(".suggesstion-box").hide();
	}

	function addmore(id){
		var numItems = $('.newitem_'+id).length;		
		var newdiv = 	numItems + 1;
		var dtserial = id+'.'+newdiv;
				
		var addnew ='<table class="newitem_'+id+'"  id="div_'+id+'_'+newdiv+'"><tr><td><input type="hidden" style="width:30px;" name="types[]" value="'+id+'"><input type="text" style="width:63px;" name="serial[]" value="'+dtserial+'"></td><td><input type="text" style="width:225px;" name="coverage[]" value=""  id="coverage_'+id+'_'+newdiv+'"></td><td><div class="frmSearch"><input autocomplete="off" type="text" style="width:225px;" name="product[]" value="" id="pro_'+id+'_'+newdiv+'" onkeyup="onkeyups('+id+','+newdiv+')"><div class="suggesstion-box" id="suggesstion-box_'+id+'_'+newdiv+'"></div></div></td><td><input type="text" style="width:100px;" name="coverage_by_pack[]" value=""  id="coverage_by_pack_'+id+'_'+newdiv+'"></td><td><input type="text" style="width:100px;" name="Warranty[]" value=""  id="warranty_'+id+'_'+newdiv+'"></td><td><a href="javascript:void(0);" style="color:red;" onclick="remove('+id+','+newdiv+')">&nbsp;&nbsp; <i class="fa fa-times"></i> </a></td></tr></table>';
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
	function removesection(id){
		$("#section_"+id).remove();
	}


	function addnewsection() {
		var numItems = $('.addsection').length;
		var newdiv = numItems + 1;

		var varhtml = '' +
			'<div class="form-group addsection" id="section_' + newdiv + '">' +
				'<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>' +
				'<div class="col-sm-9">' +
					'<table>' +
						'<tr style="border-bottom: 15px solid #ffff;">' +
							'<td colspan="5">' +
								'<div class="frmSearch">' +
									'<input type="text" style="width:100%;" name="title[' + newdiv + ']" id="title_' + newdiv + '" ' +
									'value="" placeholder="enter title e.g. Wet area or planter box" ' +
									'onkeyup="onTitleSearch(' + newdiv + ')" required>' +
									'<div class="suggesstion-box" id="title-suggestion-box_' + newdiv + '"></div>' +
								'</div>' +
							'</td>' +
						'</tr>' +
						'<tr>' +
							'<th></th>' +
							'<th>Product Type</th>' +
							'<th>Product</th>' +
							'<th>MFT</th>' +
							'<th>Warranty Period</th>' +
						'</tr>' +
						'<tr>' +
							'<td>' +
								'<input type="hidden" style="width:30px;" name="types[]" value="' + newdiv + '">' +
								'<input type="text" style="width:63px;" name="serial[]" value="' + newdiv + '">' +
							'</td>' +
							'<td>' +
								'<input type="text" style="width:225px;" name="coverage[]" value="" id="coverage_' + newdiv + '_0">' +
							'</td>' +
							'<td>' +
								'<div class="frmSearch">' +
									'<input type="text" autocomplete="off" style="width:225px;" name="product[]" ' +
									'id="pro_' + newdiv + '_0" value="" onkeyup="onkeyups(' + newdiv + ',0)">' +
									'<div class="suggesstion-box" id="suggesstion-box_' + newdiv + '_0"></div>' +
								'</div>' +
							'</td>' +
							'<td>' +
								'<input type="text" style="width:100px;" name="coverage_by_pack[]" value="" id="coverage_by_pack_' + newdiv + '_0">' +
							'</td>' +
							'<td>' +
								'<input type="text" style="width:100px;" name="Warranty[]" value="" id="warranty_' + newdiv + '_0">' +
							'</td>' +
							'<td>' +
								'<a href="javascript:void(0);" style="color:red;" onclick="removesection(' + newdiv + ')" title="Remove" style="color: red; font-size: 22px;">&nbsp;&nbsp; <i class="fa fa-times"></i> </a>' +
							'</td>' +
						'</tr>' +
					'</table>' +
					'<div id="addnew_' + newdiv + '"></div>' +
					'<a href="javascript:void(0);" class="btn btn-xs btn-primary" style="margin-top:10px;" onclick="addmore(' + newdiv + ')" >' +
						'<i class="fa fa-plus"></i> Add More' +
					'</a>' +
				'</div>' +
			'</div>';

		$("#addsection").append(varhtml);
	}


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
		const keyword = ($("#title_" + id).val() || '').trim();
		
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
				const suggestionBox = $("#title-suggestion-box_" + id);
				if (data.trim() !== '') {
					suggestionBox.show().html(data);
					$("#title_" + id).css("background", "#FFF");
				} else {
					suggestionBox.hide().html('');
				}
			}
		});
	}

	// Debounce avoids request burst while user is typing.
	const debouncedFetch = debounce(fetchTitleSuggestions, 500);

	// Change your onTitleSearch to just call the debounced function
	function onTitleSearch(id) {
	  debouncedFetch(id);
	}

	function selectTitle(title, id) {
		$("#title_" + id).val(title);
		$("#title-suggestion-box_" + id).hide().html('');
	}
	function clearAllSectionsAndComments() {
		$('#addsection').empty();
		$('#addcommentnew').empty();
		$('.commentdiv input[name="comment[]"]').eq(0).val('');
	}
	function loadSectionsFromData(sections) {
		if (!sections || !sections.length) return;
		var secIdx, rowIdx, sec, rows, sectionId;
		for (secIdx = 0; secIdx < sections.length; secIdx++) {
			sec = sections[secIdx] || {};
			rows = sec.rows || [];
			if (!rows.length) continue;
			addnewsection();
			sectionId = $('.addsection').length;
			$('#title_' + sectionId).val(sec.title || '');
			$('#section_' + sectionId).find('input[name="serial[]"]').first().val(rows[0].serial || sectionId);
			$('#coverage_' + sectionId + '_0').val(rows[0].coverage || '');
			$('#pro_' + sectionId + '_0').val(rows[0].product || '');
			$('#coverage_by_pack_' + sectionId + '_0').val(rows[0].coverage_by_pack || '');
			$('#warranty_' + sectionId + '_0').val(rows[0].Warranty || '');
			for (rowIdx = 1; rowIdx < rows.length; rowIdx++) {
				addmore(sectionId);
				$('#section_' + sectionId).find('input[name="serial[]"]').last().val(rows[rowIdx].serial || (sectionId + '.' + rowIdx));
				$('#coverage_' + sectionId + '_' + rowIdx).val(rows[rowIdx].coverage || '');
				$('#pro_' + sectionId + '_' + rowIdx).val(rows[rowIdx].product || '');
				$('#coverage_by_pack_' + sectionId + '_' + rowIdx).val(rows[rowIdx].coverage_by_pack || '');
				$('#warranty_' + sectionId + '_' + rowIdx).val(rows[rowIdx].Warranty || '');
			}
		}
	}
	function loadCommentsFromData(comments) {
		if (!comments || !comments.length) return;
		$('.commentdiv input[name="comment[]"]').eq(0).val(comments[0] || '');
		for (var i = 1; i < comments.length; i++) {
			addmorecomment();
			$('.commentdiv input[name="comment[]"]').eq(i).val(comments[i] || '');
		}
	}

	// Draft auto-save every 45 seconds
	var specAutosaveInterval = 45000;
	var specAutosaveTimer = null;

	function specCollectFormData() {
		var form = document.getElementById('specForm');
		if (!form) return null;
		var fd = new FormData(form);
		fd.append('submit_spec', '0');
		return fd;
	}

	function specHasData() {
		return (
			$('#name').val().trim() !== '' ||
			$('input[name="company"]').val().trim() !== '' ||
			$('input[name="address"]').val().trim() !== '' ||
			$('input[name="specification"]').val().trim() !== '' ||
			$('#email').val().trim() !== ''
		);
	}

	function specDoAutosave() {
		if (!specHasData()) return;
		var fd = specCollectFormData();
		if (!fd) return;
		$.ajax({
			type: 'POST',
			url: '<?php echo SITEURL; ?>admin/mailers/spec-draft-autosave-v3',
			data: fd,
			processData: false,
			contentType: false,
			dataType: 'json',
			success: function(res) {
				if (res && res.success) {
					if (res.draft_id) {
						$('#draft_id').val(res.draft_id);
						$('#spec-status-text').text('Draft');
					}
					if (res.tracknumber) {
						$('#tracknumber').val(res.tracknumber);
					}
					var now = new Date();
					var timeStr = now.getHours() + ':' + (now.getMinutes() < 10 ? '0' : '') + now.getMinutes();
					$('#spec-last-saved').text('Last saved at ' + timeStr).css('color', '#333');
				}
			},
			error: function() {
				$('#spec-last-saved').text('(Save failed)').css('color', '#c00');
			}
		});
	}

	function specStartAutosave() {
		if (specAutosaveTimer) clearInterval(specAutosaveTimer);
		specAutosaveTimer = setInterval(specDoAutosave, specAutosaveInterval);
	}

	jQuery(function() {
		specStartAutosave();
		if ($('#draft_id').val() && parseInt($('#draft_id').val(), 10) > 0 && specHasData()) {
			specDoAutosave();
		}
		$('#specForm').on('submit', function() {
			var $btn = $('#add_ser_prd_btn');
			if ($btn.length) {
				$btn.prop('disabled', true).html('Submitting...');
			}
		});
	});

	// Restore draft product sections
	var draftSections = <?php echo $draftSectionsJson; ?>;
	if (draftSections && draftSections.length > 0) {
		jQuery(function() {
			var secIdx, rowIdx, sec, rows, sectionId;
			for (secIdx = 0; secIdx < draftSections.length; secIdx++) {
				sec = draftSections[secIdx];
				rows = sec.rows || [];
				if (rows.length === 0) continue;
				addnewsection();
				sectionId = $('.addsection').length;
				$('#title_' + sectionId).val(sec.title || '');
				$('#section_' + sectionId).find('input[name="serial[]"]').first().val(rows[0].serial || sectionId);
				$('#coverage_' + sectionId + '_0').val(rows[0].coverage || '');
				$('#pro_' + sectionId + '_0').val(rows[0].product || '');
				$('#coverage_by_pack_' + sectionId + '_0').val(rows[0].coverage_by_pack || '');
				$('#warranty_' + sectionId + '_0').val(rows[0].Warranty || '');

				for (rowIdx = 1; rowIdx < rows.length; rowIdx++) {
					addmore(sectionId);
					$('#section_' + sectionId).find('input[name="serial[]"]').last().val(rows[rowIdx].serial || (sectionId + '.' + rowIdx));
					$('#coverage_' + sectionId + '_' + rowIdx).val(rows[rowIdx].coverage || '');
					$('#pro_' + sectionId + '_' + rowIdx).val(rows[rowIdx].product || '');
					$('#coverage_by_pack_' + sectionId + '_' + rowIdx).val(rows[rowIdx].coverage_by_pack || '');
					$('#warranty_' + sectionId + '_' + rowIdx).val(rows[rowIdx].Warranty || '');
				}
			}
		});
	}

	// Restore draft comments
	var draftComments = <?php echo $draftCommentsJson; ?>;
	if (draftComments && draftComments.length > 0) {
		jQuery(function() {
			var i;
			$('.commentdiv input[name="comment[]"]').eq(0).val(draftComments[0] || '');
			for (i = 1; i < draftComments.length; i++) {
				addmorecomment();
				$('.commentdiv input[name="comment[]"]').eq(i).val(draftComments[i] || '');
			}
		});
	}

	<?php if ($isAdaptiveMode): ?>
	var adaptiveLoadBaseUrl = '<?php echo $this->Url->build(['controller' => 'Mailers', 'action' => 'adminPreviousSpecDataV3']); ?>';
	function adaptiveLoadSelectedSpec() {
		var selectedId = $('#adaptive_previous_spec_id').val();
		if (!selectedId) {
			$('#spec-source-track').hide().text('');
			$('#spec-status-text').text('New (Smart Spec mode)');
			return;
		}
		$.ajax({
			type: 'GET',
			url: adaptiveLoadBaseUrl.replace(/\/$/, '') + '/' + selectedId,
			dataType: 'json',
			success: function(res) {
				if (!res || !res.success || !res.data) {
					alert((res && res.error) ? res.error : 'Unable to load previous spec.');
					return;
				}
				var data = res.data;
				$('#name').val(data.name || '');
				$('input[name="company"]').val(data.company || '');
				$('input[name="address"]').val(data.address || '');
				$('input[name="specification"]').val(data.specification || '');
				$('#email').val(data.email || '');
				$('#subject').val(data.subject || '');
				$('select[name="type"]').val(data.type || '3');
				clearAllSectionsAndComments();
				loadSectionsFromData(data.sections || []);
				loadCommentsFromData(data.comments || []);
				$('#spec-status-text').text('Loaded from previous spec');
				var selectedText = $('#adaptive_previous_spec_id option:selected').text() || '';
				var sourceTrack = selectedText.split('|')[0].trim();
				if (sourceTrack) {
					$('#spec-source-track').text('Source: ' + sourceTrack).show();
				} else {
					$('#spec-source-track').hide().text('');
				}
			},
			error: function() {
				alert('Unable to load previous spec right now.');
			}
		});
	}
	$('#adaptive_previous_spec_id').on('change', adaptiveLoadSelectedSpec);
	<?php endif; ?>




</script>