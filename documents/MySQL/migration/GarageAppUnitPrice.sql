## Garage Unit Price
SELECT
`setting_brand`.`name` AS `Brand`,
`app_garage`.`model` AS `Model`,
`setting_unit_price`.`slug` AS `SettingPrice`
FROM `app_garage`
INNER JOIN `setting_brand` ON `setting_brand`.`id` = `app_garage`.`setting_brand_id`
INNER JOIN `setting_unit_price` ON `setting_unit_price`.`id` = `app_garage`.`setting_unit_price_id`
ORDER BY `setting_brand`.`name` ASC, `app_garage`.`model` ASC
;

mysql -u root -p sym-prod-asphalt --batch --raw -e "SELECT `setting_brand`.`name` AS `Brand`, `app_garage`.`model` AS `Model`, `setting_unit_price`.`slug` AS `SettingPrice` FROM `app_garage` INNER JOIN `setting_brand` ON `setting_brand`.`id` = `app_garage`.`setting_brand_id` INNER JOIN `setting_unit_price` ON `setting_unit_price`.`id` = `app_garage`.`setting_unit_price_id` ORDER BY `setting_brand`.`name` ASC, `app_garage`.`model` ASC;" | sed 's/\t/;/g' > E:\Symfony\Asphalt\documents\csv\garages\dev---setting-price.csv
