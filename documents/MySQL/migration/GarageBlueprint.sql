## Garage Blueprint
SELECT
`star1` AS `Star1`, `star2` AS `Star2`, `star3` AS `Star3`,
`star4` AS `Star4`, `star5` AS `Star5`, `star6` AS `Star6`,
`total` AS `Total`, `setting_brand`.`name` AS `Brand`, `app_garage`.`model` AS `Model`
FROM `garage_blueprint`
INNER JOIN `app_garage` ON `garage_blueprint`.`garage_id` = `app_garage`.`id`
INNER JOIN `setting_brand` ON `setting_brand`.`id` = `app_garage`.`setting_brand_id`
ORDER BY `setting_brand`.`name` ASC, `app_garage`.`model` ASC
;

mysql -u root -p sym-prod-asphalt --batch --raw -e "SELECT `star1` AS `Star1`, `star2` AS `Star2`, `star3` AS `Star3`, `star4` AS `Star4`, `star5` AS `Star5`, `star6` AS `Star6`, `total` AS `Total`, `setting_brand`.`name` AS `Brand`, `app_garage`.`model` AS `Model` FROM `garage_blueprint` INNER JOIN `app_garage` ON `garage_blueprint`.`garage_id` = `app_garage`.`id` INNER JOIN `setting_brand` ON `setting_brand`.`id` = `app_garage`.`setting_brand_id` ORDER BY `setting_brand`.`name` ASC, `app_garage`.`model` ASC;" | sed 's/\t/;/g' > E:\Symfony\Asphalt\documents\csv\garages\dev---garage-blueprint.csv
