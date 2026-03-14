SELECT
`category` AS Category, `label` AS `Label`, `value` AS `Value`, `filter` AS `Filter`, `position` AS `Position`, `active` AS `Active`
FROM
`inventory_app`
;

mysql -u root -p sym-asphalt-v7 --batch --raw -e "SELECT `category` AS Category, `label` AS `Label`, `value` AS `Value`, `filter` AS `Filter`, `position` AS `Position`, `active` AS `Active` FROM `inventory_app`;" > E:\Symfony\Asphalt\documents\csv\migration\inventory.csv
