# Testimonials table for CakePHP 3 app
# Run this in MySQL: mysql -u your_user -p customer_durotech < config/schema/testimonials.sql
# Or run the CREATE TABLE below in phpMyAdmin / MySQL client.

CREATE TABLE IF NOT EXISTS `testimonials` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `quote` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
