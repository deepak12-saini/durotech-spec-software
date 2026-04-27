<div class="container" style="max-width:920px;margin-top:20px;margin-bottom:30px;">
    <h2 style="margin-bottom:16px;"><?php echo h($lesson->title); ?></h2>

    <div class="panel panel-default">
        <div class="panel-heading"><strong>Presentation</strong></div>
        <div class="panel-body">
            <?php foreach ($presentation as $idx => $section): ?>
                <h4 style="margin-top:0;"><?php echo ($idx + 1) . '. ' . h($section['heading'] ?? 'Section'); ?></h4>
                <ul>
                    <?php foreach ((array)($section['points'] ?? []) as $point): ?>
                        <li><?php echo h($point); ?></li>
                    <?php endforeach; ?>
                </ul>
                <hr>
            <?php endforeach; ?>
            <p><em>When ready, complete the questionnaire below.</em></p>
        </div>
    </div>

    <?php echo $this->Form->create(null, ['url' => ['action' => 'submit', $lesson->id], 'class' => 'panel panel-default']); ?>
    <div class="panel-heading"><strong>Questionnaire</strong></div>
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                    <label>Your Name</label>
                    <input type="text" name="student_name" class="form-control" placeholder="Optional">
                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="student_email" class="form-control" placeholder="Optional">
                </div>
            </div>
        </div>

        <?php foreach ($quiz as $idx => $q): ?>
            <div style="margin-bottom:18px;">
                <p><strong>Q<?php echo $idx + 1; ?>.</strong> <?php echo h($q['question'] ?? ''); ?></p>
                <?php foreach ((array)($q['options'] ?? []) as $optIdx => $opt): ?>
                    <label style="display:block;font-weight:normal;">
                        <input type="radio" name="answers[<?php echo (int)$idx; ?>]" value="<?php echo (int)$optIdx; ?>" required>
                        <?php echo h($opt); ?>
                    </label>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="panel-footer">
        <button type="submit" class="btn btn-primary">Submit Questionnaire</button>
    </div>
    <?php echo $this->Form->end(); ?>
</div>

