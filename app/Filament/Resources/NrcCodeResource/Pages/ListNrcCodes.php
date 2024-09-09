<?php

namespace App\Filament\Resources\NrcCodeResource\Pages;

use App\Filament\Resources\NrcCodeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNrcCodes extends ListRecords
{
    protected static string $resource = NrcCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
