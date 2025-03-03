<?php
session_start();
require '../../back-end/conexion.php'; // Importa la conexión a la BD

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['usuario'] = 'Invitado';
    $_SESSION['email'] = 'No disponible';
    $_SESSION['telefono'] = 'No disponible';
    $_SESSION['grado'] = 'No definido';
    $_SESSION['avatar'] = $usuario['avatar'] ?? "https://i.postimg.cc/JzBWVhW4/my-avatar.png";
} else {
    // Obtiene los datos del usuario desde la BD
    $usuario_id = $_SESSION['usuario_id'];
    $sql = "SELECT nombre, email, telefono, grado, avatar FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql); // Cambiado de $conexion a $conn
    $stmt->bindParam(1, $usuario_id, PDO::PARAM_INT); // Usar bindParam en lugar de bind_param
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        $_SESSION['usuario'] = $usuario['nombre'];
        $_SESSION['email'] = $usuario['email'];
        $_SESSION['telefono'] = $usuario['telefono'];
        $_SESSION['grado'] = $usuario['grado'];
        $_SESSION['avatar'] = $usuario['avatar'] ?? "https://i.postimg.cc/JzBWVhW4/my-avatar.png"; // Imagen por defecto
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Portfolio</title>
    <link rel="stylesheet" href="styleadm.css">
    <link rel="shortcut icon" href="https://i.postimg.cc/9fqYVvxh/logo.png" type="image/x-icon">

</head>

<body>
    <main>
        <aside class="sidebar" data-sidebar>
            <div class="sidebar-info">
                <figure class="avatar-box">
                    <img src="<?php echo $_SESSION['avatar']; ?>" alt="avatar" width="80">
                </figure>

                <div class="info-content">
                    <h1 class="name"><?php echo $_SESSION['usuario']; ?></h1>
                </div>

                <button class="info-more-btn" data-sidebar-btn>
                    <span>Show Contacts</span>
                    <ion-icon name="chevron-down"></ion-icon>
                </button>
            </div>

            <div class="sidebar-info-more">
                <div class="separator"></div>

                <ul class="contacts-list">
                    <li class="contact-item">
                        <div class="icon-box">
                            <ion-icon name="mail-outline"></ion-icon>
                        </div>
                        <div class="contact-info">
                            <p class="contact-title">Email</p>
                            <a href="mailto:<?php echo $_SESSION['email']; ?>" class="contact-link">
                                <?php echo $_SESSION['email']; ?>
                            </a>
                        </div>
                    </li>

                    <li class="contact-item">
                        <div class="icon-box">
                            <ion-icon name="phone-portrait-outline"></ion-icon>
                        </div>
                        <div class="contact-info">
                            <p class="contact-title">Teléfono</p>
                            <a href="tel:<?php echo $_SESSION['telefono']; ?>" class="contact-link">
                                <?php echo $_SESSION['telefono']; ?>
                            </a>
                        </div>
                    </li>

                    <li class="contact-item">
                        <div class="icon-box">
                            <ion-icon name="briefcase-outline"></ion-icon>
                        </div>
                        <div class="contact-info">
                            <p class="contact-title">Grado</p>
                            <address><?php echo $_SESSION['grado']; ?></address>
                        </div>
                    </li>
                </ul>

                <div class="separator"></div>
            </div>
        </aside>


        <div class="main-content">
            <article class="about active" data-page="about">
                <header>
                    <h2 class="h2 article-title">Bienvenido Administrador</h2>
                </header>

                <h3 class="h3 service-title">Ver usuarios</h3>

                <section class="service">
                    <div id="userTable">
                        <!-- Aquí se cargará la tabla de usuarios -->
                    </div>
                </section>

                <!-- Modal para actualizar usuario -->
                <div id="updateModal" class="modal">
                    <div class="modal-content">
                        <span class="close" onclick="closeModal()">&times;</span>
                        <h2>Actualizar Usuario</h2>
                        <form id="updateForm">
                            <input type="hidden" id="userId">
                            <label>Nombre:</label>
                            <input type="text" id="userName" required>
                            <label>Email:</label>
                            <input type="email" id="userEmail" required>
                            <label>Teléfono:</label>
                            <input type="text" id="userPhone" required>
                            <label>Grado:</label>
                            <input type="text" id="userGrade" required>
                            <label>Avatar (URL):</label>
                            <input type="text" id="userAvatar" required>
                            <label>Rol:</label>
                            <select id="userRole">
                                <option value="estudiante">Estudiante</option>
                                <option value="administrador">Administrador</option>
                            </select>
                            <button type="submit">Actualizar</button>
                        </form>
                    </div>
                </div>


                <h3 class="h3 service-title">Agregar Test</h3>
                <section class="service">

                    <form id="formPregunta">
                        <label>Pregunta:</label>
                        <input type="text" name="pregunta" required>

                        <label>Categoría:</label>
                        <input type="text" name="categoria">

                        <label>Respuestas y valores:</label>
                        <div id="respuestas">
                            <input type="text" name="respuestas[]" required>
                            <input type="number" name="valores[]" required>
                        </div>

                        <button type="button" id="agregarRespuesta">Añadir otra respuesta</button>
                        <button type="submit">Guardar Pregunta</button>
                    </form>

                    <div id="mensaje"></div>
                </section>

                
                <h3 class="h3 service-title">Ver Test</h3>
                <section class="service">
                    <div id="questionTable">
                        <!-- Aquí se cargará la tabla de preguntas -->
                    </div>
                </section>

                <!-- Modal para actualizar pregunta -->
                <div id="updateQuestionModal" class="modal">
                    <div class="modal-content">
                        <span class="close" onclick="closeQuestionModal()">×</span>
                        <h2>Actualizar Pregunta</h2>
                        <form id="updateQuestionForm">
                            <input type="hidden" id="questionId">
                            <label>Pregunta:</label>
                            <input type="text" id="questionText" required>
                            <label>Categoría:</label>
                            <input type="text" id="questionCategory">
                            <label>Estado:</label>
                            <select id="questionStatus">
                                <option value="activa">Activa</option>
                                <option value="inactiva">Inactiva</option>
                            </select>
                            <!-- Aquí se cargarán dinámicamente los campos para respuestas -->
                            <div id="updateQuestionAnswers"></div>
                            <button type="submit">Actualizar Pregunta</button>
                        </form>
                    </div>
                </div>





            </article>
        </div>
    </main>

    <script src="mainadm.js"></script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>