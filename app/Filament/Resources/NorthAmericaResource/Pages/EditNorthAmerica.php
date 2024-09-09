<?php

namespace App\Filament\Resources\NorthAmericaResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Http;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\NorthAmericaResource;

class EditNorthAmerica extends EditRecord
{
    protected static string $resource = NorthAmericaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            // Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterSave(): void
    {
        $data = $this->record;
        $this->sendWebhook($data, 'updated');
    }

    private function sendWebhook($data, $event)
    {
        $webhookUrl = 'http://192.168.1.61:8080/api/webhook/countries';
        $payload = [
            'event' => $event,
            'data' => [
                'id' => $data['id'],
                'name' => $data->countries->name_en,
            ],
        ];

        Http::post($webhookUrl, $payload);
    }
}
