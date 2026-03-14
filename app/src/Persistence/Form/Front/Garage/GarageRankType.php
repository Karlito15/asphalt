<?php

declare(strict_types=1);

namespace App\Persistence\Form\Front\Garage;

use App\Persistence\Entity\GarageRank;
use App\Toolbox\Trait\Form\DefaultType;
use App\Toolbox\Trait\Form\StarType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GarageRankType extends AbstractType
{
    use DefaultType, StarType;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('star0', NumberType::class, [
                'attr'       => self::attrClass(),
                'label'      => 'form.start',
                'label_attr' => self::labelClass(),
                'label_html' => false,
                'required'   => false,
            ])
            ->add('star1', NumberType::class, [
                'attr'       => self::attrClass(),
                'label'      => self::star(),
                'label_attr' => self::labelClass(),
                'label_html' => true,
                'required'   => false,
            ])
            ->add('star2', NumberType::class, [
                'attr'       => self::attrClass(),
                'label'      => self::star(2),
                'label_attr' => self::labelClass(),
                'label_html' => true,
                'required'   => false,
            ])
            ->add('star3', NumberType::class, [
                'attr'       => self::attrClass(),
                'label'      => self::star(3),
                'label_attr' => self::labelClass(),
                'label_html' => true,
                'required'   => false,
            ])
            ->add('star4', NumberType::class, [
                'attr'       => self::attrClass(),
                'label'      => self::star(4),
                'label_attr' => self::labelClass(),
                'label_html' => true,
                'required'   => false,
            ])
            ->add('star5', NumberType::class, [
                'attr'       => self::attrClass(),
                'label'      => self::star(5),
                'label_attr' => self::labelClass(),
                'label_html' => true,
                'required'   => false,
            ])
            ->add('star6', NumberType::class, [
                'attr'       => self::attrClass(7000),
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
            'data_class' => GarageRank::class,
            'allow_extra_fields' => false,
//            'translation_domain' => 'forms',
            'translation_domain' => false,
        ]);
    }

    /**
     * @param int $max
     * @return array
     */
    private static function attrClass(int $max = 6000): array
    {
        return [
            'autocomplete' => 'off',
            'class'        => 'text-start fw-bolder m-0 px-3 py-0 form-control-sm',
            'max'          => $max,
            'min'          => 0,
        ];
    }
}
