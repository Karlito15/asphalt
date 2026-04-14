<?php

declare(strict_types=1);

namespace App\Application\Controller\EasyAdmin\Garage;

use App\Domain\Entity\GarageApp;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

#[AdminDashboard(
    routePath: '/admin/garage/app.php',
    routeName: 'easy.admin.garage.app'
)]
class GarageAppCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return GarageApp::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield IntegerField::new('stars');
        yield IntegerField::new('gameUpdate');
        yield IntegerField::new('carOrder');
        yield IntegerField::new('statOrder');
        yield IntegerField::new('level');
        yield IntegerField::new('epic');
        yield IntegerField::new('evo');
        yield TextField::new('model');
        yield DateTimeField::new('createdAt')->onlyOnIndex();
        yield DateTimeField::new('updatedAt')->onlyOnIndex();
    }
}
