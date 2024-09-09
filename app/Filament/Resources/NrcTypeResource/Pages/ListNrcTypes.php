<?php

namespace App\Filament\Resources\NrcTypeResource\Pages;

use App\Filament\Resources\NrcTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNrcTypes extends ListRecords
{
    protected static string $resource = NrcTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
