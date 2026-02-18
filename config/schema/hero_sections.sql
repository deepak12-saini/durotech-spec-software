# Hero Sections table for CakePHP 3 app
# Run in MySQL: mysql -u your_user -p customer_durotech < config/schema/hero_sections.sql
# Or run the CREATE TABLE below in phpMyAdmin / MySQL client.

CREATE TABLE IF NOT EXISTS `hero_sections` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `video` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
