<?php

namespace App\Form;

use App\Enum\DayOfWeek;
use App\Entity\OpeningHours;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OpeningHoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dayOfWeek', ChoiceType::class, [
                'choices' => DayOfWeek::cases(),
                'choice_value' => static fn (?DayOfWeek $dayOfWeek): ?string => $dayOfWeek?->value,
                'choice_label' => static fn (DayOfWeek $dayOfWeek): string => $dayOfWeek->translationKey(),
                'translation_domain' => 'messages',
                'label' => 'title.day_of_week'
            ])
            ->add('openTime', TimeType::class, [
                'widget' => 'single_text',
                'translation_domain' => 'messages',
                'label' => 'form.opening_hours.open_time'
            ])
            ->add('closeTime', TimeType::class, [
                'widget' => 'single_text',
                'translation_domain' => 'messages',
                'label' => 'form.opening_hours.close_time'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OpeningHours::class,
        ]);
    }
}
