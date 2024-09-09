<?php

namespace App\Filament\Resources\NorthAmericaResource\Pages;

use App\Filament\Resources\NorthAmericaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNorthAmericas extends ListRecords
{
    protected static string $resource = NorthAmericaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
