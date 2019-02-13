<?php
/**
 * Created by PhpStorm.
 * User: johno
 * Date: 12/10/2017
 * Time: 12:30 PM
 */

include_once 'connection.php';
$conn = new ConectorBD('localhost', 'root', '');
$conn->initConexion('agendadb');

$conn->validarLogin('oliva@gmail.com', 'Usr2k15');