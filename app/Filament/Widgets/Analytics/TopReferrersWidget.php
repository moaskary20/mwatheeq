<?php

namespace App\Filament\Widgets\Analytics;

use App\Models\PageView;
use Filament\Widgets\Widget;

class TopReferrersWidget extends Widget
{
    protected static bool $isDiscovered = false;

    protected static string $view = 'filament.widgets.analytics-list';

    protected int | string | array $columnSpan = 1;

    protected function getViewData(): array
    {
        $items = PageView::query()
            ->humans()
            ->where('created_at', '>=', now()->subDays(30))
            ->whereNotNull('referer_host')
            ->selectRaw('referer_host as label, COUNT(*) as total')
            ->groupBy('referer_host')
            ->orderByDesc('total')
            ->limit(10)
            ->get()
            ->map(fn ($row) => [
                'label' => $row->label,
                'total' => (int) $row->total,
            ]);

        return [
            'heading' => 'مصادر الإحالة (30 يوم)',
            'empty' => 'لا توجد إحالات خارجية بعد.',
            'items' => $items,
        ];
    }
}
