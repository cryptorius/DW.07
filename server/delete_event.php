<?php

include_once 'connection.php';
$conn = new ConectorBD('localhost', 'root', '');
$conn->initConexion('agendadb');

$id = $_POST['id'];

$conn->eliminarEvento($id);

echo json_encode((object)array("msg" => "OK"));

?>
