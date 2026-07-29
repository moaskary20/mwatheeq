<?php

namespace App\Filament\Widgets\Analytics;

use App\Models\PageView;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class VisitStatsOverview extends StatsOverviewWidget
{
    protected static bool $isDiscovered = false;

    protected static ?string $pollingInterval = '60s';

    protected function getStats(): array
    {
        $base = PageView::query()->humans();

        $today = (clone $base)->today()->count();
        $uniqueToday = (clone $base)->today()
            ->select(DB::raw('COUNT(DISTINCT COALESCE(session_id, ip)) as aggregate'))
            ->value('aggregate') ?? 0;

        $week = (clone $base)->where('created_at', '>=', now()->subDays(7))->count();
        $month = (clone $base)->where('created_at', '>=', now()->subDays(30))->count();
        $total = (clone $base)->count();
        $online = (clone $base)->where('created_at', '>=', now()->subMinutes(5))
            ->select(DB::raw('COUNT(DISTINCT COALESCE(session_id, ip)) as aggregate'))
            ->value('aggregate') ?? 0;

        $spark = PageView::query()
            ->humans()
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->selectRaw('DATE(created_at) as day, COUNT(*) as total')
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('total', 'day');

        $chart = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = now()->subDays($i)->toDateString();
            $chart[] = (float) ($spark[$day] ?? 0);
        }

        $yesterday = PageView::query()->humans()
            ->whereDate('created_at', Carbon::yesterday())
            ->count();
        $diff = $today - $yesterday;
        $diffLabel = $diff === 0
            ? 'مساوٍ لأمس'
            : ($diff > 0 ? '+'.$diff.' عن أمس' : $diff.' عن أمس');

        return [
            Stat::make('زيارات اليوم', number_format($today))
                ->description($diffLabel)
                ->descriptionIcon($diff >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($diff >= 0 ? 'success' : 'danger')
                ->chart($chart),
            Stat::make('زوار فريدون اليوم', number_format((int) $uniqueToday))
                ->description('حسب الجلسة / الـ IP')
                ->descriptionIcon('heroicon-m-user')
                ->color('info'),
            Stat::make('متصلون الآن', number_format((int) $online))
                ->description('آخر 5 دقائق')
                ->descriptionIcon('heroicon-m-signal')
                ->color('warning'),
            Stat::make('آخر 7 أيام', number_format($week))
                ->description('زيارات')
                ->color('primary'),
            Stat::make('آخر 30 يوم', number_format($month))
                ->description('زيارات')
                ->color('primary'),
            Stat::make('الإجمالي', number_format($total))
                ->description('كل الزيارات المسجّلة')
                ->descriptionIcon('heroicon-m-globe-alt')
                ->color('gray'),
        ];
    }
}
