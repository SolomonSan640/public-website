<?php

namespace App\Filament\Resources\NrcCodeResource\Pages;

use App\Filament\Resources\NrcCodeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewNrcCode extends ViewRecord
{
    protected static string $resource = NrcCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
