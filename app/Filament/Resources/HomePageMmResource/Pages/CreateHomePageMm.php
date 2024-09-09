<?php

namespace App\Filament\Resources\HomePageMmResource\Pages;

use App\Filament\Resources\HomePageMmResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateHomePageMm extends CreateRecord
{
    protected static string $resource = HomePageMmResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
