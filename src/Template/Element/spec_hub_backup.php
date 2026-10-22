<div class="sh-backup">
    <a class="sh-btn sh-btn-outline" href="<?= $this->Url->build(['controller' => 'SpecHub', 'action' => 'admin_export']) ?>">↓ Export backup</a>
    <?= $this->Form->create(null, [
        'type' => 'file',
        'url' => ['controller' => 'SpecHub', 'action' => 'admin_import'],
        'class' => 'sh-backup-import',
        'id' => 'specHubImportForm',
    ]); ?>
        <input class="sh-backup-file" type="file" name="backup" id="specHubImportFile" accept=".json,application/json">
        <button class="sh-btn sh-btn-outline" type="button" id="specHubImportBtn">↑ Import backup</button>
    <?= $this->Form->end(); ?>
</div>
<?php $this->append('script'); ?>
<script>
$(function () {
    $('#specHubImportBtn').on('click', function () {
        $('#specHubImportFile').trigger('click');
    });
    $('#specHubImportFile').on('change', function () {
        if (this.files && this.files.length) {
            $('#specHubImportForm').submit();
        }
    });
});
</script>
<?php $this->end(); ?>
