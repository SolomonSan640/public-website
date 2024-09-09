<?php

namespace App\Filament\Resources\ProfilePageResource\Pages;

use App\Filament\Resources\ProfilePageResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewProfilePage extends ViewRecord
{
    protected static string $resource = ProfilePageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
