<?php
/**
 * New material order request (QR / readqrcode flow).
 * Vars: toname, orderid, material_type, weight, quantity, requestedname, url
 */
$toname = trim((string)($toname ?? 'Team'));
$orderid = trim((string)($orderid ?? ''));
$material_type = trim((string)($material_type ?? ''));
$weight = trim((string)($weight ?? ''));
$quantity = trim((string)($quantity ?? ''));
$requestedname = trim((string)($requestedname ?? ''));
$url = trim((string)($url ?? ''));
$siteName = defined('SITENAME') ? SITENAME : 'Durotech Industries';
?>
<p>Hi <?= h($toname !== '' ? $toname : 'Team') ?>,</p>
<p>A new <strong>material order request</strong> was submitted via the QR order form.</p>
<table cellpadding="8" cellspacing="0" border="1" style="border-collapse:collapse;border-color:#dddddd;max-width:560px;">
    <tr>
        <th align="left">Request ID</th>
        <td><?= h($orderid) ?></td>
    </tr>
    <tr>
        <th align="left">Material</th>
        <td><?= h($material_type) ?></td>
    </tr>
    <tr>
        <th align="left">Weight / dimensions</th>
        <td><?= h($weight) ?></td>
    </tr>
    <tr>
        <th align="left">Quantity</th>
        <td><?= h($quantity) ?></td>
    </tr>
    <tr>
        <th align="left">Requested by (name)</th>
        <td><?= h($requestedname !== '' ? $requestedname : '—') ?></td>
    </tr>
</table>
<?php if ($url !== '') : ?>
    <p style="margin-top:16px;"><a href="<?= h($url) ?>" style="display:inline-block;padding:10px 16px;background:#307ecc;color:#fff;text-decoration:none;border-radius:4px;">Open admin material orders</a></p>
    <p style="font-size:12px;color:#666;">If the button does not work, copy this link:<br><?= h($url) ?></p>
<?php endif; ?>
<p style="margin-top:16px;">Regards,<br><?= h($siteName) ?></p>
