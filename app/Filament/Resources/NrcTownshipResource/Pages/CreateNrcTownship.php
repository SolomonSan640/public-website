<?php

namespace App\Filament\Resources\NrcTownshipResource\Pages;

use App\Filament\Resources\NrcTownshipResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateNrcTownship extends CreateRecord
{
    protected static string $resource = NrcTownshipResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
