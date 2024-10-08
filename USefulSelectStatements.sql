
-- DELETE FROM MagicTrainings WHERE character_id = 5;

-- UPDATE MagicTrainings SET magic_type_id = 5 WHERE magic_type_id = 1;


-- SELECT Characters.character_name, Characters.age, Countries.country_name, MagicTypes.magic_name 
-- FROM Characters
-- JOIN MagicTrainings ON Characters.character_id = MagicTrainings.character_id
-- JOIN MagicTypes ON MagicTrainings.magic_type_id = MagicTypes.magic_type_id
-- JOIN Countries ON Characters.country_id = Countries.country_id;

-- SELECT MagicTypes.magic_name FROM MagicTypes;

 -- SELECT Countries.country_name FROM Countries;

SELECT 
    c1.character_name AS 'Character',
    c2.character_name AS Relative,
    rt.relation_name AS Relationship_Type
FROM 
    Relationships r
JOIN 
    Characters c1 ON r.character_id = c1.character_id
JOIN 
    Characters c2 ON r.relative_id = c2.character_id
JOIN 
    RelationTypes rt ON r.relation_type_id = rt.relation_type_id;