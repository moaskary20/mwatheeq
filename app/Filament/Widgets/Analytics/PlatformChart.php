<?php

namespace App\Filament\Widgets\Analytics;

class PlatformChart extends BreakdownChart
{
    protected static ?string $heading = 'أنظمة التشغيل (30 يوم)';

    protected function column(): string
    {
        return 'platform';
    }

    protected function labelsMap(): array
    {
        return [];
    }
}
