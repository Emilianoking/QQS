// Variable global para almacenar las preguntas
let questionsData = [];

// Cargar las preguntas al iniciar la página
document.addEventListener('DOMContentLoaded', function () {
    fetch('/blog-questions', { credentials: 'include' })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error ${response.status}: No se pudo cargar las preguntas`);
            }
            return response.json();
        })
        .then(questions => {
            questionsData = questions;
            renderQuestions(questions);
            initBlogModal();
        })
        .catch(error => {
            console.error('Error al cargar las preguntas:', error);
            const blogList = document.getElementById('blogPostsList');
            blogList.innerHTML = '<li>Error al cargar las preguntas. Por favor, intenta de nuevo más tarde.</li>';
        });
});

// Renderizar las preguntas en la sección "Blog"
function renderQuestions(questions) {
    const blogList = document.getElementById('blogPostsList');
    blogList.innerHTML = ''; // Limpiar la lista

    if (questions.message) {
        blogList.innerHTML = `<li>${questions.message}</li>`;
        return;
    }

    questions.forEach(question => {
        const li = document.createElement('li');
        li.className = 'blog-post-item';
        li.setAttribute('data-blog-id', question.id);

        li.innerHTML = `
            <a href="#" class="blog-post-link">
                <div class="blog-content">
                    <div class="blog-meta">
                        <p class="blog-category">${question.categoria || 'Sin categoría'}</p>
                    </div>
                    <h3 class="h3 blog-item-title">${question.texto}</h3>
                </div>
            </a>
        `;

        blogList.appendChild(li);
    });
}

// Inicializar el modal de detalles de la pregunta
function initBlogModal() {
    const blogItems = document.querySelectorAll('.blog-post-item');
    const modal = document.getElementById('blogModal');
    const modalClose = document.getElementById('blogModalClose');
    const overlay = document.getElementById('blogOverlay');

    const modalQuestionText = document.getElementById('blogQuestionText');
    const optionsContainer = document.getElementById('optionsButtons');

    // Depuración: Verificar que los elementos existan
    console.log('Modal:', modal);
    console.log('Modal Close:', modalClose);
    console.log('Overlay:', overlay);

    const toggleModal = () => {
        console.log('Toggling modal...');
        if (modal && overlay) {
            modal.classList.toggle('active');
            overlay.classList.toggle('active');
        } else {
            console.error('No se puede alternar el modal: modal o overlay no encontrados');
        }
    };

    blogItems.forEach(item => {
        item.addEventListener('click', (e) => {
            e.preventDefault();
            const blogId = item.getAttribute('data-blog-id');
            const question = questionsData.find(q => q.id == blogId);
            if (question) {
                modalQuestionText.textContent = question.texto;

                // Limpiar y cargar las opciones de respuesta
                optionsContainer.innerHTML = '';
                question.respuestas.forEach(respuesta => {
                    const btn = document.createElement('button');
                    btn.className = 'option-btn';
                    btn.setAttribute('data-respuesta-id', respuesta.id);
                    btn.textContent = respuesta.texto;
                    optionsContainer.appendChild(btn);
                });

                // Añadir eventos a los botones de opciones
                const optionButtons = optionsContainer.querySelectorAll('.option-btn');
                optionButtons.forEach(btn => {
                    btn.addEventListener('click', () => {
                        // Resaltar el botón seleccionado
                        optionButtons.forEach(button => button.classList.remove('selected'));
                        btn.classList.add('selected');

                        const respuestaId = btn.getAttribute('data-respuesta-id');
                        console.log(`Opción seleccionada: ${btn.textContent} (ID: ${respuestaId})`);

                        // Guardar la respuesta del usuario
                        fetch('/user-responses', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                pregunta_id: question.id,
                                respuesta_id: respuestaId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log(data.message || data.error);
                            toggleModal();
                        })
                        .catch(error => {
                            console.error('Error al guardar la respuesta:', error);
                        });
                    });
                });

                toggleModal();
            }
        });
    });

    if (modalClose) {
        modalClose.addEventListener('click', (e) => {
            e.stopPropagation();
            console.log('Clic en botón de cerrar');
            toggleModal();
        });
    } else {
        console.error('Botón de cerrar no encontrado');
    }

    if (overlay) {
        overlay.addEventListener('click', () => {
            console.log('Clic en overlay');
            toggleModal();
        });
    } else {
        console.error('Overlay no encontrado');
    }
}