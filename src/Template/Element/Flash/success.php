<?php
/**
 * Flash success message element – green alert, auto-hide
 * @var \App\View\AppView $this
 * @var array $params
 * @var string $message
 */
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="alert alert-success flash-message-auto-hide" role="alert" style="background-color: #0f7d40; border-color: #0a5c2e; color: #fff; margin-bottom: 15px;">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: #fff; opacity: 0.9;"><span aria-hidden="true">&times;</span></button>
	<?= $message ?>
</div>
