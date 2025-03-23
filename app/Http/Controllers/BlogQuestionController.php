<?php
namespace App\Http\Controllers;

use App\Models\Pregunta;
use Illuminate\Http\Request;

class BlogQuestionController extends Controller
{
    public function getQuestions()
    {
        try {
            $preguntas = Pregunta::with('respuestas')->get();

            if ($preguntas->isEmpty()) {
                return response()->json(['message' => 'No hay preguntas registradas.'], 404);
            }

            return response()->json($preguntas);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al cargar las preguntas: ' . $e->getMessage()], 500);
        }
    }
}