<?php
namespace App\Http\Controllers;

use App\Models\Resultado;
use Illuminate\Http\Request;

class ResultadoController extends Controller
{
    // Mostrar todos los rangos en una tabla
    public function index()
    {
        try {
            $resultados = Resultado::all();

            if ($resultados->isEmpty()) {
                return 'No hay rangos registrados.';
            }

            $html = '<table border="1">
                        <tr>
                            <th>ID</th>
                            <th>Rango Mínimo</th>
                            <th>Rango Máximo</th>
                            <th>Carrera Recomendada</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>';

            foreach ($resultados as $resultado) {
                $html .= '<tr>';
                $html .= '<td>' . htmlspecialchars($resultado->id) . '</td>';
                $html .= '<td>' . htmlspecialchars($resultado->rango_min) . '</td>';
                $html .= '<td>' . htmlspecialchars($resultado->rango_max) . '</td>';
                $html .= '<td>' . htmlspecialchars($resultado->carrera_recomendada) . '</td>';
                $html .= '<td>' . htmlspecialchars($resultado->descripcion) . '</td>';
                $html .= '<td>';
                $html .= '<button class="btn-update" onclick="showUpdateResultadoModal(\'' 
                    . htmlspecialchars($resultado->id, ENT_QUOTES) . '\', \'' 
                    . htmlspecialchars($resultado->rango_min, ENT_QUOTES) . '\', \'' 
                    . htmlspecialchars($resultado->rango_max, ENT_QUOTES) . '\', \'' 
                    . htmlspecialchars($resultado->carrera_recomendada, ENT_QUOTES) . '\', \'' 
                    . htmlspecialchars($resultado->descripcion, ENT_QUOTES) . '\')">Actualizar</button>';
                $html .= '<button class="btn-delete" onclick="deleteResultado(\'' . htmlspecialchars($resultado->id, ENT_QUOTES) . '\')">Eliminar</button>';
                $html .= '</td>';
                $html .= '</tr>';
            }
            $html .= '</table>';

            return $html;
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    // Guardar un nuevo rango
    public function store(Request $request)
    {
        try {
            Resultado::create([
                'rango_min' => $request->rango_min,
                'rango_max' => $request->rango_max,
                'carrera_recomendada' => $request->carrera_recomendada,
                'descripcion' => $request->descripcion,
            ]);

            return $this->index();
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // Actualizar un rango existente
    public function update(Request $request, $id)
    {
        try {
            $resultado = Resultado::findOrFail($id);
            $resultado->update([
                'rango_min' => $request->rango_min,
                'rango_max' => $request->rango_max,
                'carrera_recomendada' => $request->carrera_recomendada,
                'descripcion' => $request->descripcion,
            ]);

            return $this->index();
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // Eliminar un rango
    public function destroy($id)
    {
        try {
            $resultado = Resultado::findOrFail($id);
            $resultado->delete();

            return $this->index();
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
}