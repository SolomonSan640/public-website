<?php

namespace App\Filament\Resources\NrcNoResource\Pages;

use App\Filament\Resources\NrcNoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNrcNo extends EditRecord
{
    protected static string $resource = NrcNoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
