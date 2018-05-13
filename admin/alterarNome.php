<?php
include_once '../classes/BD/crudPDO.php';

$id = $_POST['idUser'];
$nome = $_POST['nomeUser'];

$sucesso = alterar("usuario", array("nome" => $nome), "id = $id");
if($sucesso){
    print "sucesso";
    
}else{
    print $sucesso;
    
}