<?php
require 'conexion.php';

$usuario_id = $_SESSION['usuario_id'] ?? null;

if ($usuario_id) {
    $sql = "SELECT nombre, email, telefono, grado, avatar FROM usuarios WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $usuario = $resultado->fetch_assoc();

    echo json_encode($usuario);
} else {
    echo json_encode(["error" => "Usuario no autenticado"]);
}
?>
