<?php
error_reporting(1);
require_once('../config/cors.php');
require_once('../models/usuarios.model.php');

$usuario = new Clase_Usuarios();
$metodo = $_SERVER['REQUEST_METHOD'];

//$_POST   insertar
//$_GET    select 
// $_PUT   actualizar
//$_DELETE   eliminar
//www.google.com?Nombre=Luis

switch ($metodo) {
    case "GET":
        if (isset($_GET["UsuarioId"])) {

            $uno = $usuario->uno($_GET["UsuarioId"]);
            echo json_encode(mysqli_fetch_assoc($uno));
        } else {
            $datos = $usuario->todos();
            $todos = array();
            while ($fila = mysqli_fetch_assoc($datos)) {
                array_push($todos, $fila);
            }
            echo json_encode($todos);
        }
        break;
    case "POST":
        if (isset($_GET["op"]) == "login") {
            if (empty(trim($_POST["correo"]))  || empty(trim($_POST["contrasenia"]))) {
                header('Location: ../index.php?op=2');
                exit();
            }
            $correo = $_POST["correo"];
            $contrasena = $_POST["contrasenia"];

            $login = $usuario->loginParametros($correo, $contrasena);
            $res = mysqli_fetch_assoc($login);
            if ($res) {

                if ($res['password'] == $contrasena) {
                    header('Location:../views/dashboard.php');
                    exit();
                } else {
                    header('Location:../index.php?op=3');
                    exit();
                }
            } else {
                header('Location:../index.php?op=1');
                exit();
            }
        } elseif (isset($_GET["op"]) == "actualizar") {
            $UsuarioId = $_POST["UsuarioId"];
            $Nombre = $_POST["Nombre"];
            $correo = $_POST["correo"];
            $password = $_POST["password"];
            $estado = $_POST["estado"];
            $RolesId = $_POST["RolesId"];
            if (!empty($UsuarioId) || !empty($correo) || !empty($password)) {
                echo "entro";
                $actualizar = array();
                $actualizar = $usuario->actualizar($UsuarioId, $Nombre, $correo, $password, $estado, $RolesId);

                if ($actualizar) {
                    echo json_encode(array("message" => "Se actualizo correctamente"));
                } else {
                    echo json_encode(array("message" => "Error, no se actualizo"));
                }
            } else {
                echo json_encode(array("message" => "Error, faltan datos veremos si es de aqui" . $UsuarioId . " " . $Nombre . " " . $correo . " " . $password . " " . $estado . " " . $RolesId));
            }
        } else {
            $datos = json_decode(file_get_contents('php://input'));
            $Nombre = $_POST["Nombre"];
            $correo = $_POST["correo"];
            $password = $_POST["password"];
            $estado = $_POST["estado"];
            $RolesId = $_POST["RolesId"];
            if (!empty($correo) || !empty($password)) {
                $insetar = array();
                $insetar = $usuario->insertar($Nombre, $correo, $password, $estado, $RolesId);
                if ($insetar) {
                    //echo "Se inserto correctamente";
                    echo json_encode(array("message" => "Se inserto correctamente"));
                } else {
                    echo json_encode(array("message" => "Error, no se inserto"));
                }
            } else {
                echo json_encode(array("message" => "Error, faltan datos"));
            }
        }

        break;
    case "PUT":



        break;
    case "DELETE":
        $datos = json_decode(file_get_contents('php://input'));
        if (!empty($datos->UsuarioId)) {
            try {
                $eliminar = array();
                $eliminar = $usuario->eliminar($datos->UsuarioId);
                echo json_encode(array("message" => "Se elimino correctamente"));
            } catch (Exception $th) {
                echo json_encode(array("message" => "Error, no se elimino"));
            }
        } else {
            echo json_encode(array("message" => "Error, no se envio el id"));
        }
        break;
    case "login":

        break;
}
