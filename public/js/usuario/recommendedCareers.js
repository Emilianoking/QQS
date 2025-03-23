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
            renderRecommendedCareers(careers);
        })
        .catch(error => {
            console.error('Error al cargar las carreras recomendadas:', error);
            const careersList = document.getElementById('recommendedCareersList');
            careersList.innerHTML = '<li>Error al cargar las carreras recomendadas. Por favor, intenta de nuevo más tarde.</li>';
        });
});

// Renderizar las carreras recomendadas en la sección
function renderRecommendedCareers(careers) {
    const careersList = document.getElementById('recommendedCareersList');
    careersList.innerHTML = ''; // Limpiar la lista

    if (careers.message) {
        careersList.innerHTML = `<li>${careers.message}</li>`;
        return;
    }

    careers.forEach(career => {
        const li = document.createElement('li');
        li.className = 'timeline-item';

        li.innerHTML = `
            <h4 class="h4 timeline-item-title">${career.nombre}</h4>
            <span>${career.descripcion}</span>
        `;

        careersList.appendChild(li);
    });
}