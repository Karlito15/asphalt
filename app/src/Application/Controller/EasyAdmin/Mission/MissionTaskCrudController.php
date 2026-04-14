<?php

declare(strict_types=1);

namespace App\Application\Controller\EasyAdmin\Mission;

use App\Domain\Entity\MissionTask;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

#[AdminDashboard(
    routePath: '/admin/mission/task.php',
    routeName: 'easy.admin.mission.task'
)]
class MissionTaskCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MissionTask::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield TextField::new('value');
        yield DateTimeField::new('createdAt')->onlyOnIndex();
        yield DateTimeField::new('updatedAt')->onlyOnIndex();
    }
}
