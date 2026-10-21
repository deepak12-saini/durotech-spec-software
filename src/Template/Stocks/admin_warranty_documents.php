<div class="wp-top">
    <div>
        <h1>Documents</h1>
        <p>Issued certificates only. Site photos and invoices are not stored yet.</p>
    </div>
</div>
<div class="wp-card">
    <table class="wp-table">
        <thead>
            <tr>
                <th>Serial</th>
                <th>Contractor</th>
                <th>Certificate</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($docs)) : ?>
                <tr><td colspan="3">No certificates issued yet. Approve a pending warranty to generate a PDF.</td></tr>
            <?php else : ?>
                <?php foreach ($docs as $row) : ?>
                    <tr>
                        <td><?= h($row['serialnumber'] ?? '') ?></td>
                        <td><?= h($row['contract_company_name'] ?? '') ?></td>
                        <td>
                            <?php if (!empty($row['certificate'])) : ?>
                                <a href="<?= h(rtrim((string)$this->getRequest()->getAttribute('webroot'), '/') . '/' . ltrim((string)$row['certificate'], '/')) ?>" target="_blank">Certificate PDF</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
