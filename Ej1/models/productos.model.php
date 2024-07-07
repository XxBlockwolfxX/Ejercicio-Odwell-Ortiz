<?php
require_once('../config/conexion.php');

class Clase_Productos
{
    public function todosProductos()
    {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $query = "SELECT * FROM productos";
        $result = mysqli_query($con, $query);
        $con->close();
        return $result;
    }

    public function obtenerProducto($ProductoId)
    {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $stmt = $con->prepare("SELECT * FROM productos WHERE id = ?");
        $stmt->bind_param("i", $ProductoId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $con->close();
        return $result;
    }

    public function insertarProducto($nombre, $precio, $stock)
{
    $con = new Clase_Conectar();
    $con = $con->Procedimiento_Conectar();
    $stmt = $con->prepare("INSERT INTO productos (nombre, precio, stock) VALUES (?, ?, ?)");
    $stmt->bind_param("sdi", $nombre, $precio, $stock);
    if ($stmt->execute()) {
        $ProductoId = $con->insert_id;
        $stmt->close();
        $con->close();
        return $ProductoId;
    } else {
        $stmt->close();
        $con->close();
        return false;
    }
}


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
        } else {
            $stmt->close();
            $con->close();
            return false;
        }
    }

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
        } else {
            $stmt->close();
            $con->close();
            return false;
        }
    }
}
?>
