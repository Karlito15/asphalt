SELECT
`category` AS Category, `label` AS `Label`, `value` AS `Value`, `filter` AS `Filter`, `position` AS `Position`, `active` AS `Active`
FROM
`app_inventory`
;

mysql -u root -p sym-prod-asphalt --batch --raw -e "SELECT `category` AS Category, `label` AS `Label`, `value` AS `Value`, `filter` AS `Filter`, `position` AS `Position`, `active` AS `Active` FROM `app_inventory`;" | sed 's/\t/;/g' > E:\Symfony\Asphalt\documents\csv\dev---inventory.csv
