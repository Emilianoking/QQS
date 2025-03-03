<?php
include '../conexion.php'; // Asegúrate de que este archivo tiene la conexión a la BD

try {
    // Obtener todas las preguntas
    $query = "SELECT id, texto, categoria, estado FROM preguntas";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $preguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($preguntas) > 0) {
        echo '<table border="1">
                <tr>
                    <th>ID</th>
                    <th>Pregunta</th>
                    <th>Categoría</th>
                    <th>Estado</th>
                    <th>Respuestas</th>
                    <th>Acciones</th>
                </tr>';

        foreach ($preguntas as $pregunta) {
            // Obtener las respuestas asociadas a esta pregunta
            $query_respuestas = "SELECT id, texto, valor FROM respuestas WHERE id_pregunta = ?";
            $stmt_respuestas = $conn->prepare($query_respuestas);
            $stmt_respuestas->execute([$pregunta['id']]);
            $respuestas = $stmt_respuestas->fetchAll(PDO::FETCH_ASSOC);

            // Convertir las respuestas a formato JSON para pasarlas a JavaScript
            $respuestas_json = json_encode($respuestas, JSON_HEX_QUOT | JSON_HEX_APOS);

            echo '<tr>';
            echo '<td>' . htmlspecialchars($pregunta['id']) . '</td>';
            echo '<td>' . htmlspecialchars($pregunta['texto']) . '</td>';
            echo '<td>' . htmlspecialchars($pregunta['categoria'] ?? 'Sin categoría') . '</td>';
            echo '<td>' . htmlspecialchars($pregunta['estado']) . '</td>';
            echo '<td>';
            // Mostrar las respuestas en una lista
            if (count($respuestas) > 0) {
                echo '<ul>';
                foreach ($respuestas as $respuesta) {
                    echo '<li>' . htmlspecialchars($respuesta['texto']) . ' (Valor: ' . htmlspecialchars($respuesta['valor']) . ')</li>';
                }
                echo '</ul>';
            } else {
                echo 'Sin respuestas';
            }
            echo '</td>';
            echo '<td>';
            // Botón "Actualizar"
            echo '<button class="btn-update" onclick="showUpdateQuestionModal(\'' 
                . htmlspecialchars($pregunta['id'], ENT_QUOTES) . '\', \'' 
                . htmlspecialchars($pregunta['texto'], ENT_QUOTES) . '\', \'' 
                . htmlspecialchars($pregunta['categoria'] ?? '', ENT_QUOTES) . '\', \'' 
                . htmlspecialchars($pregunta['estado'], ENT_QUOTES) . '\', \'' 
                . $respuestas_json . '\')">Actualizar</button>';
            // Botón "Eliminar"
            echo '<button class="btn-delete" onclick="deleteQuestion(\'' . htmlspecialchars($pregunta['id'], ENT_QUOTES) . '\')">Eliminar</button>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo 'No hay preguntas registradas.';
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>