<?php

namespace App\Filament\Resources\ProfilePageMmResource\Pages;

use App\Filament\Resources\ProfilePageMmResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProfilePageMms extends ListRecords
{
    protected static string $resource = ProfilePageMmResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
