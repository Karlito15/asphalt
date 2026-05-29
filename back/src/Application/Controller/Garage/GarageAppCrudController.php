<?php

declare(strict_types=1);

namespace App\Application\Controller\Garage;

use App\Domain\Entity\GarageApp;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
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

    public function configureCrud(Crud $crud): Crud
    {
		return $crud
			// Design
			->renderContentMaximized()
//			->renderSidebarMinimized()
			// Entity
			->setEntityLabelInSingular('Garage')
			->setEntityLabelInPlural('Garages')
			// Title & Help
			->setPageTitle('index', '%entity_label_plural% listing')
			->setPageTitle('new', 'Create a new Entity %entity_label_singular%')
			->setPageTitle('edit', fn (GarageApp $entity) => sprintf('Editing <b>%s</b>', sprintf('%s', $entity->getSettingBrand()->getName() . " " . $entity->getModel())))
			->setPageTitle('detail', fn (GarageApp $entity) => (string) $entity)
			// Date, Time and Number Formatting
			// https://symfony.com/bundles/EasyAdminBundle/current/crud.html#date-time-and-number-formatting-options
			->setTimezone('Europe/Paris')
			// Search, Order, and Pagination
            ->setDefaultSort(['gameUpdate' => 'DESC'])
			// Templates and Form Options
			->addFormTheme('bootstrap_5_layout.html.twig')
		;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield IntegerField::new('stars');
        yield IntegerField::new('gameUpdate');
        yield IntegerField::new('carOrder');
        yield IntegerField::new('statOrder')->hideOnIndex();
        yield IntegerField::new('level');
        yield IntegerField::new('epic')->hideOnIndex();
        yield IntegerField::new('evo')->hideOnIndex();
        yield AssociationField::new('settingBrand')->renderAsHtml();
        yield TextField::new('model');
        yield AssociationField::new('blueprint')->renderAsHtml()->hideOnIndex();
        yield AssociationField::new('gauntlet')->renderAsHtml()->hideOnIndex();
        yield AssociationField::new('rank')->renderAsHtml()->hideOnIndex();
        yield AssociationField::new('statActual')->renderAsHtml()->hideOnIndex();
        yield AssociationField::new('statMax')->renderAsHtml()->hideOnIndex();
        yield AssociationField::new('statMin')->renderAsHtml()->hideOnIndex();
        yield AssociationField::new('status')->renderAsHtml()->hideOnIndex();
        yield AssociationField::new('statusControl')->renderAsHtml()->hideOnIndex();
        yield AssociationField::new('upgrade')->renderAsHtml()->hideOnIndex();
        yield AssociationField::new('settingBlueprint')->renderAsHtml()->hideOnIndex();
        yield AssociationField::new('settingClass')->renderAsHtml()->hideOnIndex();
        yield AssociationField::new('settingLevel')->renderAsHtml()->hideOnIndex();
        yield AssociationField::new('settingUnitPrice')->renderAsHtml()->hideOnIndex();
        yield DateTimeField::new('updatedAt')->setFormat('yyyy-MM-dd')->onlyOnIndex();
        yield DateTimeField::new('updatedAt')->setFormat('yyyy-MM-dd')->onlyOnIndex();
    }
}
