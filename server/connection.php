<?php

/**
 * Created by PhpStorm.
 * User: johno
 * Date: 12/10/2017
 * Time: 8:53 AM
 */
class ConectorBD
{
    private $host;
    private $user;
    private $password;
    private $conexion;

    function __construct($host, $user, $password)
    {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
    }

    function initConexion($nombre_db)
    {
        $this->conexion = new mysqli($this->host, $this->user, $this->password, $nombre_db);
        if ($this->conexion->connect_error) {
            return "Error:" . $this->conexion->connect_error;
        } else {
            return "OK";
        }
    }

    function ejecutarQuery($query)
    {
        return $this->conexion->query($query);
    }

    function cerrarConexion()
    {
        $this->conexion->close();
    }

    function obtenerIdUsuario($correo_usr){
        $stmt = $this->conexion->prepare('SELECT id_usuario FROM USUARIO WHERE correo_usr = ?');
        $stmt->bind_param("s", $correo_usr);
        $stmt->execute();

        $stmt->bind_result($id_usuario);

        $rows = array();

        while($stmt->fetch()){
            $row = array('id_usuario' => $id_usuario);

            $rows[] = $row;
        }

        return $rows[0]['id_usuario'];
    }

    function existenUsuarios(){
        $sql = "SELECT * FROM USUARIO";

        return mysqli_num_rows($this->ejecutarQuery($sql)) > 0;
    }

    function crearUsuarios(){
        $stmt = $this->conexion->prepare('INSERT INTO USUARIO (correo_usr, password_usr, nombre_completo_usr, fecha_nacimiento_usr) VALUES (?, ?, ?, ?)');
        $correo_usr = 'oliva@gmail.com';
        $password_usr_not_hashed = 'Usr2k15';
        $password_usr = password_hash($password_usr_not_hashed, PASSWORD_DEFAULT);
        $nombre_completo_usr = "Oliva Ordoñez Meneses";
        $fecha_nacimiento_usr = "1969-05-20";
        $stmt->bind_param("ssss", $correo_usr, $password_usr, $nombre_completo_usr, $fecha_nacimiento_usr);
        $stmt->execute();
        $correo_usr = 'juan@gmail.com';
        $password_usr_not_hashed = 'Usr2k16';
        $password_usr = password_hash($password_usr_not_hashed, PASSWORD_DEFAULT);
        $nombre_completo_usr = "Juan Ortiz Urbano";
        $fecha_nacimiento_usr = "1969-10-20";
        $stmt->execute();
        $correo_usr = 'julio@gmail.com';
        $password_usr_not_hashed = 'Usr2k17';
        $password_usr = password_hash($password_usr_not_hashed, PASSWORD_DEFAULT);
        $nombre_completo_usr = "Julio Ordoñez Bolívar";
        $fecha_nacimiento_usr = "1943-04-13";
        $stmt->execute();
    }

    function validarLogin($correo_usr, $password_usr_readable){

        $stmt = $this->conexion->prepare('SELECT password_usr FROM USUARIO WHERE correo_usr = ?');
        $stmt->bind_param("s", $correo_usr);
        $stmt->execute();

        $stmt->bind_result($password_usr);

        $rows = array();

        while($stmt->fetch()){
            $row = array('password_usr' => $password_usr);

            $rows[] = $row;
        }

        if(count($rows) > 0){
            if (password_verify($password_usr_readable, $rows[0]['password_usr'])){
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function obtenerEventos($id_usuario){
        $sql = "SELECT * FROM EVENTO WHERE fk_id_usuario = " . $id_usuario;

        $resultado = $this->conexion->query($sql);

        $jsnEventos = array();

        while ($evento = $resultado->fetch_assoc()){
            $jsnEvento['id'] = $evento['id_evento'];
            $jsnEvento['title'] = $evento['titulo_evt'];
            $jsnEvento['start'] = $evento['fecha_inicio_evt'] . ' ' . $evento['hora_inicio_evt'];
            $jsnEvento['end'] = $evento['fecha_fin_evt'] . ' ' . $evento['hora_fin_evt'];
            $jsnEvento['backgroundColor'] = '#014461';

            array_push($jsnEventos, $jsnEvento);
        }

        return $jsnEventos;
    }

    function crearEvento($titulo_evt, $fecha_inicio_evt, $hora_inicio_evt, $fecha_fin_evt, $hora_fin_evt, $todo_dia_evt, $id_usuario){
        $stmt = $this->conexion->prepare('INSERT INTO EVENTO (titulo_evt, fecha_inicio_evt, hora_inicio_evt, fecha_fin_evt, hora_fin_evt, todo_dia_evt, fk_id_usuario) VALUES (?, ?, ?, ?, ?, ?, ?)');

        $stmt->bind_param('sssssii', $titulo_evt, $fecha_inicio_evt, $hora_inicio_evt, $fecha_fin_evt, $hora_fin_evt, $todo_dia_evt, $id_usuario);

        $stmt->execute();

        return $this->conexion->insert_id;
    }

    function eliminarEvento($id){
        $stmt = $this->conexion->prepare('DELETE FROM evento WHERE id_evento = ?');
        $stmt->bind_param('i', $id);

        $stmt->execute();
    }

    function actualizarEvento($id_evento, $fecha_inicio_evt, $hora_inicio_evt, $fecha_fin_evt, $hora_fin_evt){
        $stmt = $this->conexion->prepare('UPDATE EVENTO SET fecha_inicio_evt = ?, hora_inicio_evt = ?, fecha_fin_evt = ?, hora_fin_evt = ? WHERE id_evento = ?');

        $stmt->bind_param('ssssi', $fecha_inicio_evt, $hora_inicio_evt, $fecha_fin_evt, $hora_fin_evt, $id_evento);

        $stmt->execute();
    }

    function getConexion()
    {
        return $this->conexion;
    }
}


?>
