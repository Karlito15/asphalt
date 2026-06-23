<?php

declare(strict_types=1);

namespace App\Application\Controller\EasyAdmin\Setting;

use App\Domain\Entity\SettingLevel;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

final class LevelCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SettingLevel::class;
    }

	/**
	 * @param Crud $crud
	 * @return Crud
	 */
	public function configureCrud(Crud $crud): Crud
	{
		return $crud
			### Design
			// ->renderContentMaximized()
			// ->renderSidebarMinimized()
			// Entity
			->setEntityLabelInSingular('Level')
			->setEntityLabelInPlural('Levels')
			// Title & Help
			->setPageTitle('index', '%entity_label_plural% listing')
			->setPageTitle('new', 'Create a new Entity %entity_label_singular%')
			->setPageTitle('edit', fn (SettingLevel $entity) => sprintf('Editing <b>%s</b>', $entity->getSlug()))
			->setPageTitle('detail', fn (SettingLevel $entity) => (string) $entity)
			// Date, Time and Number Formatting
			// https://symfony.com/bundles/EasyAdminBundle/current/crud.html#date-time-and-number-formatting-options
			->setTimezone('Europe/Paris')
			// Search, Order, and Pagination
			->setDefaultSort(['id' => 'ASC'])
			// Templates and Form Options
			->addFormTheme('bootstrap_5_layout.html.twig')
		;
	}

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield IntegerField::new('level');
        yield IntegerField::new('common');
        yield IntegerField::new('rare');
        yield IntegerField::new('epic');
        yield DateTimeField::new('updatedAt')->setFormat('yyyy-MM-dd')->onlyOnIndex();
        yield DateTimeField::new('updatedAt')->setFormat('yyyy-MM-dd')->onlyOnIndex();
    }
}
