SELECT
`level` AS `Level`, `common` AS `Common`, `rare` AS `Rare`, `epic` AS `Epic`
FROM
`setting_level`
# ORDER BY `id` ASC
;

mysql -u root -p sym-prod-asphalt --batch --raw -e "SELECT `level` AS `Level`, `common` AS `Common`, `rare` AS `Rare`, `epic` AS `Epic` FROM `setting_level`;" | sed 's/\t/;/g' > E:\Symfony\Asphalt\documents\csv\settings\dev---level.csv
