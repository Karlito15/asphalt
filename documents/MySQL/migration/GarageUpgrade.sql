## Upgrade
SELECT
`setting_brand`.`name` AS `Brand`,
`garage_app`.`model` AS `Model`,
`garage_upgrade`.`speed` AS `Speed`,
`garage_upgrade`.`acceleration` AS `Acceleration`,
`garage_upgrade`.`handling` AS `Handling`,
`garage_upgrade`.`nitro` AS `Nitro`,
`garage_upgrade`.`common` AS `Common`,
`garage_upgrade`.`rare` AS `Rare`,
`garage_upgrade`.`epic` AS `Epic`
FROM `garage_upgrade`
INNER JOIN `garage_app` ON `garage_upgrade`.`garage_id` = `garage_app`.`id`
INNER JOIN `setting_brand` ON `setting_brand`.`id` = `garage_app`.`setting_brand_id`
ORDER BY `setting_brand`.`name` ASC, `garage_app`.`model` ASC
;

mysql -u root -p sym-asphalt-v7 --batch --raw -e "SELECT `setting_brand`.`name` AS `Brand`, `garage_app`.`model` AS `Model`, `garage_upgrade`.`speed` AS `Speed`, `garage_upgrade`.`acceleration` AS `Acceleration`, `garage_upgrade`.`handling` AS `Handling`, `garage_upgrade`.`nitro` AS `Nitro`, `garage_upgrade`.`common` AS `Common`, `garage_upgrade`.`rare` AS `Rare`, `garage_upgrade`.`epic` AS `Epic` FROM `garage_upgrade` INNER JOIN `garage_app` ON `garage_upgrade`.`garage_id` = `garage_app`.`id` INNER JOIN `setting_brand` ON `setting_brand`.`id` = `garage_app`.`setting_brand_id` ORDER BY `setting_brand`.`name` ASC, `garage_app`.`model` ASC ;" > E:\Symfony\Asphalt\documents\csv\migration\garages\garage-upgrade.csv
