<div class="wp-top">
    <div>
        <h1>Contractors</h1>
        <p>Companies from existing warranty rows (not a separate CRM).</p>
    </div>
</div>
<?php if (empty($grouped)) : ?>
    <div class="wp-card">No contractor names on file yet.</div>
<?php else : ?>
    <?php foreach ($grouped as $company => $rows) : ?>
        <div class="wp-card" style="margin-bottom:12px;">
            <h2><?= h($company) ?> <span class="wp-badge"><?= count($rows) ?></span></h2>
            <table class="wp-table">
                <thead>
                    <tr>
                        <th>Serial</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $row) :
                        $rid = (int)($row['id'] ?? 0);
                        ?>
                    <tr>
                        <td><?= h($row['serialnumber'] ?? '') ?></td>
                        <td><?= h($row['contract_name'] ?? '') ?></td>
                        <td><?= h($row['email'] ?? '') ?></td>
                        <td><?= h($row['status'] ?? 'Pending') ?></td>
                        <td><a href="<?= $this->Url->build(['action' => 'admin_warranty_view', $rid]) ?>">View</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
