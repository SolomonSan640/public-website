<?php

namespace App\Filament\Resources\ContactPageMmResource\Pages;

use App\Filament\Resources\ContactPageMmResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateContactPageMm extends CreateRecord
{
    protected static string $resource = ContactPageMmResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
