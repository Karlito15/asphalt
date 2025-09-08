SELECT
setting_brand.name AS Brand,
garage.model AS Model,
setting_level.slug AS SettingLevel
FROM garage
INNER JOIN setting_brand ON setting_brand.id = garage.setting_brand_id
INNER JOIN setting_level ON setting_level.id = garage.setting_level_id
ORDER BY setting_brand.`name` ASC, garage.model ASC
;
