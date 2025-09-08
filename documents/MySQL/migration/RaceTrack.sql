SELECT 
name_english AS English, name_french AS French, `name` AS Region
FROM 
race_track
INNER JOIN race_region ON race_track.region_id = race_region.id
ORDER BY Region ASC
;
