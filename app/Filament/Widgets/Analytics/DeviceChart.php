<?php

namespace App\Filament\Widgets\Analytics;

class DeviceChart extends BreakdownChart
{
    protected static ?string $heading = 'الأجهزة (30 يوم)';

    protected function column(): string
    {
        return 'device';
    }

    protected function labelsMap(): array
    {
        return [
            'desktop' => 'كمبيوتر',
            'mobile' => 'جوال',
            'tablet' => 'تابلت',
            'bot' => 'روبوت',
        ];
    }
}
