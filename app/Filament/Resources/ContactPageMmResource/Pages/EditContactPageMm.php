<?php

namespace App\Filament\Resources\ContactPageMmResource\Pages;

use App\Filament\Resources\ContactPageMmResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContactPageMm extends EditRecord
{
    protected static string $resource = ContactPageMmResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
