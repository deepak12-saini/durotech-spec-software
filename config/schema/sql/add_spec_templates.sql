-- Employee template presets (Phase 2)
-- Run in local/prod DB before using Template Presets UI.

CREATE TABLE IF NOT EXISTS `spec_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `template_name` varchar(255) NOT NULL,
  `type` int(11) NOT NULL DEFAULT 3,
  `subject` varchar(255) DEFAULT NULL,
  `specification` varchar(255) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_spec_templates_employee` (`employee_id`),
  KEY `idx_spec_templates_deleted_at` (`deleted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `spec_template_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `template_id` int(11) NOT NULL,
  `section_no` int(11) NOT NULL DEFAULT 0,
  `section_title` varchar(255) DEFAULT NULL,
  `serial` varchar(100) DEFAULT NULL,
  `coverage` varchar(255) DEFAULT NULL,
  `product` varchar(255) DEFAULT NULL,
  `coverage_by_pack` varchar(100) DEFAULT NULL,
  `warranty` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_spec_template_items_template` (`template_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `spec_template_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `template_id` int(11) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 1,
  `comment` text,
  PRIMARY KEY (`id`),
  KEY `idx_spec_template_comments_template` (`template_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
