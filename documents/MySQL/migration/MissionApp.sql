## TO Reformat title of column
SELECT
`week`, `region`, `track`, `class`, `brand`, `description`, `success`, `target`,
`mission_task`.`value` AS `task`,
`mission_type`.`value` AS `type`
FROM
`app_mission`
INNER JOIN `mission_task` ON `app_mission`.`task_id` = `mission_task`.`id`
INNER JOIN `mission_type` ON `app_mission`.`type_id` = `mission_type`.`id`
ORDER BY `week` ASC
;
SELECT `value` AS `Value` FROM `mission_task`;
SELECT `value` AS `Value` FROM `mission_type`;

mysql -u root -p sym-prod-asphalt --batch --raw -e "SELECT `week`, `region`, `track`, `class`, `brand`, `description`, `success`, `target`, `mission_task`.`value` AS `task`, `mission_type`.`value` AS `type` FROM `app_mission` INNER JOIN `mission_task` ON `app_mission`.`task_id` = `mission_task`.`id` INNER JOIN `mission_type` ON `app_mission`.`type_id` = `mission_type`.`id` ORDER BY `week` ASC;" | sed 's/\t/;/g' > E:\Symfony\Asphalt\documents\csv\missions\dev---app.csv
