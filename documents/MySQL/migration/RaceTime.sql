SELECT
`name` AS `Name`
FROM
`race_time`
ORDER BY `Name` ASC
;

mysql -u root -p sym-asphalt-v7 --batch --raw -e "SELECT `name` AS `Name` FROM `race_time` ORDER BY `Name` ASC;" > E:\Symfony\Asphalt\documents\csv\migration\races\time.csv
