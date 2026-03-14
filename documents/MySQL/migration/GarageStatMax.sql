## StatMax
SELECT
`setting_brand`.`name` AS `Brand`,
`garage_app`.`model` AS `Model`,
`speed` AS `Speed`,
`acceleration` AS `Acceleration`,
`handling` AS `Handling`,
`nitro` AS `Nitro`,
`average` AS `Average`
FROM `garage_stat_max`
INNER JOIN `garage_app` ON `garage_stat_max`.`garage_id` = `garage_app`.`id`
INNER JOIN `setting_brand` ON `setting_brand`.`id` = `garage_app`.`setting_brand_id`
ORDER BY `setting_brand`.`name` ASC, `garage_app`.`model` ASC
;

mysql -u root -p sym-asphalt-v7 --batch --raw -e "SELECT `setting_brand`.`name` AS `Brand`, `garage_app`.`model` AS `Model`, `speed` AS `Speed`, `acceleration` AS `Acceleration`, `handling` AS `Handling`, `nitro` AS `Nitro`, `average` AS `Average` FROM `garage_stat_max` INNER JOIN `garage_app` ON `garage_stat_max`.`garage_id` = `garage_app`.`id` INNER JOIN `setting_brand` ON `setting_brand`.`id` = `garage_app`.`setting_brand_id` ORDER BY `setting_brand`.`name` ASC, `garage_app`.`model` ASC ;" > E:\Symfony\Asphalt\documents\csv\migration\garages\garage-stat-max.csv
