<?php

namespace App\Enum;

enum DayOfWeek: string
{
    case MONDAY = '1';
    case TUESDAY = '2';
    case WEDNESDAY = '3';
    case THURSDAY = '4';
    case FRIDAY = '5';
    case SATURDAY = '6';
    case SUNDAY = '7';

    public function translationKey(): string
    {
        return 'form.opening_hours.day_of_week.' . $this->value;
    }
}
