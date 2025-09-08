SELECT
`week`, region, track, class, brand, `description`, success, target, 
mission_task.`value` AS task,
mission_type.`value` AS `type`
FROM
mission
INNER JOIN mission_task ON mission.task_id = mission_task.id
INNER JOIN mission_type ON mission.type_id = mission_type.id
ORDER BY `week` ASC
;