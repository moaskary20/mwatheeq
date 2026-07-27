<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Resources\ClientResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageClients extends ManageRecords
{
    protected static string $resource = ClientResource::class;

    protected static ?string $title = 'عملاؤنا';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('إضافة عميل'),
        ];
    }
}
