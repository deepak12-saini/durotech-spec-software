<?php
$filters = isset($filters) && is_array($filters) ? $filters : [
    'keyword' => '',
    'status' => '',
    'date_from' => '',
    'date_to' => '',
];
$this->Paginator->options(['url' => ['?' => array_filter($filters, 'strlen')]]);
$stripHtml = function($str) {
    if ($str === null || $str === '') return '';
    $str = strip_tags((string)$str);
    $str = html_entity_decode($str, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    return trim(preg_replace('/\s+/', ' ', $str));
};
$excerpt = function($str, $limit = 90) use ($stripHtml) {
    $str = $stripHtml($str);
    return strlen($str) > $limit ? substr($str, 0, $limit) . '...' : $str;
};
?>

<style>
    .case-page-header {
        align-items: center;
        display: flex;
        gap: 15px;
        justify-content: space-between;
        margin-bottom: 16px;
    }
    .case-page-header h1 {
        margin: 0;
    }
    .case-filter-card,
    .case-list-card {
        background: #fff;
        border: 1px solid #dbe5f1;
        border-radius: 14px;
        box-shadow: 0 8px 22px rgba(36, 92, 154, 0.08);
        margin-bottom: 18px;
        padding: 16px;
    }
    .case-filter-card .form-control {
        border: 1px solid #cfd8e3;
        border-radius: 7px;
        height: 36px;
    }
    .case-filter-actions {
        display: flex;
        gap: 6px;
        margin-top: 24px;
    }
    .case-action-btn {
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        line-height: 1.2;
        padding: 5px 10px;
    }
    .case-row-actions .case-action-btn {
        font-size: 11px;
        padding: 4px 8px;
    }
    .case-table {
        margin-bottom: 0;
    }
    .case-table thead th {
        background: #f5f8fc;
        border-bottom: 1px solid #dbe5f1 !important;
        color: #41566d;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
    }
    .case-table tbody tr:hover {
        background: #f9fcff;
    }
    .case-title {
        color: #2f4d6b;
        font-weight: 700;
    }
    .case-muted {
        color: #7a8794;
        font-size: 12px;
        margin-top: 3px;
    }
    .case-status {
        border-radius: 999px;
        display: inline-block;
        font-size: 11px;
        font-weight: 700;
        padding: 5px 10px;
    }
    .case-status-active {
        background: #e8f7ee;
        color: #23834b;
    }
    .case-status-inactive {
        background: #f1f3f5;
        color: #6c757d;
    }
    .case-row-actions {
        display: flex;
        gap: 6px;
        white-space: nowrap;
    }
    .case-empty {
        color: #7a8794;
        padding: 36px 10px;
        text-align: center;
    }
    .case-pager {
        border-top: 1px solid #e8eef5;
        margin-top: 14px;
        padding-top: 14px;
    }
    .case-pager .pagination > li > a,
    .case-pager .pagination > li > span {
        border-radius: 6px;
        color: #2f4d6b;
        margin: 0 2px;
    }
    .case-pager .pagination > .active > a,
    .case-pager .pagination > .active > span {
        background: #2889c8;
        border-color: #2889c8;
    }
    .case-pager-info {
        color: #7a8794;
        font-size: 12px;
        margin-top: 8px;
    }
    @media (max-width: 767px) {
        .case-page-header,
        .case-filter-actions {
            align-items: flex-start;
            flex-direction: column;
        }
        .case-row-actions {
            flex-direction: column;
        }
    }
</style>

<div class="page-header case-page-header">
    <div>
        <h1>Case Studies</h1>
        <div class="case-muted">Latest case studies are shown first.</div>
    </div>
    <a href="<?php echo $this->Url->build(['controller' => 'Employees', 'action' => 'case_add']); ?>" class="btn btn-primary case-action-btn">
        <i class="fa fa-plus"></i> Add New Case Study
    </a>
</div>

<div class="case-filter-card">
    <?php echo $this->Form->create(null, ['type' => 'get', 'class' => 'row']); ?>
        <div class="col-sm-4">
            <label>Search</label>
            <input type="text" name="keyword" class="form-control" value="<?php echo h($filters['keyword']); ?>" placeholder="Project, location, challenge...">
        </div>
        <div class="col-sm-2">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="">All</option>
                <option value="1"<?php echo $filters['status'] === '1' ? ' selected' : ''; ?>>Active</option>
                <option value="0"<?php echo $filters['status'] === '0' ? ' selected' : ''; ?>>Inactive</option>
            </select>
        </div>
        <div class="col-sm-2">
            <label>From Date</label>
            <input type="date" name="date_from" class="form-control" value="<?php echo h($filters['date_from']); ?>">
        </div>
        <div class="col-sm-2">
            <label>To Date</label>
            <input type="date" name="date_to" class="form-control" value="<?php echo h($filters['date_to']); ?>">
        </div>
        <div class="col-sm-2">
            <div class="case-filter-actions">
                <button type="submit" class="btn btn-primary case-action-btn"><i class="fa fa-search"></i> Filter</button>
                <a href="<?php echo $this->Url->build(['controller' => 'Employees', 'action' => 'case_studies']); ?>" class="btn btn-default case-action-btn">Reset</a>
            </div>
        </div>
    <?php echo $this->Form->end(); ?>
</div>

<div class="case-list-card">
    <div class="table-responsive">
        <table class="table table-hover case-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Project</th>
                    <th>Challenge</th>
                    <th>Solution</th>
                    <th>Outcome</th>
                    <th>Project Date</th>
                    <th>Created At</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($caseStudies)):
                    $i = (int)$this->Paginator->param('start');
                    if ($i < 1) {
                        $i = 1;
                    }
                ?>
                    <?php foreach ($caseStudies as $case):
                        if (is_object($case) && method_exists($case, 'toArray')) {
                            $caseData = $case->toArray();
                            $caseId = $case->id ?? null;
                            $title = $case->title ?? '';
                            $location = $case->location ?? '';
                            $challenge = $case->challenge ?? '';
                            $solution = $case->solution ?? '';
                            $outcome = $case->outcome ?? '';
                            $projectDate = $case->project_date ?? '';
                            $createdAt = $case->created ?? null;
                            $status = (bool)($case->status ?? false);
                        } else {
                            $caseData = $case['CaseStudy'] ?? $case;
                            $caseId = $caseData['id'] ?? null;
                            $title = $caseData['title'] ?? '';
                            $location = $caseData['location'] ?? '';
                            $challenge = $caseData['challenge'] ?? '';
                            $solution = $caseData['solution'] ?? '';
                            $outcome = $caseData['outcome'] ?? '';
                            $projectDate = $caseData['project_date'] ?? '';
                            $createdAt = $caseData['created'] ?? null;
                            $status = !empty($caseData['status']);
                        }
                        $createdAtFormatted = '';
                        if (!empty($createdAt) && $createdAt instanceof \DateTimeInterface) {
                            $createdAtFormatted = $createdAt->format('d M Y, H:i');
                        } elseif (!empty($createdAt)) {
                            $ts = strtotime((string)$createdAt);
                            $createdAtFormatted = $ts ? date('d M Y, H:i', $ts) : '';
                        }
                    ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td>
                                <div class="case-title"><?php echo h($title); ?></div>
                                <?php if ($location !== ''): ?>
                                    <div class="case-muted"><i class="fa fa-map-marker"></i> <?php echo h($location); ?></div>
                                <?php endif; ?>
                            </td>
                            <td><?php echo h($excerpt($challenge)); ?></td>
                            <td><?php echo h($excerpt($solution)); ?></td>
                            <td><?php echo h($excerpt($outcome)); ?></td>
                            <td><?php echo h($projectDate); ?></td>
                            <td><?php echo $createdAtFormatted !== '' ? h($createdAtFormatted) : '<span class="text-muted">—</span>'; ?></td>
                            <td>
                                <?php if ($status): ?>
                                    <span class="case-status case-status-active">Active</span>
                                <?php else: ?>
                                    <span class="case-status case-status-inactive">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="case-row-actions">
                                    <a href="<?php echo $this->Url->build(['controller' => 'Employees', 'action' => 'case_edit', $caseId]); ?>" class="btn btn-xs btn-info case-action-btn">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <a href="<?php echo $this->Url->build(['controller' => 'Employees', 'action' => 'case_delete', $caseId]); ?>" class="btn btn-xs btn-danger case-action-btn"
                                        onclick="return confirm('Are you sure you want to delete this case study?');">
                                        <i class="fa fa-trash"></i> Delete
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="9" class="case-empty">No case studies found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if (!empty($caseStudies)): ?>
    <div class="case-pager text-center">
        <ul class="pagination" style="margin:0;">
            <?php echo $this->Paginator->first('« First'); ?>
            <?php echo $this->Paginator->prev('‹ Prev'); ?>
            <?php echo $this->Paginator->numbers(['modulus' => 5]); ?>
            <?php echo $this->Paginator->next('Next ›'); ?>
            <?php echo $this->Paginator->last('Last »'); ?>
        </ul>
        <div class="case-pager-info">
            <?php echo $this->Paginator->counter('Page {{page}} of {{pages}} — showing {{start}}–{{end}} of {{count}} case studies'); ?>
        </div>
    </div>
    <?php endif; ?>
</div>
