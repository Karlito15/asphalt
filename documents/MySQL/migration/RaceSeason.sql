SELECT
`chapter` AS `Chapter`, `name` AS `Name`
FROM
`race_season`
ORDER BY `Chapter` ASC
;

mysql -u root -p sym-asphalt-v7 --batch --raw -e "SELECT `chapter` AS `Chapter`, `name` AS `Name` FROM `race_season` ORDER BY `Chapter` ASC;" > E:\Symfony\Asphalt\documents\csv\migration\races\season.csv
