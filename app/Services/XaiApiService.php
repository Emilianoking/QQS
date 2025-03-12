<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class XaiApiService
{
    protected $apiKey;
    protected $apiUrl;

    public function __construct()
    {
        $this->apiKey = config('services.xai.key');
        $this->apiUrl = config('services.xai.url');
    }

    public function sendMessage($message)
    {
        $data = [
            'messages' => [
                ['role' => 'system', 'content' => 'You are a helpful assistant named Grok, created by xAI.'],
                ['role' => 'user', 'content' => $message]
            ],
            'model' => 'grok-2-latest',
            'stream' => false,
            'temperature' => 0.7
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->apiKey
        ])->post($this->apiUrl, $data);

        if ($response->failed()) {
            throw new \Exception('Error al conectar con la API de xAI: ' . $response->body());
        }

        return $response->json();
    }
}