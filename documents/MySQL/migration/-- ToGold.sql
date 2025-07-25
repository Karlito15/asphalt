SELECT 
`setting_brand`.`name` AS `Brand`,
`app_garage`.`model` AS `Model`,
`app_garage`.`slug` AS `Slug`
FROM `garage_boolean`
INNER JOIN `app_garage` ON `garage_boolean`.`garage_id` = `app_garage`.`id`
INNER JOIN `setting_brand` ON `setting_brand`.`id` = `app_garage`.`setting_brand_id`
WHERE to_gold = 1
;

mysql -u root -p sym-prod-asphalt --batch --raw -e "SELECT `setting_brand`.`name` AS `Brand`, `app_garage`.`model` AS `Model`, `app_garage`.`slug` AS `Slug` FROM `garage_boolean` INNER JOIN `app_garage` ON `garage_boolean`.`garage_id` = `app_garage`.`id` INNER JOIN `setting_brand` ON `setting_brand`.`id` = `app_garage`.`setting_brand_id` WHERE to_gold = 1;" | sed 's/\t/;/g' > E:\Symfony\Asphalt\documents\csv\garages\dev---zzz-to-gold.csv
