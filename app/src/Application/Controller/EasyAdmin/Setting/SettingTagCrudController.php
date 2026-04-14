<?php

declare(strict_types=1);

namespace App\Application\Controller\EasyAdmin\Setting;

use App\Domain\Entity\SettingTag;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

#[AdminDashboard(
    routePath: '/admin/setting/tag.php',
    routeName: 'easy.admin.setting.tag'
)]
class SettingTagCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SettingTag::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield TextField::new('value');
        yield IntegerField::new('carsNumber');
        yield DateTimeField::new('createdAt')->onlyOnIndex();
        yield DateTimeField::new('updatedAt')->onlyOnIndex();
    }
}
