<?php

declare(strict_types=1);

namespace App\Form\Front;

use App\Entity\GarageStatMax;
use App\Trait\Form\FormTrait;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GarageStatMaxType extends AbstractType
{
    use FormTrait;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('speed', NumberType::class, [
                'attr'       => self::attrClass(),
                'label'      => 'form.speed',
                'label_attr' => self::labelClass(),
                'scale'      => 2,
                'required'   => false,
            ])
            ->add('acceleration', NumberType::class, [
                'attr'       => self::attrClass(),
                'label'      => 'form.acceleration',
                'label_attr' => self::labelClass(),
                'scale'      => 2,
                'required'   => false,
            ])
            ->add('handling', NumberType::class, [
                'attr'       => self::attrClass(),
                'label'      => 'form.handling',
                'label_attr' => self::labelClass(),
                'scale'      => 2,
                'required'   => false,
            ])
            ->add('nitro', NumberType::class, [
                'attr'       => self::attrClass(),
                'label'      => 'form.nitro',
                'label_attr' => self::labelClass(),
                'scale'      => 2,
                'required'   => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'         => GarageStatMax::class,
            'allow_extra_fields' => true,
            'translation_domain' => 'forms',
        ]);
    }

    /**
     * @return array
     */
    private static function attrClass(): array
    {
        return [
            'autocomplete' => 'off',
            'class'        => 'text-center fw-bolder form-control-plaintext form-control-sm',
        ];
    }
}
