## Status Control
SELECT
`setting_brand`.`name` AS `Brand`,
`garage_app`.`model` AS `Model`,
`garage_status`.`full_upgrade_speed` AS `FullSpeed`,
`garage_status`.`full_upgrade_acceleration` AS `FullAcceleration`,
`garage_status`.`full_upgrade_handling` AS `FullHandling`,
`garage_status`.`full_upgrade_nitro` AS `FullNitro`,
`garage_status`.`full_upgrade_level` AS `FullUpgrade`,
`garage_status`.`full_upgrade_common` AS `FullCommon`,
`garage_status`.`full_upgrade_rare` AS `FullRare`,
`garage_status`.`full_upgrade_epic` AS `FullEpic`,
# `garage_status`.`XXX` AS `FullImport`,
`garage_status`.`full_blueprint_star1` AS `FullStar1`,
`garage_status`.`full_blueprint_star2` AS `FullStar2`,
`garage_status`.`full_blueprint_star3` AS `FullStar3`,
`garage_status`.`full_blueprint_star4` AS `FullStar4`,
`garage_status`.`full_blueprint_star5` AS `FullStar5`,
`garage_status`.`full_blueprint_star6` AS `FullStar6`,
# `garage_status`.`XXX` AS `FullBlueprint`,
# `garage_status`.`XXX` AS `FullEvo`,
`garage_status`.`to_install_upgrade_speed` AS `ToInstallSpeed`,
`garage_status`.`to_install_upgrade_acceleration` AS `ToInstallAcceleration`,
`garage_status`.`to_install_upgrade_handling` AS `ToInstallHandling`,
`garage_status`.`to_install_upgrade_nitro` AS `ToInstallNitro`,
`garage_status`.`to_install_upgrade_common` AS `ToInstallUpgrade`,
`garage_status`.`to_install_upgrade_rare` AS `ToInstallCommon`,
`garage_status`.`to_install_upgrade_epic` AS `ToInstallRare`,
# `garage_status`.`XXX` AS `ToInstallEpic`,
# `garage_status`.`XXX` AS `ToInstallImport`,
`garage_status`.`to_unblock` AS `ToUnblock`,
`garage_status`.`to_gold` AS `ToGold`
FROM `garage_status`
INNER JOIN `garage_app` ON `garage_status`.`garage_id` = `garage_app`.`id`
INNER JOIN `setting_brand` ON `setting_brand`.`id` = `garage_app`.`setting_brand_id`
ORDER BY `setting_brand`.`name` ASC, `garage_app`.`model` ASC
;

mysql -u root -p sym-asphalt-v7 --batch --raw -e "SELECT `setting_brand`.`name` AS `Brand`, `garage_app`.`model` AS `Model`, `garage_status`.`full_upgrade_speed` AS `FullSpeed`, `garage_status`.`full_upgrade_acceleration` AS `FullAcceleration`, `garage_status`.`full_upgrade_handling` AS `FullHandling`, `garage_status`.`full_upgrade_nitro` AS `FullNitro`, `garage_status`.`full_upgrade_level` AS `FullUpgrade`, `garage_status`.`full_upgrade_common` AS `FullCommon`, `garage_status`.`full_upgrade_rare` AS `FullRare`, `garage_status`.`full_upgrade_epic` AS `FullEpic`, `garage_status`.`full_blueprint_star1` AS `FullStar1`, `garage_status`.`full_blueprint_star2` AS `FullStar2`, `garage_status`.`full_blueprint_star3` AS `FullStar3`, `garage_status`.`full_blueprint_star4` AS `FullStar4`, `garage_status`.`full_blueprint_star5` AS `FullStar5`, `garage_status`.`full_blueprint_star6` AS `FullStar6`, `garage_status`.`to_install_upgrade_speed` AS `ToInstallSpeed`, `garage_status`.`to_install_upgrade_acceleration` AS `ToInstallAcceleration`, `garage_status`.`to_install_upgrade_handling` AS `ToInstallHandling`, `garage_status`.`to_install_upgrade_nitro` AS `ToInstallNitro`, `garage_status`.`to_install_upgrade_common` AS `ToInstallUpgrade`, `garage_status`.`to_install_upgrade_rare` AS `ToInstallCommon`, `garage_status`.`to_install_upgrade_epic` AS `ToInstallRare`, `garage_status`.`to_unblock` AS `ToUnblock`, `garage_status`.`to_gold` AS `ToGold` FROM `garage_status` INNER JOIN `garage_app` ON `garage_status`.`garage_id` = `garage_app`.`id` INNER JOIN `setting_brand` ON `setting_brand`.`id` = `garage_app`.`setting_brand_id` ORDER BY `setting_brand`.`name` ASC, `garage_app`.`model` ASC ;" > E:\Symfony\Asphalt\documents\csv\migration\garages\garage-status-control.csv
