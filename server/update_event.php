<?php
include_once 'connection.php';
$conn = new ConectorBD('localhost', 'root', '');
$conn->initConexion('agendadb');

$id_evento = $_POST['id'];
$fecha_inicio_evt = $_POST['start_date'];
$hora_inicio_evt = $_POST['start_hour'];
$fecha_fin_evt = $_POST['end_date'];
$hora_fin_evt = $_POST['end_hour'];

$conn->actualizarEvento($id_evento, $fecha_inicio_evt, $hora_inicio_evt, $fecha_fin_evt, $hora_fin_evt);

echo json_encode((object)array("msg" => "OK"));

?>
