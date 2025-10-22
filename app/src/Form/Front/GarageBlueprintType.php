<?php

declare(strict_types=1);

namespace App\Form\Front;

use App\Entity\GarageBlueprint;
use App\Trait\Form\FormTrait;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GarageBlueprintType extends AbstractType
{
    use FormTrait;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('star1', TextType::class, [
                'attr'       => self::attrClass(),
                'label'      => $this->star(),
                'label_attr' => self::labelClass(),
                'label_html' => true,
                'required'   => false,
            ])
            ->add('star2', IntegerType::class, [
                'attr'       => self::attrClass(),
                'label'      => $this->star(2),
                'label_attr' => self::labelClass(),
                'label_html' => true,
                'required'   => false,
            ])
            ->add('star3', IntegerType::class, [
                'attr'       => self::attrClass(),
                'label'      => $this->star(3),
                'label_attr' => self::labelClass(),
                'label_html' => true,
                'required'   => false,
            ])
            ->add('star4', IntegerType::class, [
                'attr'       => self::attrClass(),
                'label'      => $this->star(4),
                'label_attr' => self::labelClass(),
                'label_html' => true,
                'required'   => false,
            ])
            ->add('star5', IntegerType::class, [
                'attr'       => self::attrClass(),
                'label'      => $this->star(5),
                'label_attr' => self::labelClass(),
                'label_html' => true,
                'required'   => false,
            ])
            ->add('star6', IntegerType::class, [
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
            'data_class' => GarageBlueprint::class,
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
            'class'        => 'text-center fw-bolder m-0 p-0 form-control form-control-sm',
            'max'          => 99,
            'min'          => 0,
        ];
    }
}
