<?php

declare(strict_types=1);

namespace App\Domain\Form\Front\Inventory;

use App\Domain\Entity\InventoryApp;
use App\Domain\Service\Type\DefaultType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppType extends AbstractType
{
    use DefaultType;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', HiddenType::class)
            ->add('position', HiddenType::class)
            ->add('label', HiddenType::class)
            ->add('filter', HiddenType::class)
            ->add('value', NumberType::class, [
                'attr'      => [
                    'autocomplete'   => 'off',
                    'autocapitalize' => 'none',
                    'class'          => 'text-end fw-bolder p-xxl-0 form-control form-control-plaintext',
                    'maxlength'      => 10,
                    'minlength'      => 0,
                ],
                'label'     => false,
                'required'  => true,
                'row_attr'  => self::labelClass(),
                'trim'      => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InventoryApp::class,
            'allow_extra_fields' => false,
            'translation_domain' => false, //'messages'
        ]);
    }
}
