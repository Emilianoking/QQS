document.addEventListener('DOMContentLoaded', function () {
    fetch('/becas-list', { credentials: 'include' })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error ${response.status}: No se pudo cargar las becas`);
            }
            return response.json();
        })
        .then(becas => {
            renderBecas(becas);
        })
        .catch(error => {
            console.error('Error al cargar las becas:', error);
            const becasList = document.getElementById('becasList');
            becasList.innerHTML = '<li class="timeline-item">Error al cargar las becas.</li>';
        });
});

function renderBecas(becas) {
    const becasList = document.getElementById('becasList');
    becasList.innerHTML = '';

    if (becas.length === 0) {
        becasList.innerHTML = '<li class="timeline-item">No hay becas disponibles en este momento.</li>';
        return;
    }

    // Agrupar becas por entidad
    const becasPorEntidad = becas.reduce((acc, beca) => {
        if (!acc[beca.entidad]) {
            acc[beca.entidad] = [];
        }
        acc[beca.entidad].push(beca);
        return acc;
    }, {});

    // Renderizar cada grupo de becas
    Object.keys(becasPorEntidad).forEach(entidad => {
        const li = document.createElement('li');
        li.className = 'timeline-item';

        let html = `
            <h4 class="h4 timeline-item-title">${entidad}</h4>
        `;

        becasPorEntidad[entidad].forEach(beca => {
            html += `
                <p><strong>${beca.nombre}</strong></p>
                <p>${beca.requisitos}</p>
            `;
        });

        li.innerHTML = html;
        becasList.appendChild(li);
    });
}