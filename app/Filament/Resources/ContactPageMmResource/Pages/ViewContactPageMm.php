<?php

namespace App\Filament\Resources\ContactPageMmResource\Pages;

use App\Filament\Resources\ContactPageMmResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewContactPageMm extends ViewRecord
{
    protected static string $resource = ContactPageMmResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
