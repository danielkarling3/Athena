<?php

include_once '../classes/BD/crudPDO.php';

$id = $_POST['idUser'];
$email = $_POST['emailUser'];

$sucesso = alterar("usuario", array("email" => $email), "id = $id");
if ($sucesso) {
    print "sucesso";
} else {
    print $sucesso;
}
