## Rank
SELECT
`car_order` AS `Position`,
`setting_brand`.`name` AS `Brand`,
`app_garage`.`model` AS `Model`
FROM `garage_rank`
INNER JOIN `app_garage` ON `garage_rank`.`garage_id` = `app_garage`.`id`
INNER JOIN `setting_brand` ON `setting_brand`.`id` = `app_garage`.`setting_brand_id`
ORDER BY `setting_brand`.`name` ASC, `app_garage`.`model` ASC
;
