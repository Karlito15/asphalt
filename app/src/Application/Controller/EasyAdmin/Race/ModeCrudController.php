<?php

declare(strict_types=1);

namespace App\Application\Controller\EasyAdmin\Race;

use App\Domain\Entity\RaceMode;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

final class ModeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return RaceMode::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield TextField::new('name');
        yield DateTimeField::new('updatedAt')->setFormat('yyyy-MM-dd')->onlyOnIndex();
        yield DateTimeField::new('updatedAt')->setFormat('yyyy-MM-dd')->onlyOnIndex();
    }
}
