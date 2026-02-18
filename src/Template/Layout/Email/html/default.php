<?php
/**
 * Email HTML layout (CakePHP 3.10).
 * Wraps email template content in a basic HTML shell.
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $this->fetch('title') ?></title>
</head>
<body>
    <?= $this->fetch('content') ?>
</body>
</html>
