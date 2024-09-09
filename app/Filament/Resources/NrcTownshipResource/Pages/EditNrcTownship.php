<?php

namespace App\Filament\Resources\NrcTownshipResource\Pages;

use App\Filament\Resources\NrcTownshipResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNrcTownship extends EditRecord
{
    protected static string $resource = NrcTownshipResource::class;

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
