function buscarUsuario() {
    var idUsuario = document.getElementById("id").value;

    // Realizar la solicitud AJAX para buscar al usuario en la base de datos
    $.ajax({
        url: 'templates/editardatos.php',
        method: 'GET',
        data: { id: idUsuario },
        dataType: 'json',
        success: function (response) {
            // Rellenar los campos del formulario con los datos del usuario
            $('#nombre').val(response.nombre);
            $('#contraseña').val(response.contraseña);
            $('#num_banco').val(response.numero);
            $('#banco').val(response.banco);
            $('#fecha_inicio').val(response.fecha_inicio);
            $('#fecha_final').val(response.fecha_final)
        },
        error: function () {
            // Mostrar mensaje de error si no se encuentra el usuario
            alert('Usuario no encontrado.');
        }
    });
}
