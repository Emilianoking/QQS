<?php
session_start();
require '../back-end/conexion.php'; 
if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['usuario'] = 'Invitado';
    $_SESSION['email'] = 'No disponible';
    $_SESSION['telefono'] = 'No disponible';
    $_SESSION['grado'] = 'No definido';
    $_SESSION['avatar'] = $usuario['avatar'] ?? "https://i.postimg.cc/JzBWVhW4/my-avatar.png";
} else {
    $usuario_id = $_SESSION['usuario_id'];
    $sql = "SELECT nombre, email, telefono, grado, avatar FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql); 
    $stmt->bindParam(1, $usuario_id, PDO::PARAM_INT); 
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        $_SESSION['usuario'] = $usuario['nombre'];
        $_SESSION['email'] = $usuario['email'];
        $_SESSION['telefono'] = $usuario['telefono'];
        $_SESSION['grado'] = $usuario['grado'];
        $_SESSION['avatar'] = $usuario['avatar'] ?? "https://i.postimg.cc/JzBWVhW4/my-avatar.png"; 
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Portfolio</title>
    <link rel="stylesheet" href="style.css">
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
                    <span>Informacion personal</span>
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
            <nav class="navbar">
                <ul class="navbar-list">
                    <li class="navbar-item"><button class="navbar-link active" data-nav-link>About</button></li>
                    <li class="navbar-item"><button class="navbar-link" data-nav-link>Resume</button></li>
                    <li class="navbar-item"><button class="navbar-link" data-nav-link>Portfolio</button></li>
                    <li class="navbar-item"><button class="navbar-link" data-nav-link>Blog</button></li>
                    <li class="navbar-item"><button class="navbar-link" data-nav-link>Contact</button></li>
                </ul>
            </nav>

            <article class="about active" data-page="about">
                <header>
                    <h2 class="h2 article-title">Bienvenido</h2>
                </header>

                <section class="about-text">
                    <p>I'm Creative Director and UI/UX Designer from Sydney, Australia, working in web development and
                        print media. I enjoy turning complex problems into simple, beautiful and intuitive designs.</p>
                    <p>My job is to build your website so that it is functional and user-friendly but at the same time
                        attractive. Moreover, I add personal touch to your product and make sure that is eye-catching
                        and easy to use. My aim is to bring across your message and identity in the most creative way. I
                        created web design for many famous brand companies.</p>
                </section>



                <section class="testimonials">
                    <h3 class="h3 testimonials-title">Testimonials</h3>

                    <ul class="testimonials-list has-scrollbar">
                        <li class="testimonials-item">
                            <div class="content-card" data-testimonials-item>
                                <figure class="testimonials-avatar-box">
                                    <img src="https://i.postimg.cc/zGDHfn3G/avatar-1.png" alt="avatar"
                                        data-testimonials-avatar width="60">
                                </figure>

                                <h4 class="h4 testimonials-item-title" data-testimonials-title>Daniel Lewis</h4>

                                <div class="testimonials-text" data-testimonials-text>
                                    <p>Richard was hired to create a corporate identity. It's modern, clean and with a
                                        beautiful design that got a lot of praises from colleagues and visitors. We were
                                        very pleased with the work done. He has a lot of experience and is very
                                        concerned about the needs of client.</p>
                                </div>
                            </div>
                        </li>

                        <li class="testimonials-item">
                            <div class="content-card" data-testimonials-item>
                                <figure class="testimonials-avatar-box">
                                    <img src="https://i.postimg.cc/DwY0yHtx/avatar-2.png" alt="avatar"
                                        data-testimonials-avatar width="60">
                                </figure>

                                <h4 class="h4 testimonials-item-title" data-testimonials-title>Jessica Miller</h4>

                                <div class="testimonials-text" data-testimonials-text>
                                    <p>Working with Richard has been an absolute pleasure. I was impressed with his
                                        attention to detail, his web design skills and his professional approach to our
                                        timelines and processes.</p>
                                </div>
                            </div>
                        </li>

                        <li class="testimonials-item">
                            <div class="content-card" data-testimonials-item>
                                <figure class="testimonials-avatar-box">
                                    <img src="https://i.postimg.cc/fRFWhX9F/avatar-3.png" alt="avatar"
                                        data-testimonials-avatar width="60">
                                </figure>

                                <h4 class="h4 testimonials-item-title" data-testimonials-title>Emily Evans</h4>

                                <div class="testimonials-text" data-testimonials-text>
                                    <p>I couldn't be happier with the website that Richard created for us. His attention
                                        to detail and creativity is unmatched. Our clients frequently compliment the
                                        design, and it has significantly improved our brand image.</p>
                                </div>
                            </div>
                        </li>

                        <li class="testimonials-item">
                            <div class="content-card" data-testimonials-item>
                                <figure class="testimonials-avatar-box">
                                    <img src="https://i.postimg.cc/zXv1Xv81/avatar-4.png" alt="avatar"
                                        data-testimonials-avatar width="60">
                                </figure>

                                <h4 class="h4 testimonials-item-title" data-testimonials-title>Henry Williams</h4>

                                <div class="testimonials-text" data-testimonials-text>
                                    <p>I was overwhelmed with the thought of redesigning my online store, but Richard
                                        made the process seamless. The site is not only visually appealing but also
                                        optimized for conversions. I've seen a 50% increase in traffic since the launch!
                                    </p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </section>

                <div class="modal-container " data-modal-container>
                    <div class="overlay " data-overlay></div>

                    <section class="testimonials-modal">
                        <button class="modal-close-btn" data-modal-close-btn><ion-icon
                                name="close-outline"></ion-icon></button>

                        <div class="modal-img-wrapper">
                            <figure class="modal-avatar-box">
                                <img src="https://i.postimg.cc/zGDHfn3G/avatar-1.png" alt="Daniel Lewis" width="80"
                                    data-modal-img>
                            </figure>

                            <img src="https://i.postimg.cc/mZ00RwX7/icon-quote.png" alt="quote icon">
                        </div>

                        <div class="modal-content">
                            <h4 class="h3 modal-title" data-modal-title>Daniel Lewis</h4>
                            <time datetime="2023-06-14">14 June, 2023</time>

                            <div class="modal-text" data-modal-text>
                                <p>Richard was hired to create a corporate identity. It's modern, clean and with a
                                    beautiful design that got a lot of praises from colleagues and visitors. We were
                                    very pleased with the work done. He has a lot of experience and is very concerned
                                    about the needs of client.</p>
                            </div>
                        </div>
                    </section>
                </div>

                <section class="clients">
                    <h3 class="h3 clients-title">Universidades convenio</h3>

                    <ul class="clients-list has-scrollbar">
                        <li class="clients-item">
                            <a href="https://www.uniminuto.edu/oriente" target="_blank">
                                <img src="https://ulibros.com/publisher/ilogo/8a831d50869bd4271f1b20a4a0acf44b"
                                    alt="logo">
                            </a>
                        </li>
                        <li class="clients-item">
                            <a href="https://estudios.unad.edu.co/descuentos-por-convenios-institucionales/municipio-de-acacias-meta" target="_blank">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR-flZjMI0abrc0Lgubyn2hedBQG6Zfppi3jA&s"
                                    alt="logo">
                            </a>
                        </li>
                    </ul>
                </section>

            </article>

            <article class="resume " data-page="resume">
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
                            <p class="timeline-text">There I learnt a wide range of topics that are essential to
                                understanding both the theory and practical aspects of computing. This involves
                                programming fundamentals, computer architecture, operating systems, databases, software
                                engineering, problem solving, collaboration and communication soft skills.</p>
                        </li>

                        <li class="timeline-item">
                            <h4 class="h4 timeline-item-title">New York Academy of Art</h4>
                            <span>2006 - 2007</span>
                            <p class="timeline-text">I chose my master degree in technology. There I deepened my
                                knowledge, enhanced my skills in the area and learnt how to increase my career prospects
                                in a competitive job market.</p>
                        </li>

                        <li class="timeline-item">
                            <h4 class="h4 timeline-item-title">High School of Art and Design</h4>
                            <span>2003 - 2005</span>
                            <p class="timeline-text">There I learnt foundational courses and computer sciences
                                fundamentals. In the institution, I chose my specialization in web-development that
                                involves front-end and back-end technologies, user interface designs and content
                                management systems.</p>
                        </li>
                    </ol>
                </section>

                <section class="timeline">
                    <div class="title-wrapper">
                        <div class="icon-box"><ion-icon name="book-outline"></ion-icon></div>

                        <h3 class="h3">Experience</h3>
                    </div>

                    <ol class="timeline-list">
                        <li class="timeline-item">
                            <h4 class="h4 timeline-item-title">Creative director</h4>
                            <span>2015 - Present</span>
                            <p class="timeline-text">I can develop and oversee creative concepts for projects and
                                campaigns managing a team of designers, writers, and other creative professionals.</p>
                        </li>

                        <li class="timeline-item">
                            <h4 class="h4 timeline-item-title">Art director</h4>
                            <span>2013 - 2015</span>
                            <p class="timeline-text">I create and develop visual concepts that align with the project's
                                goals and objectives, supervising the design process and managing timelines and budgets
                                for design projects.</p>
                        </li>

                        <li class="timeline-item">
                            <h4 class="h4 timeline-item-title">Web designer</h4>
                            <span>2010 - 2013</span>
                            <p class="timeline-text">I create logos, color schemes and typography for a brand's
                                identity. Also I develop graphics for websites, social media and digital ads with
                                applications that enhance user experience.</p>
                        </li>
                    </ol>
                </section>

                <section class="skill">
                    <h3 class="h3 skills-title">My Skills</h3>

                    <ul class="skills-list content-card">
                        <li class="skills-item">
                            <div class="title-wrapper">
                                <h5 class="h5">Web Design</h5>
                                <data value="80">80%</data>
                            </div>

                            <div class="skills-progress-bg">
                                <div class="skills-progress-fill" style="width: 80%;"></div>
                            </div>
                        </li>

                        <li class="skills-item">
                            <div class="title-wrapper">
                                <h5 class="h5">Graphic Design</h5>
                                <data value="70">70%</data>
                            </div>

                            <div class="skills-progress-bg">
                                <div class="skills-progress-fill" style="width: 70%;"></div>
                            </div>
                        </li>

                        <li class="skills-item">
                            <div class="title-wrapper">
                                <h5 class="h5">Branding</h5>
                                <data value="90">90%</data>
                            </div>

                            <div class="skills-progress-bg">
                                <div class="skills-progress-fill" style="width: 90%;"></div>
                            </div>
                        </li>

                        <li class="skills-item">
                            <div class="title-wrapper">
                                <h5 class="h5">WordPress</h5>
                                <data value="50">50%</data>
                            </div>

                            <div class="skills-progress-bg">
                                <div class="skills-progress-fill" style="width: 50%;"></div>
                            </div>
                        </li>
                    </ul>
                </section>
            </article>

            <article class="portfolio " data-page="portfolio">
                <header>
                    <h2 class="h2 article-title">Portfolio</h2>
                </header>

                <section class="projects">
                    <ul class="filter-list">
                        <li class="filter-item"><button class="active" data-filter-btn>All</button></li>
                        <li class="filter-item"><button data-filter-btn>Web Design</button></li>
                        <li class="filter-item"><button data-filter-btn>Applications</button></li>
                        <li class="filter-item"><button data-filter-btn>Web Development</button></li>
                    </ul>

                    <div class="filter-select-box">
                        <button class="filter-select " data-select>
                            <div class="select-value" data-select-value>Select Category</div>

                            <div class="select-icon">
                                <ion-icon name="chevron-down"></ion-icon>
                            </div>
                        </button>

                        <ul class="select-list">
                            <li class="select-item"><button data-select-item>All</button></li>
                            <li class="select-item"><button data-select-item>Web Design</button></li>
                            <li class="select-item"><button data-select-item>Applications</button></li>
                            <li class="select-item"><button data-select-item>Web Development</button></li>
                        </ul>
                    </div>

                    <ul class="project-list">
                        <li class="project-item active" data-filter-item data-category="web development">
                            <a href="#">
                                <figure class="project-img">
                                    <div class="project-item-icon-box">
                                        <ion-icon name="eye-outline"></ion-icon>
                                    </div>

                                    <img src="https://i.postimg.cc/qRHpHMyd/project-1.jpg" alt="finance" loading="lazy">
                                </figure>

                                <h3 class="project-title">Finance</h3>
                                <p class="project-category">Web Development</p>
                            </a>
                        </li>

                        <li class="project-item active" data-filter-item data-category="web development">
                            <a href="#">
                                <figure class="project-img">
                                    <div class="project-item-icon-box">
                                        <ion-icon name="eye-outline"></ion-icon>
                                    </div>

                                    <img src="https://i.postimg.cc/bNrcM2Wt/project-2.png" alt="orizon" loading="lazy">
                                </figure>

                                <h3 class="project-title">Orizon</h3>
                                <p class="project-category">Web Development</p>
                            </a>
                        </li>

                        <li class="project-item active" data-filter-item data-category="web design">
                            <a href="#">
                                <figure class="project-img">
                                    <div class="project-item-icon-box">
                                        <ion-icon name="eye-outline"></ion-icon>
                                    </div>

                                    <img src="https://i.postimg.cc/jSJVqYsq/project-3.jpg" alt="fundo" loading="lazy">
                                </figure>

                                <h3 class="project-title">Fundo</h3>
                                <p class="project-category">Web Design</p>
                            </a>
                        </li>

                        <li class="project-item active" data-filter-item data-category="applications">
                            <a href="#">
                                <figure class="project-img">
                                    <div class="project-item-icon-box">
                                        <ion-icon name="eye-outline"></ion-icon>
                                    </div>

                                    <img src="https://i.postimg.cc/dtpXxNGb/project-4.png" alt="brawlhalla"
                                        loading="lazy">
                                </figure>

                                <h3 class="project-title">Brawlhalla</h3>
                                <p class="project-category">Applications</p>
                            </a>
                        </li>

                        <li class="project-item active" data-filter-item data-category="web design">
                            <a href="#">
                                <figure class="project-img">
                                    <div class="project-item-icon-box">
                                        <ion-icon name="eye-outline"></ion-icon>
                                    </div>

                                    <img src="https://i.postimg.cc/43T0JKLw/project-5.png" alt="dsm." loading="lazy">
                                </figure>

                                <h3 class="project-title">DSM.</h3>
                                <p class="project-category">Web Design</p>
                            </a>
                        </li>

                        <li class="project-item active" data-filter-item data-category="web design">
                            <a href="#">
                                <figure class="project-img">
                                    <div class="project-item-icon-box">
                                        <ion-icon name="eye-outline"></ion-icon>
                                    </div>

                                    <img src="https://i.postimg.cc/qR1DX1kZ/project-6.png" alt="metaspark"
                                        loading="lazy">
                                </figure>

                                <h3 class="project-title">Metaspark</h3>
                                <p class="project-category">Web Design</p>
                            </a>
                        </li>

                        <li class="project-item active" data-filter-item data-category="web development">
                            <a href="#">
                                <figure class="project-img">
                                    <div class="project-item-icon-box">
                                        <ion-icon name="eye-outline"></ion-icon>
                                    </div>

                                    <img src="https://i.postimg.cc/Kj4q9tjc/project-7.png" alt="summary" loading="lazy">
                                </figure>

                                <h3 class="project-title">Summary</h3>
                                <p class="project-category">Web Development</p>
                            </a>
                        </li>

                        <li class="project-item active" data-filter-item data-category="applications">
                            <a href="#">
                                <figure class="project-img">
                                    <div class="project-item-icon-box">
                                        <ion-icon name="eye-outline"></ion-icon>
                                    </div>

                                    <img src="https://i.postimg.cc/rw2j4B1w/project-8.jpg" alt="task manager"
                                        loading="lazy">
                                </figure>

                                <h3 class="project-title">Task Manager</h3>
                                <p class="project-category">Applications</p>
                            </a>
                        </li>

                        <li class="project-item active" data-filter-item data-category="web development">
                            <a href="#">
                                <figure class="project-img">
                                    <div class="project-item-icon-box">
                                        <ion-icon name="eye-outline"></ion-icon>
                                    </div>

                                    <img src="https://i.postimg.cc/7LxNsSQv/project-9.png" alt="arrival" loading="lazy">
                                </figure>

                                <h3 class="project-title">Arrival</h3>
                                <p class="project-category">Web Development</p>
                            </a>
                        </li>
                    </ul>
                </section>
            </article>

            <article class="blog " data-page="blog">
                <header>
                    <h2 class="h2 article-title">Blog</h2>
                </header>

                <section class="blog-posts">
                    <ul class="blog-posts-list">
                        <li class="blog-post-item">
                            <a href="#">
                                <figure class="blog-banner-box">
                                    <img src="https://i.postimg.cc/DysCZrWs/blog-1.jpg" alt="Design conferences in 2024"
                                        loading="lazy">
                                </figure>

                                <div class="blog-content">
                                    <div class="blog-meta">
                                        <p class="blog-category">Design</p>
                                        <span class="dot"></span>
                                        <time datetime="2024-02-23">Feb 23, 2024</time>
                                    </div>

                                    <h3 class="h3 blog-item-title">Design conferences in 2024</h3>
                                    <p class="blog-text">In 2024, several exciting design conferences are set to take
                                        place, offering opportunities for professionals and enthusiasts to connect,
                                        learn, and share innovative ideas.</p>
                                </div>
                            </a>
                        </li>

                        <li class="blog-post-item">
                            <a href="#">
                                <figure class="blog-banner-box">
                                    <img src="https://i.postimg.cc/QC7qFDMs/blog-2.jpg" alt="Best fonts every designer"
                                        loading="lazy">
                                </figure>


                                <div class="blog-content">
                                    <div class="blog-meta">
                                        <p class="blog-category">Design</p>
                                        <span class="dot"></span>
                                        <time datetime="2024-01-29">Jan 29, 2024</time>
                                    </div>

                                    <h3 class="h3 blog-item-title">Best fonts every designer</h3>
                                    <p class="blog-text">When it comes to typography, choosing the right font is
                                        essential for effective design. In this article, I'll bring a brief overview of
                                        some of the best fonts that every designer should consider incorporating into
                                        their toolkit.</p>
                                </div>
                            </a>
                        </li>

                        <li class="blog-post-item">
                            <a href="#">
                                <figure class="blog-banner-box">
                                    <img src="https://i.postimg.cc/W1T71QcL/blog-3.jpg" alt="Design digest #80"
                                        loading="lazy">
                                </figure>

                                <div class="blog-content">
                                    <div class="blog-meta">
                                        <p class="blog-category">Design</p>
                                        <span class="dot"></span>
                                        <time datetime="2023-12-20">Dec 20, 2023</time>
                                    </div>

                                    <h3 class="h3 blog-item-title">Design digest #80</h3>
                                    <p class="blog-text">Hello, my friends. In this Design Digest, I'll show you a
                                        curated collection of the latest trends, insights, and innovations in the design
                                        world. This edition highlights key themes and discussions that are shaping the
                                        future of design.</p>
                                </div>
                            </a>
                        </li>

                        <li class="blog-post-item">
                            <a href="#">
                                <figure class="blog-banner-box">
                                    <img src="https://i.postimg.cc/2S0n8yxh/blog-4.jpg" alt="2023 UI interactions"
                                        loading="lazy">
                                </figure>

                                <div class="blog-content">
                                    <div class="blog-meta">
                                        <p class="blog-category">Design</p>
                                        <span class="dot"></span>
                                        <time datetime="2023-11-29">Nov 29, 2023</time>
                                    </div>

                                    <h3 class="h3 blog-item-title">2023 UI interactions</h3>
                                    <p class="blog-text">As we move into 2024, 2023 was marked by the rapidly evolution
                                        of the landscape of UI interactions, driven by advancements in technology and
                                        user expectations. Dive with me in this text to see the main areas changed in
                                        this year.</p>
                                </div>
                            </a>
                        </li>

                        <li class="blog-post-item">
                            <a href="#">
                                <figure class="blog-banner-box">
                                    <img src="https://i.postimg.cc/YCCmVkw9/blog-5.jpg"
                                        alt="The forgotten art of spacing" loading="lazy">
                                </figure>

                                <div class="blog-content">
                                    <div class="blog-meta">
                                        <p class="blog-category">Design</p>
                                        <span class="dot"></span>
                                        <time datetime="2023-11-12">Nov 12, 2023</time>
                                    </div>

                                    <h3 class="h3 blog-item-title">The forgotten art of spacing</h3>
                                    <p class="blog-text">In the realm of design, spacing is often an overlooked yet
                                        crucial element that can significantly impact the overall aesthetic and
                                        functionality of a composition. This post will emphasize the importance of white
                                        space, margins, and padding in creating visually appealing and effective
                                        designs.</p>
                                </div>
                            </a>
                        </li>

                        <li class="blog-post-item">
                            <a href="#">
                                <figure class="blog-banner-box">
                                    <img src="https://i.postimg.cc/zBCBvP16/blog-6.jpg" alt="Design digest #79"
                                        loading="lazy">
                                </figure>

                                <div class="blog-content">
                                    <div class="blog-meta">
                                        <p class="blog-category">Design</p>
                                        <span class="dot"></span>
                                        <time datetime="2023-10-20">Oct 20, 2023</time>
                                    </div>

                                    <h3 class="h3 blog-item-title">Design digest #79</h3>
                                    <p class="blog-text">Hi, my friends. In this Design Digest I'll focus in the tools
                                        and resources that we use daily in our projects. Also, I'll include examples of
                                        software recommendations, online courses, and design communities that foster
                                        collaboration and learning.</p>
                                </div>
                            </a>
                        </li>
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
                <iframe
                    id="map-iframe"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3986.123456789012!2d-73.6267!3d4.1450!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3f9b5c8d8d8d8d%3A0x1234567890abcdef!2sUniminuto%20Villavicencio%2C%20Meta%2C%20Colombia!5e0!3m2!1sen!2sco!4v1717747200!5m2!1sen!2sco"
                    width="400" height="300" loading="lazy" allowfullscreen="" style="border:0;"></iframe>
            </figure>
        </section>

        <section class="chat-section">
            <h3 class="h3 form-title">Chat with Grok</h3>
            <div class="chat-messages" id="chat-messages"></div>
            <div class="chat-input-container">
                <input type="text" id="chat-input" placeholder="Escribe tu mensaje...">
                <button id="chat-send">Enviar</button>
            </div>
        </section>
    </article>
        </div>
    </main>

    <script src="main.js"></script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>