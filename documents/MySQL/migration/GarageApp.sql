## Garage
SELECT
`setting_brand`.`name` AS `Brand`,
`garage_app`.`model` AS `Model`,
`garage_app`.`stars` AS `Stars`,
`garage_app`.`game_update` AS `GameUpdate`,
`garage_app`.`car_order` AS `CarOrder`,
`garage_app`.`stat_order` AS `StatOrder`,
`garage_app`.`level` AS `Level`,
`garage_app`.`epic` AS `Epic`,
# `garage_app`.`evo` AS `Evo`,
`setting_class`.`value` AS `SettingClassValue`
FROM `garage_app`
INNER JOIN `setting_brand` ON `setting_brand`.`id` = `garage_app`.`setting_brand_id`
INNER JOIN `setting_class` ON `setting_class`.`id` = `garage_app`.`setting_class_id`
ORDER BY `setting_brand`.`name` ASC, `garage_app`.`model` ASC
;

mysql -u root -p sym-asphalt-v7 --batch --raw -e "SELECT `setting_brand`.`name` AS `Brand`, `garage_app`.`model` AS `Model`, `garage_app`.`stars` AS `Stars`, `garage_app`.`game_update` AS `GameUpdate`, `garage_app`.`car_order` AS `CarOrder`, `garage_app`.`stat_order` AS `StatOrder`, `garage_app`.`level` AS `Level`, `garage_app`.`epic` AS `Epic`, `setting_class`.`value` AS `SettingClassValue` FROM `garage_app` INNER JOIN `setting_brand` ON `setting_brand`.`id` = `garage_app`.`setting_brand_id` INNER JOIN `setting_class` ON `setting_class`.`id` = `garage_app`.`setting_class_id` ORDER BY `setting_brand`.`name` ASC, `garage_app`.`model` ASC;" > E:\Symfony\Asphalt\documents\csv\migration\garages\app.csv
