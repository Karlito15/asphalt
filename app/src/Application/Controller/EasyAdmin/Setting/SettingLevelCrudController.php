<?php

declare(strict_types=1);

namespace App\Application\Controller\EasyAdmin\Setting;

use App\Domain\Entity\SettingLevel;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

#[AdminDashboard(
    routePath: '/admin/setting/level.php',
    routeName: 'easy.admin.setting.level'
)]
class SettingLevelCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SettingLevel::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield IntegerField::new('level');
        yield IntegerField::new('common');
        yield IntegerField::new('rare');
        yield IntegerField::new('epic');
        yield DateTimeField::new('createdAt')->onlyOnIndex();
        yield DateTimeField::new('updatedAt')->onlyOnIndex();
    }
}
