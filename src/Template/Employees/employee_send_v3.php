	<style>
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

	/* Adaptive spec + form polish */
	.spec-adaptive-box {
		border: 1px solid #cfdff1;
		border-radius: 12px;
		background: linear-gradient(180deg, #f8fbff 0%, #eef5ff 100%);
		box-shadow: 0 6px 18px rgba(36, 92, 154, 0.08);
		padding: 12px 14px;
		transition: all 0.25s ease;
	}
	.spec-adaptive-box:hover {
		border-color: #7aa9e8;
		box-shadow: 0 10px 22px rgba(36, 92, 154, 0.14);
		transform: translateY(-1px);
	}
	.spec-adaptive-inline {
		display: flex;
		align-items: center;
		gap: 14px;
		flex-wrap: wrap;
	}
	.spec-adaptive-select {
		width: 100%;
		height: 42px;
		border: 1px solid #8fb4e6;
		border-radius: 10px;
		background: #ffffff;
		color: #1f4f86;
		font-weight: 600;
		padding: 8px 12px;
		transition: border-color .2s ease, box-shadow .2s ease;
	}
	.spec-adaptive-select:focus {
		border-color: #2f7bd7;
		box-shadow: 0 0 0 4px rgba(47, 123, 215, 0.18);
		outline: none;
	}
	#adaptive_previous_spec_id {
		width: 100%;
		-webkit-appearance: none;
		-moz-appearance: none;
		appearance: none;
	}
	.spec-adaptive-load-btn {
		min-width: 86px;
		height: 36px;
		border-radius: 6px;
		font-weight: 600;
	}
	.adaptive-load-label {
		height: 60px;
		display: flex;
		align-items: center;
		justify-content: center;
	}
	.adaptive-load-col {
		display: flex;
		align-items: center;
	}
	.spec-adaptive-help {
		display: block;
		clear: both;
		margin-top: 10px;
		margin-bottom: 0;
		color: #2f6cab;
		font-size: 12px;
		font-weight: 600;
	}
	#specForm input[type="text"],
	#specForm input[type="file"],
	#specForm select {
		border-radius: 6px !important;
		border: 1px solid #d2d9e6;
		transition: border-color .2s ease, box-shadow .2s ease, background-color .2s ease;
	}
	#specForm input[type="text"]:hover,
	#specForm select:hover {
		border-color: #b8c7df;
	}
	#specForm input[type="text"]:focus,
	#specForm select:focus {
		border-color: #4f88d3;
		box-shadow: 0 0 0 3px rgba(79, 136, 211, 0.12);
		outline: none;
	}
	#specForm .form-group {
		margin-bottom: 14px;
	}
	.spec-page-heading {
		display: flex;
		align-items: center;
		justify-content: space-between;
		gap: 15px;
	}
	.spec-page-heading h1 {
		margin: 0;
	}
	.spec-back-btn {
		border-radius: 4px;
		padding: 6px 16px;
	}
	@media (max-width: 767px) {
		.spec-page-heading {
			align-items: flex-start;
			flex-direction: column;
		}
	}
	.ui-datepicker{
		background:#fff;
		border:1px solid #cfd8e3;
		border-radius:8px;
		box-shadow:0 8px 24px rgba(0, 0, 0, 0.14);
		padding:10px;
		width:245px;
		z-index:9999 !important;
	}
	.ui-datepicker .ui-datepicker-header{
		background:#f5f8fc;
		border:0;
		border-radius:6px;
		color:#2f4d6b;
		font-weight:700;
		margin-bottom:8px;
		padding:7px 30px;
		position:relative;
		text-align:center;
	}
	.ui-datepicker .ui-datepicker-prev,
	.ui-datepicker .ui-datepicker-next{
		color:#2f80c9;
		cursor:pointer;
		font-size:0;
		height:24px;
		line-height:24px;
		position:absolute;
		text-align:center;
		top:5px;
		width:24px;
	}
	.ui-datepicker .ui-datepicker-prev{ left:6px; }
	.ui-datepicker .ui-datepicker-next{ right:6px; }
	.ui-datepicker .ui-datepicker-prev:before,
	.ui-datepicker .ui-datepicker-next:before{
		font-family:FontAwesome;
		font-size:13px;
		font-weight:normal;
	}
	.ui-datepicker .ui-datepicker-prev:before{ content:"\f053"; }
	.ui-datepicker .ui-datepicker-next:before{ content:"\f054"; }
	.ui-datepicker table{
		margin:0;
		width:100%;
	}
	.ui-datepicker th{
		color:#5d7186;
		font-size:12px;
		font-weight:700;
		padding:5px 0;
		text-align:center;
	}
	.ui-datepicker td{
		padding:2px;
	}
	.ui-datepicker td a,
	.ui-datepicker td span{
		border-radius:5px;
		color:#35475a;
		display:block;
		font-size:12px;
		padding:5px 0;
		text-align:center;
		text-decoration:none;
	}
	.ui-datepicker td a:hover{
		background:#eaf3ff;
		color:#2f80c9;
	}
	.ui-datepicker .ui-datepicker-today a{
		background:#eef5ff;
		color:#2f80c9;
		font-weight:700;
	}
	.ui-datepicker .ui-datepicker-current-day a{
		background:#428bca;
		color:#fff;
		font-weight:700;
	}
	.ui-datepicker .ui-state-disabled span{
		color:#b6c1cd;
	}

	</style>	
	<div class="page-content">
		<div class="page-header">
		<div class="spec-page-heading">
			<h1>DuroEzy Specification<small><i class="ace-icon fa fa-angle-double-right"></i>Create New Spec</small>
			</h1>
			<a href="javascript:window.history.back();" class="btn btn-inverse spec-back-btn">Back</a>
		</div>
		<div id="spec-draft-status" class="alert alert-info" style="margin-top:10px;margin-bottom:0;">
			<strong>Status:</strong> <span id="spec-status-text"><?php echo !empty($draftId) ? 'Draft (restored)' : (((string)$this->request->getQuery('mode') === 'adaptive') ? 'New (Smart Spec mode)' : ((((string)$this->request->getQuery('mode') === 'template') ? 'New (Template mode)' : 'New'))); ?></span>
			<span id="spec-source-track" style="margin-left:15px;display:none;color:#2a88c8;font-weight:600;"></span>
			<span id="spec-last-saved" style="margin-left:15px;"></span>
			<?php if (!empty($draftId)): ?>
				<span style="margin-left:15px;"><?php echo $this->Html->link('Start New Spec (discard this draft)', ['controller' => 'Employees', 'action' => 'employee_send_v3', '?' => ['discard_draft' => '1']], ['class' => 'btn btn-default btn-xs']); ?></span>
			<?php endif; ?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
		<?php
		$draftIdVal = isset($draftId) ? (int)$draftId : 0;
		$isAdaptiveMode = !empty($adaptiveMode);
		$isTemplateMode = !empty($templateMode);
		$previousSpecList = (isset($previousSpecs) && is_iterable($previousSpecs)) ? $previousSpecs : [];
		$templatePresetList = (isset($templatePresets) && is_iterable($templatePresets)) ? $templatePresets : [];
		$draftName = isset($draft) ? h($draft->name) : '';
		$draftCompany = isset($draft) ? h($draft->company) : '';
		$draftAddress = isset($draft) ? h($draft->address) : '';
		$draftSpec = isset($draft) ? h($draft->specification) : '';
		$draftEmail = isset($draft) ? h($draft->email) : '';
		$draftDate = isset($draft) && $draft->date ? format_db_date('d/m/Y', $draft->date) : date('d/m/Y');
		$draftType = isset($draft) ? (string)$draft->type : '3';
		$draftSubject = isset($draft) ? h($draft->subject) : 'Durotech: External Liquid WPM';
		$refernce = isset($refernce) ? $refernce : '';
		$draftSpectype = '1'; // not stored in DB, default
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
		<?php echo $this->Form->create('Employee',array('class'=>'form-horizontal','enctype'=>'multipart/form-data','id'=>'specForm')); ?>
			<input type="hidden" name="draft_id" id="draft_id" value="<?php echo $draftIdVal; ?>">
			<?php if ($isAdaptiveMode): ?>
			<?php
				$adaptiveSpecChoices = [];
				foreach ($previousSpecList as $prev) {
					$labelParts = [];
					$labelParts[] = (string)($prev->tracknumber ?? ('#' . (int)$prev->id));
					if (!empty($prev->company)) {
						$labelParts[] = (string)$prev->company;
					}
					if (!empty($prev->name)) {
						$labelParts[] = (string)$prev->name;
					}
					$isAdminTemplate = (int)($prev->admin_id ?? 0) > 0
						&& ((int)($prev->employee_id ?? 0) <= 0);
					if ($isAdminTemplate) {
						$labelParts[] = 'Admin template';
					}
					$label = implode(' | ', $labelParts);
					$searchHay = strtolower(
						(string)($prev->tracknumber ?? '') . ' '
						. (string)($prev->company ?? '') . ' '
						. (string)($prev->name ?? '') . ' '
						. (string)($prev->specification ?? '') . ' '
						. (int)$prev->id
					);
					$adaptiveSpecChoices[] = [
						'id' => (int)$prev->id,
						'label' => $label,
						'search' => $searchHay,
					];
				}
				$adaptiveYearNote = ((int)date('Y') - 1) . '–' . (int)date('Y');
			?>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right adaptive-load-label" for="adaptive_previous_spec_filter">Smart Spec (from Previous):</label>
				<div class="col-sm-9 adaptive-load-col">
					<div class="spec-adaptive-inline spec-adaptive-box">
						<div class="col-xs-12 col-sm-12" style="padding-left:0;margin-bottom:8px;">
							<input type="search" id="adaptive_previous_spec_filter" class="form-control input-sm" placeholder="Filter list (track #, company, name, id…)" autocomplete="off">
						</div>
						<div class="col-xs-12 col-sm-12" style="padding-left:0;">
							<select id="adaptive_previous_spec_id" class="col-xs-12 col-sm-12 spec-adaptive-select">
								<option value="">Select previous submitted spec...</option>
								<?php foreach ($adaptiveSpecChoices as $choice): ?>
									<option value="<?php echo (int)$choice['id']; ?>"><?php echo h($choice['label']); ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<p class="help-block spec-adaptive-help">Shows submitted specs from <strong><?php echo h($adaptiveYearNote); ?></strong> (your own + admin templates). Type in the box to narrow the list. Choosing a row loads it into this form.</p>
					</div>
				</div>
			</div>
			<script type="application/json" id="adaptive-spec-choices-data"><?php echo json_encode($adaptiveSpecChoices, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE); ?></script>
			<?php endif; ?>
			<?php /* Template Preset block hidden for now. Uncomment if client approves.
			<?php if ($isTemplateMode): ?>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right adaptive-load-label" for="template_preset_id">Load Template Preset:</label>
				<div class="col-sm-9 adaptive-load-col">
					<div class="spec-adaptive-inline spec-adaptive-box">
						<div class="col-xs-12 col-sm-12" style="padding-left:0;">
							<select id="template_preset_id" class="col-xs-12 col-sm-12 spec-adaptive-select">
								<option value="">Select template preset...</option>
								<?php foreach ($templatePresetList as $tpl): ?>
									<option value="<?php echo (int)$tpl->id; ?>"><?php echo h((string)($tpl->template_name ?? ('Template #' . (int)$tpl->id))); ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<p class="help-block spec-adaptive-help">Loads saved template preset into this form for faster creation.</p>
					</div>
				</div>
			</div>
			<?php endif; ?>
			*/ ?>
		
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
						<option value="1"<?php echo $draftSpectype === '1' ? ' selected' : ''; ?>>With Warranty Column</option> 
						<option value="0"<?php echo $draftSpectype === '0' ? ' selected' : ''; ?>>Without Warranty Column</option> 
					</select>
				</div>
			</div>
						
			
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
		if (!csrfToken) {
			var m = document.cookie.match(/(?:^|;\s*)csrfToken=([^;]+)/);
			csrfToken = m ? decodeURIComponent(m[1]) : '';
		}

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
				headers: { 'X-CSRF-Token': csrfToken },
				data:{
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
			message: "Please enter project"
		}); $("#subject").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter subject"
		});
	});
	function removesection(id){
		$("#section_"+id).remove();
	}


	var nextSectionId = 0;
	function getNextSectionId() {
		nextSectionId += 1;
		return nextSectionId;
	}

	function addnewsection() {
		var newdiv = getNextSectionId();

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
		return newdiv;
	}

function clearAllSectionsAndComments() {
	$('#addsection').empty();
	nextSectionId = 0;
	$('#addcommentnew').empty();
	$('.commentdiv input[name="comment[]"]').eq(0).val('');
}

function loadSectionsFromData(sections) {
	var secIdx, rowIdx, sec, rows, sectionId, $section;
	if (!sections || !sections.length) return;
	for (secIdx = 0; secIdx < sections.length; secIdx++) {
		sec = sections[secIdx] || {};
		rows = sec.rows || [];
		if (!rows.length) continue;
		sectionId = addnewsection();
		$('#title_' + sectionId).val(sec.title || '');
		$section = $('#section_' + sectionId);
		$section.find('input[name="serial[]"]').first().val(rows[0].serial || sectionId);
		$('#coverage_' + sectionId + '_0').val(rows[0].coverage || '');
		$('#pro_' + sectionId + '_0').val(rows[0].product || '');
		$('#coverage_by_pack_' + sectionId + '_0').val(rows[0].coverage_by_pack || '');
		$('#warranty_' + sectionId + '_0').val(rows[0].Warranty || '');
		for (rowIdx = 1; rowIdx < rows.length; rowIdx++) {
			addmore(sectionId);
			$section.find('input[name="serial[]"]').last().val(rows[rowIdx].serial || (sectionId + '.' + rowIdx));
			$('#coverage_' + sectionId + '_' + rowIdx).val(rows[rowIdx].coverage || '');
			$('#pro_' + sectionId + '_' + rowIdx).val(rows[rowIdx].product || '');
			$('#coverage_by_pack_' + sectionId + '_' + rowIdx).val(rows[rowIdx].coverage_by_pack || '');
			$('#warranty_' + sectionId + '_' + rowIdx).val(rows[rowIdx].Warranty || '');
		}
	}
}

function loadCommentsFromData(comments) {
	var i;
	if (!comments || !comments.length) return;
	$('.commentdiv input[name="comment[]"]').eq(0).val(comments[0] || '');
	for (i = 1; i < comments.length; i++) {
		addmorecomment();
		$('.commentdiv input[name="comment[]"]').eq(i).val(comments[i] || '');
	}
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
        //new condtition add for draft not save if no data
		if (!specHasData()) {
			console.log('No data, skip autosave');
			return;
		}
		//end new condition
		var form = document.getElementById('specForm');
		if (!form) return;
		var fd = specCollectFormData();
		if (!fd) return;

		$.ajax({
			type: 'POST',
			url: '<?php echo SITEURL; ?>employees/spec-draft-autosave',
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
		// Prevent double submit: disable button once form is submitted
		$('#specForm').on('submit', function() {
			var $btn = $('#add_ser_prd_btn');
			if ($btn.length) {
				$btn.prop('disabled', true).html('Submitting…');
			}
		});
	});

	<?php if ($isAdaptiveMode): ?>
	jQuery(function() {
		var adaptiveLoadBaseUrl = '<?php echo $this->Url->build(['controller' => 'Employees', 'action' => 'previousSpecData']); ?>';
		var adaptiveChoices = [];
		try {
			var raw = document.getElementById('adaptive-spec-choices-data');
			if (raw && raw.textContent) {
				adaptiveChoices = JSON.parse(raw.textContent);
			}
		} catch (e) {
			adaptiveChoices = [];
		}

		function adaptiveRebuildSelect(filterText) {
			var $sel = $('#adaptive_previous_spec_id');
			var prevVal = $sel.val();
			var q = (filterText || '').toLowerCase().trim();
			$sel.empty();
			$sel.append($('<option></option>').attr('value', '').text('Select previous submitted spec...'));
			for (var i = 0; i < adaptiveChoices.length; i++) {
				var row = adaptiveChoices[i];
				if (!q || (row.search && row.search.indexOf(q) !== -1) || (row.label && row.label.toLowerCase().indexOf(q) !== -1)) {
					$sel.append($('<option></option>').attr('value', row.id).text(row.label || ('#' + row.id)));
				}
			}
			if (prevVal && $sel.find('option[value="' + prevVal + '"]').length) {
				$sel.val(prevVal);
			} else {
				$sel.val('');
			}
		}

		$('#adaptive_previous_spec_filter').on('input', function() {
			adaptiveRebuildSelect($(this).val());
		});

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
					$('input[name="date"]').val(data.date || '');
					$('select[name="type"]').val(data.type || '3');
					$('#subject').val(data.subject || '');

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

		// Works on dropdown change (auto-fill immediately).
		$('#adaptive_previous_spec_id').on('change', adaptiveLoadSelectedSpec);
	});
	<?php endif; ?>

	<?php /* Template Preset script hidden for now. Uncomment if client approves.
	<?php if ($isTemplateMode): ?>
	jQuery(function() {
		var templateLoadBaseUrl = '<?php echo $this->Url->build(['controller' => 'Employees', 'action' => 'templatePresetData']); ?>';
		function loadTemplatePreset() {
			var selectedId = $('#template_preset_id').val();
			if (!selectedId) {
				$('#spec-source-track').hide().text('');
				$('#spec-status-text').text('New (Template mode)');
				return;
			}
			$.ajax({
				type: 'GET',
				url: templateLoadBaseUrl.replace(/\/$/, '') + '/' + selectedId,
				dataType: 'json',
				success: function(res) {
					if (!res || !res.success || !res.data) {
						alert((res && res.error) ? res.error : 'Unable to load template.');
						return;
					}
					var data = res.data;
					$('select[name="type"]').val(data.type || '3');
					$('#subject').val(data.subject || '');
					$('input[name="specification"]').val(data.specification || '');
					clearAllSectionsAndComments();
					loadSectionsFromData(data.sections || []);
					loadCommentsFromData(data.comments || []);
					$('#spec-status-text').text('Loaded from template preset');
					var sourceLabel = $('#template_preset_id option:selected').text() || '';
					if (sourceLabel) {
						$('#spec-source-track').text('Source: ' + sourceLabel).show();
					} else {
						$('#spec-source-track').hide().text('');
					}
				},
				error: function() {
					alert('Unable to load template right now.');
				}
			});
		}

		$('#template_preset_id').on('change', loadTemplatePreset);
		var preselectedTemplateId = '<?php echo (int)$this->request->getQuery('preset_id'); ?>';
		if (preselectedTemplateId) {
			$('#template_preset_id').val(preselectedTemplateId).trigger('change');
		}
	});
	<?php endif; ?>
	*/ ?>

	// Restore draft product sections (title + Product Type, Product, MFT, Warranty rows)
	var draftSections = <?php echo $draftSectionsJson; ?>;
	if (draftSections && draftSections.length > 0) {
		jQuery(function() {
			loadSectionsFromData(draftSections);
		});
	}

	// Restore draft comments
	var draftComments = <?php echo $draftCommentsJson; ?>;
	if (draftComments && draftComments.length > 0) {
		jQuery(function() {
			loadCommentsFromData(draftComments);
		});
	}

</script>