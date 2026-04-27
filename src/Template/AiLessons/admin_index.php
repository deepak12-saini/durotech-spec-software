<div class="page-content">
    <div class="page-header">
        <h1>AI Lessons
            <?php echo $this->Html->link('Create AI Lesson', ['controller' => 'AiLessons', 'action' => 'admin_add'], ['class' => 'btn btn-info btn-xs top-button']); ?>
        </h1>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($lessons as $lesson): ?>
                        <tr>
                            <td><?php echo (int)$lesson->id; ?></td>
                            <td><?php echo h($lesson->title); ?></td>
                            <td><?php echo h($lesson->status); ?></td>
                            <td><?php echo h(!empty($lesson->created) ? format_db_date('d-M-Y h:i a', $lesson->created) : '—'); ?></td>
                            <td>
                                <?php echo $this->Html->link('Admin View', ['action' => 'admin_view', $lesson->id], ['class' => 'btn btn-xs btn-primary']); ?>
                                <?php echo $this->Html->link('Student View', ['action' => 'view', $lesson->id], ['class' => 'btn btn-xs btn-success', 'target' => '_blank']); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

