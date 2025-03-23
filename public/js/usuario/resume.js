// Cargar las últimas respuestas al iniciar la página
document.addEventListener('DOMContentLoaded', function () {
    fetch('/latest-responses', { credentials: 'include' })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error ${response.status}: No se pudo cargar las respuestas`);
            }
            return response.json();
        })
        .then(responses => {
            renderResponses(responses);
        })
        .catch(error => {
            console.error('Error al cargar las respuestas:', error);
            const responsesList = document.getElementById('responsesList');
            responsesList.innerHTML = '<li>Error al cargar las respuestas. Por favor, intenta de nuevo más tarde.</li>';
        });
});

// Renderizar las respuestas en la sección "Resume"
function renderResponses(responses) {
    const responsesList = document.getElementById('responsesList');
    responsesList.innerHTML = ''; // Limpiar la lista

    if (responses.message) {
        responsesList.innerHTML = `<li>${responses.message}</li>`;
        return;
    }

    responses.forEach(response => {
        const li = document.createElement('li');
        li.className = 'timeline-item';

        li.innerHTML = `
            <h4 class="h4 timeline-item-title">${response.pregunta_texto}</h4>
            <span>Respuesta: ${response.respuesta_texto}</span>
        `;

        responsesList.appendChild(li);
    });
}