<!DOCTYPE html>
<html lang='es'>
<head>
    <?php require_once('./html/head.php') ?>
    <link href='../public/lib/calendar/lib/main.css' rel='stylesheet' />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
        .custom-flatpickr {
            display: flex;
            align-items: center;
        }

        .custom-flatpickr input {
            margin-right: 5px;
            flex: 1;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class='container-xxl position-relative bg-white d-flex p-0'>
        <!-- Spinner Start -->
        <div id='spinner' class='show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center'>
            <div class='spinner-border text-primary' style='width: 3rem; height: 3rem;' role='status'>
                <span class='sr-only'>Cargando...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Sidebar Start -->
        <?php require_once('./html/menu.php') ?>
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class='content'>
            <!-- Navbar Start -->
            <?php require_once('./html/header.php') ?>
            <!-- Navbar End -->

            <!-- Canvas Elements for Charts -->
            <div class='container-fluid pt-4 px-4'>
                <div class='row'>
                    <div class='col-md-6'>
                        <canvas id="worldwide-sales" width="400" height="200"></canvas>
                    </div>
                    <div class='col-md-6'>
                        <canvas id="salse-revenue" width="400" height="200"></canvas>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-6'>
                        <canvas id="line-chart" width="400" height="200"></canvas>
                    </div>
                    <div class='col-md-6'>
                        <canvas id="bar-chart" width="400" height="200"></canvas>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-6'>
                        <canvas id="pie-chart" width="400" height="200"></canvas>
                    </div>
                    <div class='col-md-6'>
                        <canvas id="doughnut-chart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>

            <!-- Recent Sales Start -->
            <div class='container-fluid pt-4 px-4'>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalProducto">
                    Nuevo Producto
                </button>
                <div class='d-flex align-items-center justify-content-between mb-4'>
                    <h6 class='mb-0'>Lista de productos</h6>
                </div>
                <div class='table-responsive'>
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="table-light">
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
            </div>
            <!-- Recent Sales End -->

            <!-- Footer Start -->
            <?php require_once('./html/footer.php') ?>
            <!-- Footer End -->
        </div>
        <!-- Content End -->

        <!-- Back to Top -->
        <a href='#' class='btn btn-lg btn-primary btn-lg-square back-to-top'><i class='bi bi-arrow-up'></i></a>
    </div>
    <!-- Modal para productos -->
    <div class="modal fade" id="modalProducto" tabindex="-1" aria-labelledby="modalProductoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalProductoLabel">Nuevo Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="frm_productos">
                    <div class="modal-body">
                        <input type="hidden" name="ProductoId" id="ProductoId">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" id="nombre" placeholder="Ingrese el nombre del producto" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="precio">Precio</label>
                            <input type="number" name="precio" id="precio" placeholder="Ingrese el precio del producto" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="stock">Stock</label>
                            <input type="number" name="stock" id="stock" placeholder="Ingrese el stock del producto" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <?php require_once('./html/scripts.php') ?>
    <script src="producto.js"></script>
</body>
</html>
