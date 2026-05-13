-- Soft-delete column for mailers (employee spec list hides deleted_at rows).
-- Run once via phpMyAdmin or mysql CLI. If the column already exists, skip.

ALTER TABLE `mailers`
  ADD COLUMN `deleted_at` DATETIME NULL DEFAULT NULL;

CREATE INDEX `idx_mailers_deleted_at` ON `mailers` (`deleted_at`);
