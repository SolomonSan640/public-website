<?php

namespace App\Filament\Resources\ServicePageMmResource\Pages;

use App\Filament\Resources\ServicePageMmResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateServicePageMm extends CreateRecord
{
    protected static string $resource = ServicePageMmResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
