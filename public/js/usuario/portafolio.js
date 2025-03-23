// Variable global para almacenar las carreras
let carrerasData = [];

// Portafolio: Cargar y Filtrar Carreras
document.addEventListener('DOMContentLoaded', function () {
    fetch('/portafolio', { credentials: 'include' })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error ${response.status}: No se pudo cargar las carreras`);
            }
            return response.json();
        })
        .then(carreras => {
            carrerasData = carreras;
            renderCarreras(carreras);
            initFilter();
            initModal();
        })
        .catch(error => {
            console.error('Error al cargar las carreras:', error);
            const projectList = document.getElementById('projectList');
            projectList.innerHTML = '<li>Error al cargar las carreras. Por favor, intenta de nuevo más tarde.</li>';
        });
});

// Renderizar las carreras en el portafolio
function renderCarreras(carreras) {
    const projectList = document.getElementById('projectList');
    projectList.innerHTML = ''; // Limpiar la lista

    if (carreras.length === 0) {
        projectList.innerHTML = '<li>No hay carreras disponibles.</li>';
        return;
    }

    carreras.forEach(carrera => {
        const li = document.createElement('li');
        li.className = 'project-item active';
        li.setAttribute('data-filter-item', '');
        li.setAttribute('data-category', carrera.universidad);
        li.setAttribute('data-carrera-id', carrera.id);

        li.innerHTML = `
            <a href="#" class="carrera-card">
                <figure class="project-img">
                    <div class="project-item-icon-box"><ion-icon name="eye-outline"></ion-icon></div>
                    <img src="${carrera.imagen}" alt="${carrera.nombre}" loading="lazy">
                </figure>
                <h3 class="project-title">${carrera.nombre}</h3>
                <p class="project-category">${carrera.universidad}</p>
            </a>
        `;

        projectList.appendChild(li);
    });
}

// Inicializar el filtrado del portafolio
function initFilter() {
    const filterButtons = document.querySelectorAll('[data-filter-btn]');
    const filterSelectItems = document.querySelectorAll('[data-select-item]');
    const projectItems = document.querySelectorAll('[data-filter-item]');

    const applyFilter = (filterValue) => {
        projectItems.forEach(item => {
            const category = item.getAttribute('data-category');
            if (filterValue === 'Todas las carreras' || category === filterValue) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });

        filterButtons.forEach(btn => {
            btn.classList.remove('active');
            if (btn.getAttribute('data-filter') === filterValue) {
                btn.classList.add('active');
            }
        });

        const selectValue = document.querySelector('[data-select-value]');
        selectValue.textContent = filterValue;
    };

    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const filterValue = btn.getAttribute('data-filter');
            applyFilter(filterValue);
        });
    });

    filterSelectItems.forEach(item => {
        item.addEventListener('click', () => {
            const filterValue = item.getAttribute('data-filter');
            applyFilter(filterValue);
        });
    });

    applyFilter('Todas las carreras');
}

// Mostrar/ocultar el select en móviles
const filterSelect = document.querySelector('[data-select]');
const selectList = document.querySelector('.select-list');
if (filterSelect) {
    filterSelect.addEventListener('click', () => {
        selectList.classList.toggle('active');
    });
}

// Inicializar el modal de detalles de la carrera
function initModal() {
    const projectItems = document.querySelectorAll('[data-filter-item]');
    const modal = document.getElementById('carreraModal');
    const modalClose = document.getElementById('carreraModalClose');
    const overlay = document.getElementById('carreraOverlay');

    const modalNombre = document.getElementById('carreraNombre');
    const modalUniversidad = document.getElementById('carreraUniversidad');
    const modalNivelEducativo = document.getElementById('carreraNivelEducativo');
    const modalDescripcion = document.getElementById('carreraDescripcion');
    const modalLink = document.getElementById('carreraLink');
    const modalChatLink = document.getElementById('carreraChatLink');

    // Depuración: Verificar que los elementos existan
    console.log('Modal:', modal);
    console.log('Modal Close:', modalClose);
    console.log('Overlay:', overlay);
    console.log('Chat Link:', modalChatLink);

    const toggleModal = () => {
        console.log('Toggling modal...');
        if (modal && overlay) {
            modal.classList.toggle('active');
            overlay.classList.toggle('active');
        } else {
            console.error('No se puede alternar el modal: modal o overlay no encontrados');
        }
    };

    projectItems.forEach(item => {
        item.addEventListener('click', (e) => {
            e.preventDefault();
            const carreraId = item.getAttribute('data-carrera-id');
            const carrera = carrerasData.find(c => c.id == carreraId);
            if (carrera) {
                modalNombre.textContent = carrera.nombre;
                modalUniversidad.textContent = carrera.universidad || 'Sin universidad';
                modalNivelEducativo.textContent = carrera.nivel_educativo || 'Sin nivel educativo';
                modalDescripcion.textContent = carrera.descripcion || 'Sin descripción';

                // Establecer el enlace "Conoce más de la carrera" según la universidad
                if (carrera.universidad && carrera.universidad.toLowerCase() === 'uniminuto') {
                    modalLink.href = 'https://www.uniminuto.edu/oriente';
                    modalLink.target = '_blank'; // Abrir en una nueva pestaña
                    modalLink.style.display = 'inline-block';
                } else if (carrera.universidad && carrera.universidad.toLowerCase() === 'unad') {
                    modalLink.href = 'https://estudios.unad.edu.co/';
                    modalLink.target = '_blank'; // Abrir en una nueva pestaña
                    modalLink.style.display = 'inline-block';
                } else {
                    modalLink.href = '#';
                    modalLink.style.display = 'none';
                }

                // Configurar el enlace "Quieres charlar sobre el tema?"
                if (modalChatLink) {
                    modalChatLink.addEventListener('click', (e) => {
                        e.preventDefault();
                        console.log('Clic en enlace de chat');

                        // Ajustar el selector para buscar el botón cuyo texto sea "Contact"
                        const chatSection = document.querySelector('article[data-page="contact"]');
                        const chatInput = document.querySelector('#chat-input');
                        const navLink = Array.from(document.querySelectorAll('button[data-nav-link]'))
                            .find(btn => btn.innerHTML.toLowerCase() === 'contact');

                        // Depuración: Verificar cada elemento
                        console.log('chatSection:', chatSection);
                        console.log('chatInput:', chatInput);
                        console.log('navLink:', navLink);

                        if (chatSection && chatInput && navLink) {
                            // Cerrar el modal
                            toggleModal();

                            // Simular un clic en el enlace de navegación "Contact" para activar la pestaña
                            navLink.click();

                            // Desplazarse a la sección de chat y predefinir el mensaje
                            setTimeout(() => {
                                chatSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                chatInput.value = `Quiero saber más sobre ${carrera.nombre} en ${carrera.universidad}. ¿Qué me puedes contar?`;
                                chatInput.focus(); // Enfocar el campo de entrada
                            }, 300); // Retraso para evitar conflicto con window.scrollTo(0, 0)
                        } else {
                            console.error('Sección de chat, campo de entrada o enlace de navegación no encontrados');
                        }
                    });
                } else {
                    console.error('Enlace de chat no encontrado');
                }

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