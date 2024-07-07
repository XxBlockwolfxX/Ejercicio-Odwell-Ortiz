<?php
include '../html/head.php';  
include '../html/header.php';  
include '../html/menu.php';  
?>

<div class="container mt-5">
    <h2>Lista de Productos</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="cuerpoProductos">
            <!-- Los productos se cargarán aquí usando JavaScript -->
        </tbody>
    </table>
</div>

<?php
include '../html/footer.php'; 
?>

<!-- JavaScript para cargar los productos -->
<script src="../producto.js"></script>

</body>
</html>
