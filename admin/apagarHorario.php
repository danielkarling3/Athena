<?php
include_once '../classes/BD/crudPDO.php';
$id = $_POST['id'];

$sucesso = deletar("horario", "id_horario = $id");
if ($sucesso){
    print "sucesso";
    
}else{
    
    print $sucesso;
}


