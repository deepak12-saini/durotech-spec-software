-- Quick Spec public form submissions (run once on MySQL/MariaDB)
CREATE TABLE IF NOT EXISTS `quick_specs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `project_name` varchar(255) NOT NULL DEFAULT '',
  `project_type` varchar(64) NOT NULL DEFAULT '',
  `area` varchar(128) NOT NULL DEFAULT '',
  `system_interest` varchar(255) NOT NULL DEFAULT '',
  `quantity_or_size` varchar(128) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `phone` varchar(64) NOT NULL DEFAULT '',
  `company` varchar(255) NOT NULL DEFAULT '',
  `state` varchar(64) NOT NULL DEFAULT '',
  `notes` text,
  `status` varchar(16) NOT NULL DEFAULT 'new',
  `ip_address` varchar(45) NOT NULL DEFAULT '',
  `user_agent` varchar(512) NOT NULL DEFAULT '',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_quick_specs_status` (`status`),
  KEY `idx_quick_specs_created` (`created`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
