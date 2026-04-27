CREATE TABLE IF NOT EXISTS ai_lessons (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    admin_id INT UNSIGNED NULL,
    title VARCHAR(255) NOT NULL,
    source_content MEDIUMTEXT NULL,
    presentation_json MEDIUMTEXT NULL,
    quiz_json MEDIUMTEXT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'draft',
    created DATETIME NOT NULL,
    modified DATETIME NOT NULL,
    PRIMARY KEY (id),
    KEY idx_ai_lessons_admin_created (admin_id, created),
    KEY idx_ai_lessons_status_created (status, created)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS ai_lesson_attempts (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    lesson_id INT UNSIGNED NOT NULL,
    student_name VARCHAR(120) NULL,
    student_email VARCHAR(180) NULL,
    score INT NOT NULL DEFAULT 0,
    total_questions INT NOT NULL DEFAULT 0,
    answers_json MEDIUMTEXT NULL,
    created DATETIME NOT NULL,
    modified DATETIME NOT NULL,
    PRIMARY KEY (id),
    KEY idx_ai_attempts_lesson_created (lesson_id, created),
    CONSTRAINT fk_ai_attempts_lesson FOREIGN KEY (lesson_id) REFERENCES ai_lessons(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

