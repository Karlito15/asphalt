SELECT
setting_brand.name AS Brand,
garage.model AS Model,
setting_blueprint.slug AS SettingBlueprint
FROM garage
INNER JOIN setting_brand ON setting_brand.id = garage.setting_brand_id
INNER JOIN setting_blueprint ON setting_blueprint.id = garage.setting_blueprint_id
ORDER BY setting_brand.`name` ASC, garage.model ASC
;
