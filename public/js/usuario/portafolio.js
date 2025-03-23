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
            renderCarreras(carreras);
            initFilter();
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

        li.innerHTML = `
            <a href="#">
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

    // Función para aplicar el filtro
    const applyFilter = (filterValue) => {
        projectItems.forEach(item => {
            const category = item.getAttribute('data-category');
            if (filterValue === 'Todas las carreras' || category === filterValue) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });

        // Actualizar el estado activo de los botones
        filterButtons.forEach(btn => {
            btn.classList.remove('active');
            if (btn.getAttribute('data-filter') === filterValue) {
                btn.classList.add('active');
            }
        });

        // Actualizar el valor del select
        const selectValue = document.querySelector('[data-select-value]');
        selectValue.textContent = filterValue;
    };

    // Evento para los botones de filtro
    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const filterValue = btn.getAttribute('data-filter');
            applyFilter(filterValue);
        });
    });

    // Evento para el select de filtro (móviles)
    filterSelectItems.forEach(item => {
        item.addEventListener('click', () => {
            const filterValue = item.getAttribute('data-filter');
            applyFilter(filterValue);
        });
    });

    // Aplicar filtro por defecto ("Todas las carreras")
    applyFilter('Todas las carreras');
}

// Mostrar/ocultar el select en móviles
const filterSelect = document.querySelector('[data-select]');
const selectList = document.querySelector('.select-list');
filterSelect.addEventListener('click', () => {
    selectList.classList.toggle('active');
});