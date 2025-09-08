SELECT
race_order AS `RaceOrder`,
finished,
race_mode.`name` AS `Mode`,
race_season.`name` AS `Season`,
race_time.`name` AS `Time`,
race_track. name_english AS `English`
FROM
race
INNER JOIN race_mode ON race.mode_id = race_mode.id
INNER JOIN race_season ON race.season_id = race_season.id
INNER JOIN race_time ON race.time_id = race_time.id
INNER JOIN race_track ON race.track_id = race_track.id
ORDER BY race_season.chapter ASC, race_season.`name` ASC, `RaceOrder` ASC
;
