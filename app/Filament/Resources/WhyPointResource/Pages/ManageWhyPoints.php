<?php

namespace App\Filament\Resources\WhyPointResource\Pages;

use App\Filament\Resources\WhyPointResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageWhyPoints extends ManageRecords
{
    protected static string $resource = WhyPointResource::class;

    protected static ?string $title = 'لماذا تختارنا';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('إضافة نقطة'),
        ];
    }
}
