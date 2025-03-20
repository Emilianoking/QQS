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
                $html .= "<tr>";
                $html .= "<td>{$carrera->id}</td>";
                $html .= "<td>" . htmlspecialchars($carrera->nombre) . "</td>";
                $html .= "<td>" . htmlspecialchars($carrera->descripcion ?? 'Sin descripción') . "</td>";
                $html .= "<td>" . htmlspecialchars($carrera->categoria ?? 'Sin categoría') . "</td>";
                $html .= "<td>" . htmlspecialchars($carrera->universidad ?? 'Sin universidad') . "</td>";
                $html .= "<td>" . htmlspecialchars($carrera->nivel_educativo ?? 'Sin nivel educativo') . "</td>";
                $html .= "<td>" . htmlspecialchars($carrera->estado) . "</td>";
                $html .= "<td>
                    <button class='btn-update' onclick=\"showUpdateCarreraModal({$carrera->id}, '{$carrera->nombre}', '{$carrera->descripcion}', '{$carrera->categoria}', '{$carrera->universidad}', '{$carrera->nivel_educativo}', '{$carrera->estado}')\">Actualizar</button>
                    <button class='btn-delete' onclick=\"deleteCarrera({$carrera->id})\">Eliminar</button>
                </td>";
                $html .= "</tr>";
            }
        }
        
        $html .= '</tbody></table>';
        return $html;
    }

    public function store(Request $request)
    {
        $carrera = new Carrera();
        $carrera->nombre = $request->nombre;
        $carrera->descripcion = $request->descripcion;
        $carrera->categoria = $request->categoria;
        $carrera->universidad = $request->universidad;
        $carrera->nivel_educativo = $request->nivel_educativo; // Añadimos el nuevo campo
        $carrera->estado = $request->estado;
        $carrera->save();

        return $this->index();
    }

    public function update(Request $request)
    {
        $carrera = Carrera::find($request->id);
        if ($carrera) {
            $carrera->nombre = $request->nombre;
            $carrera->descripcion = $request->descripcion;
            $carrera->categoria = $request->categoria;
            $carrera->universidad = $request->universidad;
            $carrera->nivel_educativo = $request->nivel_educativo; // Añadimos el nuevo campo
            $carrera->estado = $request->estado;
            $carrera->save();
            return "Carrera actualizada correctamente.";
        }
        return "Error: Carrera no encontrada.";
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