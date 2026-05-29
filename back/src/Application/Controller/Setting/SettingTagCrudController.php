<?php

declare(strict_types=1);

namespace App\Application\Controller\Setting;

use App\Domain\Entity\SettingTag;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

#[AdminDashboard(
    routePath: '/admin/setting/tag.php',
    routeName: 'easy.admin.setting.tag'
)]
class SettingTagCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SettingTag::class;
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
			->setEntityLabelInSingular('Tag')
			->setEntityLabelInPlural('Tags')
			// Title & Help
			->setPageTitle('index', '%entity_label_plural% listing')
			->setPageTitle('new', 'Create a new Entity %entity_label_singular%')
			->setPageTitle('edit', fn (SettingTag $entity) => sprintf('Editing <b>%s</b>', $entity->getSlug()))
			->setPageTitle('detail', fn (SettingTag $entity) => (string) $entity)
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
        yield TextField::new('value');
        yield IntegerField::new('carsNumber');
        yield DateTimeField::new('updatedAt')->setFormat('yyyy-MM-dd')->onlyOnIndex();
        yield DateTimeField::new('updatedAt')->setFormat('yyyy-MM-dd')->onlyOnIndex();
    }
}
