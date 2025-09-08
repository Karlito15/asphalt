<?php

namespace App\Form\Dashboard;

use App\Able\FormAble;
use App\Entity\AppInventory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InventoryType extends AbstractType
{
    use FormAble;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', HiddenType::class, [
                'data'      => $options['data']->getId(),
                'required'  => true,
            ])
            ->add('value', NumberType::class, [
                'attr'      => [
                    'class'      => 'form-control form-control-plaintext fw-bolder text-end pe-0',
                ],
                'data'      => $options['data']->getValue(),
                'label'     => null,
                'trim'      => true,
                'required'  => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AppInventory::class,
        ]);
    }
}
