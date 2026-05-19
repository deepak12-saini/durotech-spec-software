<?php
$filters = isset($filters) && is_array($filters) ? $filters : [
    'keyword' => '',
    'status' => '',
    'date_from' => '',
    'date_to' => '',
];
$this->Paginator->options(['url' => ['?' => array_filter($filters, 'strlen')]]);
$stripHtml = function ($str) {
    if ($str === null || $str === '') {
        return '';
    }
    $str = strip_tags((string)$str);
    $str = html_entity_decode($str, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    return trim(preg_replace('/\s+/', ' ', $str));
};
$excerpt = function ($str, $limit = 80) use ($stripHtml) {
    $str = $stripHtml($str);
    return mb_strlen($str) > $limit ? mb_substr($str, 0, $limit) . '…' : $str;
};
?>

<style>
    .cs-admin .cs-page-header {
        align-items: flex-start;
        border-bottom: 1px solid #e8eef4;
        display: flex;
        gap: 16px;
        justify-content: space-between;
        margin-bottom: 18px;
        padding-bottom: 14px;
    }
    .cs-admin .cs-page-header h1 {
        display: block;
        float: none;
        font-size: 26px;
        font-weight: 600;
        line-height: 1.2;
        margin: 0 0 6px;
        width: auto;
    }
    .cs-admin .cs-page-header .page-sub {
        color: #7a8794;
        display: block;
        font-size: 13px;
        line-height: 1.4;
        margin: 0;
    }
    .cs-admin .cs-page-header .btn-add {
        flex-shrink: 0;
        margin-top: 4px;
    }
    .cs-admin .cs-filter-card,
    .cs-admin .cs-list-card {
        background: #fff;
        border: 1px solid #dbe5f1;
        border-radius: 10px;
        box-shadow: 0 4px 14px rgba(36, 92, 154, 0.06);
        margin-bottom: 18px;
        padding: 16px;
    }
    .cs-admin .cs-filter-card label {
        color: #41566d;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 4px;
    }
    .cs-admin .cs-filter-card .form-control {
        border-radius: 6px;
        height: 34px;
    }
    .cs-admin .cs-filter-actions {
        display: flex;
        gap: 6px;
        margin-top: 22px;
    }
    .cs-admin .cs-table {
        margin-bottom: 0;
    }
    .cs-admin .cs-table thead th {
        background: #f5f8fc;
        border-bottom: 1px solid #dbe5f1 !important;
        color: #41566d;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        vertical-align: middle;
        white-space: nowrap;
    }
    .cs-admin .cs-table tbody td {
        vertical-align: middle;
    }
    .cs-admin .cs-table tbody tr:hover {
        background: #f9fcff;
    }
    .cs-admin .cs-project strong {
        color: #2f4d6b;
        display: block;
    }
    .cs-admin .cs-project small {
        color: #7a8794;
    }
    .cs-admin .cs-excerpt {
        color: #555;
        font-size: 13px;
        line-height: 1.4;
        margin: 0;
        max-width: 200px;
    }
    .cs-admin .cs-status {
        border-radius: 999px;
        display: inline-block;
        font-size: 11px;
        font-weight: 700;
        padding: 4px 10px;
        white-space: nowrap;
    }
    .cs-admin .cs-status-inactive {
        background: #f1f3f5;
        color: #6c757d;
    }
    .cs-admin .cs-status-active {
        background: #fff4e5;
        color: #b7791f;
    }
    .cs-admin .cs-status-approved {
        background: #e8f7ee;
        color: #23834b;
    }
    .cs-admin .cs-actions .btn {
        margin-bottom: 0;
    }
    .cs-admin .cs-actions .btn-group {
        display: inline-flex;
        flex-wrap: nowrap;
    }
    .cs-admin .cs-empty {
        color: #7a8794;
        padding: 40px 16px;
        text-align: center;
    }
    .cs-admin .cs-pager {
        margin-top: 14px;
    }
    .cs-admin .cs-pager-info {
        color: #7a8794;
        font-size: 12px;
        margin-top: 8px;
        text-align: center;
    }
</style>

<div class="page-content cs-admin">
    <div class="cs-page-header">
        <div>
            <h1>Case Studies</h1>
            <p class="page-sub">Newest first. Use filters to find projects quickly.</p>
        </div>
        <a href="<?= $this->Url->build(['controller' => 'CaseStudies', 'action' => 'adminAdd']); ?>"
           class="btn btn-primary btn-sm btn-add">
            <i class="fa fa-plus"></i> Add New
        </a>
    </div>

    <div class="cs-filter-card">
        <?= $this->Form->create(null, ['type' => 'get', 'class' => 'row']); ?>
            <div class="col-sm-3">
                <label>Search</label>
                <input type="text" name="keyword" class="form-control input-sm"
                       value="<?= h($filters['keyword']); ?>"
                       placeholder="Project, location, challenge…">
            </div>
            <div class="col-sm-2">
                <label>Status</label>
                <select name="status" class="form-control input-sm">
                    <option value="">All</option>
                    <option value="0"<?= $filters['status'] === '0' ? ' selected' : ''; ?>>Inactive</option>
                    <option value="1"<?= $filters['status'] === '1' ? ' selected' : ''; ?>>Active</option>
                    <option value="2"<?= $filters['status'] === '2' ? ' selected' : ''; ?>>Approved</option>
                </select>
            </div>
            <div class="col-sm-2">
                <label>Project date from</label>
                <input type="date" name="date_from" class="form-control input-sm" value="<?= h($filters['date_from']); ?>">
            </div>
            <div class="col-sm-2">
                <label>Project date to</label>
                <input type="date" name="date_to" class="form-control input-sm" value="<?= h($filters['date_to']); ?>">
            </div>
            <div class="col-sm-3">
                <div class="cs-filter-actions">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Filter</button>
                    <a href="<?= $this->Url->build(['controller' => 'CaseStudies', 'action' => 'adminIndex']); ?>"
                       class="btn btn-default btn-sm">Reset</a>
                </div>
            </div>
        <?= $this->Form->end(); ?>
    </div>

    <div class="cs-list-card">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover cs-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Project</th>
                        <th>Challenge</th>
                        <th>Solution</th>
                        <th>Outcome</th>
                        <th>Created By</th>
                        <th>Project Date</th>
                        <th>Created At</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $hasRows = false;
                    if (!empty($caseStudies)) {
                        if (is_object($caseStudies) && method_exists($caseStudies, 'count')) {
                            $hasRows = $caseStudies->count() > 0;
                        } elseif (is_countable($caseStudies)) {
                            $hasRows = count($caseStudies) > 0;
                        }
                    }
                    ?>
                    <?php if (!$hasRows): ?>
                        <tr>
                            <td colspan="10" class="cs-empty">
                                <i class="fa fa-folder-open-o" style="font-size:36px;color:#c5cdd6;display:block;margin-bottom:10px;"></i>
                                No case studies match your filters.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php
                        $i = (int)$this->Paginator->param('start');
                        if ($i < 1) {
                            $i = 1;
                        }
                        foreach ($caseStudies as $case):
                            $c = is_object($case) ? $case : ($case['CaseStudy'] ?? []);
                            $caseId = is_object($c) ? ($c->id ?? null) : ($c['id'] ?? null);
                            $title = is_object($c) ? ($c->title ?? '') : ($c['title'] ?? '');
                            $location = is_object($c) ? ($c->location ?? '') : ($c['location'] ?? '');
                            $challenge = is_object($c) ? ($c->challenge ?? '') : ($c['challenge'] ?? '');
                            $solution = is_object($c) ? ($c->solution ?? '') : ($c['solution'] ?? '');
                            $outcome = is_object($c) ? ($c->outcome ?? '') : ($c['outcome'] ?? '');
                            $projectDate = is_object($c) ? ($c->project_date ?? '') : ($c['project_date'] ?? '');
                            $createdAt = is_object($c) ? ($c->created ?? null) : ($c['created'] ?? null);
                            $status = (int)(is_object($c) ? ($c->status ?? 0) : ($c['status'] ?? 0));
                            $createdAtFormatted = '';
                            if ($createdAt instanceof \DateTimeInterface) {
                                $createdAtFormatted = $createdAt->format('d M Y, H:i');
                            } elseif (!empty($createdAt)) {
                                $ts = strtotime((string)$createdAt);
                                $createdAtFormatted = $ts ? date('d M Y, H:i', $ts) : '';
                            }
                            $employeeName = null;
                            if (is_object($case) && $case->has('employee')) {
                                $employeeName = $case->employee->name ?? null;
                            } elseif (is_object($case) && $case->has('Employee')) {
                                $employeeName = $case->Employee->name ?? null;
                            } else {
                                $employeeName = $case['Employee']['name'] ?? null;
                            }
                        ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td class="cs-project">
                                <strong><?= h($stripHtml($title)); ?></strong>
                                <?php if ($location !== ''): ?>
                                    <small><i class="fa fa-map-marker"></i> <?= h($location); ?></small>
                                <?php endif; ?>
                            </td>
                            <td><p class="cs-excerpt" title="<?= h($stripHtml($challenge)); ?>"><?= h($excerpt($challenge)); ?></p></td>
                            <td><p class="cs-excerpt" title="<?= h($stripHtml($solution)); ?>"><?= h($excerpt($solution)); ?></p></td>
                            <td><p class="cs-excerpt" title="<?= h($stripHtml($outcome)); ?>"><?= h($excerpt($outcome)); ?></p></td>
                            <td><?= $employeeName ? h($employeeName) : 'Admin'; ?></td>
                            <td><?= $projectDate !== '' ? h($projectDate) : '<span class="text-muted">—</span>'; ?></td>
                            <td><?= $createdAtFormatted !== '' ? h($createdAtFormatted) : '<span class="text-muted">—</span>'; ?></td>
                            <td>
                                <?php if ($status === 0): ?>
                                    <span class="cs-status cs-status-inactive">Inactive</span>
                                <?php elseif ($status === 1): ?>
                                    <span class="cs-status cs-status-active">Active</span>
                                <?php elseif ($status === 2): ?>
                                    <span class="cs-status cs-status-approved">Approved</span>
                                <?php endif; ?>
                            </td>
                            <td class="cs-actions text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="<?= $this->Url->build(['controller' => 'CaseStudies', 'action' => 'adminEdit', $caseId]); ?>"
                                       class="btn btn-info" title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a href="<?= $this->Url->build(['controller' => 'CaseStudies', 'action' => 'adminDelete', $caseId]); ?>"
                                       class="btn btn-danger"
                                       onclick="return confirm('Delete this case study?');"
                                       title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    <?php if (in_array($status, [0, 1], true)): ?>
                                        <a href="<?= $this->Url->build(['controller' => 'CaseStudies', 'action' => 'adminApprove', $caseId]); ?>"
                                           class="btn btn-success"
                                           onclick="return confirm('Approve this case study?');"
                                           title="Approve">
                                            <i class="fa fa-check"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if ($hasRows): ?>
        <div class="cs-pager text-center">
            <ul class="pagination" style="margin:0;">
                <?= $this->Paginator->first('«'); ?>
                <?= $this->Paginator->prev('‹'); ?>
                <?= $this->Paginator->numbers(); ?>
                <?= $this->Paginator->next('›'); ?>
                <?= $this->Paginator->last('»'); ?>
            </ul>
            <div class="cs-pager-info"><?= $this->Paginator->counter('{{start}}–{{end}} of {{count}} case studies'); ?></div>
        </div>
        <?php endif; ?>
    </div>
</div>
