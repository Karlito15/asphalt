SELECT `value` AS `Value` FROM `mission_task`;

mysql -u root -p sym-prod-asphalt --batch --raw -e "SELECT `value` AS `Value` FROM `mission_task`;" | sed 's/\t/;/g' > E:\Symfony\Asphalt\documents\csv\missions\dev---task.csv
