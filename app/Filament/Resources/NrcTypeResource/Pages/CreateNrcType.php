<?php

namespace App\Filament\Resources\NrcTypeResource\Pages;

use App\Filament\Resources\NrcTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateNrcType extends CreateRecord
{
    protected static string $resource = NrcTypeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
