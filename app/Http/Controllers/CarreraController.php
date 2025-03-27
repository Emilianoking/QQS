<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use Illuminate\Http\Request;

class CarreraController extends Controller
{
    public function index()
    {
        $carreras = Carrera::all();
        $html = '<table>';
        $html .= '<thead><tr><th>ID</th><th>Nombre</th><th>Descripción</th><th>Categoría</th><th>Universidad</th><th>Nivel Educativo</th><th>Estado</th><th>Acciones</th></tr></thead>';
        $html .= '<tbody>';
        
        if ($carreras->isEmpty()) {
            $html .= '<tr><td colspan="8">No hay carreras registradas.</td></tr>';
        } else {
            foreach ($carreras as $carrera) {
                // Truncar la descripción a las primeras 5 palabras
                $descripcion = $carrera->descripcion ?? 'Sin descripción';
                $descripcionTruncada = $this->truncateToWords($descripcion, 5);

                $html .= "<tr>";
                $html .= "<td>{$carrera->id}</td>";
                $html .= "<td>" . htmlspecialchars($carrera->nombre) . "</td>";
                $html .= "<td>" . htmlspecialchars($descripcionTruncada) . "</td>";
                $html .= "<td>" . htmlspecialchars($carrera->categoria ?? 'Sin categoría') . "</td>";
                $html .= "<td>" . htmlspecialchars($carrera->universidad ?? 'Sin universidad') . "</td>";
                $html .= "<td>" . htmlspecialchars($carrera->nivel_educativo ?? 'Sin nivel educativo') . "</td>";
                $html .= "<td>" . htmlspecialchars($carrera->estado) . "</td>";
                $html .= "<td>
                    <button class='btn-update' onclick=\"showUpdateCarreraModal({$carrera->id}, '{$carrera->nombre}', '" . htmlspecialchars($carrera->descripcion, ENT_QUOTES, 'UTF-8') . "', '{$carrera->categoria}', '{$carrera->universidad}', '{$carrera->nivel_educativo}', '{$carrera->estado}')\">Actualizar</button>
                    <button class='btn-delete' onclick=\"deleteCarrera({$carrera->id})\">Eliminar</button>
                </td>";
                $html .= "</tr>";
            }
        }
        
        $html .= '</tbody></table>';
        return $html;
    }

    /**
     * Trunca un texto a un número específico de palabras y añade "..." si es necesario.
     *
     * @param string $text El texto a truncar.
     * @param int $wordLimit El número máximo de palabras.
     * @return string El texto truncado.
     */
    private function truncateToWords($text, $wordLimit)
    {
        // Dividir el texto en palabras
        $words = explode(' ', trim($text));
        
        // Si el texto tiene menos o igual palabras que el límite, devolverlo tal cual
        if (count($words) <= $wordLimit) {
            return $text;
        }

        // Tomar las primeras $wordLimit palabras y unirlas
        $truncated = implode(' ', array_slice($words, 0, $wordLimit));
        
        // Añadir puntos suspensivos
        return $truncated . '...';
    }

    public function store(Request $request)
    {
        $carrera = new Carrera();
        $carrera->nombre = $request->nombre;
        $carrera->descripcion = $request->descripcion;
        $carrera->categoria = $request->categoria;
        $carrera->universidad = $request->universidad;
        $carrera->nivel_educativo = $request->nivel_educativo;
        $carrera->estado = $request->estado;
        $carrera->save();

        return $this->index();
    }

    public function update(Request $request, $id)
{
    try {
        $carrera = Carrera::findOrFail($id);
        $carrera->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'categoria' => $request->categoria,
            'universidad' => $request->universidad,
            'nivel_educativo' => $request->nivel_educativo,
            'estado' => $request->estado,
        ]);
        return "Carrera actualizada correctamente.";
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
}

    public function delete(Request $request)
    {
        $carrera = Carrera::find($request->id);
        if ($carrera) {
            $carrera->delete();
            return "Carrera eliminada correctamente.";
        }
        return "Error: Carrera no encontrada.";
    }
}