SELECT `value` AS `Value` FROM `mission_type`;

mysql -u root -p sym-prod-asphalt --batch --raw -e "SELECT `value` AS `Value` FROM `mission_type`;" | sed 's/\t/;/g' > E:\Symfony\Asphalt\documents\csv\missions\dev---type.csv
