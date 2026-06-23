<?php

declare(strict_types=1);

namespace App\Application\Controller\EasyAdmin\Race;

use App\Domain\Entity\RaceRegion;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

final class RegionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return RaceRegion::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield TextField::new('name');
        yield DateTimeField::new('updatedAt')->setFormat('yyyy-MM-dd')->onlyOnIndex();
        yield DateTimeField::new('updatedAt')->setFormat('yyyy-MM-dd')->onlyOnIndex();
    }
}
