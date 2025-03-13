<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        try {
            $users = User::select('id', 'nombre', 'email', 'telefono', 'grado', 'avatar', 'rol')->get();

            if ($users->isEmpty()) {
                return 'No hay usuarios registrados.';
            }

            $html = '<table border="1">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Grado</th>
                            <th>Avatar</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>';

            foreach ($users as $user) {
                $html .= '<tr>';
                $html .= '<td>' . htmlspecialchars($user->id) . '</td>';
                $html .= '<td>' . htmlspecialchars($user->nombre) . '</td>';
                $html .= '<td>' . htmlspecialchars($user->email) . '</td>';
                $html .= '<td>' . htmlspecialchars($user->telefono) . '</td>';
                $html .= '<td>' . htmlspecialchars($user->grado) . '</td>';
                $html .= '<td><img src="' . htmlspecialchars($user->avatar) . '" width="40"></td>';
                $html .= '<td>' . htmlspecialchars($user->rol) . '</td>';
                $html .= '<td>';
                $html .= '<button class="btn-update" onclick="showUpdateModal(\'' 
                    . htmlspecialchars($user->id, ENT_QUOTES) . '\', \'' 
                    . htmlspecialchars($user->nombre, ENT_QUOTES) . '\', \'' 
                    . htmlspecialchars($user->email, ENT_QUOTES) . '\', \'' 
                    . htmlspecialchars($user->telefono, ENT_QUOTES) . '\', \'' 
                    . htmlspecialchars($user->grado, ENT_QUOTES) . '\', \'' 
                    . htmlspecialchars($user->avatar, ENT_QUOTES) . '\', \'' 
                    . htmlspecialchars($user->rol, ENT_QUOTES) . '\')">Actualizar</button>';
                $html .= '<button class="btn-delete" onclick="deleteUser(\'' . htmlspecialchars($user->id, ENT_QUOTES) . '\')">Eliminar</button>';
                $html .= '</td>';
                $html .= '</tr>';
            }
            $html .= '</table>';

            return $html;
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    public function update(Request $request)
    {
        try {
            $user = User::findOrFail($request->id);
            $user->update([
                'nombre' => $request->nombre,
                'email' => $request->email,
                'telefono' => $request->telefono,
                'grado' => $request->grado,
                'avatar' => $request->avatar,
                'rol' => $request->rol,
            ]);
            return "Usuario actualizado correctamente.";
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function destroy(Request $request)
    {
        try {
            $user = User::findOrFail($request->id);
            $user->delete();
            return "Usuario eliminado correctamente.";
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
}