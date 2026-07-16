<?php

namespace App\Filament\Resources\BlogCommentResource\Pages;

use App\Filament\Resources\BlogCommentResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBlogComment extends ViewRecord
{
    protected static string $resource = BlogCommentResource::class;

    protected static ?string $title = 'عرض الرد';

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('approve')
                ->label('اعتماد الرد')
                ->icon('heroicon-o-check')
                ->color('success')
                ->visible(fn (): bool => ! $this->record->is_approved)
                ->action(function (): void {
                    $this->record->update(['is_approved' => true]);
                }),
            Actions\DeleteAction::make()->label('حذف'),
        ];
    }
}
