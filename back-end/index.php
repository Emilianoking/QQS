<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caja de Inicio de Sesión / Registro en 3D</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="data:;base64,iVBORw0KGgo=">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/material-icons@1.13.12/iconfont/material-icons.min.css">
</head>

<body>
    <nav class="navbar">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="logo">¿Qué Qui<span>ero Ser?</span></div>
                <input type="checkbox" id="click">  
                <label for="click" class="menu-btn">
                    <i class="material-icons">menu</i>
                </label>
                <ul>
                    <li><a href="#" class="active">Inicio</a></li>
                    <li><a href="#">Acerca de</a></li>
                    <li><a href="#">Servicios</a></li>
                    <li><a href="#">Galería</a></li>
                    <li><a href="#">Comentarios</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section>
        <div class="container">
            <div class="row full-screen align-items-center">
                <div class="left">
                    <span class="line"></span>
                    <h2>Descubre tu futuro, <br><span>elige tu camino.</span></h2>
                    <a href="#" class="btn">Conoce más sobre nosotros</a>
                    <div class="social-media">
                        <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#"><i class="fa-brands fa-x-twitter"></i></a>
                        <a href="#"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#"><i class="fa-brands fa-youtube"></i></a>
                        <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="right">
                    <div class="form">
                        <div class="text-center">
                            <h6><span>Iniciar Sesión</span> <span>Registrarse</span></h6>
                            <input type="checkbox" class="checkbox" id="reg-log">
                            <label for="reg-log"></label>
                            <div class="card-3d-wrap">
                                <div class="card-3d-wrapper">
                                    <div class="card-front">
                                        <div class="center-wrap">
                                            <h4 class="heading">Iniciar Sesión</h4>
                                            <form action="login.php" method="POST">
                                                <div class="form-group">
                                                    <input type="email" name="email" class="form-style"
                                                        placeholder="Tu Correo" required>
                                                    <i class="input-icon material-icons">alternate_email</i>
                                                </div>
                                                <div class="form-group">
                                                    <input type="password" name="contraseña" class="form-style"
                                                        placeholder="Tu Contraseña" required>
                                                    <i class="input-icon material-icons">lock</i>
                                                </div>
                                                <button type="submit" class="btn">Enviar</button>

                                                <?php if (isset($_GET['error'])): ?>
                                                    <p style="color: red;">Correo o contraseña incorrectos</p>
                                                <?php endif; ?>
                                            </form>


                                            <p class="text-center"><a href="#" class="link">¿Olvidaste tu
                                                    contraseña?</a></p>
                                            <p class="text-center"><a href="../front-end/usuario.php" class="link">No
                                                    segistrar</a></p>
                                        </div>
                                    </div>
                                    <div class="card-back">
                                        <div class="center-wrap">
                                            <h4 class="heading">Registrarse</h4>
                                            <form action="registro.php" method="POST">
                                                <div class="form-group">
                                                    <input type="text" class="form-style" name="nombre"
                                                        placeholder="Tu nombre" required>
                                                    <i class="input-icon material-icons">perm_identity</i>
                                                </div>
                                                <div class="form-group">
                                                    <input type="email" class="form-style" name="email"
                                                        placeholder="Tu correo electrónico" required>
                                                    <i class="input-icon material-icons">alternate_email</i>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-style" name="telefono"
                                                        placeholder="Tu teléfono">
                                                    <i class="input-icon material-icons">phone</i>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-style" name="grado"
                                                        placeholder="Grado actual">
                                                    <i class="input-icon material-icons">school</i>
                                                </div>
                                                <div class="form-group">
                                                    <input type="password" class="form-style" name="contraseña"
                                                        placeholder="Tu contraseña" required>
                                                    <i class="input-icon material-icons">lock</i>
                                                </div>
                                                <button type="submit" class="btn">Registrarse</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>