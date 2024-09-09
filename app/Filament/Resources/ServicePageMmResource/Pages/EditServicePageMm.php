<?php

namespace App\Filament\Resources\ServicePageMmResource\Pages;

use App\Filament\Resources\ServicePageMmResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditServicePageMm extends EditRecord
{
    protected static string $resource = ServicePageMmResource::class;

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
