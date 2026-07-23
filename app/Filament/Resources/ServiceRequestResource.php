<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceRequestResource\Pages;
use App\Models\ServiceRequest;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ServiceRequestResource extends Resource
{
    protected static ?string $model = ServiceRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationLabel = 'الطلبات';

    protected static ?string $modelLabel = 'طلب';

    protected static ?string $pluralModelLabel = 'الطلبات';

    protected static ?string $navigationGroup = 'الموقع';

    protected static ?int $navigationSort = 3;

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::query()->where('is_read', false)->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('تفاصيل الطلب')
                    ->schema([
                        Infolists\Components\TextEntry::make('name')->label('الاسم'),
                        Infolists\Components\TextEntry::make('phone')->label('رقم التليفون'),
                        Infolists\Components\TextEntry::make('email')->label('البريد الإلكتروني'),
                        Infolists\Components\TextEntry::make('service_title')->label('الخدمة'),
                        Infolists\Components\TextEntry::make('created_at')->label('تاريخ الطلب')->dateTime('Y-m-d H:i'),
                        Infolists\Components\IconEntry::make('is_read')->label('مقروء')->boolean(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('التليفون')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('البريد')
                    ->searchable(),
                Tables\Columns\TextColumn::make('service_title')
                    ->label('الخدمة')
                    ->searchable()
                    ->limit(40),
                Tables\Columns\IconColumn::make('is_read')
                    ->label('مقروء')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('التاريخ')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_read')
                    ->label('مقروء'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('عرض'),
                Tables\Actions\Action::make('markAsRead')
                    ->label('تعليم كمقروء')
                    ->icon('heroicon-o-check')
                    ->visible(fn (ServiceRequest $record): bool => ! $record->is_read)
                    ->action(fn (ServiceRequest $record) => $record->update(['is_read' => true])),
                Tables\Actions\DeleteAction::make()->label('حذف'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('حذف المحدد'),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServiceRequests::route('/'),
            'view' => Pages\ViewServiceRequest::route('/{record}'),
        ];
    }
}
