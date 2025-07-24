SELECT 
`label` AS `Label`, `value` AS `Value`, `class_order` AS `Order`, `cars_number` AS `Number`, `median` AS `Median`
FROM 
`setting_class`
ORDER BY `Label` ASC
;

mysql -u root -p sym-prod-asphalt --batch --raw -e "SELECT `label` AS `Label`, `value` AS `Value`, `class_order` AS `Order`, `cars_number` AS `Number`, `median` AS `Median` FROM `setting_class` ORDER BY `Label` ASC;" | sed 's/\t/;/g' > E:\Symfony\Asphalt\documents\csv\settings\dev---class.csv
