// Función para guardar un nuevo usuario
function agregarUsuario() {
    if (!validarFormulario()) {
        return; // Si la validación falla, no continuar con la función
    }

    const nombre = document.getElementById('nombre').value;
    const apellidos = document.getElementById('apellidos').value;
    const email = document.getElementById('email').value;
    const telefono = document.getElementById('telefono').value;
    const rol = document.getElementById('rol').value;
    const password = document.getElementById('password').value;

    const nuevoUsuario = {
        nombre: nombre,
        apellidos: apellidos,
        email: email,
        telefono: telefono,
        rol: rol,
        password: password
    };

    fetch('../models/M_Create_User.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(nuevoUsuario)
    })
    .then(response => response.json())
    .then(data => {
        if (data.message === 'Usuario agregado correctamente') {
            // Recargar los usuarios para mostrar el nuevo usuario en la tabla
            cargarUsuarios();
            // Limpiar los campos del formulario
            limpiarFormulario();
            // Cerrar el modal (si existe)
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalAgregarUsuario'));
            if (modal) modal.hide();
        } else {
            console.error('Error al agregar el usuario:', data.error); // Mostrar error exacto
            if (data.message === 'El correo electrónico ingresado ya existe, ingrese otro.') {
                alert('El correo electrónico ingresado ya existe, ingrese otro.');
            } else {
                alert('No se pudo agregar el usuario: ' + data.message);
            }
        }
    })
    .catch(error => {
        console.error('Error en la solicitud:', error);
        alert('Error al intentar agregar el usuario. Intente nuevamente.');
    });
}

let usuarioIdAEliminar = null;  // Variable global para almacenar el ID del usuario a eliminar

// Función para manejar la eliminación de un usuario
function eliminarUsuario(id) {
    // Mostrar el modal de confirmación de eliminación
    const modalEliminar = new bootstrap.Modal(document.getElementById('modalEliminarUsuario'));
    modalEliminar.show();

    // Guardar el ID del usuario que se desea eliminar
    usuarioIdAEliminar = id;
}

// Asignar el ID del usuario a eliminar y eliminarlo cuando el usuario confirme en el modal
document.getElementById('confirmarEliminar').addEventListener('click', function() {
    if (usuarioIdAEliminar) {
        // Realizar la solicitud para eliminar el usuario
        fetch('../models/M_Delete_User.php', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: usuarioIdAEliminar })
        })
        .then(response => response.json())
        .then(data => {
            if (data.message === 'Usuario eliminado correctamente') {
                // Recargar los usuarios para reflejar la eliminación
                cargarUsuarios();
            } else {
                alert('Error al eliminar el usuario: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error en la solicitud de eliminación:', error);
            alert('Error al intentar eliminar el usuario. Intente nuevamente.');
        });
    }
    
    // Cerrar el modal
    const modalEliminar = bootstrap.Modal.getInstance(document.getElementById('modalEliminarUsuario'));
    if (modalEliminar) modalEliminar.hide();
});

// Función para cargar los usuarios al cargar la página
function cargarUsuarios() {
    fetch('../models/M_Create_User.php', {
        method: 'GET'
    })
    .then(response => response.json())
    .then(data => {
        const tableBody = document.getElementById('usuariosTableBody');
        tableBody.innerHTML = ''; // Limpiar la tabla antes de agregar los usuarios

        data.forEach(usuario => {
            const nuevaFila = document.createElement('tr');
            nuevaFila.innerHTML = `
                <td>${usuario.nombre}</td>
                <td>${usuario.apellidos}</td>
                <td>${usuario.correo_electronico}</td>
                <td>${usuario.telefono}</td>
                <td><span class="badge bg-label-primary">${usuario.rol}</span></td>
                <td>
                    <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Editar</a>
                            <a class="dropdown-item" href="javascript:void(0);" onclick="eliminarUsuario(${usuario.id})"><i class="bx bx-trash me-1"></i> Eliminar</a>
                        </div>
                    </div>
                </td>
            `;
            tableBody.appendChild(nuevaFila);
        });
    })
    .catch(error => {
        console.error('Error al cargar los usuarios:', error);
    });
}

// Función para validar los campos del formulario
function validarFormulario() {
    const nombre = document.getElementById('nombre').value;
    const apellidos = document.getElementById('apellidos').value;
    const email = document.getElementById('email').value;
    const telefono = document.getElementById('telefono').value;
    const rol = document.getElementById('rol').value;
    const password = document.getElementById('password').value;

    // Validar campos requeridos
    if (!nombre || !apellidos || !email || !telefono || !rol || !password) {
        alert('Por favor, complete todos los campos.');
        return false;
    }

    // Validar formato del correo electrónico
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!emailPattern.test(email)) {
        alert('Por favor, ingrese un correo electrónico válido.');
        return false;
    }

    // Validar número de teléfono (solo números y 9 dígitos)
    const telefonoPattern = /^\d{9}$/;
    if (!telefonoPattern.test(telefono)) {
        alert('Por favor, ingrese un número de teléfono válido (9 dígitos).');
        return false;
    }

    // Validar contraseña (mínimo 6 caracteres)
    if (password.length < 6) {
        alert('La contraseña debe tener al menos 6 caracteres.');
        return false;
    }

    return true;
}

// Función para limpiar los campos del formulario
function limpiarFormulario() {
    document.getElementById('nombre').value = '';
    document.getElementById('apellidos').value = '';
    document.getElementById('email').value = '';
    document.getElementById('telefono').value = '';
    document.getElementById('rol').value = ''; // Asumiendo que el campo de rol es un dropdown
    document.getElementById('password').value = '';
}

// Llamar a la función para cargar los usuarios al cargar la página
window.onload = cargarUsuarios;

// Asignar la función agregarUsuario al botón de guardar
document.getElementById('guardarUsuario').addEventListener('click', agregarUsuario);

// Agregar un evento para limpiar los campos al cerrar el modal
const modalElement = document.getElementById('modalAgregarUsuario');
const modal = new bootstrap.Modal(modalElement);

// Escuchar el evento 'hidden.bs.modal' para limpiar el formulario cuando el modal se cierra
modalElement.addEventListener('hidden.bs.modal', function () {
    limpiarFormulario(); // Limpiar campos cuando el modal se cierre
});