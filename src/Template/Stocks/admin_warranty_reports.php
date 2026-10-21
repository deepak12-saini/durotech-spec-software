<div class="wp-top">
    <div>
        <h1>Reports</h1>
        <p>Counts from the same product warranty table.</p>
    </div>
</div>
<div class="wp-stats">
    <div class="wp-stat"><div class="l">Total</div><div class="n"><?= (int)($stats['total'] ?? 0) ?></div></div>
    <div class="wp-stat"><div class="l">Pending</div><div class="n"><?= (int)($stats['pending'] ?? 0) ?></div></div>
    <div class="wp-stat"><div class="l">Approved</div><div class="n"><?= (int)($stats['approved'] ?? 0) ?></div></div>
    <div class="wp-stat"><div class="l">Rejected</div><div class="n"><?= (int)($stats['rejected'] ?? 0) ?></div></div>
</div>
<div class="wp-card">
    <p><a class="wp-btn wp-btn-outline" href="<?= $this->Url->build(['action' => 'admin_warranty_register', '?' => ['export' => 'csv']]) ?>">Export full register (CSV)</a></p>
</div>
