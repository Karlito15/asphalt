## StatMin
SELECT 
`speed` AS `Speed`,
`acceleration` AS `Acceleration`,
`handly` AS `Handly`,
`nitro` AS `Nitro`,
`setting_brand`.`name` AS `Brand`,
`app_garage`.`model` AS `Model`
FROM `garage_stat_min`
INNER JOIN `app_garage` ON `garage_stat_min`.`garage_id` = `app_garage`.`id`
INNER JOIN `setting_brand` ON `setting_brand`.`id` = `app_garage`.`setting_brand_id`
ORDER BY `setting_brand`.`name` ASC, `app_garage`.`model` ASC
;

mysql -u root -p sym-prod-asphalt --batch --raw -e "SELECT `speed` AS `Speed`, `acceleration` AS `Acceleration`, `handly` AS `Handling`, `nitro` AS `Nitro`, `setting_brand`.`name` AS `Brand`, `app_garage`.`model` AS `Model` FROM `garage_stat_min` INNER JOIN `app_garage` ON `garage_stat_min`.`garage_id` = `app_garage`.`id` INNER JOIN `setting_brand` ON `setting_brand`.`id` = `app_garage`.`setting_brand_id` ORDER BY `setting_brand`.`name` ASC, `app_garage`.`model` ASC;" | sed 's/\t/;/g' > E:\Symfony\Asphalt\documents\csv\garages\dev---garage-stat-min.csv
