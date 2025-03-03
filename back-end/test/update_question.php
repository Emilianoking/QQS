<?php
include '../conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $texto = $_POST['texto'];
    $categoria = $_POST['categoria'] ?: null;
    $estado = $_POST['estado'];
    $respuestas = isset($_POST['respuestas']) ? $_POST['respuestas'] : [];
    $valores = isset($_POST['valores']) ? $_POST['valores'] : [];

    try {
        // Actualizar la pregunta
        $query = "UPDATE preguntas SET texto = ?, categoria = ?, estado = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$texto, $categoria, $estado, $id]);

        // Eliminar las respuestas actuales
        $query_delete = "DELETE FROM respuestas WHERE id_pregunta = ?";
        $stmt_delete = $conn->prepare($query_delete);
        $stmt_delete->execute([$id]);

        // Insertar las nuevas respuestas
        foreach ($respuestas as $index => $respuesta_texto) {
            if (!empty($respuesta_texto) && isset($valores[$index])) {
                $valor = $valores[$index];
                $query_insert = "INSERT INTO respuestas (id_pregunta, texto, valor) VALUES (?, ?, ?)";
                $stmt_insert = $conn->prepare($query_insert);
                $stmt_insert->execute([$id, $respuesta_texto, $valor]);
            }
        }

        echo "Pregunta actualizada correctamente.";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>