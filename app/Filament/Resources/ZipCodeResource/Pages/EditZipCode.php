<?php

namespace App\Filament\Resources\ZipCodeResource\Pages;

use App\Filament\Resources\ZipCodeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditZipCode extends EditRecord
{
    protected static string $resource = ZipCodeResource::class;

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
