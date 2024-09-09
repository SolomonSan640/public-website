<?php

namespace App\Filament\Resources\PassportCodeResource\Pages;

use App\Filament\Resources\PassportCodeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPassportCodes extends ListRecords
{
    protected static string $resource = PassportCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
