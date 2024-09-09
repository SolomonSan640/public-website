<?php

namespace App\Filament\Resources\RegionalResource\Pages;

use App\Filament\Resources\RegionalResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRegional extends CreateRecord
{
    protected static string $resource = RegionalResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
