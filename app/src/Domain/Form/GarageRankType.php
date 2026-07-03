<?php

declare(strict_types=1);

namespace App\Domain\Form;

use App\Domain\Entity\GarageRank;
use App\Infrastructure\Abstract\Form\AbstractForm;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GarageRankType extends AbstractForm
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('star0', NumberType::class, [
                'attr'       => self::attrClassPrivate(),
                'label'      => self::star(),
                'label_attr' => self::labelClass(),
                'label_html' => true,
                'required'   => false,
            ])
            ->add('star1', NumberType::class, [
                'attr'       => self::attrClassPrivate(),
                'label'      => self::star(1),
                'label_attr' => self::labelClass(),
                'label_html' => true,
                'required'   => false,
            ])
            ->add('star2', NumberType::class, [
                'attr'       => self::attrClassPrivate(3000),
                'label'      => self::star(2),
                'label_attr' => self::labelClass(),
                'label_html' => true,
                'required'   => false,
            ])
            ->add('star3', NumberType::class, [
                'attr'       => self::attrClassPrivate(4000),
                'label'      => self::star(3),
                'label_attr' => self::labelClass(),
                'label_html' => true,
                'required'   => false,
            ])
            ->add('star4', NumberType::class, [
                'attr'       => self::attrClassPrivate(5000),
                'label'      => self::star(4),
                'label_attr' => self::labelClass(),
                'label_html' => true,
                'required'   => false,
            ])
            ->add('star5', NumberType::class, [
                'attr'       => self::attrClassPrivate(6000),
                'label'      => self::star(5),
                'label_attr' => self::labelClass(),
                'label_html' => true,
                'required'   => false,
            ])
            ->add('star6', NumberType::class, [
                'attr'       => self::attrClassPrivate(),
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
            'translation_domain' => 'forms',
        ]);
    }

    /** PRIVATE METHODS */

    /**
     * @param int $max
     * @return array
     */
    private static function attrClassPrivate(int $max = 7000): array
    {
        return [
            'autocomplete' => 'off',
            'class'        => 'form-control-plaintext text-end pe-5',
            'max'          => $max,
            'min'          => 0,
        ];
    }
}
