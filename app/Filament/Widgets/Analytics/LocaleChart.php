<?php

namespace App\Filament\Widgets\Analytics;

class LocaleChart extends BreakdownChart
{
    protected static ?string $heading = 'اللغة (30 يوم)';

    protected function column(): string
    {
        return 'locale';
    }

    protected function labelsMap(): array
    {
        return [
            'ar' => 'العربية',
            'en' => 'English',
        ];
    }
}
