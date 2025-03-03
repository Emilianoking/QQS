<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $grado = $_POST['grado'];
    $avatar = $_POST['avatar'];
    $rol = $_POST['rol'];

    try {
        $query = "UPDATE usuarios SET nombre=?, email=?, telefono=?, grado=?, avatar=?, rol=? WHERE id=?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$nombre, $email, $telefono, $grado, $avatar, $rol, $id]);
        echo "Usuario actualizado correctamente.";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
