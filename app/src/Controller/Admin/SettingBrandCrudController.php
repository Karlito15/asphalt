<?php

namespace App\Controller\Admin;

use App\Persistence\Entity\SettingBrand;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SettingBrandCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SettingBrand::class;
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
