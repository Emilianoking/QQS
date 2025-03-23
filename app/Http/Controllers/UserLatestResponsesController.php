<?php
namespace App\Http\Controllers;

use App\Models\RespuestaUsuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserLatestResponsesController extends Controller
{
    public function getLatestResponses()
    {
        try {
            $userId = Auth::id();
            if (!$userId) {
                return response()->json(['error' => 'Usuario no autenticado'], 401);
            }

            // Obtener las últimas respuestas del usuario usando una subconsulta
            $latestResponses = RespuestaUsuario::select('respuestas_usuario.*')
                ->where('id_usuario', $userId)
                ->whereIn('respuestas_usuario.id', function ($query) use ($userId) {
                    $query->select(DB::raw('MAX(id)'))
                        ->from('respuestas_usuario')
                        ->where('id_usuario', $userId)
                        ->groupBy('id_pregunta');
                })
                ->with(['pregunta', 'respuesta']) // Cargar relaciones
                ->orderBy('respuestas_usuario.created_at', 'desc')
                ->get()
                ->map(function ($response) {
                    return [
                        'pregunta_id' => $response->id_pregunta,
                        'pregunta_texto' => $response->pregunta ? $response->pregunta->texto : 'Pregunta no encontrada',
                        'respuesta_id' => $response->id_respuesta,
                        'respuesta_texto' => $response->respuesta ? $response->respuesta->texto : 'Respuesta no encontrada',
                        'created_at' => $response->created_at,
                    ];
                });

            if ($latestResponses->isEmpty()) {
                return response()->json(['message' => 'No has respondido ninguna pregunta aún.'], 404);
            }

            return response()->json($latestResponses);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al cargar las respuestas: ' . $e->getMessage()], 500);
        }
    }
}