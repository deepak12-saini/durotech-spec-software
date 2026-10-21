<div class="wp-top">
    <div>
        <h1>Settings</h1>
        <p>Serial numbering is automatic. There is no extra permission matrix on this portal.</p>
    </div>
</div>
<div class="wp-card">
    <dt>Next serial</dt>
    <dd><?= h($nextWarrantySerial ?? '') ?></dd>
    <dt>Format</dt>
    <dd>DT-MM-YYYY-NNNN (resets each calendar month, Australia/Sydney)</dd>
    <dt>Staff add</dt>
    <dd>Admins can log a warranty without a signature. The customer is emailed only after Approve.</dd>
    <p style="margin-top:16px;"><a class="wp-btn wp-btn-green" href="<?= $this->Url->build(['action' => 'admin_add_product_warranty']) ?>">+ New Warranty</a></p>
</div>
