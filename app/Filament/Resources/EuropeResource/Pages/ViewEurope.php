<?php

namespace App\Filament\Resources\EuropeResource\Pages;

use App\Filament\Resources\EuropeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewEurope extends ViewRecord
{
    protected static string $resource = EuropeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
