SELECT
setting_brand.name AS Brand,
garage.model AS Model,
garage.stars AS Stars,
garage.game_update AS GameUpdate,
garage.car_order AS CarOrder,
garage.stat_order AS StatOrder,
garage.`level` AS 'Level',
garage.epic AS Epic,
garage.class AS SettingClassValue
FROM garage
INNER JOIN setting_brand ON setting_brand.id = garage.setting_brand_id
ORDER BY setting_brand.`name` ASC, garage.model ASC
;
