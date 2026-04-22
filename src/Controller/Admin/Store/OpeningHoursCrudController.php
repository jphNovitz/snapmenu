<?php

namespace App\Controller\Admin\Store;

use App\Enum\DayOfWeek;
use App\Entity\OpeningHours;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use Symfony\Contracts\Translation\TranslatorInterface;

class OpeningHoursCrudController extends AbstractCrudController
{
    public function __construct(private readonly TranslatorInterface $translator)
    {
    }

    public static function getEntityFqcn(): string
    {
        return OpeningHours::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            ChoiceField::new('dayOfWeek')
                ->setLabel('fields.day')
                ->setChoices([
                    'form.opening_hours.day_of_week.1' => DayOfWeek::MONDAY,
                    'form.opening_hours.day_of_week.2' => DayOfWeek::TUESDAY,
                    'form.opening_hours.day_of_week.3' => DayOfWeek::WEDNESDAY,
                    'form.opening_hours.day_of_week.4' => DayOfWeek::THURSDAY,
                    'form.opening_hours.day_of_week.5' => DayOfWeek::FRIDAY,
                    'form.opening_hours.day_of_week.6' => DayOfWeek::SATURDAY,
                    'form.opening_hours.day_of_week.7' => DayOfWeek::SUNDAY,
                ])
                ->formatValue(fn ($value) => $value ? $this->translator->trans($value->translationKey()) : '')
                ->renderExpanded(false)
                ->setColumns(12),
            TimeField::new('openTime')->setLabel('fields.start_time')->setColumns(6),
            TimeField::new('closeTime')->setLabel('fields.close_time')->setColumns(6),
        ];
    }

}
