<?php

namespace App\Filament\Widgets\Analytics;

use App\Models\PageView;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class VisitsChart extends ChartWidget
{
    protected static bool $isDiscovered = false;

    protected static ?string $heading = 'الزيارات عبر الزمن';

    protected static ?string $description = 'عدد زيارات الصفحات (بدون الروبوتات)';

    protected static ?string $maxHeight = '300px';

    protected int | string | array $columnSpan = 'full';

    public ?string $filter = '30';

    protected function getFilters(): ?array
    {
        return [
            '7' => 'آخر 7 أيام',
            '30' => 'آخر 30 يوم',
            '90' => 'آخر 90 يوم',
        ];
    }

    protected function getData(): array
    {
        $days = (int) ($this->filter ?: 30);
        $start = now()->subDays($days - 1)->startOfDay();

        $rows = PageView::query()
            ->humans()
            ->where('created_at', '>=', $start)
            ->selectRaw('DATE(created_at) as day, COUNT(*) as views, COUNT(DISTINCT COALESCE(session_id, ip)) as visitors')
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->keyBy('day');

        $labels = [];
        $views = [];
        $visitors = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $day = now()->subDays($i)->toDateString();
            $labels[] = Carbon::parse($day)->format('m/d');
            $views[] = (int) ($rows[$day]->views ?? 0);
            $visitors[] = (int) ($rows[$day]->visitors ?? 0);
        }

        return [
            'datasets' => [
                [
                    'label' => 'الزيارات',
                    'data' => $views,
                    'borderColor' => '#3154ad',
                    'backgroundColor' => 'rgba(49, 84, 173, 0.15)',
                    'fill' => true,
                    'tension' => 0.3,
                ],
                [
                    'label' => 'الزوار الفريدون',
                    'data' => $visitors,
                    'borderColor' => '#0d9488',
                    'backgroundColor' => 'rgba(13, 148, 136, 0.1)',
                    'fill' => true,
                    'tension' => 0.3,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
