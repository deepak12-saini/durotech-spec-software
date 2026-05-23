<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AiSpec $aiSpec
 * @var array<string, string> $aispecActions
 * @var array<int, array{section: \App\Model\Entity\AiSpecSection, item: \App\Model\Entity\AiSpecItem}> $allItemsSorted
 */
$pdf = trim((string)($aiSpec->pdf_attachment ?? ''));
$status = (string)($aiSpec->save_status ?? '');
$track = trim((string)($aiSpec->tracknumber ?? ''));
$docRef = trim((string)($aiSpec->doc_reference ?? ''));

$aispecNormColor = function (string $hex): string {
	$hex = trim($hex);
	if ($hex === '') {
		return '#23550C';
	}
	if ($hex[0] !== '#') {
		$hex = '#' . $hex;
	}
	if (!preg_match('/^#[0-9A-Fa-f]{3,8}$/', $hex)) {
		return '#23550C';
	}

	return $hex;
};

$aispecBadgeTextColor = function (string $hex) use ($aispecNormColor): string {
	$hex = ltrim($aispecNormColor($hex), '#');
	if (strlen($hex) === 3) {
		$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
	}
	$r = hexdec(substr($hex, 0, 2));
	$g = hexdec(substr($hex, 2, 2));
	$b = hexdec(substr($hex, 4, 2));
	$lum = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;

	return $lum > 0.55 ? '#111111' : '#ffffff';
};

$aispecWpmLabel = function (string $wpmCode): string {
	$wpmCode = trim($wpmCode);
	if (preg_match('/wpm\s*(\S+)/i', $wpmCode, $m)) {
		return 'wpm<br>' . h(strtolower($m[1]));
	}

	return h(strtolower($wpmCode));
};
?>
<div class="page-content aispec-admin aispec-view">
	<div class="page-header clearfix">
		<div class="pull-right page-header-actions">
			<?php if ($pdf !== '') { ?>
				<a href="<?php echo h(SITEURL . $pdf); ?>" target="_blank" class="btn btn-primary">
					<i class="ace-icon fa fa-file-pdf-o"></i> View PDF
				</a>
			<?php } ?>
			<?php echo $this->Html->link(
				'<i class="ace-icon fa fa-pencil"></i> Edit',
				['action' => $aispecActions['edit'], $aiSpec->id],
				['class' => 'btn btn-info', 'escape' => false]
			); ?>
			<a href="<?php echo $this->Url->build(['action' => $aispecActions['index']]); ?>" class="btn btn-default">
				<i class="ace-icon fa fa-arrow-left"></i> Back to list
			</a>
		</div>
		<h1>
			Materials matrix
			<small><i class="ace-icon fa fa-angle-double-right"></i> <?php echo h($track !== '' ? $track : '#' . (int)$aiSpec->id); ?></small>
		</h1>
	</div>

	<?php if ($track !== '' || $status !== '') { ?>
	<div class="aispec-view-meta-bar clearfix">
		<?php if ($track !== '') { ?>
			<span class="aispec-view-meta-item"><strong>Track:</strong> <?php echo h($track); ?></span>
		<?php } ?>
		<span class="aispec-view-meta-item">
			<strong>Status:</strong>
			<?php if ($status === 'draft') { ?>
				<span class="label label-warning label-sm">Draft</span>
			<?php } else { ?>
				<span class="label label-success label-sm">Submitted</span>
			<?php } ?>
		</span>
		<?php if (!empty($aiSpec->created)) { ?>
			<span class="aispec-view-meta-item"><strong>Created:</strong> <?php echo h(format_db_date('d M Y, H:i', $aiSpec->created)); ?></span>
		<?php } ?>
	</div>
	<?php } ?>

	<div class="aispec-pdf-preview">
		<div class="aispec-pdf-title">Waterproofing Materials Matrix</div>

		<div class="aispec-pdf-header-meta">
			<table class="aispec-pdf-meta-table" cellpadding="0" cellspacing="0">
				<tr>
					<td class="aispec-pdf-meta-label">project:</td>
					<td class="aispec-pdf-meta-value"><?php echo h((string)($aiSpec->project ?? '—')); ?></td>
				</tr>
				<tr>
					<td class="aispec-pdf-meta-label">client:</td>
					<td class="aispec-pdf-meta-value"><?php echo h((string)($aiSpec->client ?? '—')); ?></td>
				</tr>
				<tr>
					<td class="aispec-pdf-meta-label">revision:</td>
					<td class="aispec-pdf-meta-value"><?php echo h((string)($aiSpec->revision ?? '1')); ?></td>
				</tr>
			</table>
		</div>

		<?php if (!empty($aiSpec->ai_spec_sections)) { ?>
		<div class="aispec-pdf-standards">
			<table class="aispec-pdf-standards-table" cellpadding="0" cellspacing="0" width="100%">
				<?php foreach ($aiSpec->ai_spec_sections as $section) { ?>
					<?php
					$secName = strtoupper(trim((string)($section->name ?? '')));
					$standards = trim((string)($section->standards_text ?? ''));
					if ($secName === '' && $standards === '') {
						continue;
					}
					?>
					<tr>
						<td class="aispec-pdf-standards-name"><?php echo h($secName); ?></td>
						<td class="aispec-pdf-standards-text"><?php echo h($standards); ?></td>
					</tr>
				<?php } ?>
			</table>
		</div>
		<?php } ?>

		<div class="aispec-pdf-matrix">
			<?php if (empty($allItemsSorted)) : ?>
				<div class="aispec-pdf-empty">No material rows defined.</div>
			<?php else : ?>
				<?php foreach ($allItemsSorted as $idx => $row) : ?>
					<?php
					$item = $row['item'];
					$color = $aispecNormColor((string)($item->tag_color ?? '#23550C'));
					$badgeText = $aispecBadgeTextColor($color);
					$area = trim((string)($item->application_area ?? ''));
					$product = trim((string)($item->product_name ?? ''));
					$desc = trim((string)($item->description ?? ''));
					$fall = trim((string)($item->fall_requirement ?? ''));
					$isLast = $idx === count($allItemsSorted) - 1;
					?>
					<div class="aispec-pdf-row<?php echo $isLast ? ' aispec-pdf-row-last' : ''; ?>">
						<div class="aispec-pdf-wpm" style="background-color:<?php echo h($color); ?>;color:<?php echo h($badgeText); ?>;">
							<?php echo $aispecWpmLabel((string)($item->wpm_code ?? '')); ?>
						</div>
						<div class="aispec-pdf-content">
							<div class="aispec-pdf-topline clearfix">
								<div class="aispec-pdf-area"><?php echo $area !== '' ? h($area) : '&nbsp;'; ?></div>
								<?php if ($fall !== '') { ?>
									<div class="aispec-pdf-fall"><?php echo h($fall); ?></div>
								<?php } ?>
							</div>
							<?php if ($product !== '') { ?>
								<div class="aispec-pdf-product"><?php echo h($product); ?></div>
							<?php } ?>
							<?php if ($desc !== '') { ?>
								<div class="aispec-pdf-desc"><?php echo h($desc); ?></div>
							<?php } ?>
						</div>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>

		<div class="aispec-pdf-footer">
			<?php echo h($docRef !== '' ? $docRef : ' '); ?>
		</div>
	</div>
</div>
<?php echo $this->element('AiSpecs/admin_styles'); ?>
