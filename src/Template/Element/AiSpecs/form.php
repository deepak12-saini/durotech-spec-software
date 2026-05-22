<?php
/**
 * @var \App\View\AppView $this
 * @var string $formTitle
 * @var array $formAction
 * @var string $tracknumber
 * @var \App\Model\Entity\AiSpec|null $aiSpec
 * @var bool $isEdit
 */

$wpmColors = [
	'01' => '#23550C',
	'02' => '#633907',
	'03' => '#FFED00',
	'04' => '#00A0E3',
	'05' => '#95346C',
	'06' => '#E31E24',
	'07' => '#C2364D',
	'08' => '#EDA708',
	'09' => '#470022',
	'10' => '#01123E',
];

$sectionPresets = [
	['name' => 'INTERNAL WET AREA', 'standards' => 'AS/NZS 4858 (2004) & AS 3740 (2021)'],
	['name' => 'EXTERNAL ABOVE-GROUND', 'standards' => 'AS 4654.1 (2012) & AS 4654.2 (2012)'],
	['name' => 'BELOW-GROUND / MISCELLANEOUS', 'standards' => 'BS 8102 (2022) & BEST PRACTICE'],
];

$dummyHeader = [
	'project' => '573 Gardeners Rd, Mascot',
	'client' => 'Astute Construction',
	'revision' => '1',
	'doc_reference' => '25-AST-1267-WMM-R1',
];

$dummyRowsByWpm = [
	'01' => ['wpm_code' => 'wpm 01', 'tag_color' => '#23550C', 'application_area' => 'tile on screed / sub-sill hob', 'product_name' => 'Durotech Duromastic P15 Diamond', 'description' => 'class III | fully bonded liquid membrane', 'fall_requirement' => 'min 1:100 ssl & ffl fall'],
	'02' => ['wpm_code' => 'wpm 02', 'tag_color' => '#633907', 'application_area' => 'pavers on pedestals / podium', 'product_name' => 'Durotech Duroproof NEP STD', 'description' => 'class III | fully bonded liquid membrane', 'fall_requirement' => 'min 1:100 ssl fall'],
	'03' => ['wpm_code' => 'wpm 03', 'tag_color' => '#FFED00', 'application_area' => 'wet area floor and wall', 'product_name' => 'Durotech Duromastic 007FC', 'description' => 'class III | fully bonded liquid membrane', 'fall_requirement' => 'min 1:100 ssl & min 1:80 ffl fall'],
	'04' => ['wpm_code' => 'wpm 04', 'tag_color' => '#00A0E3', 'application_area' => 'roof', 'product_name' => 'Durotech Duroproof NEP STD + Durotech Duroproof TTC', 'description' => 'class III | fully bonded liquid membrane', 'fall_requirement' => 'min 1:100 ssl fall'],
	'05' => ['wpm_code' => 'wpm 05', 'tag_color' => '#95346C', 'application_area' => 'tank - OSD / RWT / FST / pump-out-pit', 'product_name' => 'Durotech Duroflex Tank', 'description' => 'class II | fully bonded cementitious membrane', 'fall_requirement' => ''],
	'06' => ['wpm_code' => 'wpm 06', 'tag_color' => '#E31E24', 'application_area' => 'culvert', 'product_name' => 'Drizoro Maxseal Flex', 'description' => 'class I | fully bonded cementitious membrane', 'fall_requirement' => 'min 1:100 ssl fall'],
	'07' => ['wpm_code' => 'wpm 07', 'tag_color' => '#C2364D', 'application_area' => 'waste storage / car wash bay', 'product_name' => 'Durotech Duropoxy SLR 100', 'description' => 'fully bonded epoxy flooring system', 'fall_requirement' => 'min 1:100 ssl fall'],
	'08' => ['wpm_code' => 'wpm 08', 'tag_color' => '#EDA708', 'application_area' => 'landscape - positive side', 'product_name' => 'Durotech Duroproof NEP STD', 'description' => 'class III | fully bonded liquid membrane', 'fall_requirement' => 'min 1:100 ssl & ffl fall'],
	'09' => ['wpm_code' => 'wpm 09', 'tag_color' => '#470022', 'application_area' => 'perimeter setdown / rendered slab edge', 'product_name' => 'Durotech Duromastic P15 Diamond', 'description' => 'class III | fully bonded liquid membrane', 'fall_requirement' => 'min 1:100 ssl fall'],
	'10' => ['wpm_code' => 'wpm 10', 'tag_color' => '#01123E', 'application_area' => 'wet plant room', 'product_name' => 'Durotech Duropoxy SLR 100', 'description' => 'fully bonded epoxy flooring system', 'fall_requirement' => 'min 1:100 ssl fall'],
];

$defaultSectionsWithDummy = [
	['name' => 'INTERNAL WET AREA', 'standards_text' => 'AS/NZS 4858 (2004) & AS 3740 (2021)', 'items' => [$dummyRowsByWpm['01'], $dummyRowsByWpm['03']]],
	['name' => 'EXTERNAL ABOVE-GROUND', 'standards_text' => 'AS 4654.1 (2012) & AS 4654.2 (2012)', 'items' => [$dummyRowsByWpm['02'], $dummyRowsByWpm['04']]],
	['name' => 'BELOW-GROUND / MISCELLANEOUS', 'standards_text' => 'BS 8102 (2022) & BEST PRACTICE', 'items' => [$dummyRowsByWpm['05'], $dummyRowsByWpm['06'], $dummyRowsByWpm['07'], $dummyRowsByWpm['08'], $dummyRowsByWpm['09'], $dummyRowsByWpm['10']]],
];

$isNewForm = empty($aiSpec);

$sectionsJson = '[]';
if (!empty($aiSpec) && !empty($aiSpec->ai_spec_sections)) {
	$out = [];
	foreach ($aiSpec->ai_spec_sections as $sec) {
		$items = [];
		if (!empty($sec->ai_spec_items)) {
			foreach ($sec->ai_spec_items as $it) {
				$items[] = [
					'wpm_code' => $it->wpm_code ?? '',
					'tag_color' => $it->tag_color ?? '#23550C',
					'application_area' => $it->application_area ?? '',
					'product_name' => $it->product_name ?? '',
					'description' => $it->description ?? '',
					'fall_requirement' => $it->fall_requirement ?? '',
				];
			}
		}
		$out[] = [
			'name' => $sec->name ?? '',
			'standards_text' => $sec->standards_text ?? '',
			'items' => $items,
		];
	}
	$sectionsJson = json_encode($out);
}

$val = function ($field, $default = '') use ($aiSpec, $dummyHeader, $isNewForm) {
	if ($isNewForm && isset($dummyHeader[$field])) {
		return h((string)$dummyHeader[$field]);
	}
	if (empty($aiSpec)) {
		return h((string)$default);
	}
	return h((string)($aiSpec->{$field} ?? $default));
};
?>
<div class="page-content aispec-admin aispec-form-admin">
	<div class="page-header clearfix">
		<div class="pull-right page-header-actions">
			<a href="<?php echo $this->Url->build(['action' => 'admin_index']); ?>" class="btn btn-default">
				<i class="ace-icon fa fa-arrow-left"></i> Back to list
			</a>
		</div>
		<h1>
			<?php echo h($formTitle); ?>
			<small><i class="ace-icon fa fa-angle-double-right"></i> AiSpec materials matrix</small>
		</h1>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<?php echo $this->Form->create(null, ['url' => $formAction, 'id' => 'aispec-form']); ?>

			<input type="hidden" name="tracknumber" id="aispec-tracknumber" value="<?php echo h($tracknumber); ?>">
			<div class="track-badge">
				<i class="ace-icon fa fa-barcode"></i> <span id="aispec-tracknumber-display"><?php echo h($tracknumber); ?></span>
			</div>

			<?php if ($isNewForm): ?>
			<div class="alert alert-info alert-example">
				<i class="ace-icon fa fa-lightbulb-o"></i>
				<strong>Example data:</strong> Fields are pre-filled with sample values. Replace them with your real project details before saving.
			</div>
			<?php endif; ?>

			<div class="panel panel-default panel-aispec">
				<div class="panel-heading"><i class="ace-icon fa fa-file-text-o"></i> Document header</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label>Project <span class="text-danger">*</span></label>
								<input type="text" name="project" class="form-control" required value="<?php echo $val('project'); ?>" placeholder="e.g. 573 Gardeners Rd, Mascot">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Client <span class="text-danger">*</span></label>
								<input type="text" name="client" class="form-control" required value="<?php echo $val('client'); ?>" placeholder="e.g. Astute Construction">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-3">
							<div class="form-group">
								<label>Revision</label>
								<input type="number" name="revision" class="form-control" min="1" value="<?php echo $val('revision', '1'); ?>">
							</div>
						</div>
						<div class="col-sm-9">
							<div class="form-group">
								<label>Document reference (PDF footer)</label>
								<input type="text" name="doc_reference" class="form-control" placeholder="e.g. 25-AST-1267-WMM-R1" value="<?php echo $val('doc_reference'); ?>">
								<p class="help-hint">Shown in the PDF footer bar.</p>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="panel panel-default panel-aispec panel-matrix">
				<div class="panel-heading"><i class="ace-icon fa fa-th"></i> Matrix sections &amp; WPM rows</div>
				<div class="panel-body">
					<div class="matrix-toolbar clearfix">
						<button type="button" class="btn btn-sm btn-info" id="btn-add-section">
							<i class="ace-icon fa fa-plus"></i> Add section
						</button>
						<button type="button" class="btn btn-sm btn-default" id="btn-expand-all">
							<i class="ace-icon fa fa-expand"></i> Expand all
						</button>
						<button type="button" class="btn btn-sm btn-default" id="btn-collapse-all">
							<i class="ace-icon fa fa-compress"></i> Collapse all
						</button>
						<div class="pull-right" style="margin-top:2px;">
							<label class="inline" style="font-weight:normal;margin-right:6px;">Quick add preset:</label>
							<select id="section-preset" class="form-control input-sm" style="display:inline-block;width:auto;min-width:220px;">
								<option value="">— Choose preset —</option>
								<?php foreach ($sectionPresets as $p): ?>
									<option value="<?php echo h(json_encode($p)); ?>"><?php echo h($p['name']); ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div id="sections-container" class="aispec-matrix-wrap"></div>
				</div>
			</div>

			<div class="form-actions-sticky text-center">
				<button type="submit" name="save_action" value="submitted" class="btn btn-success btn-lg">
					<i class="ace-icon fa fa-file-pdf-o"></i> Save &amp; generate PDF
				</button>
				<button type="submit" name="save_action" value="draft" class="btn btn-default btn-lg">
					<i class="ace-icon fa fa-save"></i> Save draft only
				</button>
			</div>

			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>
<?php echo $this->element('AiSpecs/admin_styles'); ?>
<script>
(function() {
	var wpmColors = <?php echo json_encode($wpmColors); ?>;
	var initialSections = <?php echo $sectionsJson; ?>;
	var dummyRowsByWpm = <?php echo json_encode($dummyRowsByWpm); ?>;
	var defaultSectionsWithDummy = <?php echo json_encode($defaultSectionsWithDummy); ?>;
	var isNewForm = <?php echo $isNewForm ? 'true' : 'false'; ?>;

	function esc(s) {
		if (s == null) return '';
		return String(s)
			.replace(/&/g, '&amp;')
			.replace(/</g, '&lt;')
			.replace(/"/g, '&quot;');
	}

	function colorOptions(selected) {
		var html = '<option value="">Custom</option>';
		for (var k in wpmColors) {
			if (!wpmColors.hasOwnProperty(k)) continue;
			var v = wpmColors[k];
			var sel = (selected === v) ? ' selected' : '';
			html += '<option value="' + esc(v) + '"' + sel + '>WPM ' + k + '</option>';
		}
		return html;
	}

	function updateSwatch($row) {
		var v = $row.find('.aispec-tag-color-hidden').val() || '#23550C';
		$row.find('.aispec-swatch').css('background-color', v);
	}

	function updateSectionMeta($card) {
		var name = $card.find('input[name*="[name]"]').val() || 'Untitled section';
		var count = $card.find('.aispec-item-row').length;
		$card.find('.section-title').text(name);
		$card.find('.section-row-count').text(count + ' row' + (count === 1 ? '' : 's'));
	}

	function rowHtml(secIdx, rowIdx, row) {
		row = row || {};
		var color = row.tag_color || '#23550C';
		return '<tr class="aispec-item-row" data-row="' + rowIdx + '">' +
			'<td><input type="text" class="form-control input-sm" name="sections[' + secIdx + '][items][' + rowIdx + '][wpm_code]" value="' + esc(row.wpm_code) + '" placeholder="wpm 01"></td>' +
			'<td class="aispec-color-cell">' +
			'<span class="aispec-swatch" style="background-color:' + esc(color) + ';"></span>' +
			'<div class="aispec-color-inputs">' +
			'<input type="hidden" class="aispec-tag-color-hidden" name="sections[' + secIdx + '][items][' + rowIdx + '][tag_color]" value="' + esc(color) + '">' +
			'<select class="form-control input-sm aispec-color-preset" style="width:88px;">' + colorOptions(color) + '</select> ' +
			'<input type="text" class="form-control input-sm aispec-color-hex" style="width:72px;display:inline-block;" value="' + esc(color) + '" placeholder="#hex">' +
			'</div></td>' +
			'<td><input type="text" class="form-control input-sm" name="sections[' + secIdx + '][items][' + rowIdx + '][application_area]" value="' + esc(row.application_area) + '"></td>' +
			'<td><input type="text" class="form-control input-sm" name="sections[' + secIdx + '][items][' + rowIdx + '][product_name]" value="' + esc(row.product_name) + '"></td>' +
			'<td><input type="text" class="form-control input-sm" name="sections[' + secIdx + '][items][' + rowIdx + '][description]" value="' + esc(row.description) + '"></td>' +
			'<td><input type="text" class="form-control input-sm" name="sections[' + secIdx + '][items][' + rowIdx + '][fall_requirement]" value="' + esc(row.fall_requirement) + '"></td>' +
			'<td class="text-center"><button type="button" class="btn btn-xs btn-danger btn-remove-row" title="Remove row"><i class="fa fa-trash-o"></i></button></td></tr>';
	}

	function sectionHtml(secIdx, sec) {
		sec = sec || { name: '', standards_text: '', items: [] };
		var items = sec.items || [];
		var rows = '';
		for (var i = 0; i < items.length; i++) {
			rows += rowHtml(secIdx, i, items[i]);
		}
		if (items.length === 0) {
			rows = rowHtml(secIdx, 0, dummyRowForNew());
		}
		var title = sec.name || ('Section ' + (secIdx + 1));
		return '<div class="aispec-section-card" data-section="' + secIdx + '">' +
			'<div class="aispec-section-head">' +
			'<i class="ace-icon fa fa-chevron-down toggle-icon"></i> ' +
			'<span class="section-title">' + esc(title) + '</span>' +
			'<div class="section-meta"><span class="section-row-count">' + items.length + ' row' + (items.length === 1 ? '' : 's') + '</span></div>' +
			'<button type="button" class="btn btn-xs btn-danger pull-right btn-remove-section" style="margin-top:-22px;"><i class="fa fa-times"></i> Remove</button>' +
			'</div>' +
			'<div class="aispec-section-body">' +
			'<div class="row">' +
			'<div class="col-sm-5"><div class="form-group"><label>Section name</label>' +
			'<input type="text" class="form-control section-name-input" name="sections[' + secIdx + '][name]" value="' + esc(sec.name) + '"></div></div>' +
			'<div class="col-sm-7"><div class="form-group"><label>Standards (banner text)</label>' +
			'<input type="text" class="form-control" name="sections[' + secIdx + '][standards_text]" value="' + esc(sec.standards_text) + '"></div></div></div>' +
			'<div class="table-responsive">' +
			'<table class="aispec-row-table table table-condensed"><thead><tr>' +
			'<th style="width:90px;">WPM</th><th style="width:130px;">Color</th><th>Application area</th><th>Product</th><th>Description</th><th>Fall</th><th style="width:44px;"></th>' +
			'</tr></thead><tbody class="aispec-items-tbody">' + rows + '</tbody></table></div>' +
			'<div class="btn-add-row-wrap"><button type="button" class="btn btn-sm btn-success btn-add-row"><i class="fa fa-plus"></i> Add row</button></div>' +
			'</div></div>';
	}

	var sectionCount = 0;

	function padWpm(n) {
		n = parseInt(n, 10) || 1;
		return (n < 10 ? '0' : '') + n;
	}

	function getMaxWpmNumOnForm() {
		var max = 0;
		$('#sections-container input[name*="[wpm_code]"]').each(function() {
			var m = String($(this).val() || '').match(/(\d+)/);
			if (m) max = Math.max(max, parseInt(m[1], 10));
		});
		return max;
	}

	function dummyRowForNew() {
		var n = getMaxWpmNumOnForm() + 1;
		var key = padWpm(n);
		if (dummyRowsByWpm[key]) return dummyRowsByWpm[key];
		var colorKey = padWpm(((n - 1) % 10) + 1);
		return {
			wpm_code: 'wpm ' + key,
			tag_color: wpmColors[colorKey] || '#23550C',
			application_area: 'e.g. tile on screed / sub-sill hob',
			product_name: 'e.g. Durotech Duromastic P15 Diamond',
			description: 'e.g. class III | fully bonded liquid membrane',
			fall_requirement: 'e.g. min 1:100 ssl & ffl fall'
		};
	}

	function sectionWithDummyRow(preset) {
		preset = preset || {};
		return {
			name: preset.name || 'e.g. INTERNAL WET AREA',
			standards_text: preset.standards_text || preset.standards || 'e.g. AS/NZS 4858 (2004) & AS 3740 (2021)',
			items: [dummyRowForNew()]
		};
	}

	function addSection(sec) {
		var idx = sectionCount++;
		$('#sections-container').append(sectionHtml(idx, sec));
		var $card = $('#sections-container .aispec-section-card').last();
		$card.find('.aispec-item-row').each(function() { updateSwatch($(this)); });
		updateSectionMeta($card);
	}

	function reindexSections() {
		$('#sections-container .aispec-section-card').each(function(si) {
			var $box = $(this);
			$box.attr('data-section', si);
			$box.find('[name^="sections["]').each(function() {
				var n = $(this).attr('name');
				n = n.replace(/sections\[\d+\]/, 'sections[' + si + ']');
				$(this).attr('name', n);
			});
			$box.find('.aispec-item-row').each(function(ri) {
				$(this).attr('data-row', ri);
				$(this).find('[name*="[items]["]').each(function() {
					var n = $(this).attr('name');
					n = n.replace(/\[items\]\[\d+\]/, '[items][' + ri + ']');
					$(this).attr('name', n);
				});
			});
			updateSectionMeta($box);
		});
		sectionCount = $('#sections-container .aispec-section-card').length;
	}

	$('#btn-add-section').on('click', function() {
		addSection(sectionWithDummyRow({}));
	});

	$('#section-preset').on('change', function() {
		var v = $(this).val();
		if (!v) return;
		try { addSection(sectionWithDummyRow(JSON.parse(v))); } catch (e) {}
		$(this).val('');
	});

	$('#btn-expand-all').on('click', function() {
		$('.aispec-section-body').removeClass('collapsed');
		$('.toggle-icon').removeClass('fa-chevron-right').addClass('fa-chevron-down');
	});

	$('#btn-collapse-all').on('click', function() {
		$('.aispec-section-body').addClass('collapsed');
		$('.toggle-icon').removeClass('fa-chevron-down').addClass('fa-chevron-right');
	});

	$(document).on('click', '.aispec-section-head', function(e) {
		if ($(e.target).closest('.btn-remove-section').length) return;
		var $body = $(this).siblings('.aispec-section-body');
		var $icon = $(this).find('.toggle-icon');
		$body.toggleClass('collapsed');
		if ($body.hasClass('collapsed')) {
			$icon.removeClass('fa-chevron-down').addClass('fa-chevron-right');
		} else {
			$icon.removeClass('fa-chevron-right').addClass('fa-chevron-down');
		}
	});

	$(document).on('input', '.section-name-input', function() {
		updateSectionMeta($(this).closest('.aispec-section-card'));
	});

	$(document).on('click', '.btn-add-row', function(e) {
		e.stopPropagation();
		var $box = $(this).closest('.aispec-section-card');
		var si = parseInt($box.attr('data-section'), 10);
		var ri = $box.find('.aispec-item-row').length;
		var $row = $(rowHtml(si, ri, dummyRowForNew()));
		$box.find('.aispec-items-tbody').append($row);
		updateSwatch($row);
		updateSectionMeta($box);
	});

	$(document).on('click', '.btn-remove-row', function(e) {
		e.preventDefault();
		e.stopPropagation();
		var $box = $(this).closest('.aispec-section-card');
		$(this).closest('tr.aispec-item-row').remove();
		reindexSections();
	});

	$(document).on('click', '.btn-remove-section', function(e) {
		e.preventDefault();
		e.stopPropagation();
		if ($('#sections-container .aispec-section-card').length <= 1) {
			alert('At least one section is required.');
			return;
		}
		$(this).closest('.aispec-section-card').remove();
		reindexSections();
	});

	function syncColor($cell) {
		var v = $cell.find('.aispec-color-hex').val().trim();
		if (!v) v = $cell.find('.aispec-color-preset').val() || '#23550C';
		if (v.charAt(0) !== '#') v = '#' + v;
		$cell.find('.aispec-color-hex').val(v);
		$cell.find('.aispec-tag-color-hidden').val(v);
		updateSwatch($cell.closest('tr'));
	}

	$(document).on('change', '.aispec-color-preset', function() {
		var v = $(this).val();
		var $cell = $(this).closest('td');
		if (v) $cell.find('.aispec-color-hex').val(v);
		syncColor($cell);
	});

	$(document).on('blur input', '.aispec-color-hex', function() {
		syncColor($(this).closest('td'));
	});

	$('#aispec-form').on('submit', function() {
		reindexSections();
	});

	if (initialSections.length > 0) {
		for (var s = 0; s < initialSections.length; s++) addSection(initialSections[s]);
	} else if (isNewForm && defaultSectionsWithDummy.length) {
		for (var d = 0; d < defaultSectionsWithDummy.length; d++) addSection(defaultSectionsWithDummy[d]);
	} else {
		addSection(sectionWithDummyRow({}));
	}
})();
</script>
