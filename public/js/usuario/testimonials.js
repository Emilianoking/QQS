// Cargar las carreras recomendadas al iniciar la página
document.addEventListener('DOMContentLoaded', function () {
    fetch('/recommended-careers', { credentials: 'include' })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error ${response.status}: No se pudo cargar las carreras recomendadas`);
            }
            return response.json();
        })
        .then(careers => {
            renderTestimonials(careers);
        })
        .catch(error => {
            console.error('Error al cargar las carreras recomendadas:', error);
            const testimonialsList = document.getElementById('testimonialsList');
            testimonialsList.innerHTML = '<li>Error al cargar las carreras recomendadas.</li>';
        });

    // Configurar el modal
    setupModal();
});

// Renderizar las carreras recomendadas en "Testimonials" (máximo 4)
function renderTestimonials(careers) {
    const testimonialsList = document.getElementById('testimonialsList');
    testimonialsList.innerHTML = ''; // Limpiar la lista

    if (careers.message) {
        testimonialsList.innerHTML = `<li>${careers.message}</li>`;
        return;
    }

    // Obtener el nombre del usuario desde el DOM
    const userName = document.querySelector('.name').textContent || 'Usuario';

    // Limitar a 4 carreras
    const limitedCareers = careers.slice(0, 4);

    limitedCareers.forEach(career => {
        const li = document.createElement('li');
        li.className = 'testimonials-item';

        li.innerHTML = `
            <div class="content-card" data-testimonials-item data-nombre="${career.nombre}" data-descripcion="${career.descripcion}" data-universidad="${career.universidad}">
                <figure class="testimonials-avatar-box">
                    <img src="https://i.postimg.cc/zGDHfn3G/avatar-1.png" alt="${career.nombre}" data-testimonials-avatar width="60">
                </figure>
                <h4 class="h4 testimonials-item-title" data-testimonials-title>${career.nombre}</h4>
                <div class="testimonials-text" data-testimonials-text>
                    <p>${userName}, esta carrera es ${career.descripcion}</p>
                </div>
            </div>
        `;

        testimonialsList.appendChild(li);
    });
}

// Configurar el modal
function setupModal() {
    const modalContainer = document.querySelector('[data-modal-container]');
    const modalCloseBtn = document.querySelector('[data-modal-close-btn]');
    const overlay = document.querySelector('[data-overlay]');

    const modalTitle = document.querySelector('[data-modal-title]');
    const modalText = document.querySelector('[data-modal-text]');
    const modalUniversity = document.querySelector('[data-modal-university]');

    const closeModal = () => {
        modalContainer.classList.remove('active');
        overlay.classList.remove('active');
    };

    modalCloseBtn.addEventListener('click', closeModal);
    overlay.addEventListener('click', closeModal);

    // Añadir evento a cada tarjeta para abrir el modal
    document.addEventListener('click', (e) => {
        const testimonialsItem = e.target.closest('[data-testimonials-item]');
        if (testimonialsItem) {
            modalContainer.classList.add('active');
            overlay.classList.add('active');

            const nombre = testimonialsItem.getAttribute('data-nombre');
            const descripcion = testimonialsItem.getAttribute('data-descripcion');
            const universidad = testimonialsItem.getAttribute('data-universidad');

            modalTitle.textContent = nombre;
            modalText.textContent = descripcion;
            modalUniversity.textContent = universidad;
        }
    });
}