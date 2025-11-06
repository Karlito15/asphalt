<?php

declare(strict_types=1);

namespace App\Form\Front\Search;

use App\DTO\Search\GarageDTO;
use App\Entity\GarageApp;
use App\Entity\SettingBrand;
use App\Entity\SettingClass;
use App\Trait\Form\FormTrait;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GarageType extends AbstractType
{
    use FormTrait;

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
                'placeholder'   => 'form.placeholder.update',
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
                'placeholder'   => 'form.placeholder.brand',
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
                'placeholder'   => 'form.placeholder.class',
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
                    'form.no' => false,
                    'form.yes' => true,
                ],
                'empty_data'    => null,
                'label'         => false, //'form.placeholder.unblock',
                'placeholder'   => 'form.placeholder.unblock',
                'required'      => false,
                'trim'          => true,
            ])
            ->add('gold', ChoiceType ::class, [
                'attr'          => [
                    'class' => self::attrClass(),
                ],
                'choices'       => [
                    'form.no' => false,
                    'form.yes' => true,
                ],
                'empty_data'    => null,
                'label'         => false, //'form.placeholder.gold',
                'placeholder'   => 'form.placeholder.gold',
                'required'      => false,
                'trim'          => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'allow_extra_fields' => false,
            'data_class'         => GarageDTO::class,
            'method'             => 'GET',
            'translation_domain' => 'forms',
            // enable/disable CSRF protection for this form
            'csrf_protection'    => false,
        ]);
    }

    private static function attrClass(): string
    {
        return 'fw-bolder';
    }
}
