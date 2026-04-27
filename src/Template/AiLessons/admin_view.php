<div class="page-content">
    <div class="page-header">
        <h1><?php echo h($lesson->title); ?>
            <?php echo $this->Html->link('Open Student View', ['action' => 'view', $lesson->id], ['class' => 'btn btn-success btn-xs', 'target' => '_blank']); ?>
            <?php echo $this->Html->link('Back', ['action' => 'admin_index'], ['class' => 'btn btn-default btn-xs']); ?>
        </h1>
    </div>

    <div class="row">
        <div class="col-xs-12 col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Presentation Sections</strong></div>
                <div class="panel-body">
                    <?php foreach ($presentation as $idx => $section): ?>
                        <h4><?php echo ($idx + 1) . '. ' . h($section['heading'] ?? 'Section'); ?></h4>
                        <ul>
                            <?php foreach ((array)($section['points'] ?? []) as $point): ?>
                                <li><?php echo h($point); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Quiz</strong></div>
                <div class="panel-body">
                    <?php foreach ($quiz as $idx => $q): ?>
                        <p><strong>Q<?php echo $idx + 1; ?>.</strong> <?php echo h($q['question'] ?? ''); ?></p>
                        <ol type="A">
                            <?php foreach ((array)($q['options'] ?? []) as $opt): ?>
                                <li><?php echo h($opt); ?></li>
                            <?php endforeach; ?>
                        </ol>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading"><strong>Attempts</strong></div>
                <div class="panel-body" style="max-height:300px;overflow:auto;">
                    <?php foreach ($attempts as $a): ?>
                        <div style="border-bottom:1px solid #eee;padding:6px 0;">
                            <div><strong><?php echo h($a->student_name ?: 'Anonymous'); ?></strong></div>
                            <div><?php echo h($a->student_email ?: ''); ?></div>
                            <div>Score: <?php echo (int)$a->score; ?>/<?php echo (int)$a->total_questions; ?></div>
                            <div><small><?php echo h(!empty($a->created) ? format_db_date('d-M-Y h:i a', $a->created) : ''); ?></small></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

