-- Claude Spec Assistant drafts (employee panel Phase 1)
CREATE TABLE IF NOT EXISTS `claude_spec_drafts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) unsigned NOT NULL DEFAULT 0,
  `tracknumber` varchar(64) NOT NULL DEFAULT '',
  `project_brief` text,
  `client_name` varchar(255) NOT NULL DEFAULT '',
  `company` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `address` varchar(512) NOT NULL DEFAULT '',
  `generated_payload` longtext,
  `status` varchar(16) NOT NULL DEFAULT 'draft',
  `applied_mailer_id` int(11) unsigned DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_claude_spec_drafts_employee` (`employee_id`),
  KEY `idx_claude_spec_drafts_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
