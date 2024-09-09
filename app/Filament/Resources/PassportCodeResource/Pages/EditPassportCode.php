<?php

namespace App\Filament\Resources\PassportCodeResource\Pages;

use App\Filament\Resources\PassportCodeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPassportCode extends EditRecord
{
    protected static string $resource = PassportCodeResource::class;

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
