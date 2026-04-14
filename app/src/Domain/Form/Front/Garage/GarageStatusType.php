<?php

declare(strict_types=1);

namespace App\Domain\Form\Front\Garage;

use App\Domain\Entity\GarageStatus;
use App\Domain\Service\Type\DefaultType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GarageStatusType extends AbstractType
{
    use DefaultType;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('unblock', CheckboxType::class, [
            'attr'          => self::attrClass(),
            'label'         => 'text.unblock',
            'label_attr'    => self::attrLabel(),
            'required'      => false,
            ])
            ->add('gold', CheckboxType::class, [
            'attr'          => self::attrClass(),
            'label'         => 'text.gold',
            'label_attr'    => self::attrLabel(),
            'required'      => false,
            ])
            ->add('evo', CheckboxType::class, [
            'attr'          => self::attrClass(),
            'label'         => 'text.evo',
            'label_attr'    => self::attrLabel(),
            'required'      => false,
            ])
            ->add('eventClass', CheckboxType::class, [
            'attr'          => self::attrClass(),
            'label'         => 'text.event.class',
            'label_attr'    => self::attrLabel(),
            'required'      => false,
            ])
            ->add('toUpgrade', CheckboxType::class, [
            'attr'          => self::attrClass(),
            'label'         => 'text.to.upgrade',
            'label_attr'    => self::attrLabel(),
            'required'      => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GarageStatus::class,
            'allow_extra_fields' => false,
            'translation_domain' => 'messages',
        ]);
    }

    /** PRIVATE METHODS */

    /**
     * @return array
     */
    private static function attrClass(): array
    {
        return [
//            'class' => 'form-check-input'
            'class' => 'btn-check'
        ];
    }

    /**
     * @return array
     */
    private static function attrLabel(): array
    {
        return [
            'class' => 'btn btn-outline-info',
        ];
    }
}
