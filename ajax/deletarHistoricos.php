<?php
include_once '../classes/BD/crudPDO.php';
$idCurso = $_POST['idCurso'];

$i= deletar("aproveitamento", "id_curso = $idCurso");
if($i){
    print "Históricos deletados";
    
}