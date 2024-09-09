<?php

namespace App\Filament\Resources\NrcTypeResource\Pages;

use App\Filament\Resources\NrcTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewNrcType extends ViewRecord
{
    protected static string $resource = NrcTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
