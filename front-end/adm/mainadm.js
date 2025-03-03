'use strict';

// Opening or closing sidebar
const elementToggleFunc = function (elem) { elem.classList.toggle("active"); }
const sidebar = document.querySelector("[data-sidebar]");
const sidebarBtn = document.querySelector("[data-sidebar-btn]");
sidebarBtn.addEventListener("click", function() { elementToggleFunc(sidebar); });

// Cargar la tabla de usuarios
fetch('../../back-end/get_users.php')
    .then(response => response.text())
    .then(data => document.getElementById('userTable').innerHTML = data)
    .catch(error => console.error('Error:', error));

// Mostrar modal con datos del usuario
function showUpdateModal(id, nombre, email, telefono, grado, avatar, rol) {
    document.getElementById("userId").value = id;
    document.getElementById("userName").value = nombre;
    document.getElementById("userEmail").value = email;
    document.getElementById("userPhone").value = telefono;
    document.getElementById("userGrade").value = grado;
    document.getElementById("userAvatar").value = avatar;
    document.getElementById("userRole").value = rol;
    document.getElementById("updateModal").style.display = "block";
}

function closeModal() {
    document.getElementById("updateModal").style.display = "none";
}

// Enviar actualización de usuario
document.getElementById("updateForm").onsubmit = function (event) {
    event.preventDefault();
    let formData = new FormData();
    formData.append("id", document.getElementById("userId").value);
    formData.append("nombre", document.getElementById("userName").value);
    formData.append("email", document.getElementById("userEmail").value);
    formData.append("telefono", document.getElementById("userPhone").value);
    formData.append("grado", document.getElementById("userGrade").value);
    formData.append("avatar", document.getElementById("userAvatar").value);
    formData.append("rol", document.getElementById("userRole").value);

    fetch("../../back-end/update_user.php", { method: "POST", body: formData })
        .then(response => response.text())
        .then(data => {
            alert(data);
            closeModal();
            location.reload();
        });
};

// Eliminar usuario
function deleteUser(id) {
    if (confirm("¿Seguro que deseas eliminar este usuario?")) {
        let formData = new FormData();
        formData.append("id", id);

        fetch("../../back-end/delete_user.php", { method: "POST", body: formData })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload();
            });
    }
}

// Cargar la tabla de preguntas
fetch('../../back-end/test/get_questions.php')
    .then(response => response.text())
    .then(data => document.getElementById('questionTable').innerHTML = data)
    .catch(error => console.error('Error al cargar preguntas:', error));

// Mostrar modal con datos de la pregunta
function showUpdateQuestionModal(id, texto, categoria, estado, respuestas_json) {
    document.getElementById("questionId").value = id;
    document.getElementById("questionText").value = texto;
    document.getElementById("questionCategory").value = categoria === 'null' ? '' : categoria;
    document.getElementById("questionStatus").value = estado;

    // Parsear las respuestas desde JSON
    let respuestas = JSON.parse(respuestas_json);
    let answersContainer = document.getElementById("updateQuestionAnswers");
    answersContainer.innerHTML = ''; // Limpiar el contenedor

    // Generar campos para las respuestas
    respuestas.forEach((respuesta, index) => {
        answersContainer.innerHTML += `
            <div class="answer-row">
                <label>Respuesta ${index + 1}:</label>
                <input type="text" name="respuestas[]" value="${respuesta.texto}" required>
                <label>Valor:</label>
                <input type="number" name="valores[]" value="${respuesta.valor}" required>
            </div>
        `;
    });

    document.getElementById("updateQuestionModal").style.display = "block";
}

function closeQuestionModal() {
    document.getElementById("updateQuestionModal").style.display = "none";
}

// Enviar actualización de pregunta
document.getElementById("updateQuestionForm").onsubmit = function (event) {
    event.preventDefault();
    let formData = new FormData();
    formData.append("id", document.getElementById("questionId").value);
    formData.append("texto", document.getElementById("questionText").value);
    formData.append("categoria", document.getElementById("questionCategory").value);
    formData.append("estado", document.getElementById("questionStatus").value);

    // Obtener respuestas y valores dinámicamente
    let respuestas = document.getElementsByName("respuestas[]");
    let valores = document.getElementsByName("valores[]");
    for (let i = 0; i < respuestas.length; i++) {
        formData.append("respuestas[]", respuestas[i].value);
        formData.append("valores[]", valores[i].value);
    }

    fetch("../../back-end/test/update_question.php", { method: "POST", body: formData })
        .then(response => response.text())
        .then(data => {
            alert(data);
            closeQuestionModal();
            location.reload();
        });
};

// Eliminar pregunta
function deleteQuestion(id) {
    if (confirm("¿Seguro que deseas eliminar esta pregunta?")) {
        let formData = new FormData();
        formData.append("id", id);

        fetch("../../back-end/test/delete_question.php", { method: "POST", body: formData })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload();
            });
    }
}