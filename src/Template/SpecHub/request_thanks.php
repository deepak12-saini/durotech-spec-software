<?php $code = $code ?? ''; ?>
<div class="sr-card sr-thanks">
    <p class="sr-kicker">Request sent</p>
    <h1>Thank you</h1>
    <p>Your specification request is with Josh. No specification has been issued yet — dates and warranty wording are subject to confirmation.</p>
    <?php if ($code !== '') : ?>
        <div class="code"><?= h($code) ?></div>
        <p>Keep this request number for follow-up.</p>
    <?php endif; ?>
    <a class="sr-btn sr-btn-blue" href="<?= $this->Url->build(['action' => 'request']) ?>">Start another request</a>
</div>
