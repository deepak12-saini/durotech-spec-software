<?php
/**
 * Access request email for Refuel CPD / Presentation.
 * Expected vars: name, email, type
 */
$name = trim((string)($name ?? ''));
$email = trim((string)($email ?? ''));
$type = trim((string)($type ?? 'Access'));
?>
<p>Hello Team,</p>
<p>A user has requested <strong><?= h($type) ?></strong> access.</p>
<table cellpadding="6" cellspacing="0" border="1" style="border-collapse:collapse;border-color:#dddddd;">
    <tr>
        <th align="left">Name</th>
        <td><?= h($name) ?></td>
    </tr>
    <tr>
        <th align="left">Email</th>
        <td><?= h($email) ?></td>
    </tr>
    <tr>
        <th align="left">Request Type</th>
        <td><?= h($type) ?></td>
    </tr>
</table>
