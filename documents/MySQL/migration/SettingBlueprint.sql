SELECT 
`star1` AS `Star1`, `star2` AS `Star2`, `star3` AS `Star3`, `star4` AS `Star4`, `star5` AS `Star5`, `star6` AS `Star6`
FROM 
`setting_blueprint`
ORDER BY `Star1`
;

mysql -u root -p sym-prod-asphalt --batch --raw -e "SELECT `star1` AS `Star1`, `star2` AS `Star2`, `star3` AS `Star3`, `star4` AS `Star4`, `star5` AS `Star5`, `star6` AS `Star6` FROM `setting_blueprint` ORDER BY `Star1`;" | sed 's/\t/;/g' > E:\Symfony\Asphalt\documents\csv\settings\dev---blueprint.csv
