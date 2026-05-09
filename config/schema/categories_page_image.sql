-- Add category page image column for category hero section image.
-- Run once in MySQL / phpMyAdmin.
-- mysql -u your_user -p your_database < config/schema/categories_page_image.sql

ALTER TABLE `categories`
ADD COLUMN `category_page_image` VARCHAR(255) NULL DEFAULT NULL
COMMENT 'Image used on category detail page hero';
