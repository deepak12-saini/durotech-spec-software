
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
        <h1>Product Warranty Request List</h1>
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
                            <th>Status</th>
                            <th>Certificate</th>
                            <th>Date Submitted</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (empty($productWarrantyRequests)) {
                            echo '<tr><td colspan="9" class="text-center text-muted">No records found.</td></tr>';
                        } else {
                            foreach ($productWarrantyRequests as $request) {
                                $rowId = (int)($request['ProductWarrantyRequest']['id'] ?? 0);
                        ?>
                        <tr>
                            <td><?= h($request['ProductWarrantyRequest']['id']); ?></td>
                            <td><?= h($request['ProductWarrantyRequest']['serialnumber']); ?></td>
                            <td><?= h($request['ProductWarrantyRequest']['product']); ?></td>
                            <td><?= h($request['ProductWarrantyRequest']['used_as']); ?></td>
                            <td><?= h($request['ProductWarrantyRequest']['building_name']); ?></td>
                            <td>
                                   <?= !empty($request['ProductWarrantyRequest']['status']) ? h($request['ProductWarrantyRequest']['status']) : 'Pending'; ?>

                            </td>
                            <td>
                                <?php if (!empty($request['ProductWarrantyRequest']['certificate'])): ?>
                                    <?php
                                        $cert = $request['ProductWarrantyRequest']['certificate'];
                                        $pathDir = strpos($cert, '/') !== false ? dirname($cert) . '/' : 'pdf/FPDI/';
                                        $pathName = strpos($cert, '/') !== false ? basename($cert) : $cert;
                                        // Webroot file: prefix webroot so /cake3app/pdf/... is used (avoids Cake routing /pdf as controller).
                                        $webroot = (string)$this->getRequest()->getAttribute('webroot');
                                        $fileUrl = rtrim($webroot, '/') . '/' . trim($pathDir, '/') . '/' . rawurlencode($pathName);
                                    ?>
                                    <a href="<?= h($fileUrl); ?>" target="_blank" class="btn btn-xs btn-primary">
                                        View PDF
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">Not Available</span>
                                <?php endif; ?>
                            </td>


                            <td><?= !empty($request['ProductWarrantyRequest']['created_at']) ? date('d/m/Y', strtotime($request['ProductWarrantyRequest']['created_at'])) : ''; ?></td>
                            <td>
                                <button type="button" class="btn btn-xs btn-info autoModal" data-target="#detailModal_<?= $rowId; ?>">
                                    View Details
                                </button>

                                <?php
                                $statusVal = (string)($request['ProductWarrantyRequest']['status'] ?? '');
                                $isPending = ($statusVal === '' || $statusVal === 'Pending');
                                $draftPreviewUrl = $this->Url->build(
                                    '/admin/stocks/preview_product_warranty_certificate/' . (int)($request['ProductWarrantyRequest']['id'] ?? 0)
                                );
                                ?>
                                <a href="<?= h($draftPreviewUrl); ?>" target="_blank" class="btn btn-xs btn-warning" title="Opens a temporary PDF built from current form data in the database. Does not overwrite the saved certificate. Use with View PDF to compare draft vs saved file.">
                                    Preview PDF
                                </a>

                                <?php if ($isPending): ?>
                                    <button type="button" class="btn btn-xs btn-success approveBtn" data-id="<?= $request['ProductWarrantyRequest']['id']; ?>">
                                        Approve
                                    </button>
                                <?php else: ?>
                                    <span class="label label-default"><?= h($request['ProductWarrantyRequest']['status']); ?></span>
                                <?php endif; ?>


                                <a href="<?= $this->Url->build(['controller' => 'Stocks', 'action' => 'admin_delete_product_warranty', $request['ProductWarrantyRequest']['id'] ?? '']); ?>" 
                                        class="btn btn-xs btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this warranty request?');">
                                        Delete
                                </a>

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

    <!-- Modals (outside table) -->
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
                        <tr><th>Date Of Purchase:</th><td><?= !empty($request['ProductWarrantyRequest']['dateofpurchase']) ? date('d/m/Y', strtotime($request['ProductWarrantyRequest']['dateofpurchase'])) : ''; ?></td></tr>
                        <tr><th>Product:</th><td><?= h($request['ProductWarrantyRequest']['product']); ?></td></tr>
                        <tr><th>Used As:</th><td><?= h($request['ProductWarrantyRequest']['used_as']); ?></td></tr>
                        <tr><th>Application:</th><td><?= h($request['ProductWarrantyRequest']['application']); ?></td></tr>
                        <tr><th>Area Warranted:</th><td><?= h($request['ProductWarrantyRequest']['area_warranted']); ?></td></tr>
                        <tr><th>Building Address:</th><td><?= h($request['ProductWarrantyRequest']['building_address']); ?></td></tr>
                        <tr><th>Building Name:</th><td><?= h($request['ProductWarrantyRequest']['building_name']); ?></td></tr>
                        <tr><th>Start Warranty Date:</th><td><?= !empty($request['ProductWarrantyRequest']['start_requested_warranty']) ? date('d/m/Y', strtotime($request['ProductWarrantyRequest']['start_requested_warranty'])) : ''; ?></td></tr>
                        <tr><th>End Warranty Date:</th><td><?= !empty($request['ProductWarrantyRequest']['end_requested_warranty']) ? date('d/m/Y', strtotime($request['ProductWarrantyRequest']['end_requested_warranty'])) : ''; ?></td></tr>
                        <tr><th>Contractor Company Name:</th><td><?= h($request['ProductWarrantyRequest']['contract_company_name']); ?></td></tr>
                        <tr><th>Contractor Name:</th><td><?= h($request['ProductWarrantyRequest']['contract_name']); ?></td></tr>
                        <tr><th>Sign Date:</th><td><?= !empty($request['ProductWarrantyRequest']['sign_date']) ? date('d/m/Y', strtotime($request['ProductWarrantyRequest']['sign_date'])) : ''; ?></td></tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <?php } } ?>

<!-- jQuery + Bootstrap JS -->
<!-- <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->

<script>
$(document).ready(function() {
    $('.autoModal').click(function() {
        var target = $(this).data('target'); // Get modal ID
        $(target).modal('show');             // Open modal

        // // Automatically hide after 5 seconds
        // setTimeout(function() {
        //     $(target).modal('hide');
        // }, 5000);
    });
});
</script>

<script>
$(document).ready(function() {
    // Approve button click – include CSRF token for CakePHP 3
    var approveUrl = '<?= $this->Url->build(['controller' => 'Stocks', 'action' => 'admin_approve_warranty']); ?>';
    var csrfToken = $('input[name="_csrfToken"]').val() || '';
    if (!csrfToken) {
        var m = document.cookie.match(/(?:^|;\s*)csrfToken=([^;]+)/);
        csrfToken = m ? decodeURIComponent(m[1]) : '';
    }

    $('.approveBtn').click(function() {
        var id = $(this).data('id');
        var btn = $(this);

        $.ajax({
            url: approveUrl,
            type: 'POST',
            data: { id: id, _csrfToken: csrfToken },
            headers: csrfToken ? { 'X-CSRF-Token': csrfToken } : {},
            success: function(response) {
                if(response.trim() == 'success') {
                    btn.replaceWith('<span class="label label-success">Approved</span>');
                     setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    alert('Error! Please try again.');
                }
            },
            error: function(xhr) {
                alert('AJAX error! Status: ' + xhr.status);
            }
        });
    });

});
</script>

