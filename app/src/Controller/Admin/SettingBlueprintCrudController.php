<?php

namespace App\Controller\Admin;

use App\Persistence\Entity\SettingBlueprint;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SettingBlueprintCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SettingBlueprint::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // Design
            ->renderContentMaximized()
            ->renderSidebarMinimized()
            // Entity
            ->setEntityLabelInSingular('Setting Blueprint')
            ->setEntityLabelInPlural('Setting Blueprints')
            // Title & Help
            ->setPageTitle('index', '%entity_label_plural% listing')
            ->setPageTitle('new', 'Create a new Entity %entity_label_singular%')
            ->setPageTitle('edit', fn (SettingBlueprint $entity) => sprintf('Editing <b>%s</b>', $entity->getSlug()))
            ->setPageTitle('detail', fn (SettingBlueprint $entity) => (string) $entity)
            // Date, Time and Number Formatting
//            ->setTimezone('America/Bogota')
            // Search, Order, and Pagination
            ->setDefaultSort(['id' => 'DESC'])
//            ->setPaginatorPageSize(10)

//            ->addFormTheme('bootstrap_base_layout.html.twig')
//            ->addFormTheme('bootstrap_4_layout.html.twig')
//            ->addFormTheme('bootstrap_5_layout.html.twig')
//            ->addFormTheme('form_div_layout.html.twig')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            'star1',
            'star2',
            'star3',
            'star4',
            'star5',
            'star6',
        ];
    }
}
