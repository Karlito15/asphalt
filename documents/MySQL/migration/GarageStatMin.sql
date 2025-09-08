## Garage StatMin
SELECT 
speed AS Speed, 
acceleration AS Acceleration, 
handly AS Handly, 
nitro AS Nitro, 
setting_brand.name AS Brand, 
garage.model AS Model
FROM garage_stat_min
INNER JOIN garage ON garage_stat_min.garage_id = garage.id
INNER JOIN setting_brand ON setting_brand.id = garage.setting_brand_id
ORDER BY setting_brand.`name` ASC, garage.model ASC
;
