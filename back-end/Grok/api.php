<?php
// Habilitar visualización de errores para depuración (quitar en producción)
ini_set('display_errors', 1); // Cambiado a 1 para ver errores
error_reporting(E_ALL);
header('Content-Type: application/json');

try {
    // Obtener el mensaje del usuario desde la solicitud POST
    $input = json_decode(file_get_contents('php://input'), true);
    if ($input === null) {
        throw new Exception('Invalid JSON input');
    }

    $userMessage = $input['message'] ?? '';
    if (empty($userMessage)) {
        throw new Exception('No message provided');
    }

    // Configuración de la API de xAI
    $apiKey = 'xai-RUgL1I0YMKbVzKEPAnMBnpL9pvlT8YQmbS7qUwWg3MrVhxS7RTUm7356SCNufqsMWcWIlP4AC3WiT2Sb';
    $apiUrl = 'https://api.x.ai/v1/chat/completions';
    $data = [
        'messages' => [
            ['role' => 'system', 'content' => 'You are a helpful assistant named Grok, created by xAI.'],
            ['role' => 'user', 'content' => $userMessage]
        ],
        'model' => 'grok-2-latest',
        'stream' => false,
        'temperature' => 0.7
    ];

    // Intentar con curl (método preferido)
    if (function_exists('curl_init')) {
        $ch = curl_init($apiUrl);
        if ($ch === false) {
            throw new Exception('Failed to initialize cURL');
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey
        ]);

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new Exception('cURL error: ' . curl_error($ch));
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            throw new Exception('API error: HTTP ' . $httpCode . ' - ' . $response);
        }
    } else {
        // Alternativa con file_get_contents si curl no está disponible
        $options = [
            'http' => [
                'method' => 'POST',
                'header' => "Content-Type: application/json\r\n" .
                            "Authorization: Bearer " . $apiKey . "\r\n",
                'content' => json_encode($data),
                'ignore_errors' => true
            ]
        ];
        $context = stream_context_create($options);
        $response = file_get_contents($apiUrl, false, $context);

        if ($response === false) {
            throw new Exception('Failed to connect to API using file_get_contents');
        }

        // Verificar código de respuesta
        $httpCode = $http_response_header[0];
        if (!preg_match('/200/', $httpCode)) {
            throw new Exception('API error: ' . $httpCode . ' - ' . $response);
        }
    }

    // Verificar si la respuesta es JSON válido
    $decodedResponse = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Invalid JSON response from API: ' . $response);
    }

    echo $response;
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>