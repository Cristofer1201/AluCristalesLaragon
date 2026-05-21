$(document).ready(function () {
    
    // Manejar el clic en el botón de editar
    $('#tabla-usuarios').on('click', '.btn-modificar', function() {
        var editUrl1 = $(this).data('url1');
        var editUrl2 = $(this).data('url2');

        $('#formEditarUsuario').attr('action', editUrl2);

        // Hacer una petición AJAX para obtener los datos del usuario
        $.ajax({
            url: editUrl1,
            type: 'GET',
            success: function(data) {
                $('#edit_name').val(data.name);
                $('#edit_email').val(data.email);
                $('#edit_role').val(data.role_id);
                $('#edit_tienda').val(data.tienda || '');

                $('#modalEditarUsuario').modal('show');
            }
        });
    });
    
});

$(document).ready(function() {
    // Maneja el evento de clic en los botones específicos para abrir el modal
    $('#tabla-usuarios').on('click', '.btn-eliminar', function() {
        var userId = $(this).data('user-id');

        $('#formEliminarUsuario').attr('action', '/dashboard/usuarios/' + userId);
    });
});

$(document).ready(function() {
    // Maneja el evento de clic en los botones específicos para abrir el modal
    $('#tabla-usuarios').on('click', '.btn-habilitar', function() {
        var userId = $(this).data('user-id');
        var isEnabled = $(this).data('is-enabled');
        var modalTarget = $(this).data('target'); // si llegase a ser necesario

        // Actualiza el texto del modal
        var modalTitle = isEnabled ? '¿Quieres deshabilitar al usuario?' : '¿Quieres habilitar al usuario?';
        $('#modalLabelHabilitar').text(modalTitle);

        // Actualiza la acción del formulario
        $('#formHabilitarUsuario').attr('action', '/dashboard/usuarios/' + userId + '/enabled');
    });
});

// Example starter JavaScript for disabling form submissions if there are invalid fields
(function () {
    'use strict';
    window.addEventListener('load', function () {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

function fnLimpiarUsuario() {
    document.getElementById('formGuardarUsuario').reset();
    document.getElementById('formEditarUsuario').reset();
}

$(document).ready(function() {
    $('#tabla-usuarios').DataTable({
        "order": []  // No aplicar ningún orden por defecto
    });
});