## TO Reformat title of column
SELECT
`week` AS 'Week',
`region` AS 'Region',
`track` AS 'Track',
`class` AS 'Class',
`brand` AS 'Brand',
`description` AS 'Description',
`success` AS 'Success',
`target` AS 'Target',
`mission_task`.`value` AS `Task`,
`mission_type`.`value` AS `Type`
FROM `mission_app`
INNER JOIN `mission_task` ON `mission_app`.`task_id` = `mission_task`.`id`
INNER JOIN `mission_type` ON `mission_app`.`type_id` = `mission_type`.`id`
ORDER BY `week` ASC
;

mysql -u root -p sym-asphalt-v7 --batch --raw -e "SELECT `week` AS 'Week',   `region` AS 'Region',   `track` AS 'Track',   `class` AS 'Class',   `brand` AS 'Brand',   `description` AS 'Description',   `success` AS 'Success',   `target` AS 'Target',  `mission_task`.`value` AS `Task`, `mission_type`.`value` AS `Type` FROM `mission_app` INNER JOIN `mission_task` ON `mission_app`.`task_id` = `mission_task`.`id` INNER JOIN `mission_type` ON `mission_app`.`type_id` = `mission_type`.`id` ORDER BY `week` ASC ;" > E:\Symfony\Asphalt\documents\csv\migration\missions\app.csv
