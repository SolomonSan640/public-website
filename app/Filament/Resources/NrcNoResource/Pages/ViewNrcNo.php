<?php

namespace App\Filament\Resources\NrcNoResource\Pages;

use App\Filament\Resources\NrcNoResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewNrcNo extends ViewRecord
{
    protected static string $resource = NrcNoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];   
    }
}
