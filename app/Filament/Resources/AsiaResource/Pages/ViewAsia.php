<?php

namespace App\Filament\Resources\AsiaResource\Pages;

use App\Filament\Resources\AsiaResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAsia extends ViewRecord
{
    protected static string $resource = AsiaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
