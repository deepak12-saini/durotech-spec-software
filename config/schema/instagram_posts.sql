# Instagram posts table for CakePHP 3 app (admin-managed home page feed)
# Run in MySQL: mysql -u your_user -p customer_durotech < config/schema/instagram_posts.sql
# Or run the statements below in phpMyAdmin / MySQL client.

CREATE TABLE IF NOT EXISTS `instagram_posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `permalink` varchar(500) NOT NULL,
  `media_type` varchar(20) NOT NULL DEFAULT 'post',
  `display_order` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `admin_note` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permalink` (`permalink`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `instagram_posts` (`permalink`, `media_type`, `display_order`, `status`, `created`, `modified`) VALUES
('https://www.instagram.com/p/DO-Vi8Ek7Is/', 'post', 1, 1, NOW(), NOW()),
('https://www.instagram.com/p/DOIasoakiAT/', 'post', 2, 1, NOW(), NOW()),
('https://www.instagram.com/p/DN2nsgx5HLM/', 'post', 3, 1, NOW(), NOW()),
('https://www.instagram.com/p/DN2aTC9Yr1I/', 'post', 4, 1, NOW(), NOW()),
('https://www.instagram.com/p/DNFFat4RiQR/', 'post', 5, 1, NOW(), NOW()),
('https://www.instagram.com/p/DNEdysBzyMa/', 'post', 6, 1, NOW(), NOW()),
('https://www.instagram.com/p/DM_1uOgTkX0/', 'post', 7, 1, NOW(), NOW()),
('https://www.instagram.com/p/DLj3jntxkk0/', 'post', 8, 1, NOW(), NOW()),
('https://www.instagram.com/p/DLi_yJLy0CS/', 'post', 9, 1, NOW(), NOW()),
('https://www.instagram.com/p/DLYlioMBtds/', 'post', 10, 1, NOW(), NOW()),
('https://www.instagram.com/p/DKLgR9Ay9lM/', 'post', 11, 1, NOW(), NOW()),
('https://www.instagram.com/p/DJ_VFcDOlGH/', 'post', 12, 1, NOW(), NOW()),
('https://www.instagram.com/p/DJ3Oebdxeet/', 'post', 13, 1, NOW(), NOW()),
('https://www.instagram.com/p/DJ1JHYeSLYn/', 'post', 14, 1, NOW(), NOW()),
('https://www.instagram.com/p/DIzpGKszpQv/', 'post', 15, 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE `modified` = VALUES(`modified`);
