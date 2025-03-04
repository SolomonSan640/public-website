<?php

namespace App\Filament\Resources\PostalCodeResource\Pages;

use App\Filament\Resources\PostalCodeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePostalCode extends CreateRecord
{
    protected static string $resource = PostalCodeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
