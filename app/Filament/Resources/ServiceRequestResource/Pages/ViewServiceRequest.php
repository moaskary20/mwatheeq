<?php

namespace App\Filament\Resources\ServiceRequestResource\Pages;

use App\Filament\Resources\ServiceRequestResource;
use App\Models\ServiceRequest;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewServiceRequest extends ViewRecord
{
    protected static string $resource = ServiceRequestResource::class;

    protected static ?string $title = 'عرض الطلب';

    public function mount(int|string $record): void
    {
        parent::mount($record);

        /** @var ServiceRequest $request */
        $request = $this->record;

        if (! $request->is_read) {
            $request->update(['is_read' => true]);
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->label('حذف'),
        ];
    }
}
