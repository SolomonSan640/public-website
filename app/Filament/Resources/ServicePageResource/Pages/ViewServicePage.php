<?php

namespace App\Filament\Resources\ServicePageResource\Pages;

use App\Filament\Resources\ServicePageResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewServicePage extends ViewRecord
{
    protected static string $resource = ServicePageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
