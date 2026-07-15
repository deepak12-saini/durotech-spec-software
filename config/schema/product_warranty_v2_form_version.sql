-- Product Warranty v2: optional form version marker
ALTER TABLE `product_warranty_request`
    ADD COLUMN `form_version` VARCHAR(10) NULL DEFAULT NULL AFTER `status`;
