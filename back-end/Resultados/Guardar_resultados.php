<?php
$conexion = new mysqli("localhost", "root", "", "test_vocacional");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_POST["id_usuario"];
    $respuestas = $_POST["respuestas"]; // Formato: [id_pregunta => id_respuesta]

    foreach ($respuestas as $id_pregunta => $id_respuesta) {
        $stmt = $conexion->prepare("INSERT INTO respuestas_usuario (id_usuario, id_pregunta, id_respuesta) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $id_usuario, $id_pregunta, $id_respuesta);
        $stmt->execute();
        $stmt->close();
    }

    echo "Respuestas guardadas correctamente.";
}
?>
