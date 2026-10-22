<?php
$portalNav = $portalNav ?? 'overview';
$siteName = defined('SITENAME') ? SITENAME : 'Durotech';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <title><?= h($title_for_layout ?? $siteName . ' | Warranty') ?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <link rel="stylesheet" href="<?= h(defined('SITEURL') ? SITEURL : '/') ?>theme/css/bootstrap.css" />
    <link rel="stylesheet" href="<?= h(defined('SITEURL') ? SITEURL : '/') ?>theme/css/font-awesome.css" />
    <link rel="stylesheet" href="<?= h(defined('SITEURL') ? SITEURL : '/') ?>css/warranty_portal.css" />
</head>
<body class="wp-body">
<div class="wp-shell">
    <aside class="wp-side">
        <div class="wp-brand">DUROTECH<small>Warranty Portal</small></div>
        <a class="<?= $portalNav === 'overview' ? 'active' : '' ?>" href="<?= $this->Url->build(['controller' => 'Stocks', 'action' => 'admin_warranty_dashboard']) ?>"><i class="fa fa-home"></i> Overview</a>
        <a class="<?= $portalNav === 'register' ? 'active' : '' ?>" href="<?= $this->Url->build(['controller' => 'Stocks', 'action' => 'admin_warranty_register']) ?>"><i class="fa fa-list"></i> Warranty Register</a>
        <a class="<?= $portalNav === 'add' ? 'active' : '' ?>" href="<?= $this->Url->build(['controller' => 'Stocks', 'action' => 'admin_add_product_warranty']) ?>"><i class="fa fa-plus-circle"></i> New Warranty</a>
        <a class="<?= $portalNav === 'contractors' ? 'active' : '' ?>" href="<?= $this->Url->build(['controller' => 'Stocks', 'action' => 'admin_warranty_contractors']) ?>"><i class="fa fa-users"></i> Contractors</a>
        <a class="<?= $portalNav === 'documents' ? 'active' : '' ?>" href="<?= $this->Url->build(['controller' => 'Stocks', 'action' => 'admin_warranty_documents']) ?>"><i class="fa fa-file-text-o"></i> Documents</a>
        <a class="<?= $portalNav === 'reports' ? 'active' : '' ?>" href="<?= $this->Url->build(['controller' => 'Stocks', 'action' => 'admin_warranty_reports']) ?>"><i class="fa fa-bar-chart"></i> Reports</a>
        <a class="<?= $portalNav === 'settings' ? 'active' : '' ?>" href="<?= $this->Url->build(['controller' => 'Stocks', 'action' => 'admin_warranty_settings']) ?>"><i class="fa fa-cog"></i> Settings</a>
        <a class="<?= $portalNav === 'approve' ? 'active' : '' ?>" href="<?= $this->Url->build(['controller' => 'Stocks', 'action' => 'admin_product_warranty_request']) ?>"><i class="fa fa-check-square-o"></i> Approve list</a>
        <a href="<?php echo rtrim(defined('SITEURL') ? SITEURL : '/', '/') . '/admin/users/dashboard'; ?>"><i class="fa fa-arrow-left"></i> Back to admin</a>
    </aside>
    <div class="wp-main">
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </div>
</div>
<script src="<?= h(defined('SITEURL') ? SITEURL : '/') ?>theme/js/jquery.js"></script>
<script src="<?= h(defined('SITEURL') ? SITEURL : '/') ?>theme/js/bootstrap.js"></script>
<?= $this->fetch('script') ?>
</body>
</html>
