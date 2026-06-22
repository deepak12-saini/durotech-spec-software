ALTER TABLE `product_warranty_request`
    ADD COLUMN `contractor_signature` VARCHAR(255) NULL DEFAULT NULL AFTER `sign_date`;
