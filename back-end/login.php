<?php
session_start();
require 'conexion.php';

var_dump(isset($conn)); // Verifica si la conexión está definida
var_dump($conn); // Muestra el objeto PDO
// exit; <-- Elimino esto para que el código continúe

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    var_dump($_POST); // Depuración de datos recibidos

    $email = trim($_POST['email']);
    $password = trim($_POST['contraseña']);

    try {
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $conn->prepare($sql); // Asegúrate de que usas $conn

        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();

        var_dump($stmt->rowCount()); // Verifica si encuentra usuarios
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        var_dump($usuario); // Muestra los datos del usuario

        if ($usuario && password_verify($password, $usuario['password'])) {
            $_SESSION['usuario_id'] = $usuario['id']; 
            $_SESSION['usuario'] = $usuario['nombre']; 
            $_SESSION['email'] = $usuario['email']; 

            header("Location: ../front-end/usuario.php");
            exit();
        } else {
            echo "Error: Credenciales incorrectas";
            // header("Location: login.php?error=1");
            // exit();
        }
    } catch (PDOException $e) {
        die("Error en la base de datos: " . $e->getMessage());
    }
}
?>
