<?php

namespace App\Filament\Widgets\Analytics;

use App\Models\PageView;
use Filament\Widgets\Widget;

class TopUtmWidget extends Widget
{
    protected static bool $isDiscovered = false;

    protected static string $view = 'filament.widgets.analytics-list';

    protected int | string | array $columnSpan = 1;

    protected function getViewData(): array
    {
        $items = PageView::query()
            ->humans()
            ->where('created_at', '>=', now()->subDays(30))
            ->whereNotNull('utm_source')
            ->where('utm_source', '!=', '')
            ->selectRaw('utm_source, utm_medium, utm_campaign, COUNT(*) as total')
            ->groupBy('utm_source', 'utm_medium', 'utm_campaign')
            ->orderByDesc('total')
            ->limit(10)
            ->get()
            ->map(fn ($row) => [
                'label' => trim(implode(' / ', array_filter([
                    $row->utm_source,
                    $row->utm_medium ?: null,
                    $row->utm_campaign ?: null,
                ])), ' /'),
                'total' => (int) $row->total,
            ]);

        return [
            'heading' => 'حملات UTM (30 يوم)',
            'empty' => 'لا توجد حملات UTM بعد.',
            'items' => $items,
        ];
    }
}
