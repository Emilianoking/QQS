<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use Illuminate\Http\Request;

class PortafolioController extends Controller
{
    public function index(Request $request)
    {
        // Obtener todas las carreras
        $carreras = Carrera::where('estado', 'activa')->get(); // Solo mostramos carreras activas

        // Preparar los datos para el frontend
        $carrerasData = $carreras->map(function ($carrera) {
            $universidad = $carrera->universidad ?? 'Sin universidad';
            // Normalizar el nombre de la universidad
            if (strtolower($universidad) === 'uniminuto') {
                $universidad = 'Uniminuto';
            } elseif (strtolower($universidad) === 'unad') {
                $universidad = 'UNAD';
            }

            return [
                'id' => $carrera->id,
                'nombre' => $carrera->nombre,
                'descripcion' => $carrera->descripcion,
                'categoria' => $carrera->categoria,
                'universidad' => $universidad,
                'nivel_educativo' => $carrera->nivel_educativo,
                'estado' => $carrera->estado,
                'imagen' => 'https://i.postimg.cc/qRHpHMyd/project-1.jpg', // Imagen placeholder
            ];
        });

        // Devolver las carreras en formato JSON
        return response()->json($carrerasData);
    }
}