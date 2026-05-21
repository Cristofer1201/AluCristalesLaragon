
$(document).ready(function () {

    // Vista previa de imagen al crear
    $('#imagen').on('change', function() {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagen-preview-crear img').attr('src', e.target.result);
                $('#imagen-preview-crear').show();
            };
            reader.readAsDataURL(file);
        } else {
            $('#imagen-preview-crear').hide();
        }
    });

    // Vista previa de imagen al editar
    $('#edit_imagen').on('change', function() {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagen-preview-editar img').attr('src', e.target.result);
                $('#imagen-preview-editar').show();
            };
            reader.readAsDataURL(file);
        } else {
            $('#imagen-preview-editar').hide();
        }
    });

});

// Bootstrap validation
(function () {
    'use strict';
    window.addEventListener('load', function () {
        var forms = document.getElementsByClassName('needs-validation');
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

function fnLimpiarProducto() {
    document.getElementById('formGuardarProducto').reset();
    $('#imagen-preview-crear').hide();
}
