-- Draft auto-save: add save_status to mailers (draft | submitted).
-- Do not use existing "status" column (INT). Run once.
ALTER TABLE mailers ADD COLUMN save_status VARCHAR(20) NOT NULL DEFAULT 'submitted';
