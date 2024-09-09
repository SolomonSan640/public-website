<?php

namespace App\Filament\Resources\NorthAmericaResource\Pages;

use App\Filament\Resources\NorthAmericaResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewNorthAmerica extends ViewRecord
{
    protected static string $resource = NorthAmericaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
