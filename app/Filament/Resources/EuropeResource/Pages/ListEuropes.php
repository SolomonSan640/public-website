<?php

namespace App\Filament\Resources\EuropeResource\Pages;

use App\Filament\Resources\EuropeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEuropes extends ListRecords
{
    protected static string $resource = EuropeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
