
<style>
    .btn { margin-bottom: 5px; }
</style>
<?php
// CSRF token for AJAX (cookie is httpOnly so must output in page)
$csrfToken = $this->getRequest()->getCookie('csrfToken');
if (!empty($csrfToken)) {
    echo $this->Form->hidden('_csrfToken', ['id' => 'csrf-token-field', 'value' => $csrfToken]);
}
?>
<div class="page-content">
    <div class="page-header">
        <h1>
            Product Warranty Request List
            <small><?= $this->Html->link('Warranty portal', ['action' => 'admin_warranty_dashboard']); ?>
            · <?= $this->Html->link('Classic log', ['action' => 'admin_product_warranty_log']); ?></small>
        </h1>
    </div>

    <?php
    $filterQ = (string)$this->request->getQuery('q', '');
    $filterStatus = (string)$this->request->getQuery('status', '');
    $pagerQuery = array_filter(
        $this->request->getQueryParams(),
        static function ($v) {
            return $v !== '' && $v !== null;
        }
    );
    unset($pagerQuery['page']);
    ?>
    <div class="row" style="margin-bottom: 15px;">
        <div class="col-xs-12">
            <?= $this->Form->create(null, ['type' => 'get', 'class' => 'form-inline', 'url' => ['action' => 'admin_product_warranty_request']]); ?>
            <div class="form-group" style="margin-right: 10px;">
                <?= $this->Form->text('q', [
                    'class' => 'form-control',
                    'placeholder' => 'Search serial, product, building, applicator…',
                    'value' => $filterQ,
                    'style' => 'min-width: 280px;',
                ]); ?>
            </div>
            <div class="form-group" style="margin-right: 10px;">
                <?= $this->Form->select('status', [
                    '' => 'All statuses',
                    'Pending' => 'Pending',
                    'Approved' => 'Approved',
                    'Rejected' => 'Rejected',
                ], [
                    'class' => 'form-control',
                    'value' => $filterStatus,
                ]); ?>
            </div>
            <?= $this->Form->button('Search', ['class' => 'btn btn-primary', 'type' => 'submit']); ?>
            <?= $this->Html->link('Reset', ['action' => 'admin_product_warranty_request'], ['class' => 'btn btn-default']); ?>
            <?= $this->Form->end(); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="example">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Serial Number</th>
                            <th>Product</th>
                            <th>Used As</th>
                            <th>Building Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Certificate</th>
                            <th>Date Submitted</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (empty($productWarrantyRequests)) {
                            echo '<tr><td colspan="10" class="text-center text-muted">No records found.</td></tr>';
                        } else {
                            foreach ($productWarrantyRequests as $request) {
                                $rowId = (int)($request['ProductWarrantyRequest']['id'] ?? 0);
                                $statusVal = (string)($request['ProductWarrantyRequest']['status'] ?? '');
                                if ($statusVal === '') {
                                    $statusVal = 'Pending';
                                }
                                $isPending = ($statusVal === 'Pending');
                                $statusClass = 'label-default';
                                if ($statusVal === 'Pending') {
                                    $statusClass = 'label-warning';
                                } elseif ($statusVal === 'Approved') {
                                    $statusClass = 'label-success';
                                } elseif ($statusVal === 'Rejected') {
                                    $statusClass = 'label-danger';
                                }
                        ?>
                        <tr>
                            <td><?= h($request['ProductWarrantyRequest']['id']); ?></td>
                            <td><?= h($request['ProductWarrantyRequest']['serialnumber']); ?></td>
                            <td><?= h($request['ProductWarrantyRequest']['product']); ?></td>
                            <td><?= h($request['ProductWarrantyRequest']['used_as']); ?></td>
                            <td><?= h($request['ProductWarrantyRequest']['building_name']); ?></td>
                            <td><?= h($request['ProductWarrantyRequest']['email'] ?? ''); ?></td>
                            <td><span class="label <?= $statusClass; ?>"><?= h($statusVal); ?></span></td>
                            <td>
                                <?php if (!empty($request['ProductWarrantyRequest']['certificate'])): ?>
                                    <?php
                                        $cert = $request['ProductWarrantyRequest']['certificate'];
                                        $pathDir = strpos($cert, '/') !== false ? dirname($cert) . '/' : 'pdf/FPDI/';
                                        $pathName = strpos($cert, '/') !== false ? basename($cert) : $cert;
                                        $webroot = (string)$this->getRequest()->getAttribute('webroot');
                                        $fileUrl = rtrim($webroot, '/') . '/' . trim($pathDir, '/') . '/' . rawurlencode($pathName);
                                    ?>
                                    <a href="<?= h($fileUrl); ?>" target="_blank" class="btn btn-xs btn-primary">View PDF</a>
                                <?php else: ?>
                                    <span class="text-muted">Not Available</span>
                                <?php endif; ?>
                            </td>
                            <td><?= !empty($request['ProductWarrantyRequest']['created_at']) ? format_db_date('d/m/Y', $request['ProductWarrantyRequest']['created_at']) : ''; ?></td>
                            <td>
                                <button type="button" class="btn btn-xs btn-info autoModal" data-target="#detailModal_<?= $rowId; ?>">View Details</button>
                                <?php
                                $draftPreviewUrl = $this->Url->build(
                                    '/admin/stocks/preview_product_warranty_certificate/' . (int)($request['ProductWarrantyRequest']['id'] ?? 0)
                                );
                                ?>
                                <a href="<?= h($draftPreviewUrl); ?>" target="_blank" class="btn btn-xs btn-warning" title="Preview certificate PDF from current form data.">Preview PDF</a>
                                <?php if ($isPending): ?>
                                    <a href="<?= $this->Url->build(['controller' => 'Stocks', 'action' => 'admin_edit_product_warranty', $request['ProductWarrantyRequest']['id'] ?? '']); ?>"
                                       class="btn btn-xs btn-default"
                                       title="Edit details before approving. Does not email the customer.">Edit</a>
                                    <button type="button" class="btn btn-xs btn-success approveBtn" data-id="<?= $request['ProductWarrantyRequest']['id']; ?>">Approve</button>
                                    <button type="button" class="btn btn-xs btn-danger rejectBtn" data-id="<?= $request['ProductWarrantyRequest']['id']; ?>">Reject</button>
                                <?php endif; ?>
                                <a href="<?= $this->Url->build(['controller' => 'Stocks', 'action' => 'admin_delete_product_warranty', $request['ProductWarrantyRequest']['id'] ?? '']); ?>"
                                   class="btn btn-xs btn-danger"
                                   onclick="return confirm('Are you sure you want to delete this warranty request?');">Delete</a>
                            </td>
                        </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
            <?php if (!empty($productWarrantyRequests)) : ?>
                <?php $this->Paginator->options(['url' => ['?' => $pagerQuery]]); ?>
                <div class="clearfix" style="margin-top: 12px;">
                    <ul class="pagination pagination-sm pull-left" style="margin: 0;">
                        <?= $this->Paginator->first('&laquo;', ['escape' => false]); ?>
                        <?= $this->Paginator->prev('< ' . __('previous')); ?>
                        <?= $this->Paginator->numbers(['modulus' => 4]); ?>
                        <?= $this->Paginator->next(__('next') . ' >'); ?>
                        <?= $this->Paginator->last('&raquo;', ['escape' => false]); ?>
                    </ul>
                    <p class="text-muted pull-right" style="margin: 8px 0 0;">
                        <?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')); ?>
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
if (!empty($productWarrantyRequests)) {
    foreach ($productWarrantyRequests as $request) {
        $rowId = (int)($request['ProductWarrantyRequest']['id'] ?? 0);
?>
<div id="detailModal_<?= $rowId; ?>" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Product Warranty Request Details</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr><th>Serial Number:</th><td><?= h($request['ProductWarrantyRequest']['serialnumber']); ?></td></tr>
                    <tr><th>Date Of Purchase:</th><td><?= !empty($request['ProductWarrantyRequest']['dateofpurchase']) ? format_db_date('d/m/Y', $request['ProductWarrantyRequest']['dateofpurchase']) : ''; ?></td></tr>
                    <tr><th>Product:</th><td><?= h($request['ProductWarrantyRequest']['product']); ?></td></tr>
                    <tr><th>Used As:</th><td><?= h($request['ProductWarrantyRequest']['used_as']); ?></td></tr>
                    <tr><th>Application:</th><td><?= h($request['ProductWarrantyRequest']['application']); ?></td></tr>
                    <tr><th>Area Warranted:</th><td><?= h($request['ProductWarrantyRequest']['area_warranted']); ?></td></tr>
                    <tr><th>Building Address:</th><td><?= h($request['ProductWarrantyRequest']['building_address']); ?></td></tr>
                    <tr><th>Building Name:</th><td><?= h($request['ProductWarrantyRequest']['building_name']); ?></td></tr>
                    <tr><th>Start Warranty Date:</th><td><?= !empty($request['ProductWarrantyRequest']['start_requested_warranty']) ? format_db_date('d/m/Y', $request['ProductWarrantyRequest']['start_requested_warranty']) : ''; ?></td></tr>
                    <tr><th>End Warranty Date:</th><td><?= !empty($request['ProductWarrantyRequest']['end_requested_warranty']) ? format_db_date('d/m/Y', $request['ProductWarrantyRequest']['end_requested_warranty']) : ''; ?></td></tr>
                    <tr><th>Contractor Company Name:</th><td><?= h($request['ProductWarrantyRequest']['contract_company_name']); ?></td></tr>
                    <tr><th>ABN No.:</th><td><?= h($request['ProductWarrantyRequest']['applicator_active_abn']); ?></td></tr>
                    <tr><th>Company Address:</th><td><?= nl2br(h($request['ProductWarrantyRequest']['applicator_address'])); ?></td></tr>
                    <tr><th>Contractor Name:</th><td><?= h($request['ProductWarrantyRequest']['contract_name']); ?></td></tr>
                    <tr><th>Email:</th><td><?= h($request['ProductWarrantyRequest']['email'] ?? ''); ?></td></tr>
                    <tr><th>Mobile:</th><td><?= h($request['ProductWarrantyRequest']['phone'] ?? ''); ?></td></tr>
                    <tr><th>Sign Date:</th><td><?= !empty($request['ProductWarrantyRequest']['sign_date']) ? format_db_date('d/m/Y', $request['ProductWarrantyRequest']['sign_date']) : ''; ?></td></tr>
                    <tr><th>Signature:</th><td><?php if (!empty($request['ProductWarrantyRequest']['contractor_signature'])) : ?><img src="<?= h((defined('SITEURL') ? rtrim((string)SITEURL, '/') : '') . '/signature/' . $request['ProductWarrantyRequest']['contractor_signature']) ?>" alt="Signature" style="max-width:220px;max-height:80px;border:1px solid #ddd;"><?php else : ?>—<?php endif; ?></td></tr>
                    <tr><th>Status:</th><td><?= h($request['ProductWarrantyRequest']['status'] ?: 'Pending'); ?></td></tr>
                </table>
            </div>
            <div class="modal-footer">
                <?php
                $modalStatus = trim((string)($request['ProductWarrantyRequest']['status'] ?? ''));
                if ($modalStatus === '') {
                    $modalStatus = 'Pending';
                }
                if ($modalStatus === 'Pending') :
                ?>
                    <a href="<?= $this->Url->build(['controller' => 'Stocks', 'action' => 'admin_edit_product_warranty', $rowId]); ?>" class="btn btn-primary">Edit</a>
                <?php endif; ?>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php } } ?>

<script>
$(document).ready(function() {
    $('.autoModal').click(function() {
        $($(this).data('target')).modal('show');
    });

    var approveUrl = '<?= $this->Url->build(['controller' => 'Stocks', 'action' => 'admin_approve_warranty']); ?>';
    var rejectUrl = '<?= $this->Url->build(['controller' => 'Stocks', 'action' => 'admin_reject_warranty']); ?>';
    var csrfToken = $('input[name="_csrfToken"]').val() || '';
    if (!csrfToken) {
        var m = document.cookie.match(/(?:^|;\s*)csrfToken=([^;]+)/);
        csrfToken = m ? decodeURIComponent(m[1]) : '';
    }

    function postWarrantyAction(url, id, confirmMsg) {
        if (!confirm(confirmMsg)) {
            return;
        }
        $.ajax({
            url: url,
            type: 'POST',
            data: { id: id, _csrfToken: csrfToken },
            headers: csrfToken ? { 'X-CSRF-Token': csrfToken } : {},
            success: function(response) {
                var data = null;
                try {
                    data = typeof response === 'string' ? JSON.parse(response) : response;
                } catch (e) {
                    data = null;
                }
                if (data && data.status === 'success') {
                    var msg = 'Warranty approved.';
                    if (data.emailSent && data.customerEmail) {
                        msg += '\n\nApproval email with certificate sent to:\n' + data.customerEmail;
                    } else if (data.customerEmail) {
                        msg += '\n\nCould not send email to ' + data.customerEmail + '. Share the portal link manually.';
                    } else {
                        msg += '\n\nNo customer email on file — share the portal link manually.';
                    }
                    if (data.portalUrl) {
                        msg += '\n\nCustomer portal link:\n' + data.portalUrl;
                    }
                    alert(msg);
                    location.reload();
                } else if (String(response).trim() === 'success') {
                    location.reload();
                } else {
                    alert('Unable to update this request.');
                }
            },
            error: function(xhr) {
                alert('Request failed. Status: ' + xhr.status);
            }
        });
    }

    $('.approveBtn').click(function() {
        postWarrantyAction(approveUrl, $(this).data('id'), 'Approve this warranty request and generate the certificate PDF?');
    });

    $('.rejectBtn').click(function() {
        postWarrantyAction(rejectUrl, $(this).data('id'), 'Reject this warranty request? No certificate will be issued.');
    });
});
</script>
