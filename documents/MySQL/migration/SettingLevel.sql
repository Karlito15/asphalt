SELECT
`level` AS `Level`, `common` AS `Common`, `rare` AS `Rare`, `epic` AS `Epic`
FROM
`setting_level`
# ORDER BY `id` ASC
;

mysql -u root -p sym-asphalt-v7 --batch --raw -e "SELECT `level` AS `Level`, `common` AS `Common`, `rare` AS `Rare`, `epic` AS `Epic` FROM `setting_level`;" > E:\Symfony\Asphalt\documents\csv\migration\settings\level.csv
