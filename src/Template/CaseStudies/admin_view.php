<h1><?php echo h($case['CaseStudy']['title']); ?></h1>
<p class="meta"><?php echo h($case['CaseStudy']['project_date']); ?> — <?php echo h($case['CaseStudy']['location']); ?></p>

<?php if (!empty($case['CaseStudy']['datasheet'])): ?>
  <a class="btn" href="<?php echo $this->webroot . $case['CaseStudy']['datasheet']; ?>" target="_blank">Download Datasheet (PDF)</a>
<?php endif; ?>

<div class="case-gallery">
  <?php foreach ($case['CaseImage'] as $img): ?>
    <a href="<?php echo $this->webroot . $img['filename']; ?>" data-lightbox="case">
      <?php echo $this->Html->image($img['filename'], array('alt'=>$img['caption'],'loading'=>'lazy')); ?>
    </a>
  <?php endforeach; ?>
</div>

<div class="case-text">
  <h4>Challenge</h4>
  <p><?php echo nl2br(h($case['CaseStudy']['challenge'])); ?></p>

  <h4>Solution</h4>
  <p><?php echo nl2br(h($case['CaseStudy']['solution'])); ?></p>

  <h4>Outcome</h4>
  <p><?php echo nl2br(h($case['CaseStudy']['outcome'])); ?></p>
</div>
