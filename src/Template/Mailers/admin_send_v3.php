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
	.spec-combo-panel { position: relative; z-index: 20; overflow: visible; }
	.spec-combo-wrap { position: relative; width: 100%; max-width: 640px; z-index: 30; overflow: visible; }
	.spec-combo-input { width: 100% !important; height: 34px; padding: 4px 28px 4px 10px !important; background: #fff !important; }
	.spec-combo-caret { position: absolute; right: 10px; top: 9px; color: #888; pointer-events: none; z-index: 2; }
	ul.spec-combo-list,
	.spec-combo-list {
		display: none;
		position: absolute !important;
		top: 100% !important;
		left: 0 !important;
		width: 100% !important;
		max-width: 640px;
		max-height: 260px;
		overflow-x: hidden;
		overflow-y: auto;
		margin: 2px 0 0 0 !important;
		padding: 0 !important;
		list-style: none !important;
		background: #ffffff !important;
		border: 1px solid #abbac3 !important;
		border-radius: 4px;
		box-shadow: 0 8px 20px rgba(0,0,0,0.18);
		z-index: 9999 !important;
		float: none !important;
	}
	ul.spec-combo-list > li,
	.spec-combo-list > li {
		display: block !important;
		float: none !important;
		width: 100% !important;
		height: auto !important;
		min-height: 0 !important;
		margin: 0 !important;
		padding: 9px 12px !important;
		line-height: 1.35 !important;
		cursor: pointer;
		border: 0 !important;
		border-bottom: 1px solid #e8eef5 !important;
		font-size: 12px !important;
		font-weight: 500 !important;
		color: #334155 !important;
		background: #ffffff !important;
		white-space: normal;
		word-break: break-word;
		list-style: none !important;
	}
	ul.spec-combo-list > li:last-child,
	.spec-combo-list > li:last-child { border-bottom: 0 !important; }
	ul.spec-combo-list > li:hover,
	ul.spec-combo-list > li.active-suggest,
	.spec-combo-list > li:hover,
	.spec-combo-list > li.active-suggest { background: #e8f2fc !important; color: #1e3a5f !important; }
	ul.spec-combo-list > li.empty,
	.spec-combo-list > li.empty { color: #94a3b8 !important; cursor: default !important; background: #f8fafc !important; }
	.spec-load-scope { display: inline-flex; gap: 6px; margin-top: 8px; flex-wrap: wrap; position: relative; z-index: 1; }
	.spec-load-scope label { margin: 0; font-weight: 600; font-size: 12px; padding: 4px 10px; border: 1px solid #c5d4e4; border-radius: 12px; background: #fff; cursor: pointer; }
	.spec-load-scope input { margin: 0 4px 0 0; }
	.spec-load-scope label.active-scope { background: #428bca; border-color: #428bca; color: #fff; }
	#country-list li.active-suggest, .title-dropdown li.active-suggest { background: #cfe6ff !important; }

	</style>
	<?php echo $this->element('spec_form_ui_styles'); ?>
	<div class="page-content spec-ui-page">
		<div class="page-header" style="display:none;"></div>
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
		$isCloneMode = !empty($cloneMode);
		$cloneFromIdVal = isset($cloneFromId) ? (int)$cloneFromId : 0;
		$statusLabel = 'New';
		if (!empty($draftId)) {
			$statusLabel = 'Draft (restored)';
		} elseif ($isAdaptiveMode) {
			$statusLabel = 'New (Smart Spec mode)';
		} elseif ($isCloneMode) {
			$statusLabel = 'New (Clone mode — Use Area only)';
		}
		$draftSectionsJson = '[]';
		$draftCommentsJson = '[]';
		if (!empty($draft)) {
			$useAreaRows = [];
			if (isset($draft->spec_useareas)) {
				foreach ($draft->spec_useareas as $row) {
					$useAreaRows[] = $row;
				}
			}
			$bySection = [];
			foreach ($useAreaRows as $row) {
				$tid = (string)($row->types ?? '');
				if ($tid === '') {
					$tid = 'sec_' . (count($bySection) + 1);
				}
				if (!isset($bySection[$tid])) {
					$bySection[$tid] = ['title' => $row->title ?? '', 'rows' => []];
				}
				$bySection[$tid]['rows'][] = [
					'serial' => $row->serial ?? '',
					'coverage' => $row->coverage ?? '',
					'product' => $row->product ?? '',
					'coverage_by_pack' => $row->coverage_by_pack ?? '',
					'Warranty' => $row->Warranty ?? '',
				];
			}
			$encodedSections = json_encode(array_values($bySection), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE);
			$draftSectionsJson = ($encodedSections !== false) ? $encodedSections : '[]';

			$commentList = [];
			if (isset($draft->comments)) {
				foreach ($draft->comments as $c) {
					$text = trim((string)($c->comment ?? ''));
					if ($text !== '') {
						$commentList[] = $text;
					}
				}
			}
			if (empty($commentList) && isset($draft->mailer_comment)) {
				foreach ($draft->mailer_comment as $c) {
					$text = trim((string)($c->comment ?? ''));
					if ($text !== '') {
						$commentList[] = $text;
					}
				}
			}
			$encodedComments = json_encode($commentList, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE);
			$draftCommentsJson = ($encodedComments !== false) ? $encodedComments : '[]';
		}
		?>
		<div class="spec-ui-shell">
			<div class="spec-ui-head">
				<h1>
					DuroEzy Specification v3
					<small><i class="ace-icon fa fa-angle-double-right"></i>
					<?php if (!empty($isCloneMode)): ?>
						<?php echo $this->Html->image('clone_a_spec.png', ['alt' => '', 'style' => 'width:18px;height:18px;vertical-align:middle;margin:0 4px;background:#1b1b1b;border-radius:50%;padding:2px;box-sizing:content-box;']); ?>
						Clone a Spec
					<?php else: ?>
						Create New Spec
					<?php endif; ?>
					</small>
				</h1>
				<a href="javascript:window.history.back();" class="btn btn-inverse">Back</a>
			</div>
			<div id="spec-draft-status" class="spec-ui-status">
				<span class="status-pill"><i class="fa fa-circle" style="font-size:8px;"></i> <span id="spec-status-text"><?php echo h($statusLabel); ?></span></span>
				<span id="spec-source-track" style="display:none;color:#2a88c8;font-weight:600;"></span>
				<span id="spec-last-saved"></span>
				<?php if (!empty($draftId)): ?>
					<?php echo $this->Html->link('Start New Spec (discard this draft)', ['controller' => 'Mailers', 'action' => 'admin_send_v3', '?' => ['discard_draft' => '1']], ['class' => 'btn btn-default btn-xs']); ?>
				<?php endif; ?>
			</div>
			<div class="spec-ui-body">
		<?php echo $this->Form->create('Mailer',array('class'=>'form-horizontal spec-ui-form','enctype'=>'multipart/form-data','id'=>'specForm')); ?>
		<input type="hidden" name="draft_id" id="draft_id" value="<?php echo $draftIdVal; ?>">
		<?php if ($isAdaptiveMode): ?>
			<?php
				$adminAdaptiveChoices = [];
				foreach (($previousSpecList ?? []) as $prev) {
					$parts = [];
					$parts[] = (string)($prev->tracknumber ?? ('#' . (int)$prev->id));
					if (!empty($prev->company)) { $parts[] = (string)$prev->company; }
					if (!empty($prev->name)) { $parts[] = (string)$prev->name; }
					$label = implode(' | ', $parts);
					$adminAdaptiveChoices[] = [
						'id' => (int)$prev->id,
						'label' => $label,
						'search' => strtolower($label . ' ' . (int)$prev->id),
						'source' => 'spec',
					];
				}
			?>
			<div class="spec-ui-card" style="z-index:40;">
				<div class="spec-ui-card-title"><span>Smart Spec</span><span class="hint">Load Use Area from a previous job</span></div>
				<div class="spec-ui-card-body">
			<div class="form-group" style="position:relative;z-index:40;overflow:visible;margin-bottom:0 !important;">
				<label class="col-sm-3 control-label no-padding-right" for="adaptive_combo_input">Search:</label>
				<div class="col-sm-9" style="overflow:visible;">
					<div class="spec-combo-panel" style="display:block;border:0;box-shadow:none;background:transparent;padding:0;">
					<div class="spec-combo-wrap">
						<input type="text" id="adaptive_combo_input" class="form-control input-sm spec-combo-input" placeholder="Type to search previous specs…" autocomplete="off">
						<i class="fa fa-caret-down spec-combo-caret"></i>
						<ul id="adaptive_combo_list" class="spec-combo-list" role="listbox"></ul>
						<input type="hidden" id="adaptive_previous_spec_id" value="">
					</div>
					<div class="spec-load-scope" id="adaptive_load_scope">
						<label class="active-scope"><input type="radio" name="adaptive_scope" value="use_area" checked> Use Area only</label>
						<label><input type="radio" name="adaptive_scope" value="full"> Full spec</label>
					</div>
					<p class="help-block spec-adaptive-help"><strong>Use Area only</strong> keeps client details blank; <strong>Full spec</strong> also copies Name/Project/Address/Email.</p>
					</div>
				</div>
			</div>
				</div>
			</div>
			<script type="application/json" id="adaptive-spec-choices-data"><?php echo json_encode($adminAdaptiveChoices, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE); ?></script>
		<?php endif; ?>

		<?php if (!empty($isCloneMode) && $cloneFromIdVal <= 0): ?>
		<?php
			$cloneSpecChoices = [];
			foreach (($previousSpecList ?? []) as $prev) {
				$parts = [];
				$parts[] = (string)($prev->tracknumber ?? ('#' . (int)$prev->id));
				if (!empty($prev->company)) { $parts[] = (string)$prev->company; }
				if (!empty($prev->name)) { $parts[] = (string)$prev->name; }
				$label = implode(' | ', $parts);
				$cloneSpecChoices[] = [
					'id' => (int)$prev->id,
					'label' => $label,
					'search' => strtolower($label . ' ' . (int)$prev->id),
					'source' => 'spec',
				];
			}
		?>
			<div class="spec-ui-card" style="z-index:40;">
				<div class="spec-ui-card-title">
					<span>
						<?php echo $this->Html->image('clone_a_spec.png', ['alt' => '', 'style' => 'width:22px;height:22px;vertical-align:middle;margin-right:6px;background:#1b1b1b;border-radius:50%;padding:2px;box-sizing:content-box;']); ?>
						Clone a Spec
					</span>
					<span class="hint">Pick a submitted spec — Use Area + comments only</span>
				</div>
				<div class="spec-ui-card-body">
			<div class="form-group" style="position:relative;z-index:40;overflow:visible;margin-bottom:0 !important;">
				<label class="col-sm-3 control-label no-padding-right" for="clone_combo_input">Search:</label>
				<div class="col-sm-9" style="overflow:visible;">
					<div class="spec-combo-panel" style="display:block;border:0;box-shadow:none;background:transparent;padding:0;">
						<div class="spec-combo-wrap">
							<input type="text" id="clone_combo_input" class="form-control input-sm spec-combo-input" placeholder="Type to search your specs…" autocomplete="off">
							<i class="fa fa-caret-down spec-combo-caret"></i>
							<ul id="clone_combo_list" class="spec-combo-list" role="listbox"></ul>
							<input type="hidden" id="clone_previous_spec_id" value="">
						</div>
						<p class="help-block spec-adaptive-help">Copies Use Area + comments only. Client Name/Project/Address/Email stay blank for the new job.</p>
					</div>
				</div>
			</div>
				</div>
			</div>
			<script type="application/json" id="clone-spec-choices-data"><?php echo json_encode($cloneSpecChoices, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE); ?></script>
		<?php endif; ?>
		
						<div class="spec-ui-card">
				<div class="spec-ui-card-title"><span>Client details</span><span class="hint">Who this spec is for</span></div>
				<div class="spec-ui-card-body">
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
				</div>
			</div>

			<div class="spec-ui-card">
				<div class="spec-ui-card-title"><span>Spec options</span><span class="hint">Type and warranty column</span></div>
				<div class="spec-ui-card-body">
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
				</div>
			</div>

			<div class="spec-ui-card">
				<div class="spec-ui-card-title"><span>Use Area</span><span class="hint">Sections and products</span></div>
				<div class="spec-ui-card-body">
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
			
				</div>
			</div>

			<div class="spec-ui-card">
				<div class="spec-ui-card-title"><span>Comments</span><span class="hint">Optional notes on the PDF</span></div>
				<div class="spec-ui-card-body">
			<div class="form-group" style="margin-top:0;">
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

				</div>
			</div>

			<div class="form-group spec-ui-actions">
				<div class="col-md-offset-3 col-md-9">
					<button type="submit" name="submit_spec" value="1" class="btn btn-mini btn-success" id="add_ser_prd_btn">Submit / Publish</button>&nbsp;
				</div>
			</div>
			<?php echo $this->Form->end(); ?>
			</div><!-- .spec-ui-body -->
		</div><!-- .spec-ui-shell -->
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
	var productSuggestMinChars = 2;
	var productSuggestDebounceMs = 220;
	var productSuggestXhrByKey = {};
	var lastProductKeywordByKey = {};
	var productSuggestTimerByKey = {};
	var productSuggestActiveIndex = {};

	function highlightSuggestItems($box, index) {
		var $items = $box.find('li').not('.empty');
		$items.removeClass('active-suggest');
		if (!$items.length) return;
		if (index < 0) index = $items.length - 1;
		if (index >= $items.length) index = 0;
		$items.eq(index).addClass('active-suggest');
		productSuggestActiveIndex[$box.attr('id')] = index;
	}

	function onkeyups(id,newdiv){
		var fieldKey = id + '_' + newdiv;
		var $input = $("#pro_"+id+"_"+newdiv);
		var $box = $("#suggesstion-box_"+id+"_"+newdiv);
		var keyword = ($input.val() || '').trim();
		if (productSuggestTimerByKey[fieldKey]) {
			clearTimeout(productSuggestTimerByKey[fieldKey]);
		}
		if (keyword.length < productSuggestMinChars) {
			$box.hide().html('');
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
				success: function(data){
					if(data != ''){
						$box.show().html(data);
						$input.css("background","#FFF");
						productSuggestActiveIndex[$box.attr('id')] = -1;
					}else{
						$box.hide().html('');
						$input.css("background","#FFF");
					}
				}
			});
		}, productSuggestDebounceMs);
	}

	$(document).on('keydown', 'input[name="product[]"]', function(e) {
		var $input = $(this);
		var idMatch = ($input.attr('id') || '').match(/^pro_(\d+)_(\d+)$/);
		if (!idMatch) return;
		var boxId = 'suggesstion-box_' + idMatch[1] + '_' + idMatch[2];
		var $box = $('#' + boxId);
		if (!$box.is(':visible')) return;
		var $items = $box.find('li').not('.empty');
		if (!$items.length) return;
		var idx = productSuggestActiveIndex[boxId];
		if (typeof idx !== 'number') idx = -1;
		if (e.key === 'ArrowDown') {
			e.preventDefault();
			highlightSuggestItems($box, idx + 1);
		} else if (e.key === 'ArrowUp') {
			e.preventDefault();
			highlightSuggestItems($box, idx - 1);
		} else if (e.key === 'Enter' || e.key === 'Tab') {
			var $active = $items.filter('.active-suggest').first();
			if (!$active.length) $active = $items.first();
			if ($active.length) {
				e.preventDefault();
				$active.trigger('click');
			}
		} else if (e.key === 'Escape') {
			$box.hide();
		}
	});
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

	var titleSuggestMinChars = 2;
	var titleSuggestXhrById = {};
	var lastTitleKeywordById = {};
	var titleSuggestActiveIndex = {};

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
					titleSuggestActiveIndex[id] = -1;
				} else {
					suggestionBox.hide().html('');
				}
			}
		});
	}

	// Debounce avoids request burst while user is typing.
	const debouncedFetch = debounce(fetchTitleSuggestions, 220);

	// Change your onTitleSearch to just call the debounced function
	function onTitleSearch(id) {
	  debouncedFetch(id);
	}

	function selectTitle(title, id) {
		$("#title_" + id).val(title);
		$("#title-suggestion-box_" + id).hide().html('');
	}

	$(document).on('keydown', 'input[id^="title_"]', function(e) {
		var $input = $(this);
		var idMatch = ($input.attr('id') || '').match(/^title_(\d+)$/);
		if (!idMatch) return;
		var id = idMatch[1];
		var $box = $('#title-suggestion-box_' + id);
		if (!$box.is(':visible')) return;
		var $items = $box.find('li').not('.empty');
		if (!$items.length) return;
		var idx = titleSuggestActiveIndex[id];
		if (typeof idx !== 'number') idx = -1;
		if (e.key === 'ArrowDown') {
			e.preventDefault();
			$items.removeClass('active-suggest');
			idx = idx + 1;
			if (idx >= $items.length) idx = 0;
			$items.eq(idx).addClass('active-suggest');
			titleSuggestActiveIndex[id] = idx;
		} else if (e.key === 'ArrowUp') {
			e.preventDefault();
			$items.removeClass('active-suggest');
			idx = idx - 1;
			if (idx < 0) idx = $items.length - 1;
			$items.eq(idx).addClass('active-suggest');
			titleSuggestActiveIndex[id] = idx;
		} else if (e.key === 'Enter' || e.key === 'Tab') {
			var $active = $items.filter('.active-suggest').first();
			if (!$active.length) $active = $items.first();
			if ($active.length) {
				e.preventDefault();
				$active.trigger('click');
			}
		} else if (e.key === 'Escape') {
			$box.hide();
		}
	});
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
		$('#specForm').on('submit', function() {
			var $btn = $('#add_ser_prd_btn');
			if ($btn.length) {
				$btn.prop('disabled', true).html('Submitting...');
			}
		});
	});

	// Restore draft product sections + comments, then sync track (never autosave before restore).
	var draftSections = <?php echo $draftSectionsJson; ?>;
	var draftComments = <?php echo $draftCommentsJson; ?>;
	jQuery(function() {
		if (draftSections && draftSections.length > 0 && typeof loadSectionsFromData === 'function') {
			loadSectionsFromData(draftSections);
		}
		if (draftComments && draftComments.length > 0 && typeof loadCommentsFromData === 'function') {
			loadCommentsFromData(draftComments);
		}
		var isBlankCreate = <?php echo (!empty($draftId) || $isAdaptiveMode || !empty($isCloneMode)) ? 'false' : 'true'; ?>;
		if (isBlankCreate && $('#addsection').children().length === 0) {
			addnewsection();
		}
		// Delay track sync so restored product/comment inputs are included in FormData.
		setTimeout(function() {
			if ($('#draft_id').val() && parseInt($('#draft_id').val(), 10) > 0 && specHasData()) {
				specDoAutosave();
			}
		}, 300);
	});

	function applyLoadedSpec(data, scope) {
		scope = scope || 'use_area';
		if (scope === 'full') {
			$('#name').val(data.name || '');
			$('input[name="company"]').val(data.company || '');
			$('input[name="address"]').val(data.address || '');
			$('input[name="specification"]').val(data.specification || '');
			$('#email').val(data.email || '');
			$('#subject').val(data.subject || '');
			$('select[name="type"]').val(data.type || '3');
		}
		clearAllSectionsAndComments();
		loadSectionsFromData(data.sections || []);
		loadCommentsFromData(data.comments || []);
	}

	function initSpecCombobox(opts) {
		var $input = $(opts.input);
		var $list = $(opts.list);
		var $hidden = $(opts.hidden);
		var choices = opts.choices || [];
		var onSelect = opts.onSelect || function() {};
		var activeIdx = -1;
		function render(filterText) {
			var q = (filterText || '').toLowerCase().trim();
			$list.empty();
			var shown = 0;
			for (var i = 0; i < choices.length; i++) {
				var row = choices[i];
				if (!q || (row.search && row.search.indexOf(q) !== -1) || (row.label && row.label.toLowerCase().indexOf(q) !== -1)) {
					$list.append($('<li></li>').attr('data-id', row.id).text(row.label || ('#' + row.id)));
					shown++;
				}
			}
			if (!shown) $list.append($('<li class="empty"></li>').text('No matches'));
			activeIdx = -1;
			$list.show();
		}
		function pick($li) {
			if (!$li.length || $li.hasClass('empty')) return;
			$hidden.val($li.attr('data-id'));
			$input.val($li.text());
			$list.hide();
			onSelect($li.attr('data-id'));
		}
		$input.on('focus click', function() { render($input.val()); });
		$input.on('input', function() { $hidden.val(''); render($input.val()); });
		$input.on('keydown', function(e) {
			var $items = $list.find('li').not('.empty');
			if (!$list.is(':visible')) { if (e.key === 'ArrowDown') { render($input.val()); } return; }
			if (e.key === 'ArrowDown') { e.preventDefault(); activeIdx = Math.min(activeIdx + 1, $items.length - 1); $items.removeClass('active-suggest'); $items.eq(activeIdx).addClass('active-suggest'); }
			else if (e.key === 'ArrowUp') { e.preventDefault(); activeIdx = Math.max(activeIdx - 1, 0); $items.removeClass('active-suggest'); $items.eq(activeIdx).addClass('active-suggest'); }
			else if (e.key === 'Enter') { e.preventDefault(); var $a = $items.filter('.active-suggest').first(); if (!$a.length) $a = $items.first(); pick($a); }
			else if (e.key === 'Escape') { $list.hide(); }
		});
		$list.on('mousedown', 'li', function(e) { e.preventDefault(); pick($(this)); });
		$(document).on('click.adminspeccombo', function(e) { if (!$(e.target).closest($input.parent()).length) $list.hide(); });
	}

	<?php if ($isAdaptiveMode): ?>
	jQuery(function() {
		var adaptiveLoadBaseUrl = '<?php echo $this->Url->build(['controller' => 'Mailers', 'action' => 'adminPreviousSpecDataV3']); ?>';
		var adaptiveChoices = [];
		try {
			var raw = document.getElementById('adaptive-spec-choices-data');
			if (raw && raw.textContent) adaptiveChoices = JSON.parse(raw.textContent);
		} catch (e) { adaptiveChoices = []; }

		function getAdaptiveScope() {
			return $('input[name="adaptive_scope"]:checked').val() || 'use_area';
		}
		function syncScopeLabels() {
			$('#adaptive_load_scope label').removeClass('active-scope');
			$('#adaptive_load_scope input:checked').closest('label').addClass('active-scope');
		}
		syncScopeLabels();
		$('#adaptive_load_scope input').on('change', function() {
			syncScopeLabels();
			if ($('#adaptive_previous_spec_id').val()) adaptiveLoadSelectedSpec();
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
					var scope = getAdaptiveScope();
					applyLoadedSpec(res.data, scope);
					$('#spec-status-text').text(scope === 'full' ? 'Loaded full previous spec' : 'Loaded Use Area from previous spec');
					var sourceTrack = ($('#adaptive_combo_input').val() || '').split('|')[0].trim();
					if (sourceTrack) $('#spec-source-track').text('Source: ' + sourceTrack).show();
					else $('#spec-source-track').hide().text('');
				},
				error: function() { alert('Unable to load previous spec right now.'); }
			});
		}

		initSpecCombobox({
			input: '#adaptive_combo_input',
			list: '#adaptive_combo_list',
			hidden: '#adaptive_previous_spec_id',
			choices: adaptiveChoices,
			onSelect: function() { adaptiveLoadSelectedSpec(); }
		});
	});
	<?php endif; ?>

	<?php if (!empty($isCloneMode) && $cloneFromIdVal > 0): ?>
	jQuery(function() {
		var cloneLoadUrl = '<?php echo $this->Url->build(['controller' => 'Mailers', 'action' => 'adminPreviousSpecDataV3', $cloneFromIdVal]); ?>';
		$.ajax({
			type: 'GET',
			url: cloneLoadUrl,
			dataType: 'json',
			success: function(res) {
				if (!res || !res.success || !res.data) {
					alert((res && res.error) ? res.error : 'Unable to clone spec.');
					return;
				}
				applyLoadedSpec(res.data, 'use_area');
				$('#spec-status-text').text('Cloned Use Area + comments (new client details)');
				$('#spec-source-track').text('Cloned from #<?php echo (int)$cloneFromIdVal; ?>').show();
			},
			error: function() { alert('Unable to clone spec right now.'); }
		});
	});
	<?php elseif (!empty($isCloneMode)): ?>
	jQuery(function() {
		var cloneLoadBaseUrl = '<?php echo $this->Url->build(['controller' => 'Mailers', 'action' => 'adminPreviousSpecDataV3']); ?>';
		var cloneChoices = [];
		try {
			var rawC = document.getElementById('clone-spec-choices-data');
			if (rawC && rawC.textContent) cloneChoices = JSON.parse(rawC.textContent);
		} catch (e) { cloneChoices = []; }
		function cloneLoadSelectedSpec() {
			var selectedId = $('#clone_previous_spec_id').val();
			if (!selectedId) {
				$('#spec-source-track').hide().text('');
				$('#spec-status-text').text('New (Clone mode — Use Area only)');
				return;
			}
			$.ajax({
				type: 'GET',
				url: cloneLoadBaseUrl.replace(/\/$/, '') + '/' + selectedId,
				dataType: 'json',
				success: function(res) {
					if (!res || !res.success || !res.data) {
						alert((res && res.error) ? res.error : 'Unable to clone spec.');
						return;
					}
					applyLoadedSpec(res.data, 'use_area');
					$('#spec-status-text').text('Cloned Use Area + comments (new client details)');
					var sourceTrack = ($('#clone_combo_input').val() || '').split('|')[0].trim();
					if (sourceTrack) $('#spec-source-track').text('Cloned from ' + sourceTrack).show();
					else $('#spec-source-track').text('Cloned from #' + selectedId).show();
				},
				error: function() { alert('Unable to clone spec right now.'); }
			});
		}
		initSpecCombobox({
			input: '#clone_combo_input',
			list: '#clone_combo_list',
			hidden: '#clone_previous_spec_id',
			choices: cloneChoices,
			onSelect: function() { cloneLoadSelectedSpec(); }
		});
	});
	<?php endif; ?>


</script>