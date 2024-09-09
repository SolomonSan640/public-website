<?php

namespace App\Filament\Resources\AboutPageMmResource\Pages;

use App\Filament\Resources\AboutPageMmResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAboutPageMm extends ViewRecord
{
    protected static string $resource = AboutPageMmResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
