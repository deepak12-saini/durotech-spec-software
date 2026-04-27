<div class="container" style="max-width:700px;margin-top:30px;">
    <div class="panel panel-success">
        <div class="panel-heading"><strong>Questionnaire Submitted</strong></div>
        <div class="panel-body">
            <h4><?php echo h($lesson->title); ?></h4>
            <p>Your score is <strong><?php echo (int)$score; ?> / <?php echo (int)$total; ?></strong>.</p>
            <p>Thanks for completing the lesson.</p>
            <?php echo $this->Html->link('Back to Lesson', ['action' => 'view', $lesson->id], ['class' => 'btn btn-default']); ?>
        </div>
    </div>
</div>

