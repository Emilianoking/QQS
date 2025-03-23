// Cargar la tabla de rangos al iniciar la página
document.addEventListener('DOMContentLoaded', function () {
    loadResultados();
});

// Función para cargar la tabla de rangos
function loadResultados() {
    fetch('/resultados', {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('resultadoTable').innerHTML = data;
    })
    .catch(error => {
        console.error('Error al cargar los rangos:', error);
        document.getElementById('resultadoTable').innerHTML = 'Error al cargar los rangos.';
    });
}

// Manejar el formulario para agregar un nuevo rango
const formResultado = document.getElementById('formResultado');
formResultado.addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(formResultado);
    const data = Object.fromEntries(formData);

    fetch('/resultados/store', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => response.text())
    .then(result => {
        document.getElementById('mensajeResultado').innerHTML = result;
        formResultado.reset();
        loadResultados(); // Recargar la tabla
    })
    .catch(error => {
        document.getElementById('mensajeResultado').innerHTML = 'Error al guardar el rango: ' + error.message;
    });
});

// Mostrar el modal para actualizar un rango
function showUpdateResultadoModal(id, rangoMin, rangoMax, carreraRecomendada, descripcion) {
    document.getElementById('resultadoId').value = id;
    document.getElementById('resultadoRangoMin').value = rangoMin;
    document.getElementById('resultadoRangoMax').value = rangoMax;
    document.getElementById('resultadoCarreraRecomendada').value = carreraRecomendada;
    document.getElementById('resultadoDescripcion').value = descripcion;

    document.getElementById('updateResultadoModal').style.display = 'block';
}

// Cerrar el modal de actualización
function closeResultadoModal() {
    document.getElementById('updateResultadoModal').style.display = 'none';
}

// Manejar el formulario para actualizar un rango
const updateResultadoForm = document.getElementById('updateResultadoForm');
updateResultadoForm.addEventListener('submit', function (e) {
    e.preventDefault();

    const id = document.getElementById('resultadoId').value;
    const data = {
        rango_min: document.getElementById('resultadoRangoMin').value,
        rango_max: document.getElementById('resultadoRangoMax').value,
        carrera_recomendada: document.getElementById('resultadoCarreraRecomendada').value,
        descripcion: document.getElementById('resultadoDescripcion').value
    };

    fetch(`/resultados/update/${id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => response.text())
    .then(result => {
        document.getElementById('resultadoTable').innerHTML = result;
        closeResultadoModal();
    })
    .catch(error => {
        console.error('Error al actualizar el rango:', error);
        alert('Error al actualizar el rango');
    });
});

// Eliminar un rango
function deleteResultado(id) {
    if (confirm('¿Estás seguro de que deseas eliminar este rango?')) {
        fetch(`/resultados/delete/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.text())
        .then(result => {
            document.getElementById('resultadoTable').innerHTML = result;
        })
        .catch(error => {
            console.error('Error al eliminar el rango:', error);
            alert('Error al eliminar el rango');
        });
    }
}