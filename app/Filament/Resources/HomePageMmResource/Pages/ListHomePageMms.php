<?php

namespace App\Filament\Resources\HomePageMmResource\Pages;

use App\Filament\Resources\HomePageMmResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHomePageMms extends ListRecords
{
    protected static string $resource = HomePageMmResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
