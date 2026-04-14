<?php

declare(strict_types=1);

namespace App\Application\Controller\EasyAdmin\Setting;

use App\Domain\Entity\SettingClass;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

#[AdminDashboard(
    routePath: '/admin/setting/class.php',
    routeName: 'easy.admin.setting.class'
)]
class SettingClassCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SettingClass::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield TextField::new('label');
        yield TextField::new('value');
        yield IntegerField::new('classOrder');
        yield IntegerField::new('carsNumber');
        yield IntegerField::new('median');
        yield DateTimeField::new('createdAt')->onlyOnIndex();
        yield DateTimeField::new('updatedAt')->onlyOnIndex();
    }
}
