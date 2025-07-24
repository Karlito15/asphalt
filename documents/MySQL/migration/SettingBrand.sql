SELECT 
`name` AS `Name`, `cars_number` AS `Number`
FROM 
`setting_brand`
ORDER BY `Name` ASC
;

mysql -u root -p sym-prod-asphalt --batch --raw -e "SELECT `name` AS `Name`, `cars_number` AS `Number` FROM `setting_brand` ORDER BY `Name` ASC;" | sed 's/\t/;/g' > E:\Symfony\Asphalt\documents\csv\settings\dev---brand.csv
