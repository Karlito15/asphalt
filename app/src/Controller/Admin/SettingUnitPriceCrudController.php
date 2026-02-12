<?php

namespace App\Controller\Admin;

use App\Persistence\Entity\SettingUnitPrice;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SettingUnitPriceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SettingUnitPrice::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
