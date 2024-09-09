<?php

namespace App\Filament\Resources\ServicePageMmResource\Pages;

use App\Filament\Resources\ServicePageMmResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewServicePageMm extends ViewRecord
{
    protected static string $resource = ServicePageMmResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
