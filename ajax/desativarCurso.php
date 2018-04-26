<?php

require_once '../classes/BD/crudPDO.php';
$idCurso = $_POST['idCurso'];
$inserir = $_POST['inserir'];
$alterou = alterar("curso", array('visivel' => $inserir), "id = $idCurso");
if ($alterou != 1) {

    echo "erro";
}