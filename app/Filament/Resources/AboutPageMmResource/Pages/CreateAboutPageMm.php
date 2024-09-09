<?php

namespace App\Filament\Resources\AboutPageMmResource\Pages;

use App\Filament\Resources\AboutPageMmResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAboutPageMm extends CreateRecord
{
    protected static string $resource = AboutPageMmResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
