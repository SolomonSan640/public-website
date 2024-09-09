<?php

namespace App\Filament\Resources\MiddleEastResource\Pages;

use App\Filament\Resources\MiddleEastResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMiddleEasts extends ListRecords
{
    protected static string $resource = MiddleEastResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
