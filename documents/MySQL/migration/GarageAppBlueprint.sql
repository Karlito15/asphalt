## Blueprint
SELECT
`setting_brand`.`name` AS `Brand`,
`garage_app`.`model` AS `Model`,
`setting_blueprint`.`slug` AS `SettingBlueprint`
FROM `garage_app`
INNER JOIN `setting_brand` ON `setting_brand`.`id` = `garage_app`.`setting_brand_id`
INNER JOIN `setting_blueprint` ON `setting_blueprint`.`id` = `garage_app`.`setting_blueprint_id`
ORDER BY `setting_brand`.`name` ASC, `garage_app`.`model` ASC
;

mysql -u root -p sym-asphalt-v7 --batch --raw -e "SELECT `setting_brand`.`name` AS `Brand`, `garage_app`.`model` AS `Model`, `setting_blueprint`.`slug` AS `SettingBlueprint` FROM `garage_app` INNER JOIN `setting_brand` ON `setting_brand`.`id` = `garage_app`.`setting_brand_id` INNER JOIN `setting_blueprint` ON `setting_blueprint`.`id` = `garage_app`.`setting_blueprint_id` ORDER BY `setting_brand`.`name` ASC, `garage_app`.`model` ASC;" > E:\Symfony\Asphalt\documents\csv\migration\garages\setting-blueprint.csv
