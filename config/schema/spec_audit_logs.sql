CREATE TABLE IF NOT EXISTS spec_audit_logs (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    mailer_id INT UNSIGNED NULL,
    tracknumber VARCHAR(100) NULL,
    action VARCHAR(80) NOT NULL,
    actor_role VARCHAR(30) NOT NULL,
    actor_id INT UNSIGNED NULL,
    source VARCHAR(30) NULL,
    ip_address VARCHAR(45) NULL,
    message VARCHAR(255) NULL,
    meta_json TEXT NULL,
    created DATETIME NOT NULL,
    PRIMARY KEY (id),
    KEY idx_spec_audit_mailer_created (mailer_id, created),
    KEY idx_spec_audit_actor_created (actor_role, actor_id, created),
    KEY idx_spec_audit_action_created (action, created)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
