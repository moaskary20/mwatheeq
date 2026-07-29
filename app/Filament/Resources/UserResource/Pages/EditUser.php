<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected static ?string $title = 'تعديل مستخدم';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('حذف')
                ->visible(fn (): bool => auth()->id() !== $this->record->id)
                ->before(function () {
                    if (auth()->id() === $this->record->id) {
                        Notification::make()
                            ->title('لا يمكنك حذف حسابك الحالي')
                            ->danger()
                            ->send();

                        $this->halt();
                    }
                }),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        /** @var User $record */
        $record = $this->record;

        if (auth()->id() === $record->id && array_key_exists('is_admin', $data) && ! $data['is_admin']) {
            Notification::make()
                ->title('لا يمكنك إزالة صلاحية الأدمن من حسابك الحالي')
                ->danger()
                ->send();

            $data['is_admin'] = true;
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
