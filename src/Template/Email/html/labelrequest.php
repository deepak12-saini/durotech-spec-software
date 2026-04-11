<?php
/**
 * Product label access request (ProductsController::permissionrequest).
 * View vars: name, email, is_staff, userid
 */
?>
<p>A customer has requested access to product labels.</p>
<table cellpadding="6" cellspacing="0" border="0" style="border-collapse:collapse;font-size:14px;">
	<tr><td><strong>Name</strong></td><td><?= h((string)($name ?? '')) ?></td></tr>
	<tr><td><strong>Email</strong></td><td><?= h((string)($email ?? '')) ?></td></tr>
	<tr><td><strong>User ID</strong></td><td><?= h((string)($userid ?? '')) ?></td></tr>
	<tr><td><strong>Staff flag</strong></td><td><?= h((string)($is_staff ?? '')) ?></td></tr>
</table>
<p>Please review and grant label permission in admin if appropriate.</p>
<p>— <?= h(defined('SITENAME') ? SITENAME : 'Durotech Industries') ?></p>
