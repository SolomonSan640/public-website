<?php

namespace App\Filament\Resources\NrcTypeResource\Pages;

use App\Filament\Resources\NrcTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNrcType extends EditRecord
{
    protected static string $resource = NrcTypeResource::class;

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
