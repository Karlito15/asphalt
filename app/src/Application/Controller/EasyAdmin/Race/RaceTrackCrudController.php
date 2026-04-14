<?php

declare(strict_types=1);

namespace App\Application\Controller\EasyAdmin\Race;

use App\Domain\Entity\RaceTrack;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

#[AdminDashboard(
    routePath: '/admin/race/track.php',
    routeName: 'easy.admin.race.track'
)]
class RaceTrackCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return RaceTrack::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield TextField::new('nameEnglish');
        yield TextField::new('nameFrench');
//        yield TextField::new('region');
        yield DateTimeField::new('createdAt')->onlyOnIndex();
        yield DateTimeField::new('updatedAt')->onlyOnIndex();
    }
}
