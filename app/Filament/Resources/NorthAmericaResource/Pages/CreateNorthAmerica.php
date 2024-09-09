<?php

namespace App\Filament\Resources\NorthAmericaResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Http;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\NorthAmericaResource;

class CreateNorthAmerica extends CreateRecord
{
    protected static string $resource = NorthAmericaResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        $data = $this->record;
        $this->sendWebhook($data, 'created');
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
