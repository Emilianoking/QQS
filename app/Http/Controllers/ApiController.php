<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function sendToXai(Request $request)
    {
        $message = $request->input('message');

        $apiKey = env('XAI_API_KEY');
        $apiUrl = env('XAI_API_URL');

        if (!$apiKey || !$apiUrl) {
            \Log::error('Clave API o URL no configurada en .env', ['apiKey' => $apiKey, 'apiUrl' => $apiUrl]);
            return response()->json(['error' => 'Clave API o URL no configurada en .env'], 500);
        }

        try {
            \Log::info('Enviando solicitud a xAI', ['message' => $message, 'apiKey' => $apiKey, 'apiUrl' => $apiUrl]);

            $response = Http::withHeaders([
                'Authorization' => "Bearer $apiKey",
                'Content-Type' => 'application/json',
            ])->post($apiUrl, [
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a test assistant.'],
                    ['role' => 'user', 'content' => $message],
                ],
                'model' => 'grok-2-latest',
                'stream' => false,
                'temperature' => 0,
            ]);

            \Log::info('Respuesta de xAI', ['status' => $response->status(), 'body' => $response->body()]);

            if ($response->failed()) {
                $errorMessage = 'Error al conectar con xAI: ' . $response->status() . ' - ' . $response->body();
                return response()->json(['error' => $errorMessage], $response->status());
            }

            $data = $response->json();
            return response()->json($data);
        } catch (\Exception $e) {
            \Log::error('Excepción en sendToXai', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Excepción: ' . $e->getMessage()], 500);
        }
    }
}