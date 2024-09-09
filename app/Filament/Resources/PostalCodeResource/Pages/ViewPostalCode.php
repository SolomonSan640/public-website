<?php

namespace App\Filament\Resources\PostalCodeResource\Pages;

use App\Filament\Resources\PostalCodeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPostalCode extends ViewRecord
{
    protected static string $resource = PostalCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
