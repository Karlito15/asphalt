SELECT
setting_brand.name AS Brand,
garage.model AS Model,
setting_price_unit.slug AS SettingPrice
FROM garage
INNER JOIN setting_brand ON setting_brand.id = garage.setting_brand_id
INNER JOIN setting_price_unit ON setting_price_unit.id = garage.setting_unit_price_id
ORDER BY setting_brand.`name` ASC, garage.model ASC
;
