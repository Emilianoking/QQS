<?php

namespace App\Http\Controllers;

use OpenAI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OpenAIController extends Controller
{
    public function generateWelcomeMessage()
    {
        try {
            // Configurar el cliente de OpenAI con la clave del .env
            $client = OpenAI::client(env('OPENAI_API_KEY'));

            // Obtener el nombre del usuario autenticado
            $userName = Auth::user()->nombre;

            // Prompt para OpenAI: generar un mensaje de bienvenida corto, máximo 20 palabras
            $prompt = "Genera una frase de bienvenida única y motivadora para $userName, relacionada con orientación vocacional. Máximo 20 palabras. Sin signos innecesarios.";

            // Solicitar respuesta a la API de OpenAI
            $response = $client->chat()->create([
                'model' => 'gpt-3.5-turbo', // Modelo más económico
                'messages' => [
                    ['role' => 'user', 'content' => $prompt],
                ],
                'max_tokens' => 30, // Reducido para limitar a ~20 palabras
                'temperature' => 0.6, // Menos creatividad para mantener la respuesta concisa
            ]);

            // Extraer el mensaje generado
            $welcomeMessage = trim($response->choices[0]->message->content);

            // Asegurarnos de que no exceda 20 palabras
            $words = str_word_count($welcomeMessage);
            if ($words > 20) {
                $welcomeMessage = implode(' ', array_slice(explode(' ', $welcomeMessage), 0, 20));
            }

            return $welcomeMessage;
        } catch (\Exception $e) {
            // En caso de error (como cuota excedida), devolver un mensaje predeterminado
            return "Hola $userName descubre tu futuro con orientación vocacional";
        }
    }
}