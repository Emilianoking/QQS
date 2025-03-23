<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Panel de Estudiante</title>
    <link rel="stylesheet" href="{{ asset('css/usuario.css') }}">
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
            <nav class="navbar">
                <ul class="navbar-list">
                    <li class="navbar-item"><button class="navbar-link active" data-nav-link>About</button></li>
                    <li class="navbar-item"><button class="navbar-link" data-nav-link>Resume</button></li>
                    <li class="navbar-item"><button class="navbar-link" data-nav-link>Portafolio</button></li>
                    <li class="navbar-item"><button class="navbar-link" data-nav-link>Blog</button></li>
                    <li class="navbar-item"><button class="navbar-link" data-nav-link>Contact</button></li>
                </ul>
            </nav>

            <article class="about active" data-page="about">
                <header>
                    <h2 class="h2 article-title">Bienvenido</h2>
                </header>
                <section class="about-text">
                    <p><span id="welcome-message">Cargando...</span></p>
                    
                </section>

                <section class="testimonials">
                    <h3 class="h3 testimonials-title">Testimonials</h3>
                    <ul class="testimonials-list has-scrollbar">
                        <li class="testimonials-item">
                            <div class="content-card" data-testimonials-item>
                                <figure class="testimonials-avatar-box">
                                    <img src="https://i.postimg.cc/zGDHfn3G/avatar-1.png" alt="avatar" data-testimonials-avatar width="60">
                                </figure>
                                <h4 class="h4 testimonials-item-title" data-testimonials-title>Daniel Lewis</h4>
                                <div class="testimonials-text" data-testimonials-text>
                                    <p>Richard was hired to create a corporate identity. It's modern, clean and with a beautiful design that got a lot of praises from colleagues and visitors.</p>
                                </div>
                            </div>
                        </li>
                        <!-- Más testimonials aquí -->
                    </ul>
                </section>

                <div class="modal-container" data-modal-container>
                    <div class="overlay" data-overlay></div>
                    <section class="testimonials-modal">
                        <button class="modal-close-btn" data-modal-close-btn><ion-icon name="close-outline"></ion-icon></button>
                        <div class="modal-img-wrapper">
                            <figure class="modal-avatar-box">
                                <img src="https://i.postimg.cc/zGDHfn3G/avatar-1.png" alt="Daniel Lewis" width="80" data-modal-img>
                            </figure>
                            <img src="https://i.postimg.cc/mZ00RwX7/icon-quote.png" alt="quote icon">
                        </div>
                        <div class="modal-content">
                            <h4 class="h3 modal-title" data-modal-title>Daniel Lewis</h4>
                            <time datetime="2023-06-14">14 June, 2023</time>
                            <div class="modal-text" data-modal-text>
                                <p>Richard was hired to create a corporate identity. It's modern, clean and with a beautiful design.</p>
                            </div>
                        </div>
                    </section>
                </div>

                <section class="clients">
                    <h3 class="h3 clients-title">Universidades convenio</h3>
                    <ul class="clients-list has-scrollbar">
                        <li class="clients-item">
                            <a href="https://www.uniminuto.edu/oriente" target="_blank">
                                <img src="https://ulibros.com/publisher/ilogo/8a831d50869bd4271f1b20a4a0acf44b" alt="logo">
                            </a>
                        </li>
                        <li class="clients-item">
                            <a href="https://estudios.unad.edu.co/descuentos-por-convenios-institucionales/municipio-de-acacias-meta" target="_blank">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR-flZjMI0abrc0Lgubyn2hedBQG6Zfppi3jA&s" alt="logo">
                            </a>
                        </li>
                    </ul>
                </section>
            </article>

            <article class="resume" data-page="resume">
                <header>
                    <h2 class="h2 article-title">Resume</h2>
                </header>
                <section class="timeline">
                    <div class="title-wrapper">
                        <div class="icon-box"><ion-icon name="book-outline"></ion-icon></div>
                        <h3 class="h3">Education</h3>
                    </div>
                    <ol class="timeline-list">
                        <li class="timeline-item">
                            <h4 class="h4 timeline-item-title">University school of the arts</h4>
                            <span>2008 - 2010</span>
                            <p class="timeline-text">There I learnt a wide range of topics that are essential to understanding both the theory and practical aspects of computing.</p>
                        </li>
                        <!-- Más items aquí -->
                    </ol>
                </section>
                <!-- Más secciones de resume -->
            </article>
            <article class="portafolio" data-page="portafolio">
        <header>
            <h2 class="h2 article-title">Portafolio</h2>
        </header>
        <section class="projects">
            <ul class="filter-list">
                <li class="filter-item"><button class="active" data-filter-btn data-filter="Todas las carreras">Todas las carreras</button></li>
                <li class="filter-item"><button data-filter-btn data-filter="Uniminuto">Uniminuto</button></li>
                <li class="filter-item"><button data-filter-btn data-filter="UNAD">UNAD</button></li>
            </ul>
            <div class="filter-select-box">
                <button class="filter-select" data-select>
                    <div class="select-value" data-select-value>Seleccione una categoría</div>
                    <div class="select-icon"><ion-icon name="chevron-down"></ion-icon></div>
                </button>
                <ul class="select-list">
                    <li class="select-item"><button data-select-item data-filter="Todas las carreras">Todas las carreras</button></li>
                    <li class="select-item"><button data-select-item data-filter="Uniminuto">Uniminuto</button></li>
                    <li class="select-item"><button data-select-item data-filter="UNAD">UNAD</button></li>
                </ul>
            </div>
            <ul class="project-list" id="projectList">
                <!-- Las carreras se cargarán dinámicamente aquí -->
            </ul>
        </section>
    </article>

            <article class="blog" data-page="blog">
                <header>
                    <h2 class="h2 article-title">Blog</h2>
                </header>
                <section class="blog-posts">
                    <ul class="blog-posts-list">
                        <li class="blog-post-item">
                            <a href="#">
                                <figure class="blog-banner-box">
                                    <img src="https://i.postimg.cc/DysCZrWs/blog-1.jpg" alt="Design conferences in 2024" loading="lazy">
                                </figure>
                                <div class="blog-content">
                                    <div class="blog-meta">
                                        <p class="blog-category">Design</p>
                                        <span class="dot"></span>
                                        <time datetime="2024-02-23">Feb 23, 2024</time>
                                    </div>
                                    <h3 class="h3 blog-item-title">Design conferences in 2024</h3>
                                    <p class="blog-text">In 2024, several exciting design conferences are set to take place.</p>
                                </div>
                            </a>
                        </li>
                        <!-- Más posts aquí -->
                    </ul>
                </section>
            </article>

            <article class="contact" data-page="contact">
                <header>
                    <h2 class="h2 article-title">Contact</h2>
                </header>
                <section class="mapbox" data-mapbox>
                    <select id="location-select">
                        <option value="uniminuto">Uniminuto Villavicencio</option>
                        <option value="unad">UNAD Acacias</option>
                    </select>
                    <figure>
                        <iframe id="map-iframe" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3986.123456789012!2d-73.6337345!3d4.1125843!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3f9b5c8d8d8d8d%3A0x1234567890abcdef!2sUniminuto%20Villavicencio%2C%20Meta%2C%20Colombia!5e0!3m2!1sen!2sco!4v1717747200!5m2!1sen!2sco" width="400" height="300" loading="lazy" allowfullscreen="" style="border:0;"></iframe>
                    </figure>
                </section>
                <section class="chat-section">
                    <h3 class="h3 form-title">Chat con Grok</h3>
                    <div class="chat-messages" id="chat-messages"></div>
                    <div class="chat-input-container">
                        <input type="text" id="chat-input" placeholder="Escribe tu mensaje...">
                        <button id="chat-send">Enviar</button>
                    </div>
                </section>
            </article>
        </div>
    </main>

    <!-- Incluir jQuery para la solicitud AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Script para cargar el mensaje de bienvenida -->
    <script>
        $(document).ready(function() {
            // Obtener el mensaje de bienvenida desde la API
            $.ajax({
                url: '{{ route('welcome.message') }}',
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#welcome-message').text(response);
                },
                error: function(xhr, status, error) {
                    $('#welcome-message').text('Error al cargar el mensaje');
                }
            });
        });
    </script>

    <!-- Scripts existentes -->
    <script src="{{ asset('js/usuario/main.js') }}"></script>
    <script src="{{ asset('js/usuario/map.js') }}"></script>
    <script src="{{ asset('js/usuario/chat.js') }}"></script>
    <script src="{{ asset('js/usuario/portafolio.js') }}"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>