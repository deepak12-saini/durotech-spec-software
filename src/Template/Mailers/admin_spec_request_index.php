<style>
    /* Adds some margin below all buttons */
    .btn { margin-bottom: 5px; }
</style>

<div class="page-content">
    <!-- Page header with centered title -->
    <div class="page-header text-center">
        <h1>DuroEzy Specification Easy Request</h1>
    </div>

    <!-- Center the button -->
    <div class="text-center">
        <?php if ($this->Session->read('is_staff')): ?>
            <a href="<?php echo SITEURL . 'staffs/staff_specRequest_form'; ?>" class="btn btn-primary">
                + New Spec Request
            </a>
        <?php else: ?>
            <a href="<?php echo SITEURL . 'login'; ?>" class="btn btn-primary">
                + New Spec Request (Login Staff Required)
            </a>
        <?php endif; ?>
    </div>
</div>
