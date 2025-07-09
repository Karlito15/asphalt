## Garage Level
SELECT
`setting_brand`.`name` AS `Brand`,
`app_garage`.`model` AS `Model`,
`setting_level`.`slug` AS `SettingLevel`
FROM `app_garage`
INNER JOIN `setting_brand` ON `setting_brand`.`id` = `app_garage`.`setting_brand_id`
INNER JOIN `setting_level` ON `setting_level`.`id` = `app_garage`.`setting_level_id`
ORDER BY `setting_brand`.`name` ASC, `app_garage`.`model` ASC
;
