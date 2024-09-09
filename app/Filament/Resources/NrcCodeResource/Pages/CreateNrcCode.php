<?php

namespace App\Filament\Resources\NrcCodeResource\Pages;

use App\Filament\Resources\NrcCodeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateNrcCode extends CreateRecord
{
    protected static string $resource = NrcCodeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
