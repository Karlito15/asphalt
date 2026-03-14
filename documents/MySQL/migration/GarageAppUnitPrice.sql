## Garage Unit Price
SELECT
`setting_brand`.`name` AS `Brand`,
`garage_app`.`model` AS `Model`,
`setting_unit_price`.`slug` AS `SettingPrice`
FROM `garage_app`
INNER JOIN `setting_brand` ON `setting_brand`.`id` = `garage_app`.`setting_brand_id`
INNER JOIN `setting_unit_price` ON `setting_unit_price`.`id` = `garage_app`.`setting_unit_price_id`
ORDER BY `setting_brand`.`name` ASC, `garage_app`.`model` ASC
;

mysql -u root -p sym-asphalt-v7 --batch --raw -e "SELECT `setting_brand`.`name` AS `Brand`, `garage_app`.`model` AS `Model`, `setting_unit_price`.`slug` AS `SettingPrice` FROM `garage_app` INNER JOIN `setting_brand` ON `setting_brand`.`id` = `garage_app`.`setting_brand_id` INNER JOIN `setting_unit_price` ON `setting_unit_price`.`id` = `garage_app`.`setting_unit_price_id` ORDER BY `setting_brand`.`name` ASC, `garage_app`.`model` ASC;" > E:\Symfony\Asphalt\documents\csv\migration\garages\setting-price.csv
