<?php

declare(strict_types=1);

namespace App\Persistence\Form\Back;

use App\Persistence\Entity\SettingTag;
use App\Toolbox\Trait\Form\DefaultType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SettingTagType extends AbstractType
{
    use DefaultType;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('value', TextType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                ],
                'label' => 'form.value',
                'required' => true,
                'trim' => true,
            ])
            ->add('carsNumber', IntegerType::class, [
				 'attr' => [
					'autocomplete' => 'off',
					'class' => null,
					'min' => 0,
				 ],
				'label' => 'form.carsNumber',
				'required' => true,
				'trim' => true,
			])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SettingTag::class,
            'allow_extra_fields' => false,
            'translation_domain' => 'forms',
        ]);
    }
}
