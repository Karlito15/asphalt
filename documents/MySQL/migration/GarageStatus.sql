## Status
SELECT
`setting_brand`.`name` AS `Brand`,
`garage_app`.`model` AS `Model`,
`garage_status`.`unblock` AS `Unblock`,
`garage_status`.`gold` AS `Gold`,
`garage_status`.`to_upgrade_level` AS `ToUpgrade`
FROM `garage_status`
INNER JOIN `garage_app` ON `garage_status`.`garage_id` = `garage_app`.`id`
INNER JOIN `setting_brand` ON `setting_brand`.`id` = `garage_app`.`setting_brand_id`
ORDER BY `setting_brand`.`name` ASC, `garage_app`.`model` ASC
;

mysql -u root -p sym-asphalt-v7 --batch --raw -e "SELECT `setting_brand`.`name` AS `Brand`, `garage_app`.`model` AS `Model`, `garage_status`.`unblock` AS `Unblock`, `garage_status`.`gold` AS `Gold`, `garage_status`.`to_upgrade_level` AS `ToUpgrade` FROM `garage_status` INNER JOIN `garage_app` ON `garage_status`.`garage_id` = `garage_app`.`id` INNER JOIN `setting_brand` ON `setting_brand`.`id` = `garage_app`.`setting_brand_id` ORDER BY `setting_brand`.`name` ASC, `garage_app`.`model` ASC ;" > E:\Symfony\Asphalt\documents\csv\migration\garages\garage-status.csv
