<?php
require 'conexion.php';

if (!$conn) {
    die("Error: No hay conexión a la base de datos.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    var_dump($_POST);

    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $grado = $_POST['grado'];
    $password = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);

    try {
        $sql = "INSERT INTO usuarios (nombre, email, telefono, grado, password) 
                VALUES (:nombre, :email, :telefono, :grado, :password)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":telefono", $telefono);
        $stmt->bindParam(":grado", $grado);
        $stmt->bindParam(":password", $password);

        if ($stmt->execute()) {
            echo "<script>alert('Registro exitoso'); window.location.href='index.php';</script>";
        } else {
            print_r($stmt->errorInfo());
        }
    } catch (PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}

?>
