SELECT
`label` AS `Label`, `value` AS `Value`, `class_order` AS `Order`, `cars_number` AS `Number`, `median` AS `Median`
FROM
`setting_class`
ORDER BY `Label` ASC
;

mysql -u root -p sym-asphalt-v7 --batch --raw -e "SELECT `label` AS `Label`, `value` AS `Value`, `class_order` AS `Order`, `cars_number` AS `Number`, `median` AS `Median` FROM `setting_class` ORDER BY `Label` ASC;" > E:\Symfony\Asphalt\documents\csv\migration\settings\class.csv
