<?php

namespace App\Form;

use App\Entity\Night;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NightType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var Night $night */
        $night = $options['data'];

        $builder
            ->add('start', DateTimeType::class, [
                'label' => 'start',
                'attr' => [
                    'data-controller' => 'flatpickr',
                    'data-flatpickr-enable-time-value' => true,
                    'data-flatpickr-default-date-value' => $night->getStart()?->format('Y-m-d H:i'),
                ],
            ])
            ->add('end', DateTimeType::class, [
                'label' => 'end',
                'attr' => [
                    'data-controller' => 'flatpickr',
                    'data-flatpickr-enable-time-value' => true,
                    'data-flatpickr-default-date-value' => $night->getEnd()?->format('Y-m-d H:i'),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Night::class,
        ]);
    }
}
