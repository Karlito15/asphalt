SELECT
`name` AS `Name`, `cars_number` AS `Number`
FROM
`setting_brand`
ORDER BY `Name` ASC
;

mysql -u root -p sym-asphalt-v7 --batch --raw -e "SELECT `name` AS `Name`, `cars_number` AS `Number` FROM `setting_brand` ORDER BY `Name` ASC;" > E:\Symfony\Asphalt\documents\csv\migration\settings\brand.csv
