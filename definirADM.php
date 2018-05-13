<?php
include_once './classes/BD/crudPDO.php';
$user = $_POST['user'];
$senha = $_POST['senha'];

$num = numLinhasSelecionarWHERE("ADM", array('id'), " 1 ");

if($num > 1){
    print "ADM já foi definido para essa Base de Dados";
    
}else{
    inserir("ADM", array('id'=>1, 'user' => $user, 'senha'=> $senha));
    print "ADM definido";
    
    
}