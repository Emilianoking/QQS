<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    try {
        $query = "DELETE FROM usuarios WHERE id=?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$id]);
        echo "Usuario eliminado correctamente.";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
