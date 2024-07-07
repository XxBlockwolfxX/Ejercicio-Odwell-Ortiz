$(document).ready(function() {
    function cargarProductos() {
        $.ajax({
            url: '../controllers/productos.controllers.php', // Ruta a tu archivo controlador de productos
            method: 'GET',
            success: function(data) {
                console.log("Respuesta del servidor:", data);
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

    window.eliminarProducto = function(id) {
        if (confirm("¿Estás seguro de que quieres eliminar este producto?")) {
            $.ajax({
                url: '../controllers/productos.controllers.php',
                method: 'DELETE',
                contentType: 'application/json',
                data: JSON.stringify({ ProductoId: id }),
                success: function(response) {
                    cargarProductos();
                    alert("Producto eliminado");
                },
                error: function() {
                    alert("Error al eliminar el producto");
                }
            });
        }
    };

    window.editarProducto = function(id) {
        $.ajax({
            url: '../controllers/productos.controllers.php',
            method: 'GET',
            data: { ProductoId: id },
            success: function(response) {
                console.log("Respuesta del servidor:", response);
                var producto = typeof response === 'string' ? JSON.parse(response) : response;
                $('#ProductoId').val(producto.id);
                $('#nombre').val(producto.nombre);
                $('#precio').val(producto.precio);
                $('#stock').val(producto.stock);
                $('#modalProducto').modal('show');
            },
            error: function() {
                alert("Error al cargar los datos del producto");
            }
        });
    };

    $('#frm_productos').on('submit', function(event) {
        event.preventDefault();

        var formData = {
            ProductoId: $('#ProductoId').val(),
            nombre: $('#nombre').val(),
            precio: $('#precio').val(),
            stock: $('#stock').val()
        };

        console.log("Datos del formulario:", formData);

        var method = formData.ProductoId ? 'PUT' : 'POST';
        var url = '../controllers/productos.controllers.php';
        var data = formData;

        if (method === 'POST') {
            // Use FormData for POST to handle file uploads and text data
            data = new FormData();
            data.append('nombre', formData.nombre);
            data.append('precio', formData.precio);
            data.append('stock', formData.stock);
        } else {
            // Convert to JSON for PUT
            data = JSON.stringify(formData);
        }

        $.ajax({
            url: url,
            method: method,
            contentType: method === 'POST' ? false : 'application/json',
            processData: method === 'POST' ? false : true,
            data: data,
            success: function(response) {
                console.log("Respuesta del servidor:", response);
                var jsonResponse = typeof response === 'string' ? JSON.parse(response) : response;
                if (jsonResponse.message === "Producto insertado correctamente" || jsonResponse.message === "Producto actualizado correctamente") {
                    alert(jsonResponse.message);
                    $('#modalProducto').modal('hide');
                    cargarProductos();
                } else {
                    alert("Error al guardar producto");
                }
            },
            error: function() {
                alert("Error al guardar producto");
            }
        });
    });

    $('#modalProducto').on('hidden.bs.modal', function () {
        $('#ProductoId').val('');
        $('#nombre').val('');
        $('#precio').val('');
        $('#stock').val('');
    });
});
