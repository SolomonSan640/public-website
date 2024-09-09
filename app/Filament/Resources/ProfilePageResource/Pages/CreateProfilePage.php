<?php

namespace App\Filament\Resources\ProfilePageResource\Pages;

use App\Filament\Resources\ProfilePageResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProfilePage extends CreateRecord
{
    protected static string $resource = ProfilePageResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
