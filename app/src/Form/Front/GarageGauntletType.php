<?php

declare(strict_types=1);

namespace App\Form\Front;

use App\Entity\GarageGauntlet;
use App\Trait\Form\FormTrait;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GarageGauntletType extends AbstractType
{
    use FormTrait;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('division', IntegerType::class, [
                'attr'       => self::attrClass(),
                'label'      => $this->star(6),
                'label_attr' => self::labelClass(),
                'label_html' => true,
                'required'   => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'         => GarageGauntlet::class,
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
            'class'        => 'text-center fw-bolder form-control form-control-sm',
            'max'          => 9,
            'min'          => 0,
        ];
    }
}
