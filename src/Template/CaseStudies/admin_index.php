
<div class="page-header">
    <h1>Case Studies</h1>
    <a href="<?= $this->Url->build(['controller' => 'CaseStudies', 'action' => 'adminAdd']); ?>" class="btn btn-primary pull-right">Add New Case Study</a>
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
                $c = is_object($case) ? $case : ($case['CaseStudy'] ?? []);
                $title = is_object($c) ? ($c->title ?? '') : ($c['title'] ?? '');
                $challenge = is_object($c) ? ($c->challenge ?? '') : ($c['challenge'] ?? '');
                $solution = is_object($c) ? ($c->solution ?? '') : ($c['solution'] ?? '');
                $outcome = is_object($c) ? ($c->outcome ?? '') : ($c['outcome'] ?? '');
                $projectDate = is_object($c) ? ($c->project_date ?? '') : ($c['project_date'] ?? '');
                $status = is_object($c) ? ($c->status ?? 0) : ($c['status'] ?? 0);
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
                    <td><?= strip_tags($title); ?></td>
                    <td><?= strip_tags($challenge); ?></td>
                    <td><?= strip_tags($solution); ?></td>
                    <td><?= strip_tags($outcome); ?></td>
                    <td><?= $employeeName ? h($employeeName) : 'Admin'; ?></td>
                    <td><?= strip_tags($projectDate); ?></td>
                    <td>
                        <?php if ($status == 0): ?>
                            <span class="badge badge-secondary">Inactive</span>
                        <?php elseif ($status == 1): ?>
                            <span class="badge badge-warning">Active</span>
                        <?php elseif ($status == 2): ?>
                            <span class="badge badge-success">Approved</span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <div class="btn-group" role="group" aria-label="Actions">
                            <?php $caseId = is_object($case) ? $case->id : ($case['CaseStudy']['id'] ?? null); ?>
                            <a href="<?= $this->Url->build(['controller' => 'CaseStudies', 'action' => 'adminEdit', $caseId]); ?>" 
                            class="btn btn-sm btn-info" title="Edit">
                                <i class="fa fa-edit"></i> Edit
                            </a>

                            <a href="<?= $this->Url->build(['controller' => 'CaseStudies', 'action' => 'adminDelete', $caseId]); ?>" 
                            class="btn btn-sm btn-danger" 
                            onclick="return confirm('Are you sure you want to delete this case study?');"
                            title="Delete">
                                <i class="fa fa-trash"></i> Delete
                            </a>

                            <?php 
                            $caseStatus = is_object($case) ? $case->status : ($case['CaseStudy']['status'] ?? null);
                            if (in_array($caseStatus, [0, 1])): 
                            ?>
                                <a href="<?= $this->Url->build(['controller' => 'CaseStudies', 'action' => 'adminApprove', $caseId]); ?>" 
                                class="btn btn-sm btn-success"
                                onclick="return confirm('Approve this case study?');"
                                title="Approve">
                                    <i class="fa fa-check"></i> Approve
                                </a>
                            <?php endif; ?>
                        </div>
                    </td>


                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="8" class="text-center text-muted">No case studies found.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

