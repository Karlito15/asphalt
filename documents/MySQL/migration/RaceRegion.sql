SELECT 
`name` AS `Name`
FROM
`race_region`
ORDER BY `Name` ASC
;

mysql -u root -p sym-prod-asphalt --batch --raw -e "SELECT `name` AS `Name` FROM`race_region` ORDER BY `Name` ASC;" | sed 's/\t/;/g' > E:\Symfony\Asphalt\documents\csv\races\dev---region.csv
