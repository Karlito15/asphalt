<?php

declare(strict_types=1);

namespace App\Infrastructure\Data\Inventory;

use App\Domain\Entity\InventoryApp;

class App
{
    public static function create(array $datas): InventoryApp
    {
        $entity = new InventoryApp();
        $entity->setCategory($datas['Category']);
        $entity->setLabel($datas['Label']);
        $entity->setValue((int) $datas['Value']);
        $entity->setFilter($datas['Filter']);
        $entity->setPosition((int) $datas['Position']);
        $entity->setActive((bool) $datas['Active']);

        return $entity;
    }

    public static function update(InventoryApp $entity, array $datas): InventoryApp
    {
        $entity->setCategory($datas['category']);
        $entity->setLabel($datas['label']);
        $entity->setFilter($datas['filter']);
        $entity->setPosition($datas['position']);
        $entity->setValue($datas['value']);
        $entity->setActive($datas['active']);

        return $entity;
    }
}
