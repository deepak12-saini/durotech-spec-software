<?php
use App\Utility\SpecRequestDraft;
use App\Utility\SpecRequestOptions;
$step = (int)($step ?? 1);
$draft = $draft ?? SpecRequestDraft::empty();
$errors = $errors ?? [];
$labels = [
    1 => 'Your details',
    2 => 'Project',
    3 => 'Areas & products',
    4 => 'Documents',
    5 => 'Review & send',
];
$c = $draft['contact'];
$p = $draft['project'];
$sel = (array)$draft['selected_areas'];
?>
<p class="sr-kicker">Customer specification request</p>
<h1 class="sr-title">Let’s build your project specification</h1>
<p class="sr-subtitle">One project. Every area covered. Choose your spaces and tell us what you need.</p>
<div class="sr-steps">
    <?php foreach ($labels as $n => $label) : ?>
        <span class="<?= $n === $step ? 'on' : ($n < $step ? 'done' : '') ?>"><?= $n ?>. <?= h($label) ?></span>
    <?php endforeach; ?>
</div>
<div class="sr-grid">
    <div class="sr-card sr-form">
        <?php if ($errors !== []) : ?>
            <ul class="sr-errors">
                <?php foreach ($errors as $err) : ?>
                    <li><?= h($err) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <?= $this->Form->create(null, ['type' => 'file', 'url' => ['action' => 'request', '?' => ['step' => $step]], 'id' => 'srForm']); ?>
        <input type="hidden" name="_nav" id="srNavField" value="continue">
        <?php if ($step === 1) : ?>
            <h2>Your details</h2>
            <p class="sr-lead">We use this to contact you about the specification.</p>
            <div class="row">
                <div class="col-sm-6 form-group"><label>Full name *</label><input class="form-control" type="text" name="full_name" required placeholder="e.g. Jane Smith" value="<?= h($c['full_name']) ?>"></div>
                <div class="col-sm-6 form-group"><label>Company *</label><input class="form-control" type="text" name="company" required placeholder="e.g. Smith Architects Pty Ltd" value="<?= h($c['company']) ?>"></div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group"><label>Email *</label><input class="form-control" type="email" name="email" required placeholder="e.g. jane@smitharchitects.com.au" value="<?= h($c['email']) ?>"></div>
                <div class="col-sm-6 form-group"><label>Mobile *</label><input class="form-control" type="tel" name="mobile" required placeholder="e.g. 0412 345 678" value="<?= h($c['mobile']) ?>"></div>
            </div>
            <div class="form-group">
                <label>Your role *</label>
                <select class="form-control" name="role" required>
                    <option value="" disabled <?= $c['role'] === '' ? 'selected' : '' ?>>Select your role on this project…</option>
                    <?php foreach ($roles as $key => $label) : ?>
                        <option value="<?= h($key) ?>" <?= $c['role'] === $key ? 'selected' : '' ?>><?= h($label) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group"><label>Other project contact (optional)</label><input class="form-control" type="text" name="other_contact" placeholder="Name, role and phone or email if someone else should be copied" value="<?= h($c['other_contact']) ?>"></div>
        <?php elseif ($step === 2) : ?>
            <h2>Project</h2>
            <p class="sr-lead">Site and timing for this specification.</p>
            <div class="form-group"><label>Project name *</label><input class="form-control" type="text" name="name" required placeholder="e.g. Harbour House apartments — Building B" value="<?= h($p['name']) ?>"></div>
            <div class="form-group"><label>Site address *</label><input class="form-control" type="text" name="address" required placeholder="e.g. 12 Sample Street, Sydney NSW 2000" value="<?= h($p['address']) ?>"></div>
            <div class="row">
                <div class="col-sm-6 form-group">
                    <label>Building type *</label>
                    <select class="form-control" name="building_type" required>
                        <option value="" disabled <?= $p['building_type'] === '' ? 'selected' : '' ?>>Select building type…</option>
                        <?php foreach ($buildingTypes as $key => $label) : ?>
                            <option value="<?= h($key) ?>" <?= $p['building_type'] === $key ? 'selected' : '' ?>><?= h($label) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-sm-6 form-group">
                    <label>Project stage *</label>
                    <select class="form-control" name="project_stage" required>
                        <option value="" disabled <?= $p['project_stage'] === '' ? 'selected' : '' ?>>Select current project stage…</option>
                        <?php foreach ($projectStages as $key => $label) : ?>
                            <option value="<?= h($key) ?>" <?= $p['project_stage'] === $key ? 'selected' : '' ?>><?= h($label) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group"><label>Specification required by *</label><input class="form-control" type="date" name="spec_required_by" required title="Date you need the specification issued by" placeholder="YYYY-MM-DD" value="<?= h($p['spec_required_by']) ?>"><small class="sr-hint-text">When you need Josh to issue the specification</small></div>
                <div class="col-sm-6 form-group"><label>Expected installation date</label><input class="form-control" type="date" name="install_date" title="When waterproofing is expected to start on site" placeholder="YYYY-MM-DD" value="<?= h($p['install_date']) ?>"><small class="sr-hint-text">Optional — when work is expected to start on site</small></div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group">
                    <label>New build or existing structure *</label>
                    <select class="form-control" name="structure" required>
                        <option value="" disabled <?= $p['structure'] === '' ? 'selected' : '' ?>>Select new build or existing…</option>
                        <?php foreach ($structures as $key => $label) : ?>
                            <option value="<?= h($key) ?>" <?= $p['structure'] === $key ? 'selected' : '' ?>><?= h($label) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-sm-6 form-group">
                    <label>Request type *</label>
                    <select class="form-control" name="request_type" required>
                        <option value="" disabled <?= $p['request_type'] === '' ? 'selected' : '' ?>>Select the type of specification you need…</option>
                        <?php foreach ($requestTypes as $key => $label) : ?>
                            <option value="<?= h($key) ?>" <?= $p['request_type'] === $key ? 'selected' : '' ?>><?= h($label) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group"><label>Requirements / existing spec reference</label><textarea class="form-control" name="notes" rows="3" placeholder="e.g. Match previous Durotech spec DSP-014, or note any AS 4654 / NCC requirements"><?= h($p['notes']) ?></textarea></div>
        <?php elseif ($step === 3) : ?>
            <h2>Areas &amp; products</h2>
            <p class="sr-lead">Select every area that needs a system. Then complete the details for each one.</p>
            <div class="sr-tiles" id="srTiles">
                <?php foreach ($areas as $key => $label) : ?>
                    <?php $on = in_array($key, $sel, true); ?>
                    <label class="sr-tile <?= $on ? 'on' : '' ?>">
                        <input type="checkbox" name="selected_areas[]" value="<?= h($key) ?>" <?= $on ? 'checked' : '' ?>>
                        <?= h($label) ?>
                    </label>
                <?php endforeach; ?>
            </div>
            <div class="sr-chips" id="srChips">
                <?php foreach ($sel as $key) : ?>
                    <span class="sr-chip"><?= h(SpecRequestOptions::label(SpecRequestOptions::AREAS, $key)) ?></span>
                <?php endforeach; ?>
            </div>
            <?php foreach ($draft['areas'] as $i => $block) : ?>
                <?php $uid = (string)$block['uid']; ?>
                <div class="sr-area">
                    <h3><?= h(SpecRequestDraft::areaTitle($block)) ?> — system details</h3>
                    <input type="hidden" name="areas[<?= $i ?>][uid]" value="<?= h($uid) ?>">
                    <?php if (($block['area_key'] ?? '') === 'custom') : ?>
                        <div class="form-group"><label>Custom area name</label><input class="form-control" type="text" name="areas[<?= $i ?>][custom_label]" placeholder="e.g. Level 2 planter / lift overrun" value="<?= h($block['custom_label']) ?>"></div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label>Area type</label>
                            <select class="form-control" name="areas[<?= $i ?>][area_type]">
                                <option value="" disabled <?= ($block['area_type'] ?? '') === '' ? 'selected' : '' ?>>Select area type…</option>
                                <?php foreach ($areas as $key => $label) : ?>
                                    <option value="<?= h($key) ?>" <?= ($block['area_type'] ?? '') === $key ? 'selected' : '' ?>><?= h($label) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-6 form-group"><label>Location / level *</label><input class="form-control" type="text" name="areas[<?= $i ?>][location]" placeholder="e.g. Level 5 bathrooms, units 12–18" value="<?= h($block['location']) ?>"></div>
                    </div>
                    <div class="form-group"><label>Quantity &amp; units</label><input class="form-control" type="text" name="areas[<?= $i ?>][quantity]" value="<?= h($block['quantity']) ?>" placeholder="e.g. 80 m², 12 bathrooms, or 40 lm of joints"></div>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label>Substrate *</label>
                            <select class="form-control" name="areas[<?= $i ?>][substrate]">
                                <option value="" disabled <?= ($block['substrate'] ?? '') === '' ? 'selected' : '' ?>>Select substrate…</option>
                                <?php foreach ($substrates as $key => $label) : ?>
                                    <option value="<?= h($key) ?>" <?= ($block['substrate'] ?? '') === $key ? 'selected' : '' ?>><?= h($label) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-6 form-group">
                            <label>Substrate condition *</label>
                            <select class="form-control" name="areas[<?= $i ?>][condition]">
                                <option value="" disabled <?= ($block['condition'] ?? '') === '' ? 'selected' : '' ?>>Select substrate condition…</option>
                                <?php foreach ($conditions as $key => $label) : ?>
                                    <option value="<?= h($key) ?>" <?= ($block['condition'] ?? '') === $key ? 'selected' : '' ?>><?= h($label) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label>Final finish *</label>
                            <select class="form-control" name="areas[<?= $i ?>][finish]">
                                <option value="" disabled <?= ($block['finish'] ?? '') === '' ? 'selected' : '' ?>>Select final finish…</option>
                                <?php foreach ($finishes as $key => $label) : ?>
                                    <option value="<?= h($key) ?>" <?= ($block['finish'] ?? '') === $key ? 'selected' : '' ?>><?= h($label) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-6 form-group">
                            <label>Exposure *</label>
                            <select class="form-control" name="areas[<?= $i ?>][exposure]">
                                <option value="" disabled <?= ($block['exposure'] ?? '') === '' ? 'selected' : '' ?>>Select exposure…</option>
                                <?php foreach ($exposures as $key => $label) : ?>
                                    <option value="<?= h($key) ?>" <?= ($block['exposure'] ?? '') === $key ? 'selected' : '' ?>><?= h($label) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Preferred products *</label>
                        <input class="form-control" type="text" name="areas[<?= $i ?>][preferred_products]" placeholder="e.g. Durotech ARW, or click Ask Durotech to recommend a system" value="<?= h($block['preferred_products']) ?>">
                    </div>
                    <div class="form-group"><label>Other brands</label><input class="form-control" type="text" name="areas[<?= $i ?>][other_brands]" placeholder="e.g. currently specified brand / product if substituting" value="<?= h($block['other_brands']) ?>"></div>
                    <div class="form-group"><label>Area-specific issues</label><textarea class="form-control" name="areas[<?= $i ?>][issues]" rows="2" placeholder="e.g. ponding, cracks, falls, occupied building, night works"><?= h($block['issues']) ?></textarea></div>
                    <div class="form-group">
                        <label>Drawings / photos</label>
                        <input type="file" name="area_file[<?= h($uid) ?>]" title="PDF, JPG or PNG of this area">
                        <small class="sr-hint-text">Optional — PDF, JPG or PNG for this area only</small>
                        <?php if (!empty($block['file']['name'])) : ?>
                            <small>Attached: <?= h($block['file']['name']) ?></small>
                        <?php endif; ?>
                    </div>
                    <button class="sr-btn sr-btn-outline js-nav" type="submit" data-nav="recommend" data-uid="<?= h($uid) ?>">Ask Durotech to recommend a system</button>
                    <?php if (($block['area_key'] ?? '') === 'custom') : ?>
                        <button class="sr-btn sr-btn-ghost js-nav" type="submit" data-nav="remove_area" data-uid="<?= h($uid) ?>">Remove custom area</button>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            <button class="sr-btn sr-btn-outline js-nav" type="submit" data-nav="add_custom">+ Add another location / custom area</button>
            <input type="hidden" name="target_uid" id="targetUid" value="">
        <?php elseif ($step === 4) : ?>
            <h2>Documents</h2>
            <p class="sr-lead">Plans, photos and existing specs help Josh review faster.</p>
            <?php
            $kinds = [
                'plans' => 'Plans / drawings',
                'site_photos' => 'Site photos',
                'existing_specs' => 'Existing specifications',
                'other_tds' => 'Other TDS / documents',
            ];
            $byKind = [];
            foreach ((array)$draft['docs']['files'] as $f) {
                $byKind[$f['kind'] ?? ''] = $f;
            }
            ?>
            <?php foreach ($kinds as $kind => $label) : ?>
                <div class="form-group">
                    <label><?= h($label) ?></label>
                    <input type="file" name="doc_<?= h($kind) ?>" title="Upload <?= h($label) ?> — PDF, JPG, PNG or DWG">
                    <small class="sr-hint-text">Optional — PDF, JPG, PNG or DWG</small>
                    <?php if (!empty($byKind[$kind]['name'])) : ?>
                        <small>Attached: <?= h($byKind[$kind]['name']) ?></small>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            <div class="form-group"><label>Notes for Josh</label><textarea class="form-control" name="docs_notes" rows="3" placeholder="Anything else Josh should know about the documents or site access"><?= h($draft['docs']['notes']) ?></textarea></div>
            <div class="sr-check">
                <label><input type="checkbox" name="docs_not_available" value="1" <?= !empty($draft['docs']['not_available']) ? 'checked' : '' ?>> Documents are not available</label>
            </div>
            <div class="form-group"><label>Reason (so Josh can see the gap)</label><textarea class="form-control" name="docs_missing_reason" rows="2" placeholder="e.g. drawings still with the architect; photos to follow after site visit"><?= h($draft['docs']['missing_reason']) ?></textarea></div>
        <?php else : ?>
            <h2>Review &amp; send</h2>
            <p class="sr-lead">Check the areas and products below, then send to Josh.</p>
            <p><strong><?= h($p['name']) ?></strong> · <?= h($p['address']) ?></p>
            <?php foreach ($draft['areas'] as $block) : ?>
                <div class="sr-area">
                    <h3><?= h(SpecRequestDraft::areaTitle($block)) ?></h3>
                    <p><?= h($block['location']) ?> · <?= h($block['quantity']) ?></p>
                    <p>Preferred: <?= h($block['preferred_products']) ?></p>
                </div>
            <?php endforeach; ?>
            <div class="sr-note">
                After you send, you will receive a request number. Josh reviews the brief. Issue dates and warranty wording are subject to confirmation. No specification is issued automatically.
            </div>
            <div class="sr-check">
                <label><input type="checkbox" name="confirm" value="1" <?= !empty($draft['confirm']) ? 'checked' : '' ?>> I confirm this information is ready for Durotech to review. *</label>
            </div>
        <?php endif; ?>
        <div class="sr-actions">
            <?php if ($step > 1) : ?>
                <button class="sr-btn sr-btn-ghost js-nav" type="submit" data-nav="back">Back</button>
            <?php else : ?>
                <span></span>
            <?php endif; ?>
            <?php if ($step < 5) : ?>
                <button class="sr-btn sr-btn-blue js-nav" type="submit" data-nav="continue">Continue</button>
            <?php else : ?>
                <button class="sr-btn sr-btn-green js-nav" type="submit" data-nav="submit">Send specification request</button>
            <?php endif; ?>
        </div>
        <?= $this->Form->end(); ?>
    </div>
    <?php
    $areaCount = count($draft['areas']);
    $areaHeading = $areaCount === 0
        ? 'Areas in this project'
        : $areaCount . ' area' . ($areaCount === 1 ? '' : 's') . ' in this project';
    $projectBits = array_filter([
        $c['full_name'] !== '' ? $c['full_name'] : null,
        $p['name'] !== '' ? $p['name'] : null,
        $p['spec_required_by'] !== '' ? 'Required by ' . $p['spec_required_by'] : null,
    ]);
    $docLine = 'Plans, details and photographs';
    $nDocs = count($draft['docs']['files']);
    if ($nDocs > 0) {
        $docLine = $nDocs . ' file' . ($nDocs === 1 ? '' : 's') . ' attached';
    } elseif (!empty($draft['docs']['not_available'])) {
        $docLine = 'Not available yet — Josh will see the gap';
    }
    ?>
    <aside class="sr-card sr-side">
        <h3>Your specification request</h3>
        <div class="sr-side-block">
            <h4>Project information</h4>
            <p><?= $projectBits !== [] ? h(implode(' · ', $projectBits)) : 'Contact, site, stage and required date' ?></p>
        </div>
        <div class="sr-side-block">
            <h4><?= h($areaHeading) ?></h4>
            <p>Substrates, exposure, finishes and preferred products</p>
            <?php if ($draft['areas'] !== []) : ?>
                <div class="sr-chips">
                    <?php foreach ($draft['areas'] as $block) : ?>
                        <span class="sr-chip"><?= h(SpecRequestDraft::areaTitle($block)) ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="sr-side-block">
            <h4>Supporting documents</h4>
            <p><?= h($docLine) ?></p>
        </div>
        <div class="sr-side-block">
            <h4>Technical review</h4>
            <p>Assigned to Josh upon submission</p>
        </div>
        <div class="sr-side-block">
            <h4>Email confirmation</h4>
            <p>Customer, Josh and management notified</p>
        </div>
        <p class="sr-side-foot">Product selection and specification issue are subject to technical approval.</p>
    </aside>
</div>
<?php $this->append('script'); ?>
<script>
(function () {
  var form = document.getElementById('srForm');
  var navField = document.getElementById('srNavField');
  var tiles = document.getElementById('srTiles');
  if (tiles && form && navField) {
    tiles.addEventListener('change', function (e) {
      var t = e.target.closest('.sr-tile');
      if (t) { t.classList.toggle('on', e.target.checked); }
      navField.value = 'sync';
      form.submit();
    });
  }
  document.querySelectorAll('select.form-control').forEach(function (sel) {
    var mark = function () {
      sel.classList.toggle('is-placeholder', !sel.value);
    };
    mark();
    sel.addEventListener('change', mark);
  });
  document.querySelectorAll('.js-nav').forEach(function (btn) {
    btn.addEventListener('click', function () {
      if (navField) { navField.value = btn.getAttribute('data-nav') || 'continue'; }
      var uid = btn.getAttribute('data-uid');
      var el = document.getElementById('targetUid');
      if (el && uid) { el.value = uid; }
    });
  });
})();
</script>
<?php $this->end(); ?>
