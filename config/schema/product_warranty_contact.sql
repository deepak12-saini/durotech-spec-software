-- Product Warranty v2: customer contact for approval emails
ALTER TABLE `product_warranty_request`
    ADD COLUMN `email` VARCHAR(255) NULL DEFAULT NULL AFTER `contract_name`,
    ADD COLUMN `phone` VARCHAR(32) NULL DEFAULT NULL AFTER `email`;
