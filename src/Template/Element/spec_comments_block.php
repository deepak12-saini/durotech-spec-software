<?php
/**
 * Spec Comments UI — preset chips + polished editable rows.
 * Expects optional $existingComments as list of comment strings.
 */
$existingComments = isset($existingComments) && is_array($existingComments) ? array_values($existingComments) : [];
$commentPresets = [
	'Duroprime SSP Pro primer to be used on non porous substrate',
	'Refer to TDS prior to use',
	'Duroprime SSP to be used internally on all plastic, PVC, Angeles, Aluminum Area',
	'WBE hibuild required for all areas with high moisture Content',
	'SC = Seal coat',
	'Compatible sealant under subsil - Duroseal 25C',
	'Membrane protection done by others',
	'PVC fittings should be etched primed with Durotech pink etch primer',
	'Durotech METAL Primer to be used on non porous metal surfaces',
];

$existingLower = [];
foreach ($existingComments as $c) {
	$t = trim((string)$c);
	if ($t !== '') {
		$existingLower[] = strtolower($t);
	}
}
?>
<div class="spec-comments-panel">
	<div class="spec-comment-presets" id="specCommentPresets">
		<div class="spec-comment-presets__head">
			<strong>Quick presets</strong>
			<span>Click a chip to add · you can still type custom comments</span>
		</div>
		<div class="spec-comment-chips" id="specCommentPresetList">
			<?php foreach ($commentPresets as $presetText):
				$isUsed = in_array(strtolower($presetText), $existingLower, true);
			?>
			<button
				type="button"
				class="spec-comment-chip<?= $isUsed ? ' is-used' : '' ?>"
				data-preset="<?= h($presetText) ?>"
				title="<?= $isUsed ? 'Already added' : 'Click to add this comment' ?>"
			>
				<i class="fa <?= $isUsed ? 'fa-check' : 'fa-plus' ?>" aria-hidden="true"></i>
				<span><?= h($presetText) ?></span>
			</button>
			<?php endforeach; ?>
		</div>
	</div>

	<div class="spec-comments-list" id="specCommentsList">
		<?php if (!empty($existingComments)): ?>
			<?php foreach ($existingComments as $idx => $commentText):
				$num = $idx + 1;
				$canRemove = true;
			?>
			<div class="commentdiv spec-comment-row" id="commentdiv_<?= (int)$num ?>">
				<span class="spec-comment-row__num"><?= (int)$num ?></span>
				<input
					type="text"
					class="spec-comment-input"
					name="comment[]"
					value="<?= h((string)$commentText) ?>"
					placeholder="Type a custom comment, or click a preset above"
				>
				<a href="javascript:void(0);" class="spec-comment-row__remove" onclick="commnetdivremove(<?= (int)$num ?>)" title="Remove">×</a>
			</div>
			<?php endforeach; ?>
		<?php else: ?>
			<div class="commentdiv spec-comment-row" id="commentdiv_1">
				<span class="spec-comment-row__num">1</span>
				<input
					type="text"
					class="spec-comment-input"
					name="comment[]"
					value=""
					placeholder="Type a custom comment, or click a preset above"
				>
			</div>
		<?php endif; ?>
		<div id="addcommentnew"></div>
	</div>

	<a href="javascript:void(0);" class="btn btn-xs btn-primary spec-comments-add-btn" onclick="addmorecomment()">
		<i class="fa fa-plus"></i> Add More Comment
	</a>
</div>
