<?php
namespace App\Http\Controllers;

use App\Models\RespuestaUsuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserResponseController extends Controller
{
    public function store(Request $request)
    {
        try {
            $userId = Auth::id();
            if (!$userId) {
                return response()->json(['error' => 'Usuario no autenticado'], 401);
            }

            $preguntaId = $request->input('pregunta_id');
            $respuestaId = $request->input('respuesta_id');

            // Guardar la respuesta del usuario
            RespuestaUsuario::create([
                'id_usuario' => $userId,
                'id_pregunta' => $preguntaId,
                'id_respuesta' => $respuestaId,
            ]);

            return response()->json(['message' => 'Respuesta guardada correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al guardar la respuesta: ' . $e->getMessage()], 500);
        }
    }
}