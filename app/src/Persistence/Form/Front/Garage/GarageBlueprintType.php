<?php

declare(strict_types=1);

namespace App\Persistence\Form\Front\Garage;

use App\Persistence\Entity\GarageBlueprint;
use App\Toolbox\Trait\Form\DefaultType;
use App\Toolbox\Trait\Form\StarType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GarageBlueprintType extends AbstractType
{
    use DefaultType, StarType;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('star1', TextType::class, [
                'attr'       => self::attrClass(),
                'label'      => self::star(),
                'label_attr' => self::labelClass(),
                'label_html' => true,
                'required'   => false,
            ])
            ->add('star2', IntegerType::class, [
                'attr'       => self::attrClass(),
                'label'      => self::star(2),
                'label_attr' => self::labelClass(),
                'label_html' => true,
                'required'   => false,
            ])
            ->add('star3', IntegerType::class, [
                'attr'       => self::attrClass(),
                'label'      => self::star(3),
                'label_attr' => self::labelClass(),
                'label_html' => true,
                'required'   => false,
            ])
            ->add('star4', IntegerType::class, [
                'attr'       => self::attrClass(),
                'label'      => self::star(4),
                'label_attr' => self::labelClass(),
                'label_html' => true,
                'required'   => false,
            ])
            ->add('star5', IntegerType::class, [
                'attr'       => self::attrClass(),
                'label'      => self::star(5),
                'label_attr' => self::labelClass(),
                'label_html' => true,
                'required'   => false,
            ])
            ->add('star6', IntegerType::class, [
                'attr'       => self::attrClass(),
                'label'      => self::star(6),
                'label_attr' => self::labelClass(),
                'label_html' => true,
                'required'   => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GarageBlueprint::class,
            'allow_extra_fields' => true,
            'translation_domain' => false,
        ]);
    }

    /**
     * @return array
     */
    private static function attrClass(): array
    {
        return [
            'autocomplete' => 'off',
            'class'        => 'fw-bolder text-center form-control',
            'max'          => 99,
            'min'          => 0,
        ];
    }
}
