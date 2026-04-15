<div class="page-content">
    <div class="page-header">
        <h1>Visitor Details</h1>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <table class="table table-bordered table-striped">
                <tr>
                    <th style="width:220px;">Visitor Pass Id</th>
                    <td><?php echo h($visitor['visitor_card_id'] ?? ''); ?></td>
                </tr>
                <tr>
                    <th>Date</th>
                    <td><?php echo !empty($visitor['date']) ? format_db_date('d/m/Y', $visitor['date']) : '--'; ?></td>
                </tr>
                <tr>
                    <th>Visitor Name</th>
                    <td><?php echo h($visitor['visitor_name'] ?? ''); ?></td>
                </tr>
                <tr>
                    <th>Visitor For</th>
                    <td><?php echo h($visitor['visit_for'] ?? ''); ?></td>
                </tr>
                <tr>
                    <th>Time In</th>
                    <td><?php echo (!empty($visitor['timein']) && $visitor['timein'] !== '0000-00-00 00:00:00') ? format_db_date('h:i a', $visitor['timein']) : '--'; ?></td>
                </tr>
                <tr>
                    <th>Time Out</th>
                    <td><?php echo (!empty($visitor['timeout']) && $visitor['timeout'] !== '0000-00-00 00:00:00') ? format_db_date('h:i a', $visitor['timeout']) : '--'; ?></td>
                </tr>
                <tr>
                    <th>Initial / Signature</th>
                    <td>
                        <?php if (!empty($visitor['sign'])): ?>
                            <a target="_blank" href="<?php echo SITEURL . 'signature/' . h($visitor['sign']); ?>">
                                <img src="<?php echo SITEURL . 'signature/' . h($visitor['sign']); ?>" style="max-width:300px; border:1px solid #ddd;"/>
                            </a>
                        <?php else: ?>
                            --
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>Photo</th>
                    <td>
                        <?php if (!empty($visitor['image'])): ?>
                            <a target="_blank" href="<?php echo SITEURL . 'signature/' . h($visitor['image']); ?>">
                                <img src="<?php echo SITEURL . 'signature/' . h($visitor['image']); ?>" style="max-width:300px; border:1px solid #ddd;"/>
                            </a>
                        <?php else: ?>
                            --
                        <?php endif; ?>
                    </td>
                </tr>
            </table>

            <a class="btn btn-default" href="<?php echo SITEURL . 'admin/mailers/visitor'; ?>">Back to Visitor List</a>
        </div>
    </div>
</div>
