SELECT
`race_season`.`name` AS `Season`,
`race_order` AS `RaceOrder`,
`race_mode`.`name` AS `Mode`,
`race_time`.`name` AS `Time`,
`race_track`. `name_english` AS `English`,
`finished` AS `Finished`
FROM
`race_app`
INNER JOIN `race_mode` ON `race_app`.`mode_id` = `race_mode`.`id`
INNER JOIN `race_season` ON `race_app`.`season_id` = `race_season`.`id`
INNER JOIN `race_time` ON `race_app`.`time_id` = `race_time`.`id`
INNER JOIN `race_track` ON `race_app`.`track_id` = `race_track`.`id`
ORDER BY `race_season`.`chapter` ASC, `race_season`.`name` ASC, `RaceOrder` ASC
;

mysql -u root -p sym-asphalt-v7 --batch --raw -e "SELECT `race_season`.`name` AS `Season`, `race_order` AS `RaceOrder`, `race_mode`.`name` AS `Mode`, `race_time`.`name` AS `Time`, `race_track`. `name_english` AS `English`, `finished` AS `Finished` FROM `race_app` INNER JOIN `race_mode` ON `race_app`.`mode_id` = `race_mode`.`id` INNER JOIN `race_season` ON `race_app`.`season_id` = `race_season`.`id` INNER JOIN `race_time` ON `race_app`.`time_id` = `race_time`.`id` INNER JOIN `race_track` ON `race_app`.`track_id` = `race_track`.`id` ORDER BY `race_season`.`chapter` ASC, `race_season`.`name` ASC, `RaceOrder` ASC ;" > E:\Symfony\Asphalt\documents\csv\migration\races\app.csv
