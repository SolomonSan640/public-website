<?php

namespace App\Filament\Resources\ProfilePageResource\Pages;

use App\Filament\Resources\ProfilePageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProfilePage extends EditRecord
{
    protected static string $resource = ProfilePageResource::class;

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
