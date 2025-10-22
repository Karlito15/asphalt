SELECT
`race_order` AS `RaceOrder`,
`finished` AS `Finished`,
`race_mode`.`name` AS `Mode`,
`race_season`.`name` AS `Season`,
`race_time`.`name` AS `Time`,
`race_track`. `name_english` AS `English`
FROM
`app_race`
INNER JOIN `race_mode` ON `app_race`.`mode_id` = `race_mode`.`id`
INNER JOIN `race_season` ON `app_race`.`season_id` = `race_season`.`id`
INNER JOIN `race_time` ON `app_race`.`time_id` = `race_time`.`id`
INNER JOIN `race_track` ON `app_race`.`track_id` = `race_track`.`id`
ORDER BY `race_season`.`chapter` ASC, `race_season`.`name` ASC, `RaceOrder` ASC
;

mysql -u root -p sym-prod-asphalt --batch --raw -e "SELECT `race_order` AS `RaceOrder`, `finished` AS `Finished`, `race_mode`.`name` AS `Mode`, `race_season`.`name` AS `Season`, `race_time`.`name` AS `Time`, `race_track`. `name_english` AS `English` FROM `app_race` INNER JOIN `race_mode` ON `app_race`.`mode_id` = `race_mode`.`id` INNER JOIN `race_season` ON `app_race`.`season_id` = `race_season`.`id` INNER JOIN `race_time` ON `app_race`.`time_id` = `race_time`.`id` INNER JOIN `race_track` ON `app_race`.`track_id` = `race_track`.`id` ORDER BY `race_season`.`chapter` ASC, `race_season`.`name` ASC, `RaceOrder` ASC;" | sed 's/\t/;/g' > E:\Symfony\Asphalt\documents\csv\races\dev---app.csv
