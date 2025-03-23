<?php
namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\RespuestaUsuario;
use App\Models\Resultado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RecommendedCareersController extends Controller
{
    public function getRecommendedCareers()
    {
        try {
            $userId = Auth::id();
            if (!$userId) {
                return response()->json(['error' => 'Usuario no autenticado'], 401);
            }

            // Obtener las últimas respuestas del usuario
            $latestResponses = RespuestaUsuario::select('respuestas_usuario.*')
                ->where('id_usuario', $userId)
                ->whereIn('respuestas_usuario.id', function ($query) use ($userId) {
                    $query->select(DB::raw('MAX(id)'))
                        ->from('respuestas_usuario')
                        ->where('id_usuario', $userId)
                        ->groupBy('id_pregunta');
                })
                ->with(['respuesta']) // Cargar la relación con la tabla respuestas
                ->get();

            if ($latestResponses->isEmpty()) {
                return response()->json(['message' => 'No has respondido ninguna pregunta aún.'], 404);
            }

            // Sumar los valores de las respuestas
            $totalScore = $latestResponses->sum(function ($response) {
                return $response->respuesta ? $response->respuesta->valor : 0;
            });

            // Buscar rangos que coincidan con la suma total
            $recommendedCareers = Resultado::where('rango_min', '<=', $totalScore)
                ->where('rango_max', '>=', $totalScore)
                ->pluck('carrera_recomendada')
                ->toArray();

            if (empty($recommendedCareers)) {
                return response()->json(['message' => 'No se encontraron carreras recomendadas para tu puntaje.'], 404);
            }

            // Buscar carreras cuya categoría coincida (parcialmente) con las carreras recomendadas
            $carreras = Carrera::where('estado', 'activa')
                ->where(function ($query) use ($recommendedCareers) {
                    foreach ($recommendedCareers as $carreraRecomendada) {
                        $keywords = explode(' ', strtolower($carreraRecomendada));
                        foreach ($keywords as $keyword) {
                            $query->orWhereRaw('LOWER(categoria) LIKE ?', ['%' . $keyword . '%']);
                        }
                    }
                })
                ->get()
                ->map(function ($carrera) {
                    return [
                        'nombre' => $carrera->nombre,
                        'descripcion' => $carrera->descripcion,
                    ];
                });

            if ($carreras->isEmpty()) {
                return response()->json(['message' => 'No se encontraron carreras que coincidan con las recomendaciones.'], 404);
            }

            return response()->json($carreras);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al cargar las carreras recomendadas: ' . $e->getMessage()], 500);
        }
    }
}