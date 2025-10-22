## Upgrade
SELECT
`garage_upgrade`.`speed` AS `Speed`,
`garage_upgrade`.`acceleration` AS `Acceleration`,
`garage_upgrade`.`handly` AS `Handly`,
`garage_upgrade`.`nitro` AS `Nitro`,
`garage_upgrade`.`common` AS `Common`,
`garage_upgrade`.`rare` AS `Rare`,
`garage_upgrade`.`epic` AS `Epic`,
`setting_brand`.`name` AS `Brand`,
`app_garage`.`model` AS `Model`
FROM `garage_upgrade`
INNER JOIN `app_garage` ON `garage_upgrade`.`garage_id` = `app_garage`.`id`
INNER JOIN `setting_brand` ON `setting_brand`.`id` = `app_garage`.`setting_brand_id`
ORDER BY `setting_brand`.`name` ASC, `app_garage`.`model` ASC
;

mysql -u root -p sym-prod-asphalt --batch --raw -e "SELECT `garage_upgrade`.`speed` AS `Speed`, `garage_upgrade`.`acceleration` AS `Acceleration`, `garage_upgrade`.`handly` AS `Handling`, `garage_upgrade`.`nitro` AS `Nitro`, `garage_upgrade`.`common` AS `Common`, `garage_upgrade`.`rare` AS `Rare`, `garage_upgrade`.`epic` AS `Epic`, `setting_brand`.`name` AS `Brand`, `app_garage`.`model` AS `Model` FROM `garage_upgrade` INNER JOIN `app_garage` ON `garage_upgrade`.`garage_id` = `app_garage`.`id` INNER JOIN `setting_brand` ON `setting_brand`.`id` = `app_garage`.`setting_brand_id` ORDER BY `setting_brand`.`name` ASC, `app_garage`.`model` ASC;" | sed 's/\t/;/g' > E:\Symfony\Asphalt\documents\csv\garages\dev---garage-upgrade.csv
