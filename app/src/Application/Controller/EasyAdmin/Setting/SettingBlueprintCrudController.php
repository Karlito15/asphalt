<?php

declare(strict_types=1);

namespace App\Application\Controller\EasyAdmin\Setting;

use App\Domain\Entity\SettingBlueprint;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

#[AdminDashboard(
    routePath: '/admin/setting/blueprint.php',
    routeName: 'easy.admin.setting.blueprint'
)]
class SettingBlueprintCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SettingBlueprint::class;
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
            ->setEntityLabelInSingular('Blueprint')
            ->setEntityLabelInPlural('Blueprints')
            // Title & Help
            ->setPageTitle('index', '%entity_label_plural% listing')
            ->setPageTitle('new', 'Create a new Entity %entity_label_singular%')
            ->setPageTitle('edit', fn (SettingBlueprint $entity) => sprintf('Editing <b>%s</b>', $entity->getSlug()))
            ->setPageTitle('detail', fn (SettingBlueprint $entity) => (string) $entity)
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
        yield TextField::new('star1')->setCssClass('text-info');
        yield IntegerField::new('star2');
        yield IntegerField::new('star3');
        yield IntegerField::new('star4');
        yield IntegerField::new('star5');
        yield IntegerField::new('star6');
        yield IntegerField::new('total')->onlyOnDetail();
        yield DateTimeField::new('createdAt')->onlyOnIndex();
        yield DateTimeField::new('updatedAt')->onlyOnIndex();
    }
}
