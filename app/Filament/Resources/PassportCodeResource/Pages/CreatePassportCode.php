<?php

namespace App\Filament\Resources\PassportCodeResource\Pages;

use App\Filament\Resources\PassportCodeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePassportCode extends CreateRecord
{
    protected static string $resource = PassportCodeResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
