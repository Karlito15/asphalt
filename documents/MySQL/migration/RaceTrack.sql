SELECT
`name_english` AS `English`, `name_french` AS `French`, `race_region`.`name` AS `Region`
FROM
`race_track`
INNER JOIN `race_region` ON `race_track`.`region_id` = `race_region`.`id`
ORDER BY `Region` ASC
;

mysql -u root -p sym-asphalt-v7 --batch --raw -e "SELECT `name_english` AS `English`, `name_french` AS `French`, `race_region`.`name` AS `Region` FROM `race_track` INNER JOIN `race_region` ON `race_track`.`region_id` = `race_region`.`id` ORDER BY `Region` ASC;" > E:\Symfony\Asphalt\documents\csv\migration\races\track.csv
