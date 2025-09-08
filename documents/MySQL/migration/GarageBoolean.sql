## Garage Rank
SELECT 
bloquer AS Locked,
# debloquer,
full_blueprint AS FullBlueprint,
gold AS Gold,
to_unlock AS ToUnlock,
to_upgrade AS ToUpgrade,
# full_upgrade,
# full_common,
# full_rare,
# full_epic,
# full_import,
# to_install_upgrade,
to_install_common AS InstallCommon,
to_install_rare AS InstallRare,
to_install_epic AS InstallEpic,
# to_install_import,
setting_brand.name AS Brand, 
garage.model AS Model
FROM garage_boolean
INNER JOIN garage ON garage_boolean.garage_id = garage.id
INNER JOIN setting_brand ON setting_brand.id = garage.setting_brand_id
ORDER BY setting_brand.`name` ASC, garage.model ASC
;
