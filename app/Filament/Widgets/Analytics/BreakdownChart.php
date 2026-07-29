<?php

namespace App\Filament\Widgets\Analytics;

use App\Models\PageView;
use Filament\Widgets\ChartWidget;

abstract class BreakdownChart extends ChartWidget
{
    protected static bool $isDiscovered = false;

    protected static ?string $maxHeight = '260px';

    protected int | string | array $columnSpan = 1;

    abstract protected function column(): string;

    abstract protected function labelsMap(): array;

    protected function getData(): array
    {
        $column = $this->column();
        $map = $this->labelsMap();

        $rows = PageView::query()
            ->humans()
            ->where('created_at', '>=', now()->subDays(30))
            ->whereNotNull($column)
            ->selectRaw("{$column} as label, COUNT(*) as total")
            ->groupBy($column)
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        $labels = $rows->map(function ($row) use ($map) {
            $key = (string) $row->label;

            return $map[$key] ?? $key;
        })->all();

        $colors = [
            '#3154ad',
            '#0d9488',
            '#d97706',
            '#dc2626',
            '#7c3aed',
            '#0891b2',
            '#65a30d',
            '#64748b',
        ];

        return [
            'datasets' => [
                [
                    'label' => 'الزيارات',
                    'data' => $rows->pluck('total')->map(fn ($v) => (int) $v)->all(),
                    'backgroundColor' => array_slice($colors, 0, $rows->count()),
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
