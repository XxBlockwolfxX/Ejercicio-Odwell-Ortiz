<?php
require_once('../config/conexion.php');

class Clase_Productos
{
    // Método para obtener todos los productos de la base de datos
    public function todosProductos()
    {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $query = "SELECT * FROM productos";
        $result = mysqli_query($con, $query);
        $con->close();
        return $result;
    }

    // Método para obtener un producto específico por ID
    public function obtenerProducto($ProductoId)
    {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $stmt = $con->prepare("SELECT * FROM productos WHERE id = ?");
        $stmt->bind_param("i", $ProductoId);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $stmt->close();
            $con->close();
            return $result;
        }
        $stmt->close();
        $con->close();
        return null;
    }

    // Método para insertar un nuevo producto
    public function insertarProducto($nombre, $precio, $stock)
    {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $stmt = $con->prepare("INSERT INTO productos (nombre, precio, stock) VALUES (?, ?, ?)");
        $stmt->bind_param("sdi", $nombre, $precio, $stock);
        if ($stmt->execute()) {
            $productoId = $con->insert_id;
            $stmt->close();
            $con->close();
            return $productoId;  // Retornar el ID del producto insertado
        }
        $stmt->close();
        $con->close();
        return false;  // Retornar false si hubo un error
    }

    // Método para actualizar un producto
    public function actualizarProducto($ProductoId, $nombre, $precio, $stock)
    {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $stmt = $con->prepare("UPDATE productos SET nombre = ?, precio = ?, stock = ? WHERE id = ?");
        $stmt->bind_param("sdii", $nombre, $precio, $stock, $ProductoId);
        if ($stmt->execute()) {
            $stmt->close();
            $con->close();
            return true;
        }
        $stmt->close();
        $con->close();
        return false;
    }

    // Método para eliminar un producto
    public function eliminarProducto($ProductoId)
    {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $stmt = $con->prepare("DELETE FROM productos WHERE id = ?");
        $stmt->bind_param("i", $ProductoId);
        if ($stmt->execute()) {
            $stmt->close();
            $con->close();
            return true;
        }
        $stmt->close();
        $con->close();
        return false;
    }
}
?>
