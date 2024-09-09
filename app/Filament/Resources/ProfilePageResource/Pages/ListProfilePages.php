<?php

namespace App\Filament\Resources\ProfilePageResource\Pages;

use App\Filament\Resources\ProfilePageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProfilePages extends ListRecords
{
    protected static string $resource = ProfilePageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
