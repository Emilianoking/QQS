<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Panel de Administrador</title>
    <link rel="stylesheet" href="{{ asset('css/styleadm.css') }}">
    <link rel="shortcut icon" href="https://i.postimg.cc/9fqYVvxh/logo.png" type="image/x-icon">
</head>
<body>
    <main>
        <aside class="sidebar" data-sidebar>
            <div class="sidebar-info">
                <figure class="avatar-box">
                    <img src="{{ Auth::user()->avatar ?? 'https://i.postimg.cc/JzBWVhW4/my-avatar.png' }}" alt="avatar" width="80">
                </figure>
                <div class="info-content">
                    <h1 class="name">{{ Auth::user()->nombre ?? 'Invitado' }}</h1>
                </div>
                <button class="info-more-btn" data-sidebar-btn>
                    <span>Información personal</span>
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
                            <a href="mailto:{{ Auth::user()->email ?? 'No disponible' }}" class="contact-link">
                                {{ Auth::user()->email ?? 'No disponible' }}
                            </a>
                        </div>
                    </li>
                    <li class="contact-item">
                        <div class="icon-box">
                            <ion-icon name="phone-portrait-outline"></ion-icon>
                        </div>
                        <div class="contact-info">
                            <p class="contact-title">Teléfono</p>
                            <a href="tel:{{ Auth::user()->telefono ?? 'No disponible' }}" class="contact-link">
                                {{ Auth::user()->telefono ?? 'No disponible' }}
                            </a>
                        </div>
                    </li>
                    <li class="contact-item">
                        <div class="icon-box">
                            <ion-icon name="briefcase-outline"></ion-icon>
                        </div>
                        <div class="contact-info">
                            <p class="contact-title">Grado</p>
                            <address>{{ Auth::user()->grado ?? 'No definido' }}</address>
                        </div>
                    </li>
                </ul>
                <div class="separator"></div>
                <form method="POST" action="{{ url('/logout') }}" style="text-align: center;">
                    @csrf
                    <button type="submit" class="form-btn">Cerrar sesión</button>
                </form>
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
                        <span class="close" onclick="closeModal()">×</span>
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
                            <div class="answer-row">
                                <input type="text" name="respuestas[]" placeholder="Respuesta" required>
                                <input type="number" name="valores[]" placeholder="Valor" required>
                            </div>
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
                            <label>Respuestas y Valores:</label>
                            <div id="updateQuestionAnswers"></div>
                            <button type="submit">Actualizar Pregunta</button>
                        </form>
                    </div>
                </div>
                <!-- Nueva sección: Agregar Carrera -->
                <h3 class="h3 service-title">Agregar Carrera</h3>
                <section class="service">
                    <form id="formCarrera">
                        <label>Nombre:</label>
                        <input type="text" name="nombre" required>
                        <label>Descripción:</label>
                        <textarea name="descripcion"></textarea>
                        <label>Categoría:</label>
                        <input type="text" name="categoria">
                        <label>Universidad:</label>
                        <input type="text" name="universidad">
                        <label>Nivel Educativo:</label>
                        <select name="nivel_educativo">
                            <option value="">Seleccione un nivel</option>
                            <option value="técnico">Técnico</option>
                            <option value="tecnólogo">Tecnólogo</option>
                            <option value="profesional">Profesional</option>
                        </select>
                        <label>Estado:</label>
                        <select name="estado">
                            <option value="activa">Activa</option>
                            <option value="inactiva">Inactiva</option>
                        </select>
                        <button type="submit">Guardar Carrera</button>
                    </form>
                    <div id="mensajeCarrera"></div>
                </section>
                <!-- Nueva sección: Ver Carreras -->
                <h3 class="h3 service-title">Ver Carreras</h3>
                <section class="service">
                    <div id="carreraTable">
                        <!-- Aquí se cargará la tabla de carreras -->
                    </div>
                </section>
                <!-- Modal para actualizar carrera -->
                <div id="updateCarreraModal" class="modal">
                    <div class="modal-content">
                        <span class="close" onclick="closeCarreraModal()">×</span>
                        <h2>Actualizar Carrera</h2>
                        <form id="updateCarreraForm">
                            <input type="hidden" id="carreraId">
                            <label>Nombre:</label>
                            <input type="text" id="carreraNombre" required>
                            <label>Descripción:</label>
                            <textarea id="carreraDescripcion"></textarea>
                            <label>Categoría:</label>
                            <input type="text" id="carreraCategoria">
                            <label>Universidad:</label>
                            <input type="text" id="carreraUniversidad">
                            <label>Nivel Educativo:</label>
                            <select id="carreraNivelEducativo">
                                <option value="">Seleccione un nivel</option>
                                <option value="técnico">Técnico</option>
                                <option value="tecnólogo">Tecnólogo</option>
                                <option value="profesional">Profesional</option>
                            </select>
                            <label>Estado:</label>
                            <select id="carreraEstado">
                                <option value="activa">Activa</option>
                                <option value="inactiva">Inactiva</option>
                            </select>
                            <button type="submit">Actualizar Carrera</button>
                        </form>
                    </div>
                </div>
                <!-- Nueva sección: Agregar Beca -->
                <h3 class="h3 service-title">Agregar Beca</h3>
                <section class="service">
                    <form id="formBeca">
                        <label>Nombre:</label>
                        <input type="text" name="nombre" required>
                        <label>Entidad:</label>
                        <input type="text" name="entidad" required>
                        <label>Descripción:</label>
                        <textarea name="descripcion" required></textarea>
                        <label>Requisitos:</label>
                        <textarea name="requisitos" required></textarea>
                        <label>Estado:</label>
                        <select name="estado">
                            <option value="activa">Activa</option>
                            <option value="inactiva">Inactiva</option>
                        </select>
                        <button type="submit">Guardar Beca</button>
                    </form>
                    <div id="mensajeBeca"></div>
                </section>
                <!-- Nueva sección: Ver Becas -->
                <h3 class="h3 service-title">Ver Becas</h3>
                <section class="service">
                    <div id="becaTable">
                        <!-- Aquí se cargará la tabla de becas -->
                    </div>
                </section>
                <!-- Modal para actualizar beca -->
                <div id="updateBecaModal" class="modal">
                    <div class="modal-content">
                        <span class="close" onclick="closeBecaModal()">×</span>
                        <h2>Actualizar Beca</h2>
                        <form id="updateBecaForm">
                            <input type="hidden" id="becaId">
                            <label>Nombre:</label>
                            <input type="text" id="becaNombre" required>
                            <label>Entidad:</label>
                            <input type="text" id="becaEntidad" required>
                            <label>Descripción:</label>
                            <textarea id="becaDescripcion" required></textarea>
                            <label>Requisitos:</label>
                            <textarea id="becaRequisitos" required></textarea>
                            <label>Estado:</label>
                            <select id="becaEstado">
                                <option value="activa">Activa</option>
                                <option value="inactiva">Inactiva</option>
                            </select>
                            <button type="submit">Actualizar Beca</button>
                        </form>
                    </div>
                </div>
                <!-- Nueva sección: Agregar Rango -->
                <h3 class="h3 service-title">Agregar Rango</h3>
                <section class="service">
                    <form id="formResultado">
                        <label>Rango Mínimo:</label>
                        <input type="number" name="rango_min" required>
                        <label>Rango Máximo:</label>
                        <input type="number" name="rango_max" required>
                        <label>Carrera Recomendada:</label>
                        <input type="text" name="carrera_recomendada" required>
                        <label>Descripción:</label>
                        <textarea name="descripcion" required></textarea>
                        <button type="submit">Guardar Rango</button>
                    </form>
                    <div id="mensajeResultado"></div>
                </section>
                <!-- Nueva sección: Ver Rangos -->
                <h3 class="h3 service-title">Ver Rangos</h3>
                <section class="service">
                    <div id="resultadoTable">
                        <!-- Aquí se cargará la tabla de rangos -->
                    </div>
                    <!-- Modal para actualizar rango -->
                    <div id="updateResultadoModal" class="modal">
                        <div class="modal-content">
                            <span class="close" onclick="closeResultadoModal()">×</span>
                            <h2>Actualizar Rango</h2>
                            <form id="updateResultadoForm">
                                <input type="hidden" id="resultadoId">
                                <label>Rango Mínimo:</label>
                                <input type="number" id="resultadoRangoMin" required>
                                <label>Rango Máximo:</label>
                                <input type="number" id="resultadoRangoMax" required>
                                <label>Carrera Recomendada:</label>
                                <input type="text" id="resultadoCarreraRecomendada" required>
                                <label>Descripción:</label>
                                <textarea id="resultadoDescripcion" required></textarea>
                                <button type="submit">Actualizar Rango</button>
                            </form>
                        </div>
                    </div>
                </section>
            </article>
        </div>
    </main>
    <script src="{{ asset('js/mainadm.js') }}"></script>
    <script src="{{ asset('js/admin/resultados.js') }}"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>