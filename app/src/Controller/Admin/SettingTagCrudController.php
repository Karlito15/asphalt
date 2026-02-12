<?php

namespace App\Controller\Admin;

use App\Persistence\Entity\SettingTag;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SettingTagCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SettingTag::class;
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
