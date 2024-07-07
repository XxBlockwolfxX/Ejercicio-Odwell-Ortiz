$(document).ready(function() {
    function cargarProductos() {
        $.ajax({
            url: '../controllers/productos.controllers.php',
            method: 'GET',
            success: function(data) {
                var html = '';
                $.each(data, function(index, producto) {
                    html += '<tr>' +
                            '<td>' + (index + 1) + '</td>' +
                            '<td>' + producto.nombre + '</td>' +
                            '<td>' + producto.precio + '</td>' +
                            '<td>' + producto.stock + '</td>' +
                            '<td><button class="btn btn-primary" onclick="editarProducto(' + producto.id + ')">Editar</button> ' +
                            '<button class="btn btn-danger" onclick="eliminarProducto(' + producto.id + ')">Eliminar</button></td>' +
                            '</tr>';
                });
                $('#cuerpoProductos').html(html);
            },
            error: function() {
                alert("Error cargando la lista de productos");
            }
        });
    }

    cargarProductos();
});
