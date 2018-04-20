<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once '../classes/BD/crudPDO.php';
$idCurso = $_POST['idCurso'];

$fetch = selecionarWHERE("curso", array("codigo"), "id= '$idCurso'");

foreach ($fetch as $f) {
    $codCurso = $f["codigo"];
}
deletar("requisito", "id_curso = $idCurso");
alterar("disciplina", array("requisitoCadastrado" => 0, "requisitada" => 0), "id_curso = '$idCurso'");
if ((file_exists("../ModuloEspecialista/req" . $codCurso . ".pl"))) {


    $sucesso = unlink("../ModuloEspecialista/req" . $codCurso . ".pl");
    unlink("../ModuloEspecialista/qtdReq" . $codCurso . ".pl");
    if ($sucesso) {



        echo "Excluído com sucesso";
    } else {

        echo "Não foi possível excluir";
    }
} else {

    echo "Arquivo não encontrado";
}