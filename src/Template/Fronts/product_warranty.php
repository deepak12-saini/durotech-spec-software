<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Warranty Request Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e8e8e8;
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .form-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        
        .durotech-logo {
            text-align: left;
        }
        .durotech-logo h2 {
            color: #0066cc;
            font-weight: bold;
            margin: 0;
            font-size: 28px;
        }
        .durotech-logo .tagline {
            background: #0066cc;
            color: white;
            padding: 3px 10px;
            font-size: 11px;
            display: inline-block;
            margin-top: 5px;
        }
        .durotech-logo .subtext {
            color: #666;
            font-size: 10px;
            margin-top: 5px;
        }
        .australian-badge {
            text-align: center;
        }
        .badge-circle {
            width: 70px;
            height: 70px;
            border: 3px solid #2d5016;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #4a7c2c;
            color: #ffd700;
            font-weight: bold;
            font-size: 20px;
            margin: 0 auto;
        }
        .since-badge {
            color: #c17a3f;
            font-weight: bold;
            margin-top: 5px;
        }
        .since-badge .year {
            font-size: 24px;
        }
        .form-title {
            text-align: center;
            font-size: 26px;
            font-weight: bold;
            color: #333;
            margin: 30px 0;
            border-bottom: 3px solid #0066cc;
            padding-bottom: 10px;
        }
        .form-label {
            color: #5b9bd5;
            font-weight: 600;
            font-size: 13px;
            margin-bottom: 5px;
        }
        .dotted-line {
            border: none;
            border-bottom: 2px dotted #ccc;
            margin: 10px 0;
        }
        .form-control, .form-select {
            border: none;
            border-bottom: 2px dotted #ccc;
            border-radius: 0;
            padding: 5px 0;
            background: transparent;
        }
        .form-control:focus, .form-select:focus {
            box-shadow: none;
            border-bottom: 2px solid #5b9bd5;
        }
        .section-box {
            background: #f9f9f9;
            padding: 15px;
            margin: 20px 0;
            border-left: 4px solid #5b9bd5;
        }
        .legal-text {
            font-size: 12px;
            line-height: 1.4;
            color: #666;
            margin: 20px 0;
            text-align: justify;
        }
        .signature-section {
            margin-top: 30px;
        }
        .signature-line {
            border-bottom: 2px dotted #333;
            padding-bottom: 5px;
            margin: 10px 0;
        }
        .footer-section {
            /* background: #0066cc;
            color: white; */
            padding: 15px;
            text-align: center;
            margin-top: 30px;
        }
        .footer-section h4 {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .footer-section p {
            margin: 5px 0;
            font-size: 12px;
        }
        .row-spacing {
            margin-bottom: 25px;
        }

        /* //new css for deepak */
        .text-danger {
            font-size: 12px;
            margin-top: 4px;
            display: block;
        }
        .is-invalid {
            border-color: #dc3545;
        }

               /* new css for header section */

        /* Header Section Layout */
.header-section {
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 2px solid #ddd;
    padding: 15px 10px;
    margin-bottom: 25px;
}

.header-section img {
    max-height: 70px;
    width: auto;
}

/* Left Section */
.header-left {
    text-align: left;
    flex: 1;
}
.header-left h2 {
    margin: 0;
    font-size: 22px;
    color: #003366;
    letter-spacing: 1px;
}
.header-left .tagline {
    font-size: 13px;
    color: #666;
    display: block;
}
.header-left .subtext {
    font-size: 11px;
    color: #888;
}

/* Center Section */
.header-center {
    flex: 1;
    text-align: center;
}

/* Right Section */
.header-right {
    flex: 1;
    text-align: right;
}
.australian-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.badge-circle {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: #f2f2f2;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}
.since-badge {
    font-size: 12px;
    color: #333;
    text-align: center;
}
.since-badge .year {
    display: block;
    font-weight: bold;
    color: #0b6e4f;
}

/* Responsive Header */
@media (max-width: 768px) {
    .header-section {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    .header-left, .header-center, .header-right {
        flex: unset;
        margin-bottom: 10px;
    }
}
    </style>
</head>
<body>

<?php
  $log = !empty($warrantyLog['ProductWarrantyRequest']) ? $warrantyLog['ProductWarrantyRequest'] : [];
?>

<div class="form-container">

<?= $this->Flash->render() ?>

    <?= $this->Form->create(null, ['url' => ['controller' => 'Fronts', 'action' => 'productWarranty'], 'type' => 'post']) ?>
        <!-- Header -->
                <?php
         $path = $_SERVER['DOCUMENT_ROOT']; 
         $duro_logo = '/app/webroot/project_document/1977_logo (2).png';
         $middle_logo = '/app/webroot/project_document/1977_logo (3).png';
         $right_logo = '/app/webroot/project_document/1977_logo (1).png';

         ?>

        <div class="header-section">
            <!-- Left Section -->
            <div class="header-left">
                <img src="<?= $duro_logo ?>" alt="Durotech Logo">
            </div>

            <!-- Center Section -->
            <div class="header-center">
                <img src="<?= $middle_logo ?>" alt="Middle Logo">
            </div>

            <!-- Right Section -->
            <div class="header-right">
                <img src="<?= $right_logo ?>" alt="Right Logo">
                
            </div>
        </div>


        <h1 class="form-title">Product Warranty Request Form</h1>

        <!-- Warranty Serial & Date of Purchase -->
        <div class="row row-spacing">
            <div class="col-md-6">
                <label class="form-label">1. Warranty Serial No.:</label>
                <hr class="dotted-line">
                <input type="text" name="ProductWarrantyRequest[serialnumber]" class="form-control" value="<?= h(@$log['serialnumber']) ?>" />
                <?= $this->Form->error('ProductWarrantyRequest.serialnumber', null, ['class' => 'text-danger']) ?>

            </div>
            <div class="col-md-6">
                <label class="form-label">2. Date Of Purchase  of Products:</label>
                <input type="date" name="ProductWarrantyRequest[dateofpurchase]" class="form-control" value="<?= !empty($log['dateofpurchase']) ? date('Y-m-d', strtotime($log['dateofpurchase'])) : '' ?>" />
                <?= $this->Form->error('ProductWarrantyRequest.dateofpurchase', null, ['class' => 'text-danger']) ?>

            </div>
        </div>

        <!-- Product & Used As -->
        <div class="row row-spacing">
            <div class="col-md-6">
                <label class="form-label">3. Product (Please specify the amount of the Product used):</label>
                <textarea name="ProductWarrantyRequest[product]" class="form-control"><?= h(@$log['product']) ?></textarea>
                <?= $this->Form->error('ProductWarrantyRequest.product', null, ['class' => 'text-danger']) ?>
            </div>
            <div class="col-md-6">
                <label class="form-label">4. Used As(Please set out in detail the manner in which the Product was used in relation to 6.):</label>
                <textarea name="ProductWarrantyRequest[used_as]" class="form-control"><?= h(@$log['used_as']) ?></textarea>
                <?= $this->Form->error('ProductWarrantyRequest.used_as', null, ['class' => 'text-danger']) ?>
            </div>
        </div>

        <!-- Application -->
        <div class="row row-spacing">
            <label class="form-label">5. Application  (Please describe the manner in which the Products were applied, where applicable make reference to Durotech
            specifications and manuals):ecify the amount of the Product used):</label>
            <textarea name="ProductWarrantyRequest[application]" class="form-control"><?= h(@$log['application']) ?></textarea>
            <?= $this->Form->error('ProductWarrantyRequest.application', null, ['class' => 'text-danger']) ?>
        </div>

        <!-- Area Warrantied & Building Address -->
        <div class="row row-spacing">
            <div class="col-md-6">
                <label class="form-label">6. Area Warrantied(Please provide specific measurements):</label>
                <input type="text" name="ProductWarrantyRequest[area_warranted]" class="form-control" value="<?= h(@$log['area_warranted']) ?>" />
                <?= $this->Form->error('ProductWarrantyRequest.area_warranted', null, ['class' => 'text-danger']) ?>
            </div>
            <div class="col-md-6">
                <label class="form-label">7. Building Address:</label>
                <input type="text" name="ProductWarrantyRequest[building_address]" class="form-control" value="<?= h(@$log['building_address']) ?>" />
                <?= $this->Form->error('ProductWarrantyRequest.building_address', null, ['class' => 'text-danger']) ?>
            </div>
        </div>

        <!-- Building Name & Warranty Period -->
        <div class="row row-spacing">
            <div class="col-md-6">
                <label class="form-label">8. Building Name:</label>
                <input type="text" name="ProductWarrantyRequest[building_name]" class="form-control" value="<?= h(@$log['building_name']) ?>" />
                <?= $this->Form->error('ProductWarrantyRequest.building_name', null, ['class' => 'text-danger']) ?>
            </div>

            <div class="col-md-6">
                <label class="form-label">9. Requested Warranty Period:</label>
                <div class="d-flex gap-2">
                    <div class="flex-fill">
                        <input type="date" name="ProductWarrantyRequest[start_requested_warranty]" 
                            class="form-control" 
                            value="<?= !empty($log['start_requested_warranty']) ? date('Y-m-d', strtotime($log['start_requested_warranty'])) : '' ?>" />
                        <?= $this->Form->error('ProductWarrantyRequest.start_requested_warranty', null, ['class' => 'text-danger']) ?>
                    </div>

                    <div class="flex-fill">
                        <input type="date" name="ProductWarrantyRequest[end_requested_warranty]" 
                            class="form-control" 
                            value="<?= !empty($log['end_requested_warranty']) ? date('Y-m-d', strtotime($log['end_requested_warranty'])) : '' ?>" />
                        <?= $this->Form->error('ProductWarrantyRequest.end_requested_warranty', null, ['class' => 'text-danger']) ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Legal Text -->
        <div class="legal-text">
            <p>(For reference "the process of using the Products listed in point 3 for the purposes set out in point 4, applied in the manner described in point 5 for the area described in point 6 in the location set out in point 7 and 8 will be referred to as 'Durotech Product Application')</p>
            <p>I confirm that I am the Contractor in charge of the building/development/construction of the location stated at point 7 and 8 and I am properly authorised and in a fully informed position to make these statements.</p>
            <p>I certify that the 'Durotech Product Application' was implemented and I confirm that no Durotech representative or employee were present prior or during the Durotech Product Application process or involved in any aspect of the Application noted in point 5.</p>
            <p>I understand that Durotech will rely on this certificate in order to issue a report approving the use of Durotech’s Products and that the information on this certificate may be required and relied upon for warranty purposes at a later date. I understand that improper use or application of Durotech Products may result in their failure which may result in legal action or an award of damages against Durotech. As such, I further certify and declare that the facts, details and information herein are correct and that the Durotech Product Application has been conducted in strict accordance with Durotech’s specifications and manuals as at the date of purchase of the Product (see point 2).</p>
            <p>By signing below I acknowledge and confirm that I have read, understood and agreed to what has been stated above and will incur any liability/tort and indemnify Durotech against any claim, expense or order for costs arising from any errors in the aforementioned material.</p>
        </div>

        <!-- Contractor Section -->
        <div class="row row-spacing">
            <div class="col-md-6">
                <label class="form-label">Contractor Company Name:</label>
                <input type="text" name="ProductWarrantyRequest[contract_company_name]" class="form-control" value="<?= h(@$log['contract_company_name']) ?>" />
                <?= $this->Form->error('ProductWarrantyRequest.contract_company_name', null, ['class' => 'text-danger']) ?>
            </div>
            <div class="col-md-6">
                <label class="form-label">ABN No:</label>
                <input type="text" name="ProductWarrantyRequest[applicator_active_abn]" class="form-control" value="<?= h(@$log['applicator_active_abn']) ?>" />
                <?= $this->Form->error('ProductWarrantyRequest.applicator_active_abn', null, ['class' => 'text-danger']) ?>
            </div>
        </div>

        <div class="row row-spacing">
            <div class="col-md-6">
                <label class="form-label">Contractor Address:</label>
                <input type="text" name="ProductWarrantyRequest[applicator_address]" class="form-control" value="<?= h(@$log['applicator_address']) ?>" />
                <?= $this->Form->error('ProductWarrantyRequest.applicator_address', null, ['class' => 'text-danger']) ?>
            </div>
            <div class="col-md-6">
                <label class="form-label">Contractor Name:</label>
                <input type="text" name="ProductWarrantyRequest[contract_name]" class="form-control" value="<?= h(@$log['contract_name']) ?>" />
                <?= $this->Form->error('ProductWarrantyRequest.contract_name', null, ['class' => 'text-danger']) ?>
            </div>
        </div>

        <div class="row row-spacing">
            <div class="col-md-6">
                <label class="form-label">Signature / Date:</label>
                <input type="date" name="ProductWarrantyRequest[sign_date]" class="form-control" value="<?= !empty($log['sign_date']) ? date('Y-m-d', strtotime($log['sign_date'])) : '' ?>" />
                <?= $this->Form->error('ProductWarrantyRequest.sign_date', null, ['class' => 'text-danger']) ?>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="row row-spacing">
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    <?= $this->Form->end() ?>

    <!-- Footer -->
    <div class="footer-section">
        <p class="form-title" style="font-size: 11px; margin-bottom: 15px;">Please forward this completed application form together with details of the product(s) purchased to:</p>
        <h4>Durotech Industries</h4>
        <p>14 Essser Street Minto NSW 2566 | Fax 62 2 9679 5050 | Email sales@durotechindustries.com.au</p>
        <p><strong>www.durotechindustries.com.au</strong></p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Wait for the page to load
    document.addEventListener('DOMContentLoaded', function() {
        // Select all flash messages
        var flashMessages = document.querySelectorAll('.alert');

        flashMessages.forEach(function(msg) {
            // Hide after 5 seconds (5000 ms)
            setTimeout(function() {
                msg.style.transition = "opacity 0.5s ease";
                msg.style.opacity = 0;
                setTimeout(function() { msg.remove(); }, 500); // Remove from DOM after fade
            }, 5000);
        });
    });
</script>

</body>


</html>