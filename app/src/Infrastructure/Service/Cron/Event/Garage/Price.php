<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Cron\Event\Garage;

use App\Infrastructure\Event\Garage\AppEvent;

final readonly class Price
{
    public function paid(AppEvent $event): void
    {
        ### variables
        $garage     = $event->getGarage();
        $price      = $event->getSettingUnitPrices();
        $entity     = $garage->getPaid();
        $upgrade    = [
            'speed'         => $garage->getUpgrade()->getSpeed(),
            'acceleration'  => $garage->getUpgrade()->getAcceleration(),
            'handling'      => $garage->getUpgrade()->getHandling(),
            'nitro'         => $garage->getUpgrade()->getNitro(),
        ];

        ### calcul
        $result = self::calculerPrixEvolutions($upgrade, $price);

        ### set datas
        $entity
            ->setLevel01($result["lvl1"])
            ->setLevel02($result["lvl2"])
            ->setLevel03($result["lvl3"])
            ->setLevel04($result["lvl4"])
            ->setLevel05($result["lvl5"])
            ->setLevel06($result["lvl6"])
            ->setLevel07($result["lvl7"])
            ->setLevel08($result["lvl8"])
            ->setLevel09($result["lvl9"])
            ->setLevel10($result["lvl10"])
            ->setLevel11($result["lvl11"])
            ->setLevel12($result["lvl12"])
            ->setLevel13($result["lvl13"])
            ->setCommon($garage->getUpgrade()->getCommon() * $event->getSettingUnitPriceCommon())
            ->setRare($garage->getUpgrade()->getRare() * $event->getSettingUnitPriceRare())
            ->setEpic($garage->getUpgrade()->getEpic() * $event->getSettingUnitPriceEpic())
        ;
    }

    public function due(AppEvent $event): void
    {
        ### variables
        $garage     = $event->getGarage();
        $price      = $event->getSettingUnitPrices();
        $entity     = $garage->getDue();
        $upgrade    = [
            'speed'         => $garage->getUpgrade()->getSpeed(),
            'acceleration'  => $garage->getUpgrade()->getAcceleration(),
            'handling'      => $garage->getUpgrade()->getHandling(),
            'nitro'         => $garage->getUpgrade()->getNitro(),
        ];
        $setting    = $event->getSettingUpgrades();

        ### calcul
        $result = self::calculerDepensesAvenir($upgrade, $price);

        ### set datas
        $entity
            ->setLevel01($result["lvl1"])
            ->setLevel02($result["lvl2"])
            ->setLevel03($result["lvl3"])
            ->setLevel04($result["lvl4"])
            ->setLevel05($result["lvl5"])
            ->setLevel06($result["lvl6"])
            ->setLevel07($result["lvl7"])
            ->setLevel08($result["lvl8"])
            ->setLevel09($result["lvl9"])
            ->setLevel10($result["lvl10"])
            ->setLevel11($result["lvl11"])
            ->setLevel12($result["lvl12"])
            ->setLevel13($result["lvl13"])
            ->setCommon(($setting['common'] - $garage->getUpgrade()->getCommon()) * $event->getSettingUnitPriceCommon())
            ->setRare(($setting['rare'] - $garage->getUpgrade()->getRare()) * $event->getSettingUnitPriceRare())
            ->setEpic(($setting['epic'] - $garage->getUpgrade()->getEpic()) * $event->getSettingUnitPriceEpic())
        ;
    }

    public function amount(AppEvent $event): void
    {
        ### variables
        $garage  = $event->getGarage();
        $entity  = $garage->getAmount();
        $common  = $garage->getSettingLevel()->getCommon();
        $rare    = $garage->getSettingLevel()->getRare();
        $epic    = $garage->getSettingLevel()->getEpic();

        ### set datas
        $entity
            ->setLevel01(4 * $event->getSettingUnitPriceLevel01())
            ->setLevel02(4 * $event->getSettingUnitPriceLevel02())
            ->setLevel03(4 * $event->getSettingUnitPriceLevel03())
            ->setLevel04(4 * $event->getSettingUnitPriceLevel04())
            ->setLevel05(4 * $event->getSettingUnitPriceLevel05())
            ->setLevel06(4 * $event->getSettingUnitPriceLevel06())
            ->setLevel07(4 * $event->getSettingUnitPriceLevel07())
            ->setLevel08(4 * $event->getSettingUnitPriceLevel08())
            ->setLevel09(4 * $event->getSettingUnitPriceLevel09())
            ->setLevel10(4 * $event->getSettingUnitPriceLevel10())
            ->setLevel11(4 * $event->getSettingUnitPriceLevel11())
            ->setLevel12(4 * $event->getSettingUnitPriceLevel12())
            ->setLevel13(4 * $event->getSettingUnitPriceLevel13())
            ->setCommon($common * $event->getSettingUnitPriceCommon())
            ->setRare($rare * $event->getSettingUnitPriceRare())
            ->setEpic($epic * $event->getSettingUnitPriceEpic())
        ;
    }

    /** PRIVATE METHODS */

    private static function calculerPrixEvolutions(array $evolution, array $price): array
    {
        $costLevel = [];

        // On boucle sur les niveaux de 1 à 13 (le max utile selon vos données)
        for ($i = 1; $i <= 13; $i++) {
            // Permet de formater le niveau sur 2 chiffres pour correspondre aux clés
            $keyLevel = "lvl" . str_pad((string) $i, 2, "0", STR_PAD_LEFT);

            // On récupère le prix de base du niveau, s'il n'existe pas on met 0
            $prixBaseNiveau = $price[$keyLevel] ?? 0;
            $totalNiveau    = 0;

            // On vérifie chaque statistique de la voiture
            foreach ($evolution as $stat => $niveauVoiture) {
                // Si le niveau de la voiture couvre le niveau en cours, on paie l'évolution
                if ($niveauVoiture >= $i) {
                    $totalNiveau += $prixBaseNiveau;
                }
            }

            // On stocke le résultat pour ce niveau
            $costLevel["lvl" . $i] = $totalNiveau;
        }

        return $costLevel;
    }

    private static function calculerDepensesAvenir(array $evolution, array $price): array
    {
        $depensesParNiveau = [];

        // On boucle du niveau 1 au niveau 13
        for ($i = 1; $i <= 13; $i++) {
            // Permet de formater le niveau sur 2 chiffres pour correspondre aux clés
            $keyLevel = "lvl" . str_pad((string) $i, 2, "0", STR_PAD_LEFT);

            // On récupère le prix de base du niveau, s'il n'existe pas on met 0
            $prixBaseNiveau = $price[$keyLevel] ?? 0;
            $totalNiveau    = 0;

            // On parcourt chaque caractéristique de la voiture
            foreach ($evolution as $stat => $niveauActuel) {
                // Si le niveau actuel de la voiture est INFÉRIEUR au niveau testé,
                // cela signifie que l'évolution n'est pas encore installée : on doit payer.
                if ($niveauActuel < $i) {
                    $totalNiveau += $prixBaseNiveau;
                }
            }

            // On stocke le résultat pour ce niveau
            $depensesParNiveau["lvl" . $i] = $totalNiveau;
        }

        return $depensesParNiveau;
    }
}
