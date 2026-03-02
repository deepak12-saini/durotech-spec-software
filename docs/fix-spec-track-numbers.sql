-- Fix wrong spec track numbers (5019, 5020) from old count-based logic.
-- Run this once to correct existing records so they show as 549, 550.
-- After running, new specs will continue from 551.

UPDATE mailers
SET tracknumber = REPLACE(tracknumber, '-5019', '-549')
WHERE type = 3
  AND tracknumber LIKE '%-5019';

UPDATE mailers
SET tracknumber = REPLACE(tracknumber, '-5020', '-550')
WHERE type = 3
  AND tracknumber LIKE '%-5020';
