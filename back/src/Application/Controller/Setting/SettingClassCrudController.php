<?php

declare(strict_types=1);

namespace App\Application\Controller\Setting;

use App\Domain\Entity\SettingClass;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

#[AdminDashboard(
    routePath: '/admin/setting/class.php',
    routeName: 'easy.admin.setting.class'
)]
class SettingClassCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SettingClass::class;
    }

	/**
	 * @param Crud $crud
	 * @return Crud
	 */
	public function configureCrud(Crud $crud): Crud
	{
		return $crud
			// Design
			->renderContentMaximized()
			->renderSidebarMinimized()
			// Entity
			->setEntityLabelInSingular('Class')
			->setEntityLabelInPlural('Classes')
			// Title & Help
			->setPageTitle('index', '%entity_label_plural% listing')
			->setPageTitle('new', 'Create a new Entity %entity_label_singular%')
			->setPageTitle('edit', fn (SettingClass $entity) => sprintf('Editing <b>%s</b>', $entity->getSlug()))
			->setPageTitle('detail', fn (SettingClass $entity) => (string) $entity)
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
        yield TextField::new('label');
        yield TextField::new('value');
        yield IntegerField::new('classOrder');
        yield IntegerField::new('carsNumber')->onlyOnIndex();
        yield IntegerField::new('median');
        yield DateTimeField::new('createdAt')->onlyOnIndex();
        yield DateTimeField::new('updatedAt')->onlyOnIndex();
    }
}
