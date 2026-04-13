<?php
/**
 * Warranty request admin notification template.
 * Expected vars: unique_id, name, project_name, email, to_name, url, WarrantyRequestLog
 */
$toName = trim((string)($to_name ?? ''));
$name = trim((string)($name ?? ''));
$email = trim((string)($email ?? ''));
$projectName = trim((string)($project_name ?? ''));
$uniqueId = trim((string)($unique_id ?? ''));
$url = trim((string)($url ?? ''));
$log = is_array($WarrantyRequestLog ?? null) ? $WarrantyRequestLog : [];
?>
<p>Dear <?= h($toName !== '' ? $toName : 'Team') ?>,</p>
<p>A warranty form has been submitted.</p>
<table cellpadding="6" cellspacing="0" border="1" style="border-collapse:collapse;border-color:#dddddd;">
    <tr><th align="left">Request ID</th><td><?= h($uniqueId) ?></td></tr>
    <tr><th align="left">Customer Name</th><td><?= h($name) ?></td></tr>
    <tr><th align="left">Project Name</th><td><?= h($projectName) ?></td></tr>
    <tr><th align="left">Customer Email</th><td><?= h($email) ?></td></tr>
    <tr><th align="left">Serial Number</th><td><?= h((string)($log['serialnumber'] ?? '')) ?></td></tr>
    <tr><th align="left">Product</th><td><?= h((string)($log['product'] ?? '')) ?></td></tr>
    <tr><th align="left">Used As</th><td><?= h((string)($log['used_as'] ?? '')) ?></td></tr>
    <tr><th align="left">Submitted On</th><td><?= h((string)($log['created'] ?? '')) ?></td></tr>
</table>
<?php if ($url !== ''): ?>
<p>Open request details:</p>
<p><a href="<?= h($url) ?>"><?= h($url) ?></a></p>
<?php endif; ?>
