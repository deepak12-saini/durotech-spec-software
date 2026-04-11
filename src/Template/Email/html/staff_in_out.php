<?php
/**
 * Staff in/out job finished notification (MeetsController::staffinout).
 * View vars: to_name, referid, name, work_status, phone, email, summary
 */
$toName = $to_name ?? 'Team';
?>
<p>Hello <?= h($toName) ?>,</p>
<p>A staff job has been marked <strong><?= h($work_status ?? 'Finished') ?></strong>.</p>
<table cellpadding="6" cellspacing="0" border="0" style="border-collapse:collapse;font-size:14px;">
	<tr><td><strong>Reference</strong></td><td><?= h((string)($referid ?? '')) ?></td></tr>
	<tr><td><strong>Name</strong></td><td><?= h((string)($name ?? '')) ?></td></tr>
	<tr><td><strong>Phone</strong></td><td><?= h((string)($phone ?? '')) ?></td></tr>
	<tr><td><strong>Worker email</strong></td><td><?= h((string)($email ?? '')) ?></td></tr>
</table>
<?php if (!empty($summary)) : ?>
<p><strong>Job summary</strong></p>
<p style="white-space:pre-wrap;"><?= nl2br(h((string)$summary)) ?></p>
<?php endif; ?>
<p>— <?= h(defined('SITENAME') ? SITENAME : 'Durotech Industries') ?></p>
