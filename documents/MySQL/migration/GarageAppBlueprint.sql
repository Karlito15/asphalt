## Blueprint
SELECT
`setting_brand`.`name` AS `Brand`,
`app_garage`.`model` AS `Model`,
`setting_blueprint`.`slug` AS `SettingBlueprint`
FROM `app_garage`
INNER JOIN `setting_brand` ON `setting_brand`.`id` = `app_garage`.`setting_brand_id`
INNER JOIN `setting_blueprint` ON `setting_blueprint`.`id` = `app_garage`.`setting_blueprint_id`
ORDER BY `setting_brand`.`name` ASC, `app_garage`.`model` ASC
;

mysql -u root -p sym-prod-asphalt --batch --raw -e "SELECT `setting_brand`.`name` AS `Brand`, `app_garage`.`model` AS `Model`, `setting_blueprint`.`slug` AS `SettingBlueprint` FROM `app_garage` INNER JOIN `setting_brand` ON `setting_brand`.`id` = `app_garage`.`setting_brand_id` INNER JOIN `setting_blueprint` ON `setting_blueprint`.`id` = `app_garage`.`setting_blueprint_id` ORDER BY `setting_brand`.`name` ASC, `app_garage`.`model` ASC;" | sed 's/\t/;/g' > E:\Symfony\Asphalt\documents\csv\garages\dev---setting-blueprint.csv
