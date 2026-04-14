<?php

declare(strict_types=1);

namespace App\Application\Controller\EasyAdmin\Inventory;

use App\Domain\Entity\InventoryApp;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

#[AdminDashboard(
    routePath: '/admin/inventory/app.php',
    routeName: 'easy.admin.inventory.app'
)]
class InventoryAppCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return InventoryApp::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield TextField::new('category');
        yield TextField::new('label');
        yield TextField::new('filter');
        yield IntegerField::new('position')->setCssClass('text-end');
        yield IntegerField::new('value')->setCssClass('text-success text-end');
        yield BooleanField::new('active');
        yield DateTimeField::new('createdAt')->onlyOnIndex();
        yield DateTimeField::new('updatedAt')->onlyOnIndex();
    }
}
