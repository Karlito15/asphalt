<?php

declare(strict_types=1);

namespace App\Persistence\Form\Front\Garage;

use App\Persistence\Entity\GarageGauntlet;
use App\Toolbox\Trait\Form\DefaultType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GarageGauntletType extends AbstractType
{
    use DefaultType;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
//            ->add('speed')
//            ->add('acceleration')
//            ->add('handling')
//            ->add('nitro')
//            ->add('mark')
            ->add('division', IntegerType::class, [
                'attr'       => self::attrClass(),
                'label'      => 'text.division',
                'label_attr' => self::labelClass(),
                'label_html' => true,
                'required'   => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GarageGauntlet::class,
            'allow_extra_fields' => false,
            'translation_domain' => 'messages',
        ]);
    }

    /**
     * @return array
     */
    private static function attrClass(): array
    {
        return [
            'autocomplete' => 'off',
            'class'        => 'text-start fw-bolder m-0 px-3 py-0 form-control-sm',
            'max'          => 9,
            'min'          => 0,
        ];
    }
}
