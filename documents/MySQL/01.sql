SELECT 
garage.car_order AS '#', setting_brand.name AS BrandName, garage.model AS Model
FROM garage
INNER JOIN garage_boolean ON garage.id = garage_boolean.garage_id
INNER JOIN setting_brand ON setting_brand.id = garage.setting_brand_id
WHERE garage_boolean.debloquer != 2
# AND garage_boolean.full_blueprint = 0
# AND garage_boolean.full_upgrade = 0
# AND garage_boolean.full_import = 1
# AND garage_boolean.gold = 1
AND garage_boolean.to_upgrade = 1
# AND to_install_upgrade = 0
# AND garage.class = 'S'
ORDER BY class_order, car_order ASC;


/** Garage & BlueprintID */
SELECT garage.id, class_order, car_order, setting_brand.name AS BrandName, garage.model AS Model, garage.setting_blueprint_id AS BlueprintID
FROM garage
INNER JOIN setting_brand ON setting_brand.id = garage.setting_brand_id
WHERE garage.class = 'D'
ORDER BY class_order, car_order ASC;


/** Garage & Blueprints */
SELECT garage.car_order AS '#', garage_blueprint.star1 AS Star1,garage_blueprint.star2 AS Star2,garage_blueprint.star3 AS Star3,garage_blueprint.star4 AS Star4,garage_blueprint.star5 AS Star5,garage_blueprint.star6 AS Star6, setting_brand.name AS Brand, garage.model AS Model
FROM garage
INNER JOIN garage_blueprint ON garage.id = garage_blueprint.garage_id
INNER JOIN setting_brand ON setting_brand.id = garage.setting_brand_id
WHERE garage.class = 'S'
ORDER BY class_order, car_order ASC;


/** Garage & Rank */
SELECT garage.car_order AS '#', garage_rank.start AS Star0, garage_rank.star1 AS Star1, garage_rank.star2 AS Star2, garage_rank.star3 AS Star3, garage_rank.star4 AS Star4, garage_rank.star5 AS Star5, garage_rank.star6 AS Star6, setting_brand.name AS Brand, garage.model AS Model
FROM garage
INNER JOIN garage_rank ON garage.id = garage_rank.garage_id
INNER JOIN setting_brand ON setting_brand.id = garage.setting_brand_id
WHERE garage.class != 'D'
ORDER BY class_order, car_order ASC;
