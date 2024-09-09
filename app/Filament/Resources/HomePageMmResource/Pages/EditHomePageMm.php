<?php

namespace App\Filament\Resources\HomePageMmResource\Pages;

use App\Filament\Resources\HomePageMmResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHomePageMm extends EditRecord
{
    protected static string $resource = HomePageMmResource::class;

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
