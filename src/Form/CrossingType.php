<?php

namespace App\Form;

use App\Entity\Crossing;
use App\Entity\Enum\FreedomLevel;
use App\Entity\Enum\Location;
use App\Entity\Enum\ReactionLevel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CrossingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('distance', IntegerType::class, [
                'label' => 'distance_m',
            ])
            ->add('location', EnumType::class, [
                'label' => 'location',
                'class' => Location::class,
                'choices' => Location::cases(),
            ])
            ->add('freedomLevel', EnumType::class, [
                'label' => 'freedom',
                'class' => FreedomLevel::class,
                'choices' => FreedomLevel::cases(),
            ])
            ->add('reaction', EnumType::class, [
                'required' => false,
                'placeholder' => 'Pas de réaction',
                'label' => 'reaction',
                'class' => ReactionLevel::class,
                'choices' => ReactionLevel::cases(),
            ])
            ->add('date', DateTimeType::class, [
                'attr' => [
                    'data-controller' => 'flatpickr',
                    'data-flatpickr-enable-time-value' => false,
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Crossing::class,
        ]);
    }
}
