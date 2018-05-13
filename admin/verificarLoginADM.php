<?php

require_once '../classes/BD/crudPDO.php';
session_start();

$usuario = $_POST['user'];
$senha = $_POST['senha'];
$num = numLinhasSelecionarWHERE('ADM', array('senha'), "user = '$usuario' AND senha='$senha'");

if ($num > 0) {
    print "sucesso";
} else {

    print "erro";
}

