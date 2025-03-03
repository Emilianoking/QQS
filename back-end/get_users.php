<?php
include 'conexion.php'; // Asegúrate de que este archivo tiene la conexión a la BD

try {
    $query = "SELECT id, nombre, email, telefono, grado, avatar, rol FROM usuarios";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($usuarios) > 0) {
        echo '<table border="1">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Grado</th>
                    <th>Avatar</th>
                    <th>Rol</th>
                    <th>Acciones</th> <!-- Nueva columna para los botones -->
                </tr>';

        foreach ($usuarios as $row) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['id']) . '</td>';
            echo '<td>' . htmlspecialchars($row['nombre']) . '</td>';
            echo '<td>' . htmlspecialchars($row['email']) . '</td>';
            echo '<td>' . htmlspecialchars($row['telefono']) . '</td>';
            echo '<td>' . htmlspecialchars($row['grado']) . '</td>';
            echo '<td><img src="' . htmlspecialchars($row['avatar']) . '" width="40"></td>';
            echo '<td>' . htmlspecialchars($row['rol']) . '</td>';
            echo '<td>';
            // Botón "Actualizar" - Escapamos los datos para evitar errores en JavaScript
            echo '<button class="btn-update" onclick="showUpdateModal(\'' 
                . htmlspecialchars($row['id'], ENT_QUOTES) . '\', \'' 
                . htmlspecialchars($row['nombre'], ENT_QUOTES) . '\', \'' 
                . htmlspecialchars($row['email'], ENT_QUOTES) . '\', \'' 
                . htmlspecialchars($row['telefono'], ENT_QUOTES) . '\', \'' 
                . htmlspecialchars($row['grado'], ENT_QUOTES) . '\', \'' 
                . htmlspecialchars($row['avatar'], ENT_QUOTES) . '\', \'' 
                . htmlspecialchars($row['rol'], ENT_QUOTES) . '\')">Actualizar</button>';
            // Botón "Eliminar"
            echo '<button class="btn-delete" onclick="deleteUser(\'' . htmlspecialchars($row['id'], ENT_QUOTES) . '\')">Eliminar</button>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo 'No hay usuarios registrados.';
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}

// No necesitas cerrar la conexión con `$conn->close();`, ya que PDO lo maneja automáticamente
?>