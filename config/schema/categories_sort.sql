# Add display sequence (sort) column to categories for ordering on website.
# Run once in MySQL / phpMyAdmin. If column already exists, skip or remove it first.
# mysql -u your_user -p your_database < config/schema/categories_sort.sql

ALTER TABLE `categories` ADD COLUMN `sort` INT(11) NOT NULL DEFAULT 0 COMMENT 'Display order (lower = first)';
