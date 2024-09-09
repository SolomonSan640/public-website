<?php

namespace App\Filament\Resources\MiddleEastResource\Pages;

use App\Filament\Resources\MiddleEastResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMiddleEast extends ViewRecord
{
    protected static string $resource = MiddleEastResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
