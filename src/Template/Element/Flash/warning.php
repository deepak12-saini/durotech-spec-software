<?php
/**
 * Flash warning message element
 * @var \App\View\AppView $this
 * @var array $params
 * @var string $message
 */
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="alert alert-warning flash-message-auto-hide" role="alert" style="margin-bottom: 15px;" onclick="this.classList.add('hidden');"><?= $message ?></div>
