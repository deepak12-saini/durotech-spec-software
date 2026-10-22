<?php
$requestNav = $requestNav ?? 'customer';
$siteName = defined('SITENAME') ? SITENAME : 'Durotech';
$base = defined('SITEURL') ? SITEURL : '/';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <title><?= h($title_for_layout ?? $siteName . ' | Customer specification request') ?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <link rel="stylesheet" href="<?= h($base) ?>theme/css/bootstrap.css" />
    <link rel="stylesheet" href="<?= h($base) ?>theme/css/font-awesome.css" />
    <link rel="stylesheet" href="<?= h($base) ?>css/spec_request.css?v=3" />
</head>
<body class="sr-body">
<header class="sr-header">
    <div class="sr-header-inner">
        <div class="sr-brand">DUROTECH<small>Project specification studio</small></div>
        <nav class="sr-nav">
            <a class="<?= $requestNav === 'customer' ? 'active' : '' ?>" href="<?= $this->Url->build(['controller' => 'SpecHub', 'action' => 'request']) ?>">Customer view</a>
            <a class="<?= $requestNav === 'josh' ? 'active' : '' ?>" href="<?= $this->Url->build(['controller' => 'SpecHub', 'action' => 'admin_requests']) ?>">Josh &amp; management</a>
        </nav>
    </div>
</header>
<main class="sr-wrap">
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>
</main>
<script src="<?= h($base) ?>theme/js/jquery.js"></script>
<script src="<?= h($base) ?>theme/js/bootstrap.js"></script>
<?= $this->fetch('script') ?>
</body>
</html>
