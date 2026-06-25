-- Bearer tokens for mobile / API v1 employee authentication
CREATE TABLE IF NOT EXISTS api_tokens (
  id INT AUTO_INCREMENT PRIMARY KEY,
  employee_id INT NOT NULL,
  token VARCHAR(64) NOT NULL UNIQUE,
  expires_at DATETIME NOT NULL,
  created DATETIME NOT NULL,
  INDEX idx_token (token),
  INDEX idx_employee_id (employee_id)
);
