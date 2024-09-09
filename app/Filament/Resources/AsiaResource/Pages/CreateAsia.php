<?php

namespace App\Filament\Resources\AsiaResource\Pages;

use App\Filament\Resources\AsiaResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Http;

class CreateAsia extends CreateRecord
{
    protected static string $resource = AsiaResource::class;

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
