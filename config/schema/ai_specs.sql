-- AiSpec: Waterproofing Materials Matrix (run once on MySQL/MariaDB)
CREATE TABLE IF NOT EXISTS `ai_specs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) unsigned NOT NULL DEFAULT 0,
  `tracknumber` varchar(64) NOT NULL DEFAULT '',
  `project` varchar(512) NOT NULL DEFAULT '',
  `client` varchar(255) NOT NULL DEFAULT '',
  `revision` int(11) NOT NULL DEFAULT 1,
  `doc_reference` varchar(128) NOT NULL DEFAULT '',
  `section_number` varchar(16) NOT NULL DEFAULT '4',
  `section_title` varchar(255) NOT NULL DEFAULT 'Material Review by Area',
  `subsection_number` varchar(16) NOT NULL DEFAULT '4.1',
  `subsection_title` varchar(255) NOT NULL DEFAULT 'Waterproofing Materials Matrix',
  `pdf_attachment` varchar(512) NOT NULL DEFAULT '',
  `save_status` varchar(16) NOT NULL DEFAULT 'submitted',
  `deleted_at` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_ai_specs_admin` (`admin_id`),
  KEY `idx_ai_specs_status` (`save_status`),
  KEY `idx_ai_specs_track` (`tracknumber`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `ai_spec_sections` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ai_spec_id` int(11) unsigned NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `standards_text` varchar(512) NOT NULL DEFAULT '',
  `sort_order` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_ai_spec_sections_spec` (`ai_spec_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `ai_spec_items` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ai_spec_section_id` int(11) unsigned NOT NULL,
  `wpm_code` varchar(32) NOT NULL DEFAULT '',
  `tag_color` varchar(16) NOT NULL DEFAULT '#4CAF50',
  `application_area` varchar(512) NOT NULL DEFAULT '',
  `product_name` varchar(512) NOT NULL DEFAULT '',
  `description` varchar(512) NOT NULL DEFAULT '',
  `fall_requirement` varchar(255) NOT NULL DEFAULT '',
  `sort_order` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_ai_spec_items_section` (`ai_spec_section_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
