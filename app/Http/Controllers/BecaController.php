<?php

namespace App\Http\Controllers;

use App\Models\Beca;
use Illuminate\Http\Request;

class BecaController extends Controller
{
    public function index()
    {
        try {
            $becas = Beca::all();

            if ($becas->isEmpty()) {
                return 'No hay becas registradas.';
            }

            $html = '<table border="1">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Entidad</th>
                            <th>Descripción</th>
                            <th>Requisitos</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>';

            foreach ($becas as $beca) {
                $html .= '<tr>';
                $html .= '<td>' . htmlspecialchars($beca->id) . '</td>';
                $html .= '<td>' . htmlspecialchars($beca->nombre) . '</td>';
                $html .= '<td>' . htmlspecialchars($beca->entidad) . '</td>';
                $html .= '<td>' . htmlspecialchars($beca->descripcion) . '</td>';
                $html .= '<td>' . htmlspecialchars($beca->requisitos) . '</td>';
                $html .= '<td>' . htmlspecialchars($beca->estado) . '</td>';
                $html .= '<td>';
                $html .= '<button class="btn-update" onclick="showUpdateBecaModal(\'' 
                    . htmlspecialchars($beca->id, ENT_QUOTES) . '\', \'' 
                    . htmlspecialchars($beca->nombre, ENT_QUOTES) . '\', \'' 
                    . htmlspecialchars($beca->entidad, ENT_QUOTES) . '\', \'' 
                    . htmlspecialchars($beca->descripcion, ENT_QUOTES) . '\', \'' 
                    . htmlspecialchars($beca->requisitos, ENT_QUOTES) . '\', \'' 
                    . htmlspecialchars($beca->estado, ENT_QUOTES) . '\')">Actualizar</button>';
                $html .= '<button class="btn-delete" onclick="deleteBeca(\'' . htmlspecialchars($beca->id, ENT_QUOTES) . '\')">Eliminar</button>';
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
            Beca::create([
                'nombre' => $request->nombre,
                'entidad' => $request->entidad,
                'descripcion' => $request->descripcion,
                'requisitos' => $request->requisitos,
                'estado' => $request->estado,
            ]);

            return $this->index();
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $beca = Beca::findOrFail($id);
            $beca->update([
                'nombre' => $request->nombre,
                'entidad' => $request->entidad,
                'descripcion' => $request->descripcion,
                'requisitos' => $request->requisitos,
                'estado' => $request->estado,
            ]);
            return "Beca actualizada correctamente.";
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $beca = Beca::findOrFail($id);
            $beca->delete();
            return "Beca eliminada correctamente.";
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
}