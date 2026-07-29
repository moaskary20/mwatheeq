<?php

namespace App\Filament\Widgets\Analytics;

class BrowserChart extends BreakdownChart
{
    protected static ?string $heading = 'المتصفحات (30 يوم)';

    protected function column(): string
    {
        return 'browser';
    }

    protected function labelsMap(): array
    {
        return [];
    }
}
