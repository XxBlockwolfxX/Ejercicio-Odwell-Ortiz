<?php
error_reporting(1);
require_once('../config/cors.php');
require_once('../models/productos.model.php');

$producto = new Clase_Productos();
$metodo = $_SERVER['REQUEST_METHOD'];

header('Content-Type: application/json'); // Asegura que la respuesta sea JSON

switch ($metodo) {
    case "GET":
        if (isset($_GET["ProductoId"])) {
            $ProductoId = $_GET["ProductoId"];
            $resultado = $producto->obtenerProducto($ProductoId);
            echo json_encode(mysqli_fetch_assoc($resultado));
        } else {
            $datos = $producto->todosProductos();
            $todos = array();
            while ($fila = mysqli_fetch_assoc($datos)) {
                array_push($todos, $fila);
            }
            echo json_encode($todos);
        }
        break;
    case "POST":
        $nombre = $_POST["nombre"];
        $precio = $_POST["precio"];
        $stock = $_POST["stock"];
        if (!empty($nombre) && !empty($precio) && !empty($stock)) {
            $insertar = $producto->insertarProducto($nombre, $precio, $stock);
            if ($insertar) {
                echo json_encode(array("message" => "Producto insertado correctamente", "id" => $insertar));
            } else {
                echo json_encode(array("message" => "Error al insertar producto"));
            }
        } else {
            echo json_encode(array("message" => "Error, faltan datos"));
        }
        break;
    case "PUT":
        $datos = json_decode(file_get_contents('php://input'), true);
        if (!empty($datos["ProductoId"]) && !empty($datos["nombre"]) && !empty($datos["precio"]) && !empty($datos["stock"])) {
            $actualizar = $producto->actualizarProducto($datos["ProductoId"], $datos["nombre"], $datos["precio"], $datos["stock"]);
            if ($actualizar) {
                echo json_encode(array("message" => "Producto actualizado correctamente"));
            } else {
                echo json_encode(array("message" => "Error al actualizar producto"));
            }
        } else {
            echo json_encode(array("message" => "Error, faltan datos"));
        }
        break;
    case "DELETE":
        $datos = json_decode(file_get_contents('php://input'), true);
        if (!empty($datos["ProductoId"])) {
            $eliminar = $producto->eliminarProducto($datos["ProductoId"]);
            if ($eliminar) {
                echo json_encode(array("message" => "Producto eliminado correctamente"));
            } else {
                echo json_encode(array("message" => "Error al eliminar producto"));
            }
        } else {
            echo json_encode(array("message" => "Error, faltan datos"));
        }
        break;
    default:
        echo json_encode(array("message" => "Método no soportado"));
        break;
}
?>
