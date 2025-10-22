SELECT 
`name_english` AS `English`, `name_french` AS `French`, `race_region`.`name` AS `Region`
FROM
`race_track`
INNER JOIN `race_region` ON `race_track`.`region_id` = `race_region`.`id`
ORDER BY `Region` ASC
;

mysql -u root -p sym-prod-asphalt --batch --raw -e "SELECT `name_english` AS `English`, `name_french` AS `French`, `race_region`.`name` AS `Region` FROM `race_track` INNER JOIN `race_region` ON `race_track`.`region_id` = `race_region`.`id` ORDER BY `Region` ASC;" | sed 's/\t/;/g' > E:\Symfony\Asphalt\documents\csv\races\dev---track.csv
