SELECT 
garage_rank.star4 AS "Rank 4", garage_rank.star5 AS "Rank 5", garage_rank.star6 AS "Rank 6", 
garage_stat_max.speed AS Speed, garage_stat_max.acceleration AS Acceleration, garage_stat_max.handly AS Handly, garage_stat_max.nitro AS Nitro, 
setting_class.`value` AS Class, setting_brand.`name` AS Brand, app_garage.model AS Model,
garage_boolean.gold AS Gold, garage_boolean.to_upgrade AS ToUpgrade, garage_boolean.`locked` AS "Locked"
FROM 
garage_rank
INNER JOIN app_garage ON garage_rank.garage_id = app_garage.id
INNER JOIN garage_boolean ON garage_boolean.garage_id = app_garage.id
INNER JOIN garage_stat_max ON garage_stat_max.garage_id = app_garage.id
INNER JOIN setting_brand ON app_garage.setting_brand_id = setting_brand.id
INNER JOIN setting_class ON app_garage.setting_class_id = setting_class.id
ORDER BY garage_stat_max.acceleration DESC, setting_brand.`name` ASC, app_garage.model ASC
;