<?php

namespace App\Filament\Widgets\Analytics;

use App\Models\PageView;
use Filament\Widgets\Widget;

class TopPagesWidget extends Widget
{
    protected static bool $isDiscovered = false;

    protected static string $view = 'filament.widgets.analytics-list';

    protected int | string | array $columnSpan = 1;

    protected function getViewData(): array
    {
        $items = PageView::query()
            ->humans()
            ->where('created_at', '>=', now()->subDays(30))
            ->selectRaw('path as label, COUNT(*) as total')
            ->groupBy('path')
            ->orderByDesc('total')
            ->limit(10)
            ->get()
            ->map(fn ($row) => [
                'label' => $row->label === '/' ? 'الصفحة الرئيسية' : $row->label,
                'total' => (int) $row->total,
            ]);

        return [
            'heading' => 'أكثر الصفحات زيارة (30 يوم)',
            'empty' => 'لا توجد بيانات بعد.',
            'items' => $items,
        ];
    }
}
