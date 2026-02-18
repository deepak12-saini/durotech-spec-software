<div class="container-fluid mt-4">
    <div class="page-content">
        <div class="page-header mb-4 border-bottom pb-2">
            <h1 class="text-primary fw-bold">
                <i class="fa fa-comments me-2"></i> Edit Testimonial
            </h1>
        </div>

        <div class="card shadow-sm p-4 border-0 rounded-3 bg-light">
            <?php
            $existing = $existing ?? null;
            $editId = is_object($existing) ? $existing->id : ($existing['id'] ?? $existing['Testimonial']['id'] ?? null);
            echo $this->Form->create($existing, [
                'type' => 'file',
                'url' => ['controller' => 'Testimonials', 'action' => 'employee_edit', $editId],
                'class' => 'form-horizontal'
            ]);
            echo $this->Form->control('id', ['type' => 'hidden']);
            ?>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label class="fw-semibold">Client Name <span class="text-danger">*</span></label>
                        <?php echo $this->Form->control('name', [
                            'label' => false,
                            'class' => 'form-control shadow-sm',
                            'required' => true,
                            'placeholder' => 'Enter client name'
                        ]); ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label class="fw-semibold">Role / Designation</label>
                        <?php echo $this->Form->control('role', [
                            'label' => false,
                            'class' => 'form-control shadow-sm',
                            'placeholder' => 'e.g., Architect, Contractor, Distributor'
                        ]); ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label class="fw-semibold">Company Name</label>
                        <?php echo $this->Form->control('company_name', [
                            'label' => false,
                            'class' => 'form-control shadow-sm',
                            'placeholder' => 'Enter company name'
                        ]); ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label class="fw-semibold">Client Photo</label>
                        <?php echo $this->Form->control('photo', [
                            'label' => false,
                            'type' => 'file',
                            'class' => 'form-control shadow-sm'
                        ]); ?>
                        <small class="text-muted">Recommended size: 200x200px</small>
                        <?php
                        $currentPhoto = is_object($existing) ? $existing->photo : ($existing['photo'] ?? $existing['Testimonial']['photo'] ?? null);
                        if (!empty($currentPhoto)):
                        ?>
                        <div class="mt-3">
                            <p class="mb-1 text-muted">Current Photo:</p>
                            <img src="<?php echo $this->Url->build('/img/' . $currentPhoto, ['fullBase' => true]); ?>"
                                alt="Testimonial Photo" width="120" class="rounded shadow-sm border">
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label class="fw-semibold">Client Testimonial <span class="text-danger">*</span></label>
                <?php echo $this->Form->control('quote', [
                    'label' => false,
                    'type' => 'textarea',
                    'class' => 'form-control shadow-sm',
                    'rows' => 5,
                    'required' => true,
                    'placeholder' => 'Write the testimonial text here...'
                ]); ?>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-check mb-3 mt-2">
                        <label class="form-check-label fw-semibold">
                            <?php echo $this->Form->control('status', [
                                'label' => false,
                                'type' => 'checkbox',
                                'class' => 'form-check-input me-2'
                            ]); ?>
                            Publish this testimonial
                        </label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label class="fw-semibold">Display Order</label>
                        <?php echo $this->Form->control('display_order', [
                            'label' => false,
                            'class' => 'form-control shadow-sm',
                            'type' => 'number',
                            'min' => 0
                        ]); ?>
                    </div>
                </div>
            </div>

            <div class="mt-4 border-top pt-3 d-flex justify-content-end align-items-center gap-3">
                <?php echo $this->Form->button('Update Testimonial', [
                    'type' => 'submit',
                    'class' => 'btn btn-success px-4 fw-semibold shadow-sm'
                ]); ?>
                <a href="<?php echo $this->Url->build(['controller' => 'Testimonials', 'action' => 'employee_index']); ?>"
                    class="btn btn-outline-secondary px-4 fw-semibold shadow-sm">Cancel</a>
            </div>

            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>

<style>
    .card { transition: all 0.3s ease; }
    .card:hover { transform: translateY(-3px); box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1); }
</style>
