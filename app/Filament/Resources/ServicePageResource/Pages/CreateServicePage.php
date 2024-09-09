<?php

namespace App\Filament\Resources\ServicePageResource\Pages;

use App\Filament\Resources\ServicePageResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateServicePage extends CreateRecord
{
    protected static string $resource = ServicePageResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
