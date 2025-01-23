1. ALTER TABLE indikator_inovasi
DROP CONSTRAINT indikator_inovasi_indikator_id_foreign;
ALTER TABLE parameters
DROP CONSTRAINT parameters_indikator_id_foreign;
ALTER TABLE uploads
DROP CONSTRAINT uploads_indikator_id_foreign;
2. delete from indikators where id in(58,57)
3. UPDATE indikators
SET id = CASE
    WHEN id = 150 THEN 52
    WHEN id = 151 THEN 53
    WHEN id = 152 THEN 54
    WHEN id = 153 THEN 57
    WHEN id = 154 THEN 58
END
WHERE id IN (150, 151, 152, 153, 154)
AND kategori_id = 2 
AND deleted_at IS NULL;
4.

UPDATE indikator_inovasi
SET indikator_id = CASE
    WHEN indikator_id = 50 THEN 52
    WHEN indikator_id = 51 THEN 53
    WHEN indikator_id = 52 THEN 54
    WHEN indikator_id = 53 THEN 57
    WHEN indikator_id = 54 THEN 58
    ELSE indikator_id  -- Keep original id if no match
END
WHERE inovasi_id = 565;

5. update di jatim berdasi dibawah ini :


UPDATE indikator_inovasi
SET indikator_id = CASE
    WHEN indikator_id = 50 THEN 52
    WHEN indikator_id = 51 THEN 53
    WHEN indikator_id = 52 THEN 54
    WHEN indikator_id = 53 THEN 57
    WHEN indikator_id = 54 THEN 58
    ELSE indikator_id  -- Keep original id if no match
END
WHERE inovasi_id = 565;