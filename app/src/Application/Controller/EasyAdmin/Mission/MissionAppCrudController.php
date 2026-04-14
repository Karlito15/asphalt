<?php

declare(strict_types=1);

namespace App\Application\Controller\EasyAdmin\Mission;

use App\Domain\Entity\MissionApp;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

#[AdminDashboard(
    routePath: '/admin/mission/app.php',
    routeName: 'easy.admin.mission.app'
)]
class MissionAppCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MissionApp::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield IntegerField::new('week');
        yield TextField::new('region');
        yield TextField::new('track');
        yield TextField::new('class');
        yield TextField::new('brand');
        yield TextEditorField::new('description');
        yield IntegerField::new('success');
        yield IntegerField::new('target');
//        yield IntegerField::new('MissionTask');
//        yield IntegerField::new('MissionType');
        yield DateTimeField::new('createdAt')->onlyOnIndex();
        yield DateTimeField::new('updatedAt')->onlyOnIndex();
    }
}
