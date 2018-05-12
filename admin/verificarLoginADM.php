<?php

require_once '../classes/BD/crudPDO.php';
session_start();

$usuario = $_POST['user'];
$senha = $_POST['senha'];
$fetch = selecionarWHERE('ADM', array('senha'), "user = '$usuario' LIMIT 1");
foreach ($fetch as $f) {
    if ($senha == $f['senha']) {
        print "sucesso";
    } else {

        print "erro";
    }
}
