<?php

namespace App\Filament\Resources\ProfilePageMmResource\Pages;

use App\Filament\Resources\ProfilePageMmResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProfilePageMm extends CreateRecord
{
    protected static string $resource = ProfilePageMmResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
