<?php

namespace App\Filament\Widgets\Analytics;

use App\Models\PageView;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class RecentVisitsTable extends TableWidget
{
    protected static bool $isDiscovered = false;

    protected static ?string $heading = 'آخر الزيارات';

    protected int | string | array $columnSpan = 'full';

    protected int $defaultPaginationPageOption = 10;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                PageView::query()
                    ->humans()
                    ->latest('created_at')
            )
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('الوقت')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('path')
                    ->label('الصفحة')
                    ->searchable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('device')
                    ->label('الجهاز')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'desktop' => 'كمبيوتر',
                        'mobile' => 'جوال',
                        'tablet' => 'تابلت',
                        default => $state ?? '—',
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'mobile' => 'success',
                        'tablet' => 'warning',
                        'desktop' => 'info',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('browser')
                    ->label('المتصفح')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('platform')
                    ->label('النظام')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('locale')
                    ->label('اللغة')
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'ar' => 'عربي',
                        'en' => 'EN',
                        default => $state ?? '—',
                    }),
                Tables\Columns\TextColumn::make('referer_host')
                    ->label('الإحالة')
                    ->placeholder('مباشر')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('ip')
                    ->label('IP')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('utm_source')
                    ->label('UTM')
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated([10, 25, 50]);
    }
}
