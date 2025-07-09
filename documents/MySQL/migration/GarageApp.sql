## Garage
SELECT
`setting_brand`.`name` AS `Brand`,
`app_garage`.`model` AS `Model`,
`app_garage`.`stars` AS `Stars`,
`app_garage`.`game_update` AS `GameUpdate`,
`app_garage`.`car_order` AS `CarOrder`,
`app_garage`.`stat_order` AS `StatOrder`,
`app_garage`.`level` AS `Level`,
`app_garage`.`epic` AS `Epic`
FROM `app_garage`
INNER JOIN `setting_brand` ON `setting_brand`.`id` = `app_garage`.`setting_brand_id`
ORDER BY `setting_brand`.`name` ASC, `app_garage`.`model` ASC
;
