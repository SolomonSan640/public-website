<?php

namespace App\Filament\Resources\AboutPageMmResource\Pages;

use App\Filament\Resources\AboutPageMmResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAboutPageMms extends ListRecords
{
    protected static string $resource = AboutPageMmResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
