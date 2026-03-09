<?php

namespace App\Controller\Admin\Setting;

use App\Persistence\Entity\SettingBlueprint;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

#[AdminDashboard(routePath: '/admin/setting/blueprint', routeName: 'easy.admin.setting.blueprint')]
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
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('star1')->setCssClass('text-info'),
            IntegerField::new('star2'),
            IntegerField::new('star3'),
            IntegerField::new('star4'),
            IntegerField::new('star5'),
            IntegerField::new('star6'),
            IntegerField::new('total')->onlyOnDetail(),
            DateTimeField::new('createdAt')->onlyOnIndex(),
            DateTimeField::new('updatedAt')->onlyOnIndex(),
        ];
    }
}
