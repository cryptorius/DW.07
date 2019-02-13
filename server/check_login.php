<?php
session_start();

include_once 'connection.php';
$conn = new ConectorBD('localhost', 'root', '');
$conn->initConexion('agendadb');
include_once 'create_user.php';

if($conn->validarLogin($_POST['username'], $_POST['password'])){
    $_SESSION['id_usuario'] = $conn->obtenerIdUsuario($_POST['username']);
    echo json_encode((object)array("msg"=>"OK"));
} else {
    echo json_encode((object)array("msg"=>"Credenciales inválidas"));
}
?>
