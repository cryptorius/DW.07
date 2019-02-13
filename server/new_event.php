<?php
session_start();
include_once 'connection.php';
$conn = new ConectorBD('localhost', 'root', '');
$conn->initConexion('agendadb');

$titulo_evt = $_POST['titulo'];
$fecha_inicio_evt = $_POST['start_date'];
$hora_inicio_evt = $_POST['start_hour'];
$fecha_fin_evt = $_POST['end_date'];
$hora_fin_evt = $_POST['end_hour'];
$todo_dia_evt = $_POST['allDay'] === 'true' ? 1 : 0;

$id_usuario = $_SESSION['id_usuario'];

if($fecha_fin_evt === ''){
    $fecha_fin_evt = $fecha_inicio_evt;
    $hora_inicio_evt = '00:00';
    $hora_fin_evt = '23:59';
}

$id_evento = $conn->crearEvento($titulo_evt, $fecha_inicio_evt, $hora_inicio_evt, $fecha_fin_evt, $hora_fin_evt, $todo_dia_evt, $id_usuario);

echo json_encode((object)array("msg" => "OK", "id_evento" => $id_evento));
?>
