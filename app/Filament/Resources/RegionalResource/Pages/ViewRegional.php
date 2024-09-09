<?php

namespace App\Filament\Resources\RegionalResource\Pages;

use App\Filament\Resources\RegionalResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewRegional extends ViewRecord
{
    protected static string $resource = RegionalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
