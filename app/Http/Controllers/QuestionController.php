<?php
namespace App\Http\Controllers;

use App\Models\Pregunta;
use App\Models\Respuesta;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        try {
            $preguntas = Pregunta::with('respuestas')->get();

            if ($preguntas->isEmpty()) {
                return 'No hay preguntas registradas.';
            }

            $html = '<table border="1">
                        <tr>
                            <th>ID</th>
                            <th>Pregunta</th>
                            <th>Categoría</th>
                            <th>Estado</th>
                            <th>Respuestas</th>
                            <th>Acciones</th>
                        </tr>';

            foreach ($preguntas as $pregunta) {
                // Convertimos las respuestas a un formato JSON para pasarlas al frontend
                $respuestasJson = json_encode($pregunta->respuestas->map(function ($respuesta) {
                    return ['texto' => $respuesta->texto, 'valor' => $respuesta->valor];
                })->toArray());

                $html .= '<tr>';
                $html .= '<td>' . htmlspecialchars($pregunta->id) . '</td>';
                $html .= '<td>' . htmlspecialchars($pregunta->texto) . '</td>';
                $html .= '<td>' . htmlspecialchars($pregunta->categoria ?? 'Sin categoría') . '</td>';
                $html .= '<td>' . htmlspecialchars($pregunta->estado) . '</td>';
                $html .= '<td>' . htmlspecialchars($respuestasJson) . '</td>';
                $html .= '<td>';
                $html .= '<button class="btn-update" onclick="showUpdateQuestionModal(\'' 
                    . htmlspecialchars($pregunta->id, ENT_QUOTES) . '\', \'' 
                    . htmlspecialchars($pregunta->texto, ENT_QUOTES) . '\', \'' 
                    . htmlspecialchars($pregunta->categoria, ENT_QUOTES) . '\', \'' 
                    . htmlspecialchars($pregunta->estado, ENT_QUOTES) . '\', \'' 
                    . htmlspecialchars($respuestasJson, ENT_QUOTES) . '\')">Actualizar</button>';
                $html .= '<button class="btn-delete" onclick="deleteQuestion(\'' . htmlspecialchars($pregunta->id, ENT_QUOTES) . '\')">Eliminar</button>';
                $html .= '</td>';
                $html .= '</tr>';
            }
            $html .= '</table>';

            return $html;
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    public function store(Request $request)
    {
        try {
            // Crear la pregunta
            $pregunta = Pregunta::create([
                'texto' => $request->pregunta,
                'categoria' => $request->categoria,
                'estado' => 'activa',
            ]);

            // Crear las respuestas asociadas
            foreach ($request->respuestas as $index => $texto) {
                Respuesta::create([
                    'pregunta_id' => $pregunta->id,
                    'texto' => $texto,
                    'valor' => $request->valores[$index],
                ]);
            }

            // Recargar tabla de preguntas
            return $this->index();
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function update(Request $request)
    {
        try {
            $pregunta = Pregunta::findOrFail($request->id);

            // Actualizar la pregunta
            $pregunta->update([
                'texto' => $request->texto,
                'categoria' => $request->categoria,
                'estado' => $request->estado,
            ]);

            // Eliminar las respuestas existentes
            $pregunta->respuestas()->delete();

            // Crear las nuevas respuestas
            foreach ($request->respuestas as $index => $texto) {
                Respuesta::create([
                    'pregunta_id' => $pregunta->id,
                    'texto' => $texto,
                    'valor' => $request->valores[$index],
                ]);
            }

            return "Pregunta actualizada correctamente.";
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function destroy(Request $request)
    {
        try {
            $pregunta = Pregunta::findOrFail($request->id);
            // Las respuestas se eliminan automáticamente gracias a onDelete('cascade')
            $pregunta->delete();
            return "Pregunta eliminada correctamente.";
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
}