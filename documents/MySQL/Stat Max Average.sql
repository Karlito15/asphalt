/** Dev */
SELECT app_garage.id, setting_brand.`name`, app_garage.model, garage_stat_max.average, app_garage.stat_order
FROM app_garage
LEFT JOIN garage_stat_max ON app_garage.id = garage_stat_max.garage_id
LEFT JOIN setting_brand ON app_garage.setting_brand_id = setting_brand.id
WHERE app_garage.setting_class_id = 3
ORDER BY garage_stat_max.average DESC
;


/** Prod */
SELECT garage.id, setting_brand.`name`, garage.model, garage_stat_max.average, garage.stat_order
FROM garage
LEFT JOIN garage_stat_max ON garage.id = garage_stat_max.garage_id
LEFT JOIN setting_brand ON garage.setting_brand_id = setting_brand.id
WHERE garage.class = 'D'
ORDER BY garage_stat_max.average DESC
;
