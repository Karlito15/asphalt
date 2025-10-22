SELECT 
`chapter` AS `Chapter`, `name` AS `Name`
FROM
`race_season`
ORDER BY `Chapter` ASC
;

mysql -u root -p sym-prod-asphalt --batch --raw -e "SELECT `chapter` AS `Chapter`, `name` AS `Name` FROM `race_season` ORDER BY `Chapter` ASC;" | sed 's/\t/;/g' > E:\Symfony\Asphalt\documents\csv\races\dev---season.csv
