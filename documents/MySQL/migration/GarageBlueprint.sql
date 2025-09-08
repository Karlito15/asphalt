## Garage Blueprint
SELECT
star1 AS Star1, star2 AS Star2, star3 AS Star3,
star4 AS Star4, star5 AS Star5, star6 AS Star6,
total AS Total, setting_brand.name AS Brand, garage.model AS Model
FROM garage_blueprint
INNER JOIN garage ON garage_blueprint.garage_id = garage.id
INNER JOIN setting_brand ON setting_brand.id = garage.setting_brand_id
ORDER BY setting_brand.`name` ASC, garage.model ASC
;
