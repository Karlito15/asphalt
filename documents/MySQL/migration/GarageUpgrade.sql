## Garage Upgrade
SELECT 
garage_upgrade.speed AS Speed, 
garage_upgrade.acceleration AS Acceleration, 
garage_upgrade.handly AS Handly, 
garage_upgrade.nitro AS Nitro, 
garage_upgrade.common AS Common, 
garage_upgrade.rare AS Rare, 
garage_upgrade.epic AS Epic, 
setting_brand.name AS Brand, 
garage.model AS Model
FROM garage_upgrade
INNER JOIN garage ON garage_upgrade.garage_id = garage.id
INNER JOIN setting_brand ON setting_brand.id = garage.setting_brand_id
ORDER BY setting_brand.`name` ASC, garage.model ASC
;
