<?php

namespace App\Filament\Resources\AboutPageMmResource\Pages;

use App\Filament\Resources\AboutPageMmResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAboutPageMm extends EditRecord
{
    protected static string $resource = AboutPageMmResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
