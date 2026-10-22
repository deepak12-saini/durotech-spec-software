<?php
$hubNav = $hubNav ?? 'overview';
$siteName = defined('SITENAME') ? SITENAME : 'Durotech';
$base = defined('SITEURL') ? SITEURL : '/';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <title><?= h($title_for_layout ?? $siteName . ' | Specification hub') ?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <link rel="stylesheet" href="<?= h($base) ?>theme/css/bootstrap.css" />
    <link rel="stylesheet" href="<?= h($base) ?>theme/css/font-awesome.css" />
    <link rel="stylesheet" href="<?= h($base) ?>css/spec_hub.css" />
</head>
<body class="sh-body">
<div class="sh-shell">
    <aside class="sh-side">
        <div class="sh-brand">DUROTECH<small>Specification Studio</small></div>
        <a class="<?= $hubNav === 'overview' ? 'active' : '' ?>" href="<?= $this->Url->build(['controller' => 'SpecHub', 'action' => 'admin_overview']) ?>"><i class="fa fa-th-large"></i> Overview</a>
        <a class="<?= $hubNav === 'projects' ? 'active' : '' ?>" href="<?= $this->Url->build(['controller' => 'SpecHub', 'action' => 'admin_projects']) ?>"><i class="fa fa-folder-open-o"></i> Projects</a>
        <a class="<?= $hubNav === 'pipeline' ? 'active' : '' ?>" href="<?= $this->Url->build(['controller' => 'SpecHub', 'action' => 'admin_pipeline']) ?>"><i class="fa fa-long-arrow-right"></i> Specification pipeline</a>
        <a class="<?= $hubNav === 'documents' ? 'active' : '' ?>" href="<?= $this->Url->build(['controller' => 'SpecHub', 'action' => 'admin_documents']) ?>"><i class="fa fa-file-text-o"></i> Technical documents</a>
        <a href="<?php echo rtrim(defined('SITEURL') ? SITEURL : '/', '/') . '/admin/users/dashboard'; ?>"><i class="fa fa-arrow-left"></i> Back to admin</a>
    </aside>
    <div class="sh-main">
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </div>
</div>
<?= $this->element('spec_hub_project_modal') ?>
<script src="<?= h($base) ?>theme/js/jquery.js"></script>
<script src="<?= h($base) ?>theme/js/bootstrap.js"></script>
<?= $this->fetch('script') ?>
</body>
</html>
