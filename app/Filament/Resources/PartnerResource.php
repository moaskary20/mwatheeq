<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PartnerResource\Pages;
use App\Models\Partner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PartnerResource extends Resource
{
    protected static ?string $model = Partner::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';

    protected static ?string $navigationLabel = 'الجهات المتعامل معها';

    protected static ?string $modelLabel = 'جهة';

    protected static ?string $pluralModelLabel = 'الجهات المتعامل معها';

    protected static ?string $navigationGroup = 'الموقع';

    protected static ?int $navigationSort = 8;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('اسم الجهة')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\Select::make('icon')
                    ->label('الأيقونة')
                    ->options([
                        'registry' => 'الشهر العقاري',
                        'survey' => 'المساحة',
                        'aviation' => 'الطيران',
                        'antiquities' => 'الآثار',
                        'water' => 'المياه',
                        'investment' => 'الاستثمار',
                        'telecom' => 'الاتصالات',
                        'urban' => 'المجتمعات العمرانية',
                        'city' => 'جهاز مدينة',
                        'city-oct' => 'جهاز مدينة (أكتوبر)',
                        'government' => 'جهة حكومية عامة',
                    ])
                    ->required()
                    ->default('government'),
                Forms\Components\TextInput::make('sort_order')
                    ->label('ترتيب العرض')
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_published')
                    ->label('منشور')
                    ->default(true),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('الاسم')->searchable(),
                Tables\Columns\TextColumn::make('icon')->label('الأيقونة'),
                Tables\Columns\TextColumn::make('sort_order')->label('الترتيب')->sortable(),
                Tables\Columns\IconColumn::make('is_published')->label('منشور')->boolean(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->actions([
                Tables\Actions\EditAction::make()->label('تعديل'),
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
            'index' => Pages\ManagePartners::route('/'),
        ];
    }
}
