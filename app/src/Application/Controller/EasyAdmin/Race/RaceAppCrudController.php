<?php

declare(strict_types=1);

namespace App\Application\Controller\EasyAdmin\Race;

use App\Domain\Entity\RaceApp;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

#[AdminDashboard(
    routePath: '/admin/race/app.php',
    routeName: 'easy.admin.race.app'
)]
class RaceAppCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return RaceApp::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield IntegerField::new('raceOrder');
        yield BooleanField::new('finished');
//        yield BooleanField::new('mode');
//        yield BooleanField::new('season');
//        yield BooleanField::new('time');
//        yield BooleanField::new('track');
        yield DateTimeField::new('createdAt')->onlyOnIndex();
        yield DateTimeField::new('updatedAt')->onlyOnIndex();
    }
}
