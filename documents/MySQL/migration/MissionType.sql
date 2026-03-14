SELECT `value` AS `Value`, `slug` AS `Slug` FROM `mission_type`;

mysql -u root -p sym-asphalt-v7 --batch --raw -e "SELECT `value` AS `Value`, `slug` AS `Slug` FROM `mission_type`;" > E:\Symfony\Asphalt\documents\csv\migration\missions\type.csv
