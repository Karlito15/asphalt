<?php

declare(strict_types=1);

namespace App\Application\Controller\Setting;

use App\Domain\Entity\SettingUnitPrice;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

#[AdminDashboard(
    routePath: '/admin/setting/unit-price.php',
    routeName: 'easy.admin.setting.unit-price'
)]
class SettingUnitPriceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SettingUnitPrice::class;
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
			->setEntityLabelInSingular('Unit-Price')
			->setEntityLabelInPlural('Unit-Prices')
			// Title & Help
			->setPageTitle('index', '%entity_label_plural% listing')
			->setPageTitle('new', 'Create a new Entity %entity_label_singular%')
			->setPageTitle('edit', fn (SettingUnitPrice $entity) => sprintf('Editing <b>%s</b>', $entity->getSlug()))
			->setPageTitle('detail', fn (SettingUnitPrice $entity) => (string) $entity)
			// Date, Time and Number Formatting
			// https://symfony.com/bundles/EasyAdminBundle/current/crud.html#date-time-and-number-formatting-options
			->setTimezone('Europe/Paris')
			// Search, Order, and Pagination
			->setDefaultSort(['id' => 'ASC'])
			// Templates and Form Options
			->addFormTheme('bootstrap_5_layout.html.twig')
		;
	}

    /**
     * @param string $pageName
     * @return iterable
     */
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield IntegerField::new('level01')->onlyOnIndex();
        yield IntegerField::new('level02')->onlyOnIndex();
        yield IntegerField::new('level03')->onlyOnIndex();
        yield IntegerField::new('level04');
        yield IntegerField::new('level05');
        yield IntegerField::new('level06');
        yield IntegerField::new('level07');
        yield IntegerField::new('level08');
        yield IntegerField::new('level09');
        yield IntegerField::new('level10');
        yield IntegerField::new('level11');
        yield IntegerField::new('level12');
        yield IntegerField::new('level13');
        yield IntegerField::new('common')->onlyOnIndex();
        yield IntegerField::new('rare')->onlyOnIndex();
        yield IntegerField::new('epic')->onlyOnIndex();
        yield DateTimeField::new('createdAt')->onlyOnIndex();
        yield DateTimeField::new('updatedAt')->onlyOnIndex();
    }
}
