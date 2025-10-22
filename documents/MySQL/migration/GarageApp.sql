## Garage
SELECT
`setting_brand`.`name` AS `Brand`,
`app_garage`.`model` AS `Model`,
`app_garage`.`stars` AS `Stars`,
`app_garage`.`game_update` AS `GameUpdate`,
`app_garage`.`car_order` AS `CarOrder`,
`app_garage`.`stat_order` AS `StatOrder`,
`app_garage`.`level` AS `Level`,
`app_garage`.`epic` AS `Epic`,
`garage_boolean`.`locked` AS `Locked`,
`garage_boolean`.`gold` AS `Gold`,
`setting_class`.`value` AS `SettingClassValue`
FROM `app_garage`
INNER JOIN `garage_boolean` ON `garage_boolean`.`garage_id` = `app_garage`.`id`
INNER JOIN `setting_brand` ON `setting_brand`.`id` = `app_garage`.`setting_brand_id`
INNER JOIN `setting_class` ON `setting_class`.`id` = `app_garage`.`setting_class_id`
ORDER BY `setting_brand`.`name` ASC, `app_garage`.`model` ASC
;

mysql -u root -p sym-prod-asphalt --batch --raw -e "SELECT `setting_brand`.`name` AS `Brand`, `app_garage`.`model` AS `Model`, `app_garage`.`stars` AS `Stars`, `app_garage`.`game_update` AS `GameUpdate`, `app_garage`.`car_order` AS `CarOrder`, `app_garage`.`stat_order` AS `StatOrder`, `app_garage`.`level` AS `Level`, `app_garage`.`epic` AS `Epic`, `garage_boolean`.`locked` AS `Locked`, `garage_boolean`.`gold` AS `Gold`, `setting_class`.`value` AS `SettingClassValue` FROM `app_garage` INNER JOIN `garage_boolean` ON `garage_boolean`.`garage_id` = `app_garage`.`id` INNER JOIN `setting_brand` ON `setting_brand`.`id` = `app_garage`.`setting_brand_id` INNER JOIN `setting_class` ON `setting_class`.`id` = `app_garage`.`setting_class_id` ORDER BY `setting_brand`.`name` ASC, `app_garage`.`model` ASC;" | sed 's/\t/;/g' > E:\Symfony\Asphalt\documents\csv\garages\dev---app.csv
