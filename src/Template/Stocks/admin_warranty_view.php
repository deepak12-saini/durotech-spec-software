<?php
/**
 * @var \App\View\AppView $this
 * @var array<string, mixed> $record
 * @var array<int, array<string, mixed>> $events
 */
$csrfToken = $this->getRequest()->getCookie('csrfToken');
$statusVal = trim((string)($record['status'] ?? ''));
if ($statusVal === '') {
    $statusVal = 'Pending';
}
$sid = (int)($record['id'] ?? 0);
$webroot = rtrim((string)$this->getRequest()->getAttribute('webroot'), '/');
$pill = ['Pending' => 'wp-pending', 'Approved' => 'wp-approved', 'Rejected' => 'wp-rejected'][$statusVal] ?? 'wp-pending';
$statusIcon = ['Pending' => 'fa-clock-o', 'Approved' => 'fa-check-circle', 'Rejected' => 'fa-times-circle'][$statusVal] ?? 'fa-clock-o';
$previewPdf = $this->Url->build('/admin/stocks/preview_product_warranty_certificate/' . $sid);
$previewHtml = $this->Url->build('/admin/stocks/preview_product_warranty_certificate_html/' . $sid);
$cert = trim((string)($record['certificate'] ?? ''));
$certUrl = $cert !== '' ? ($webroot . '/' . ltrim($cert, '/')) : '';
$sig = trim((string)($record['contractor_signature'] ?? ''));
$sigUrl = $sig !== '' ? ($webroot . '/signature/' . ltrim($sig, '/')) : '';
$fmt = static function ($value, $pattern = 'd M Y') {
    if ($value === null || $value === '') {
        return '';
    }
    return format_db_date($pattern, $value);
};
$val = static function ($value) {
    $t = trim((string)$value);
    return $t !== '' ? $t : '—';
};
$serial = (string)($record['serialnumber'] ?? ('#' . $sid));
$email = trim((string)($record['email'] ?? ''));
$phone = trim((string)($record['phone'] ?? ''));
$row = static function ($label, $valueHtml) {
    echo '<tr><th>' . h($label) . '</th><td>' . $valueHtml . '</td></tr>';
};
?>
<?php $this->start('css'); ?>
<style>
.wp-view-head { margin-bottom: 12px; }
.wp-view-head h1 { margin: 4px 0 6px; font-size: 24px; }
.wp-view-meta { color: #6b7c8f; margin: 0 0 10px; }
.wp-view-bar { display: flex; flex-wrap: wrap; gap: 8px; align-items: center; margin: 10px 0 14px; }
.wp-view-grid { display: table; width: 100%; border-spacing: 14px 0; margin: 0 -14px; }
.wp-view-col { display: table-cell; width: 46%; vertical-align: top; }
.wp-view-col.pdf { width: 54%; }
.wp-fields { width: 100%; border-collapse: collapse; }
.wp-fields th { width: 38%; text-align: left; color: #6b7c8f; font-weight: 600; font-size: 12px; padding: 8px 10px; border-bottom: 1px solid #edf1f5; background: #f7fafc; vertical-align: top; }
.wp-fields td { padding: 8px 10px; border-bottom: 1px solid #edf1f5; font-weight: 600; }
.wp-view-seg { display: none; }
.wp-view-seg.is-on { display: block; }
.wp-pdf-frame { width: 100%; height: 780px; border: 1px solid #d8dee6; border-radius: 10px; background: #f8fafc; }
.wp-sig { max-width: 220px; max-height: 80px; border: 1px solid #d8dee6; padding: 4px; background: #fff; }
@media (max-width: 992px) {
  .wp-view-grid, .wp-view-col { display: block; width: 100%; }
  .wp-view-col { margin-bottom: 14px; }
  .wp-pdf-frame { height: 520px; }
}
</style>
<?php $this->end(); ?>
<?php if (!empty($csrfToken)) { echo $this->Form->hidden('_csrfToken', ['id' => 'csrf-token-field', 'value' => $csrfToken]); } ?>

<div class="wp-view-head">
    <a href="<?= $this->Url->build(['action' => 'admin_warranty_dashboard', '?' => ['id' => $sid]]) ?>">← Dashboard</a>
    <h1><?= h($serial) ?> <span class="wp-pill <?= h($pill) ?>"><i class="fa <?= h($statusIcon) ?>"></i> <?= h($statusVal) ?></span></h1>
    <p class="wp-view-meta"><?= h($val($record['product'] ?? '')) ?> · <?= h($val($record['contract_company_name'] ?? '')) ?> · <?= h($val($record['building_name'] ?? '')) ?></p>
    <div class="wp-view-bar">
        <?php if ($statusVal === 'Pending') : ?>
            <a class="wp-btn wp-btn-outline" href="<?= $this->Url->build(['action' => 'admin_edit_product_warranty', $sid]) ?>"><i class="fa fa-pencil"></i> Edit</a>
            <button type="button" class="wp-btn wp-btn-blue approveBtn" data-id="<?= $sid ?>"><i class="fa fa-check"></i> Approve</button>
            <button type="button" class="wp-btn wp-btn-red rejectBtn" data-id="<?= $sid ?>"><i class="fa fa-times"></i> Reject</button>
        <?php endif; ?>
        <a class="wp-btn wp-btn-outline" href="<?= h($previewPdf) ?>" target="_blank"><i class="fa fa-file-pdf-o"></i> Open PDF</a>
        <a class="wp-btn wp-btn-outline" href="<?= h($previewHtml) ?>" target="_blank"><i class="fa fa-file-text-o"></i> HTML</a>
        <?php if ($certUrl !== '') : ?>
            <a class="wp-btn wp-btn-green" href="<?= h($certUrl) ?>" target="_blank"><i class="fa fa-download"></i> Issued PDF</a>
        <?php endif; ?>
        <button type="button" class="wp-btn wp-btn-outline wp-seg is-on" data-seg="details">Details</button>
        <button type="button" class="wp-btn wp-btn-outline wp-seg" data-seg="pdf">Certificate</button>
        <button type="button" class="wp-btn wp-btn-outline wp-seg" data-seg="activity">Activity<?= !empty($events) ? ' (' . count($events) . ')' : '' ?></button>
    </div>
</div>

<div class="wp-view-grid wp-view-seg is-on" id="seg-details">
    <div class="wp-view-col">
        <div class="wp-card">
            <h2>Product &amp; site</h2>
            <table class="wp-fields">
                <?php
                $row('Serial', h($serial));
                $row('Purchase date', h($val($fmt($record['dateofpurchase'] ?? null))));
                $row('Product', h($val($record['product'] ?? '')));
                $row('Used as', nl2br(h($val($record['used_as'] ?? ''))));
                $row('Application', nl2br(h($val($record['application'] ?? ''))));
                $row('Area warranted', h($val($record['area_warranted'] ?? '')));
                $row('Building / project', h($val($record['building_name'] ?? '')));
                $row('Building area', h($val($record['building_area_name'] ?? '')));
                $row('Site address', nl2br(h($val($record['building_address'] ?? ''))));
                $row('Warranty start', h($val($fmt($record['start_requested_warranty'] ?? null))));
                $row('Warranty end', h($val($fmt($record['end_requested_warranty'] ?? null))));
                $row('Submitted', h($val($fmt($record['created_at'] ?? null, 'd M Y H:i'))));
                ?>
            </table>
        </div>
        <div class="wp-card" style="margin-top:14px;">
            <h2>Contractor</h2>
            <table class="wp-fields">
                <?php
                $row('Company', h($val($record['contract_company_name'] ?? '')));
                $row('Name', h($val($record['contract_name'] ?? ($record['applicator'] ?? ''))));
                $row('ABN', h($val($record['applicator_active_abn'] ?? '')));
                $row('Company address', nl2br(h($val($record['applicator_address'] ?? ''))));
                $row('Email', $email !== '' ? '<a href="mailto:' . h($email) . '">' . h($email) . '</a>' : '—');
                $row('Phone', $phone !== '' ? '<a href="tel:' . h($phone) . '">' . h($phone) . '</a>' : '—');
                $row('Sign date', h($val($fmt($record['sign_date'] ?? null))));
                ?>
                <tr>
                    <th>Signature</th>
                    <td>
                        <?php if ($sigUrl !== '') : ?>
                            <img class="wp-sig" src="<?= h($sigUrl) ?>" alt="Contractor signature">
                        <?php else : ?>
                            Not on file
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="wp-view-col pdf">
        <div class="wp-card">
            <h2>Certificate preview <a class="wp-btn wp-btn-outline" style="float:right;padding:6px 10px;" href="<?= h($previewPdf) ?>" target="_blank">New tab</a></h2>
            <iframe class="wp-pdf-frame" src="<?= h($previewPdf) ?>" title="Warranty certificate PDF"></iframe>
            <?php if ($certUrl === '') : ?>
                <p style="margin:10px 0 0;color:#6b7c8f;font-size:13px;">Issued PDF is created after Approve.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="wp-view-seg" id="seg-pdf">
    <div class="wp-card">
        <h2>Certificate PDF</h2>
        <iframe class="wp-pdf-frame" src="<?= h($previewPdf) ?>" title="Warranty certificate PDF full"></iframe>
    </div>
</div>

<div class="wp-view-seg" id="seg-activity">
    <div class="wp-card">
        <h2>Activity history</h2>
        <ul class="wp-activity">
            <?php if (empty($events)) : ?>
                <li>No history rows yet for this record.</li>
            <?php else : ?>
                <?php foreach ($events as $ev) : ?>
                    <li>
                        <strong><?= h($ev['action'] ?? '') ?></strong>
                        <?= h($ev['serialnumber'] ?? '') ?>
                        <br><small><?= h($ev['message'] ?? '') ?> — <?= h($ev['created'] ?? '') ?> — <?= h($ev['actor_name'] ?? '') ?></small>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
</div>
<?php $this->start('script'); ?>
<script>
$(function() {
    var approveUrl = <?= json_encode($this->Url->build(['controller' => 'Stocks', 'action' => 'admin_approve_warranty'])) ?>;
    var rejectUrl = <?= json_encode($this->Url->build(['controller' => 'Stocks', 'action' => 'admin_reject_warranty'])) ?>;
    var csrf = $('input[name="_csrfToken"]').val() || '';
    $('.wp-seg').on('click', function() {
        var name = $(this).data('seg');
        $('.wp-seg').removeClass('is-on');
        $(this).addClass('is-on');
        $('.wp-view-seg').removeClass('is-on');
        $('#seg-' + name).addClass('is-on');
    });
    function post(url, id, msg) {
        if (!confirm(msg)) return;
        $.ajax({
            url: url, type: 'POST',
            data: { id: id, _csrfToken: csrf },
            headers: csrf ? { 'X-CSRF-Token': csrf } : {},
            success: function(response) {
                var data = response;
                try { if (typeof response === 'string') data = JSON.parse(response); } catch (e) { data = response; }
                if ((data && data.status === 'success') || String(response).trim() === 'success') {
                    location.reload();
                } else {
                    alert('Unable to update this request.');
                }
            },
            error: function() { alert('Request failed.'); }
        });
    }
    $('.approveBtn').on('click', function() {
        post(approveUrl, $(this).data('id'), 'Approve and email the certificate to the customer?');
    });
    $('.rejectBtn').on('click', function() {
        post(rejectUrl, $(this).data('id'), 'Reject this warranty request?');
    });
});
</script>
<?php $this->end(); ?>
