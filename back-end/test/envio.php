<?php
session_start();
include '../conexion.php';

try {
    // Verifica la conexión (no usamos $conn->connect_error, ya que PDO no lo tiene)
    // La conexión ya debería estar establecida en 'conexion.php'
    if (!$conn) {
        throw new PDOException("No se pudo establecer la conexión a la base de datos.");
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Error de conexión a la base de datos: " . $e->getMessage()]);
    exit();
}

// Verifica si el usuario está autenticado y es administrador
if (!isset($_SESSION["usuario_id"])) {
    http_response_code(401);
    echo json_encode(["error" => "Acceso denegado. No estás autenticado."]);
    exit();
}

$usuario_id = $_SESSION["usuario_id"];
try {
    $stmt = $conn->prepare("SELECT rol FROM usuarios WHERE id = ?");
    if (!$stmt) {
        throw new PDOException("Error en la preparación de la consulta: " . $conn->errorInfo()[2]);
    }
    $stmt->bindParam(1, $usuario_id, PDO::PARAM_INT);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor(); // Usamos closeCursor en lugar de close para PDO

    if (!$usuario || $usuario["rol"] !== "administrador") {
        http_response_code(403);
        echo json_encode(["error" => "No tienes permisos para realizar esta acción."]);
        exit();
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Error al verificar permisos: " . $e->getMessage()]);
    exit();
}

// Procesar la pregunta (método POST)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recibir y validar datos
    $pregunta = trim($_POST["pregunta"] ?? '');
    $categoria = trim($_POST["categoria"] ?? '');
    $respuestas = $_POST["respuestas"] ?? [];
    $valores = $_POST["valores"] ?? [];

    if (empty($pregunta)) {
        http_response_code(400);
        echo json_encode(["error" => "La pregunta es obligatoria."]);
        exit();
    }

    if (count($respuestas) !== count($valores) || empty($respuestas)) {
        http_response_code(400);
        echo json_encode(["error" => "Debes proporcionar al menos una respuesta con su valor correspondiente."]);
        exit();
    }

    try {
        // Insertar la pregunta
        $stmt = $conn->prepare("INSERT INTO preguntas (texto, categoria) VALUES (?, ?)");
        if (!$stmt) {
            throw new PDOException("Error al preparar la consulta de preguntas: " . $conn->errorInfo()[2]);
        }
        $stmt->bindParam(1, $pregunta, PDO::PARAM_STR);
        $stmt->bindParam(2, $categoria, PDO::PARAM_STR);
        if (!$stmt->execute()) {
            throw new PDOException("Error al guardar la pregunta: " . $stmt->errorInfo()[2]);
        }
        $id_pregunta = $conn->lastInsertId();
        $stmt->closeCursor();

        // Insertar respuestas
        $stmt = $conn->prepare("INSERT INTO respuestas (id_pregunta, texto, valor) VALUES (?, ?, ?)");
        if (!$stmt) {
            throw new PDOException("Error al preparar la consulta de respuestas: " . $conn->errorInfo()[2]);
        }

        for ($i = 0; $i < count($respuestas); $i++) {
            $respuesta = trim($respuestas[$i]);
            $valor = (int)$valores[$i]; // Convertir a entero para asegurarnos de que sea un número

            if (empty($respuesta)) {
                http_response_code(400);
                echo json_encode(["error" => "Todas las respuestas deben tener texto."]);
                exit();
            }

            $stmt->bindParam(1, $id_pregunta, PDO::PARAM_INT);
            $stmt->bindParam(2, $respuesta, PDO::PARAM_STR);
            $stmt->bindParam(3, $valor, PDO::PARAM_INT);
            if (!$stmt->execute()) {
                throw new PDOException("Error al guardar la respuesta #$i: " . $stmt->errorInfo()[2]);
            }
        }
        $stmt->closeCursor();

        // Respuesta de éxito
        http_response_code(201);
        echo json_encode(["success" => "Pregunta agregada correctamente"]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error" => "Error al procesar la solicitud: " . $e->getMessage()]);
        exit();
    }
} else {
    // Si no es POST, devolver error
    http_response_code(405);
    echo json_encode(["error" => "Método no permitido. Usa POST."]);
}