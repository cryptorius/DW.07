<?php

if(!$conn->existenUsuarios()) {
    $conn->crearUsuarios();
}

?>
