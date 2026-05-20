<?php
$log = $warrantyLog['ProductWarrantyRequest'] ?? [];
$siteName = defined('SITENAME') ? SITENAME : 'Durotech Industries';
$siteUrl = defined('SITEURL') ? rtrim((string)SITEURL, '/') : '';
$logoUrl = $siteUrl !== '' ? $siteUrl . '/customdurotech/images/durotech_logo_new.png?v=20260520' : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Warranty Request Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.min.css">
    <style>
        body { background-color: #f5f5f5; font-family: Arial, sans-serif; padding-bottom: 30px; }
        .warranty-header {
            background: #ffffff;
            color: #333;
            padding: 16px 20px;
            margin: 0 0 20px 0;
            border-bottom: 1px solid #e8eef2;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        }
        .warranty-header .brand-logo {
            max-width: 280px;
            width: 100%;
            height: auto;
            display: block;
        }
        .warranty-header .form-title {
            font-size: 14px;
            color: #2889c8;
            font-weight: 600;
            margin-top: 8px;
        }
        .page-content { max-width: 1200px; margin: 0 auto; padding: 0 15px; }
        .btn { margin-bottom: 2px; }
        input, textarea {
            border: none !important;
            border-bottom: 1px dashed #ddd !important;
            border-left: 0 !important;
            border-right: 0 !important;
            border-top: 0 !important;
            margin-bottom: 2px;
            padding: 6px 0;
            border-radius: 0;
            background: transparent;
            width: 100%;
        }
        input:focus, textarea:focus { outline: none; border-bottom-color: #0066cc !important; }
        .form-group small { color: #666; font-size: 11px; display: block; margin-top: 4px; }
        .text-danger { font-size: 12px; margin-top: 4px; display: block; }
        .warranty-card { border: 2px solid #ddd; background: #fff; padding: 25px 30px; }
        .form-group { margin-bottom: 18px; }
        #add_ser_prd_btn { min-width: 130px; }

        @media (max-width: 767px) {
            .warranty-header { padding: 10px 12px; margin-bottom: 12px; }
            .warranty-header .brand { font-size: 15px; }
            .page-content { padding: 0 10px; }
            .page-content .col-lg-10 { padding-left: 0; padding-right: 0; }
            .warranty-card { padding: 14px 12px; }
            h4 { font-size: 20px; line-height: 1.3; margin-top: 0; }
            h5 { font-size: 17px; margin-top: 8px; }
            .form-group { margin-bottom: 14px; }
            .form-group [class*="col-"] { margin-bottom: 10px; }
            .form-group [class*="col-"]:last-child { margin-bottom: 0; }
            input, textarea { font-size: 16px; padding: 9px 0; }
            .form-group small { font-size: 12px; line-height: 1.45; }
            p[style*="font-size:10px"] { font-size: 12px !important; line-height: 1.6; }
            #add_ser_prd_btn { width: 100%; min-height: 44px; font-size: 16px; }
        }
    </style>
</head>
<body>
    <div class="warranty-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 text-center">
                    <?php if ($logoUrl !== '') : ?>
                        <a href="<?= h($siteUrl) ?>/"><img src="<?= h($logoUrl) ?>" alt="<?= h($siteName) ?>" class="brand-logo"></a>
                    <?php else : ?>
                        <span class="brand"><?= h($siteName) ?></span>
                    <?php endif; ?>
                    <div class="form-title">Product Warranty Request Form</div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                <p>
                    <small style="float:left;">Product Warranty Request Form</small>
                    <small style="float:right;"></small>
                </p><br>
            </div>
            <div class="col-lg-10 col-lg-offset-1 warranty-card">
                <h4 style="text-align:center;">PRODUCT WARRANTY REQUEST FORM</h4>
                <?= $this->Flash->render() ?>
                <?= $this->Form->create(null, ['url' => ['controller' => 'Fronts', 'action' => 'productWarranty'], 'type' => 'post', 'class' => 'form-horizontal']) ?>

                <div class="form-group">
                    <div class="col-sm-6">
                        <input type="text" name="ProductWarrantyRequest[serialnumber]" value="<?= h(@$log['serialnumber']) ?>" id="serialnumber" class="col-xs-12 col-sm-12" placeholder="Warranty Serial No">
                        <?= $this->Form->error('ProductWarrantyRequest.serialnumber', null, ['class' => 'text-danger']) ?>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" name="ProductWarrantyRequest[dateofpurchase]" value="<?= !empty($log['dateofpurchase']) ? format_db_date('Y-m-d', $log['dateofpurchase']) : '' ?>" id="dateofpurchase" class="datepicker col-xs-12 col-sm-12" placeholder="Date Of Purchase of Products">
                        <br><small>Date Of Purchase of Products</small>
                        <?= $this->Form->error('ProductWarrantyRequest.dateofpurchase', null, ['class' => 'text-danger']) ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-6">
                        <input type="text" name="ProductWarrantyRequest[product]" value="<?= h(@$log['product']) ?>" id="product" class="col-xs-12 col-sm-12" placeholder="Product">
                        <br><small>Product (Please specify the amount of the Product used):</small>
                        <?= $this->Form->error('ProductWarrantyRequest.product', null, ['class' => 'text-danger']) ?>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" name="ProductWarrantyRequest[used_as]" value="<?= h(@$log['used_as']) ?>" id="used_as" class="col-xs-12 col-sm-12" placeholder="Used As">
                        <br><small>Used As (Please set out in detail the manner in which the Product was used in relation to 6.) :</small>
                        <?= $this->Form->error('ProductWarrantyRequest.used_as', null, ['class' => 'text-danger']) ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-12">
                        <h5>Application</h5>
                        <small>(Please describe the manner in which the Products were applied, where applicable make reference to Durotech specifications and manuals):ecify the amount of the Product used):</small>
                        <input type="text" name="ProductWarrantyRequest[application][]" value="" id="application_1" class="col-xs-12 col-sm-12" placeholder="Application">
                        <input type="text" name="ProductWarrantyRequest[application][]" value="" id="application_2" class="col-xs-12 col-sm-12" placeholder="Application">
                        <input type="text" name="ProductWarrantyRequest[application][]" value="" id="application_3" class="col-xs-12 col-sm-12" placeholder="Application">
                        <?= $this->Form->error('ProductWarrantyRequest.application', null, ['class' => 'text-danger']) ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-6">
                        <input type="text" name="ProductWarrantyRequest[area_warranted]" value="<?= h(@$log['area_warranted']) ?>" id="area_warranted" class="col-xs-12 col-sm-12" placeholder="Area Warranted">
                        <br><small>Area Warranted(Please provide specific measurements):</small>
                        <?= $this->Form->error('ProductWarrantyRequest.area_warranted', null, ['class' => 'text-danger']) ?>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" name="ProductWarrantyRequest[building_address]" value="<?= h(@$log['building_address']) ?>" id="building_address" class="col-xs-12 col-sm-12" placeholder="Building Address">
                        <br><small>Building Address:</small>
                        <?= $this->Form->error('ProductWarrantyRequest.building_address', null, ['class' => 'text-danger']) ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="text" name="ProductWarrantyRequest[building_area_name]" value="<?= h(@$log['building_area_name']) ?>" id="building_area_name" class="col-xs-12 col-sm-12" placeholder="Building/Area Name">
                        <br><small>Building/Area Name:</small>
                        <?= $this->Form->error('ProductWarrantyRequest.building_area_name', null, ['class' => 'text-danger']) ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-6">
                        <input type="text" name="ProductWarrantyRequest[building_name]" value="<?= h(@$log['building_name']) ?>" id="building_name" class="col-xs-12 col-sm-12" placeholder="Building Name">
                        <br><small>Building Name:</small>
                        <?= $this->Form->error('ProductWarrantyRequest.building_name', null, ['class' => 'text-danger']) ?>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" name="ProductWarrantyRequest[start_requested_warranty]" value="<?= !empty($log['start_requested_warranty']) ? format_db_date('Y-m-d', $log['start_requested_warranty']) : date('Y-m-d') ?>" id="start_requested_warranty" class="datepicker col-xs-6 col-sm-6" placeholder="Start">
                        <input type="text" name="ProductWarrantyRequest[end_requested_warranty]" value="<?= !empty($log['end_requested_warranty']) ? format_db_date('Y-m-d', $log['end_requested_warranty']) : date('Y-m-d') ?>" id="end_requested_warranty" class="datepicker col-xs-6 col-sm-6" placeholder="End">
                        <br><small>Requested Warranty Period:</small>
                        <?= $this->Form->error('ProductWarrantyRequest.start_requested_warranty', null, ['class' => 'text-danger']) ?>
                        <?= $this->Form->error('ProductWarrantyRequest.end_requested_warranty', null, ['class' => 'text-danger']) ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-6">
                        <input type="text" name="ProductWarrantyRequest[applicator]" value="<?= h(@$log['applicator']) ?>" id="applicator" class="col-xs-12 col-sm-12" placeholder="Applicator">
                        <br><small>Applicator:</small>
                        <?= $this->Form->error('ProductWarrantyRequest.applicator', null, ['class' => 'text-danger']) ?>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" name="ProductWarrantyRequest[applicator_contact]" value="<?= h(@$log['applicator_contact']) ?>" id="applicator_contact" class="col-xs-12 col-sm-12" placeholder="Applicator Contact Details">
                        <br><small>Applicator Contact Details:</small>
                        <?= $this->Form->error('ProductWarrantyRequest.applicator_contact', null, ['class' => 'text-danger']) ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-6">
                        <input type="text" name="ProductWarrantyRequest[applicator_active_abn]" value="<?= h(@$log['applicator_active_abn']) ?>" id="applicator_active_abn" class="col-xs-12 col-sm-12" placeholder="Applicator's active ABN">
                        <br><small>Applicator's active ABN:</small>
                        <?= $this->Form->error('ProductWarrantyRequest.applicator_active_abn', null, ['class' => 'text-danger']) ?>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" name="ProductWarrantyRequest[applicator_address]" value="<?= h(@$log['applicator_address']) ?>" id="applicator_address" class="col-xs-12 col-sm-12" placeholder="Applicator's Address">
                        <br><small>Applicator's Address:</small>
                        <?= $this->Form->error('ProductWarrantyRequest.applicator_address', null, ['class' => 'text-danger']) ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-12"><br>
                        <p style="font-size:10px;">
                            (For reference the process of using the Products listed in point 3 for the purposes set out in point 4, applied in the manner depicted in point 5 for the area described in point 6 in the location set out in points 7 and 8 will be referred to as &lsquo;Durotech Product Application&rsquo;.)<br><br>
                            I confirm that I am the Contractor in charge of the building/development/construction of the location stated at point 7 and 8 and I am properly authorised and in a fully informed position to make these statements.<br><br>
                            I certify that the Durotech Product Application was implemented and I confirm that no Durotech representative or employee were present prior or during the Durotech Product Application process or involved in any aspect of Application noted in point 5.<br><br>
                            I understand that Durotech will rely on this certificate in order to issue a report approving the use of Durotech&rsquo;s Products and that the information on this certificate may be required and relied upon for warranty purposes at a later date. I understand that improper use or application of Durotech Products may result in their failure which may result in legal action or an award of damages against Durotech. As such, I further certify and declare that the facts, details and information herein are correct and that the Durotech Product Application has been conducted in strict accordance with Durotech&rsquo;s specifications and manuals as at the date of purchase of the Product (see point 2).<br><br>
                            By signing below I acknowledge and confirm that I have read, understood and agreed to what has been stated above and will incur any liability for and indemnify Durotech against any claim, expense or order for costs arising from any errors in the aforementioned material.
                        </p>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-4">
                        <input type="text" name="ProductWarrantyRequest[contract_company_name]" value="<?= h(@$log['contract_company_name']) ?>" id="contract_company_name" class="col-xs-12 col-sm-12" placeholder="Contractors Company name">
                        <br><small>Contractors Company name</small>
                        <?= $this->Form->error('ProductWarrantyRequest.contract_company_name', null, ['class' => 'text-danger']) ?>
                    </div>
                    <div class="col-sm-4">
                        <input type="text" name="ProductWarrantyRequest[sign_date]" value="<?= !empty($log['sign_date']) ? format_db_date('Y-m-d', $log['sign_date']) : '' ?>" id="sign_date" class="datepicker col-xs-12 col-sm-12" placeholder="Date">
                        <br><small>Date</small>
                        <?= $this->Form->error('ProductWarrantyRequest.sign_date', null, ['class' => 'text-danger']) ?>
                    </div>
                    <div class="col-sm-4">
                        <input type="text" name="ProductWarrantyRequest[contract_name]" value="<?= h(@$log['contract_name']) ?>" id="contract_name" class="col-xs-12 col-sm-12" placeholder="Contractors full name">
                        <br><small>Contractors full name</small>
                        <?= $this->Form->error('ProductWarrantyRequest.contract_name', null, ['class' => 'text-danger']) ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-12"></div>
                </div>
                <div class="form-group">
                    <div class="col-sm-6">
                        <?= $this->Form->button('Submit', ['type' => 'submit', 'class' => 'btn btn-success', 'id' => 'add_ser_prd_btn']) ?>
                    </div>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript">
        jQuery(function(){
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
        });
    </script>
</body>
</html>
