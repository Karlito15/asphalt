<?php

namespace App\Controller\Admin;

use App\Persistence\Entity\SettingLevel;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SettingLevelCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SettingLevel::class;
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
