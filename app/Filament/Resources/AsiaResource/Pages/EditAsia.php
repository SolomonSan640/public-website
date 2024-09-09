<?php

namespace App\Filament\Resources\AsiaResource\Pages;

use App\Filament\Resources\AsiaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Http;

class EditAsia extends EditRecord
{
    protected static string $resource = AsiaResource::class;

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
