## Garage Blueprint
SELECT
`setting_brand`.`name` AS `Brand`,
`garage_app`.`model` AS `Model`,
`star1` AS `Star1`,
`star2` AS `Star2`,
`star3` AS `Star3`,
`star4` AS `Star4`,
`star5` AS `Star5`,
`star6` AS `Star6`
FROM `garage_blueprint`
INNER JOIN `garage_app` ON `garage_blueprint`.`garage_id` = `garage_app`.`id`
INNER JOIN `setting_brand` ON `setting_brand`.`id` = `garage_app`.`setting_brand_id`
ORDER BY `setting_brand`.`name` ASC, `garage_app`.`model` ASC
;

mysql -u root -p sym-asphalt-v7 --batch --raw -e "SELECT `setting_brand`.`name` AS `Brand`, `garage_app`.`model` AS `Model`, `star1` AS `Star1`, `star2` AS `Star2`, `star3` AS `Star3`, `star4` AS `Star4`, `star5` AS `Star5`, `star6` AS `Star6` FROM `garage_blueprint` INNER JOIN `garage_app` ON `garage_blueprint`.`garage_id` = `garage_app`.`id` INNER JOIN `setting_brand` ON `setting_brand`.`id` = `garage_app`.`setting_brand_id` ORDER BY `setting_brand`.`name` ASC, `garage_app`.`model` ASC;" > E:\Symfony\Asphalt\documents\csv\migration\garages\garage-blueprint.csv
