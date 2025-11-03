<?php

declare(strict_types=1);

namespace App\Form\Front;

use App\Entity\GarageStatus;
use App\Trait\Form\FormTrait;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GarageStatusType extends AbstractType
{
    use FormTrait;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('unblock', CheckboxType::class, self::getOptions())
            ->add('gold', CheckboxType::class, self::getOptions())
            ->add('toGold', CheckboxType::class, self::getOptions())
            ->add('fullUpgradeLevel', CheckboxType::class, self::getOptions())
            ->add('toUpgradeLevel', CheckboxType::class, self::getOptions())
            ->add('fullBlueprintStar1', CheckboxType::class, self::getOptions())
            ->add('fullBlueprintStar2', CheckboxType::class, self::getOptions())
            ->add('fullBlueprintStar3', CheckboxType::class, self::getOptions())
            ->add('fullBlueprintStar4', CheckboxType::class, self::getOptions())
            ->add('fullBlueprintStar5', CheckboxType::class, self::getOptions())
            ->add('fullBlueprintStar6', CheckboxType::class, self::getOptions())
            ->add('fullUpgradeSpeed', CheckboxType::class, self::getOptions())
            ->add('toInstallUpgradeSpeed', CheckboxType::class, self::getOptions())
            ->add('fullUpgradeAcceleration', CheckboxType::class, self::getOptions())
            ->add('toInstallUpgradeAcceleration', CheckboxType::class, self::getOptions())
            ->add('fullUpgradeHandling', CheckboxType::class, self::getOptions())
            ->add('toInstallUpgradeHandling', CheckboxType::class, self::getOptions())
            ->add('fullUpgradeNitro', CheckboxType::class, self::getOptions())
            ->add('toInstallUpgradeNitro', CheckboxType::class, self::getOptions())
            ->add('fullUpgradeCommon', CheckboxType::class, self::getOptions())
            ->add('toInstallUpgradeCommon', CheckboxType::class, self::getOptions())
            ->add('fullUpgradeRare', CheckboxType::class, self::getOptions())
            ->add('toInstallUpgradeRare', CheckboxType::class, self::getOptions())
            ->add('fullUpgradeEpic', CheckboxType::class, self::getOptions())
            ->add('toInstallUpgradeEpic', CheckboxType::class, self::getOptions())
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'         => GarageStatus::class,
            'allow_extra_fields' => true,
            'translation_domain' => 'forms',
        ]);
    }

    /**
     * @return array
     */
    private static function getOptions(): array
    {
        return [
            'attr'          => [
                'class' => 'btn-check'
            ],
            'label'         => 'form.unblock',
            'required'      => true,
        ];
    }
}
