<?php

declare(strict_types=1);

namespace App\Application\Controller\Race;

use App\Domain\Entity\RaceTrack;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

#[AdminDashboard(
    routePath: '/admin/race/track.php',
    routeName: 'easy.admin.race.track',
    routes: [
        'index'  => ['routePath' => '/all'],
        'new'    => ['routePath' => '/create', 'routeName' => 'create'],
        'edit'   => ['routePath' => '/editing-{entityId}', 'routeName' => 'editing'],
        'delete' => ['routePath' => '/remove/{entityId}'],
        'detail' => ['routeName' => 'view'],
    ]
)]
class RaceTrackCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return RaceTrack::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
		return $crud
			// Design
			->renderContentMaximized()
//			->renderSidebarMinimized()
			// Entity
			->setEntityLabelInSingular('Track')
			->setEntityLabelInPlural('Tracks')
			// Title & Help
			->setPageTitle('index', '%entity_label_plural% listing')
			->setPageTitle('new', 'Create a new Entity %entity_label_singular%')
			->setPageTitle('edit', fn (RaceTrack $entity) => sprintf('Editing <b>%s</b>', $entity->getNameEnglish()))
			->setPageTitle('detail', fn (RaceTrack $entity) => (string) $entity)
			// Date, Time and Number Formatting
			// https://symfony.com/bundles/EasyAdminBundle/current/crud.html#date-time-and-number-formatting-options
			->setTimezone('Europe/Paris')
			// Search, Order, and Pagination
			->setDefaultSort(['id' => 'ASC'])
			// Templates and Form Options
			->addFormTheme('bootstrap_5_layout.html.twig')

            ->setDefaultRowAction([Action::EDIT, Action::DETAIL])
		;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield TextField::new('nameEnglish');
        yield TextField::new('nameFrench');
        yield AssociationField::new('region')->renderAsHtml();
        yield DateTimeField::new('updatedAt')->setFormat('yyyy-MM-dd')->onlyOnIndex();
        yield DateTimeField::new('updatedAt')->setFormat('yyyy-MM-dd')->onlyOnIndex();
    }
}
