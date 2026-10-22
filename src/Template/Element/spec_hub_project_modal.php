<?php
use App\Model\Table\SpecProjectsTable;
$applications = $applications ?? SpecProjectsTable::APPLICATIONS;
$stages = $stages ?? SpecProjectsTable::STAGES;
$returnTo = $hubNav ?? 'projects';
$openEdit = (int)($openEdit ?? 0);
$openNew = !empty($openNew);
?>
<div class="sh-modal-backdrop" id="specProjectModal">
    <div class="sh-modal sh-form">
        <div class="sh-modal-head">
            <h2>Project specification</h2>
            <button type="button" class="sh-btn sh-btn-outline" id="specModalClose">&times;</button>
        </div>
        <?= $this->Form->create(null, ['url' => ['controller' => 'SpecHub', 'action' => 'admin_save_project'], 'id' => 'specProjectForm']); ?>
        <input type="hidden" name="id" id="sp_id" value="">
        <input type="hidden" name="return_to" value="<?= h($returnTo) ?>">
        <div class="form-group">
            <label>Project name</label>
            <input type="text" class="form-control" name="name" id="sp_name" required>
        </div>
        <div class="row">
            <div class="col-sm-6 form-group">
                <label>Architect / specifier</label>
                <input type="text" class="form-control" name="architect" id="sp_architect">
            </div>
            <div class="col-sm-6 form-group">
                <label>Project location</label>
                <input type="text" class="form-control" name="location" id="sp_location">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 form-group">
                <label>Application</label>
                <select class="form-control" name="application" id="sp_application">
                    <?php foreach ($applications as $key => $label) : ?>
                        <option value="<?= h($key) ?>"><?= h($label) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-sm-6 form-group">
                <label>Area (m²)</label>
                <input type="text" class="form-control" name="area_m2" id="sp_area_m2">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 form-group">
                <label>Project owner</label>
                <input type="text" class="form-control" name="owner" id="sp_owner">
            </div>
            <div class="col-sm-6 form-group">
                <label>Next follow-up</label>
                <input type="date" class="form-control" name="follow_up_on" id="sp_follow_up_on">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 form-group">
                <label>Stage</label>
                <select class="form-control" name="stage" id="sp_stage">
                    <?php foreach ($stages as $key => $label) : ?>
                        <option value="<?= h($key) ?>"><?= h($label) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-sm-6 form-group">
                <label>Revision</label>
                <input type="text" class="form-control" name="revision" id="sp_revision" value="A">
            </div>
        </div>
        <div class="form-group">
            <label>Substrate &amp; site conditions</label>
            <textarea class="form-control" name="substrate" id="sp_substrate" rows="2" placeholder="Substrate, exposure, moisture, movement, drainage…"></textarea>
        </div>
        <div class="form-group">
            <label>Proposed product / system</label>
            <input type="text" class="form-control" name="proposed_system" id="sp_proposed_system" placeholder="Enter exact system after technical selection">
        </div>
        <div class="form-group">
            <label>Current technical document link</label>
            <input type="text" class="form-control" name="document_url" id="sp_document_url" placeholder="https://…">
        </div>
        <div class="form-group">
            <label>Specification scope &amp; application notes</label>
            <textarea class="form-control" name="scope_notes" id="sp_scope_notes" rows="2" placeholder="Preparation, primer, membrane / sealant, detailing, protection, inspection…"></textarea>
        </div>
        <div class="row">
            <div class="col-sm-6 form-group">
                <label>Technical reviewer</label>
                <input type="text" class="form-control" name="reviewer" id="sp_reviewer">
            </div>
            <div class="col-sm-6 form-group">
                <label>Review date</label>
                <input type="date" class="form-control" name="review_date" id="sp_review_date">
            </div>
        </div>
        <div class="form-group">
            <label>Review outcome / suitability evidence</label>
            <textarea class="form-control" name="review_outcome" id="sp_review_outcome" rows="2"></textarea>
        </div>
        <p class="sh-hint">Issue requires a selected system, technical document link, scope and completed review fields. This hub does not validate technical suitability automatically.</p>
        <div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:8px;">
            <button type="submit" class="sh-btn sh-btn-blue">Save project</button>
            <a class="sh-btn sh-btn-outline" id="sp_print" href="#" target="_blank" style="display:none;">Print specification</a>
            <button type="button" class="sh-btn" id="sp_delete_btn" style="display:none;color:#b42318;">Delete</button>
        </div>
        <?= $this->Form->end(); ?>
        <?= $this->Form->create(null, ['url' => ['controller' => 'SpecHub', 'action' => 'admin_delete_project'], 'id' => 'specDeleteForm']); ?>
            <input type="hidden" name="id" id="sp_delete_id" value="">
            <input type="hidden" name="return_to" value="<?= h($returnTo) ?>">
        <?= $this->Form->end(); ?>
    </div>
</div>
<script>
window.specHubModal = {
    openNew: <?= $openNew ? 'true' : 'false' ?>,
    openEdit: <?= (int)$openEdit ?>,
    printUrl: <?= json_encode($this->Url->build(['_name' => 'specHubPrint', 'id' => 987654321])) ?>
};
</script>
<?php $this->append('script'); ?>
<script>
$(function() {
    var fields = ['id','name','architect','location','application','area_m2','owner','follow_up_on','stage','revision','substrate','proposed_system','document_url','scope_notes','reviewer','review_date','review_outcome'];
    function ymd(v) {
        if (!v) return '';
        var s = String(v);
        return s.length >= 10 ? s.slice(0, 10) : s;
    }
    function fill(row) {
        row = row || {};
        fields.forEach(function(k) {
            var el = document.getElementById('sp_' + k);
            if (!el) return;
            var val = row[k] == null ? '' : row[k];
            if (k === 'follow_up_on' || k === 'review_date') val = ymd(val);
            el.value = val;
        });
        if (!row.revision) document.getElementById('sp_revision').value = 'A';
        if (!row.stage) document.getElementById('sp_stage').value = 'brief_received';
        if (!row.application) document.getElementById('sp_application').value = 'wet_areas';
        var id = row.id ? String(row.id) : '';
        $('#sp_delete_id').val(id);
        if (id) {
            $('#sp_delete_btn, #sp_print').show();
            $('#sp_print').attr('href', String(window.specHubModal.printUrl).replace('987654321', id));
        } else {
            $('#sp_delete_btn, #sp_print').hide();
        }
        $('#specProjectModal').addClass('open');
    }
    window.openSpecProject = function(row) { fill(row || {}); };
    window.openNewSpecProject = function() { fill({}); };
    $('#specModalClose, #specProjectModal').on('click', function(e) {
        if (e.target === this) $('#specProjectModal').removeClass('open');
    });
    $('.js-open-spec').on('click', function(e) {
        e.preventDefault();
        var raw = $(this).attr('data-project');
        try { fill(JSON.parse(raw)); } catch (err) { fill({}); }
    });
    $('.js-new-spec').on('click', function(e) {
        e.preventDefault();
        fill({});
    });
    $('#sp_delete_btn').on('click', function() {
        if (!confirm('Delete this project?')) return;
        $('#specDeleteForm').submit();
    });
    if (window.specHubModal.openNew) fill({});
    if (window.specHubModal.openEdit) {
        var btn = $('.js-open-spec[data-id="' + window.specHubModal.openEdit + '"]').first();
        if (btn.length) {
            try { fill(JSON.parse(btn.attr('data-project'))); } catch (err) {}
        }
    }
});
</script>
<?php $this->end(); ?>
