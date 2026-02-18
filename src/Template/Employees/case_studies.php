<div class="page-header">
    <h1>Case Studies</h1>
    <a href="<?php echo $this->Url->build(['controller' => 'Employees', 'action' => 'case_add']); ?>" class="btn btn-primary pull-right">Add New Case Study</a>
</div>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Project Name</th>
            <th>Challenge</th>
            <th>Solution</th>
            <th>Outcome</th>
            <th>Created By</th>
            <th>Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($caseStudies)): $i = 1; ?>
            <?php foreach ($caseStudies as $case):
                // Support both CakePHP 3 entities and CakePHP 2 array shape
                if (is_object($case) && method_exists($case, 'toArray')) {
                    $caseData = $case->toArray();
                    $caseId = $case->id ?? null;
                    $title = $case->title ?? '';
                    $challenge = $case->challenge ?? '';
                    $solution = $case->solution ?? '';
                    $outcome = $case->outcome ?? '';
                    $projectDate = $case->project_date ?? '';
                    $status = (bool)($case->status ?? false);
                    $employeeName = ($case->employee && is_object($case->employee)) ? ($case->employee->name ?? '') : (isset($caseData['employee']['name']) ? $caseData['employee']['name'] : 'Admin');
                } else {
                    $caseData = $case['CaseStudy'] ?? $case;
                    $caseId = $caseData['id'] ?? null;
                    $title = $caseData['title'] ?? '';
                    $challenge = $caseData['challenge'] ?? '';
                    $solution = $caseData['solution'] ?? '';
                    $outcome = $caseData['outcome'] ?? '';
                    $projectDate = $caseData['project_date'] ?? '';
                    $status = !empty($caseData['status']);
                    $employeeName = !empty($case['Employee']['name']) ? $case['Employee']['name'] : 'Admin';
                }
                // Strip HTML tags and decode entities for plain-text display in listing
                $stripHtml = function($str) {
                    if ($str === null || $str === '') return '';
                    $str = strip_tags((string)$str);
                    $str = html_entity_decode($str, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                    return trim(preg_replace('/\s+/', ' ', $str));
                };
                $challenge = $stripHtml($challenge);
                $solution = $stripHtml($solution);
                $outcome = $stripHtml($outcome);
            ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo h($title); ?></td>
                    <td><?php echo h($challenge); ?></td>
                    <td><?php echo h($solution); ?></td>
                    <td><?php echo h($outcome); ?></td>
                    <td><?php echo h($employeeName); ?></td>
                    <td><?php echo h($projectDate); ?></td>
                    <td>
                        <?php if ($status): ?>
                            <span class="badge badge-success">Active</span>
                        <?php else: ?>
                            <span class="badge badge-secondary">Inactive</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Actions">
                            <a href="<?php echo $this->Url->build(['controller' => 'Employees', 'action' => 'case_edit', $caseId]); ?>" class="btn btn-sm btn-info">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <a href="<?php echo $this->Url->build(['controller' => 'Employees', 'action' => 'case_delete', $caseId]); ?>" class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure you want to delete this case study?');">
                                <i class="fa fa-trash"></i> Delete
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="9" class="text-center text-muted">No case studies found.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?php if (!empty($caseStudies) && $this->Paginator->numbers()): ?>
<div class="text-center" style="margin-top: 10px;">
    <ul class="pagination" style="margin:0;">
        <?php echo $this->Paginator->first('<< First'); ?>
        <?php echo $this->Paginator->prev('< Prev'); ?>
        <?php echo $this->Paginator->numbers(); ?>
        <?php echo $this->Paginator->next('Next >'); ?>
        <?php echo $this->Paginator->last('Last >>'); ?>
    </ul>
    <div style="margin-top:6px;"><?php echo $this->Paginator->counter('{{start}}-{{end}} of {{count}} records'); ?></div>
</div>
<?php endif; ?>

