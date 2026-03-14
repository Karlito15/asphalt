SELECT `value` AS `Value`, `slug` AS `Slug` FROM `mission_task`;

mysql -u root -p sym-asphalt-v7 --batch --raw -e "SELECT `value` AS `Value`, `slug` AS `Slug` FROM `mission_task`;" > E:\Symfony\Asphalt\documents\csv\migration\missions\task.csv
