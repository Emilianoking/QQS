<?php
$conexion = new mysqli("localhost", "root", "", "test_vocacional");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$id_usuario = $_GET["id_usuario"];
$resultado_total = 0;

// Obtener todas las respuestas del usuario y sumarlas
$query = "SELECT r.valor FROM respuestas_usuario ru 
          JOIN respuestas r ON ru.id_respuesta = r.id 
          WHERE ru.id_usuario = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $resultado_total += $row["valor"];
}
$stmt->close();

// Determinar la carrera recomendada
$query = "SELECT carrera_recomendada, descripcion FROM resultados 
          WHERE ? BETWEEN rango_min AND rango_max 
          LIMIT 1";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $resultado_total);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo "Tu carrera recomendada es: " . $row["carrera_recomendada"];
    echo "<p>" . $row["descripcion"] . "</p>";
} else {
    echo "No se encontró una carrera recomendada para tu puntaje.";
}
?>
