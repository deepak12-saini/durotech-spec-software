-- Track last time spec PDF email was sent to the customer from employee or admin panel.
-- Run once on your database.
ALTER TABLE mailers ADD COLUMN spec_email_sent_at DATETIME NULL DEFAULT NULL;
ALTER TABLE mailers ADD COLUMN spec_email_sent_to VARCHAR(255) NULL DEFAULT NULL;
