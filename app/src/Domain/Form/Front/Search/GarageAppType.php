<?php

declare(strict_types=1);

namespace App\Domain\Form\Front\Search;

use App\Application\DTO\Search\GarageDTO;
use App\Domain\Entity\GarageApp;
use App\Domain\Entity\SettingBrand;
use App\Domain\Entity\SettingClass;
use App\Domain\Service\Type\DefaultType;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GarageAppType extends AbstractType
{
    use DefaultType;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('gameUpdate', EntityType::class, [
                'attr'          => [
                    'class' => self::attrClass(),
                ],
                'class'         => GarageApp::class,
                'choice_label'  => 'gameUpdate',
                'empty_data'    => null,
                'label'         => false,
                'placeholder'   => 'text.placeholder.update',
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('g')->groupBy('g.gameUpdate')->orderBy('g.gameUpdate', 'DESC');
                },
                'required'      => false,
                'trim'          => true,
            ])
            ->add('brand', EntityType::class, [
                'attr'          => [
                    'class' => self::attrClass(),
                ],
                'class'         => SettingBrand::class,
                'choice_label'  => 'name',
                'empty_data'    => null,
                'label'         => false,
                'placeholder'   => 'text.placeholder.brand',
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('b')->orderBy('b.name', 'ASC');
                },
                'required'      => false,
                'trim'          => true,
            ])
            ->add('classLetter', EntityType::class, [
                'attr'          => [
                    'class' => self::attrClass(),
                ],
                'class'         => SettingClass::class,
                'choice_label'  => 'value',
                'empty_data'    => null,
                'label'         => false,
                'placeholder'   => 'text.placeholder.class',
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('b')->orderBy('b.value', 'ASC');
                },
                'required'      => false,
                'trim'          => true,
            ])
            ->add('unblock', ChoiceType ::class, [
                'attr'          => [
                    'class' => self::attrClass(),
                ],
                'choices'       => [
                    'text.no' => false,
                    'text.yes' => true,
                ],
                'empty_data'    => null,
                'label'         => false, //'text.placeholder.unblock',
                'placeholder'   => 'text.placeholder.unblock',
                'required'      => false,
                'trim'          => true,
            ])
            ->add('gold', ChoiceType ::class, [
                'attr'          => [
                    'class' => self::attrClass(),
                ],
                'choices'       => [
                    'text.no' => false,
                    'text.yes' => true,
                ],
                'empty_data'    => null,
                'label'         => false, //'text.placeholder.gold',
                'placeholder'   => 'text.placeholder.gold',
                'required'      => false,
                'trim'          => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'allow_extra_fields' => false,
            'csrf_protection'    => false,
            'data_class'         => GarageDTO::class,
            'method'             => 'GET',
            'translation_domain' => 'messages',
        ]);
    }
}
