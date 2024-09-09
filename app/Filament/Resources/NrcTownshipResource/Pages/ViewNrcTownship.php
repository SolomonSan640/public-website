<?php

namespace App\Filament\Resources\NrcTownshipResource\Pages;

use App\Filament\Resources\NrcTownshipResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewNrcTownship extends ViewRecord
{
    protected static string $resource = NrcTownshipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
