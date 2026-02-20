# Config table for web settings (single row, id=1)
# Run in MySQL: mysql -u your_user -p xoroglobal_customer_durotech < config/schema/config.sql

CREATE TABLE IF NOT EXISTS `config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mailto` varchar(255) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `facebook` varchar(500) DEFAULT NULL,
  `google_plus` varchar(500) DEFAULT NULL,
  `twiter` varchar(500) DEFAULT NULL,
  `linkdin` varchar(500) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insert default row so admin_web_setting finds Config.id = 1
INSERT INTO `config` (`id`, `mailto`, `phone`, `address`, `facebook`, `google_plus`, `twiter`, `linkdin`, `logo`, `created`, `modified`)
VALUES (1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NOW(), NOW())
ON DUPLICATE KEY UPDATE `id` = `id`;
