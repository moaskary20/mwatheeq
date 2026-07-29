<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\Analytics\BrowserChart;
use App\Filament\Widgets\Analytics\DeviceChart;
use App\Filament\Widgets\Analytics\EngagementStatsOverview;
use App\Filament\Widgets\Analytics\LocaleChart;
use App\Filament\Widgets\Analytics\PlatformChart;
use App\Filament\Widgets\Analytics\RecentVisitsTable;
use App\Filament\Widgets\Analytics\TopPagesWidget;
use App\Filament\Widgets\Analytics\TopReferrersWidget;
use App\Filament\Widgets\Analytics\TopUtmWidget;
use App\Filament\Widgets\Analytics\VisitStatsOverview;
use App\Filament\Widgets\Analytics\VisitsChart;
use Filament\Pages\Page;

class SiteAnalytics extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar-square';

    protected static string $view = 'filament.pages.site-analytics';

    protected static ?string $navigationLabel = 'إحصائيات الزيارات';

    protected static ?string $title = 'إحصائيات الزيارات';

    protected static ?string $navigationGroup = 'التقارير';

    protected static ?int $navigationSort = 1;

    protected function getHeaderWidgets(): array
    {
        return [
            VisitStatsOverview::class,
            EngagementStatsOverview::class,
            VisitsChart::class,
            DeviceChart::class,
            BrowserChart::class,
            PlatformChart::class,
            LocaleChart::class,
            TopPagesWidget::class,
            TopReferrersWidget::class,
            TopUtmWidget::class,
            RecentVisitsTable::class,
        ];
    }

    public function getHeaderWidgetsColumns(): int | string | array
    {
        return 2;
    }
}
