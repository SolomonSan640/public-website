<?php

namespace App\Filament\Resources\NrcCodeResource\Pages;

use App\Filament\Resources\NrcCodeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNrcCode extends EditRecord
{
    protected static string $resource = NrcCodeResource::class;

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
