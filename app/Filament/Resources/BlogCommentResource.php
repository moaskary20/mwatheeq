<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogCommentResource\Pages;
use App\Models\BlogComment;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BlogCommentResource extends Resource
{
    protected static ?string $model = BlogComment::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationLabel = 'ردود المدونة';

    protected static ?string $modelLabel = 'رد';

    protected static ?string $pluralModelLabel = 'ردود المدونة';

    protected static ?string $navigationGroup = 'الموقع';

    protected static ?int $navigationSort = 6;

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::query()->where('is_approved', false)->count();

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
                Infolists\Components\Section::make('تفاصيل الرد')
                    ->schema([
                        Infolists\Components\TextEntry::make('post.title')->label('الموضوع'),
                        Infolists\Components\TextEntry::make('name')->label('الاسم'),
                        Infolists\Components\TextEntry::make('email')->label('البريد')->placeholder('—'),
                        Infolists\Components\TextEntry::make('created_at')->label('التاريخ')->dateTime('Y-m-d H:i'),
                        Infolists\Components\IconEntry::make('is_approved')->label('معتمد')->boolean(),
                        Infolists\Components\TextEntry::make('body')
                            ->label('نص الرد')
                            ->columnSpanFull()
                            ->prose(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('post.title')
                    ->label('الموضوع')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('المستخدم')
                    ->placeholder('—')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('body')
                    ->label('الرد')
                    ->limit(40),
                Tables\Columns\IconColumn::make('is_approved')
                    ->label('معتمد')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('التاريخ')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_approved')
                    ->label('معتمد'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('عرض'),
                Tables\Actions\Action::make('approve')
                    ->label('اعتماد')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(fn (BlogComment $record): bool => ! $record->is_approved)
                    ->action(fn (BlogComment $record) => $record->update(['is_approved' => true])),
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
            'index' => Pages\ListBlogComments::route('/'),
            'view' => Pages\ViewBlogComment::route('/{record}'),
        ];
    }
}
