<?php

namespace App\Filament\Resources\ServicePageMmResource\Pages;

use App\Filament\Resources\ServicePageMmResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListServicePageMms extends ListRecords
{
    protected static string $resource = ServicePageMmResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
