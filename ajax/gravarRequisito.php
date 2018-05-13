<?php

include_once '../classes/BD/crudPDO.php';

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$idCurso = $_POST['idCurso'];
$codDisciplina = $_POST["codDisciplina"];
$fetch = selecionarWHERE("disciplina", array('ID'), "CODIGO =  '$codDisciplina' AND id_curso = $idCurso LIMIT 1");
foreach ($fetch as $f) {
    $idDisciplina = $f['ID'];
    $sucesso = alterar("disciplina", array("requisitoCadastrado" => 1), "ID = $idDisciplina");
    print $sucesso;
}

if (!empty($_POST["codRequisito"])) {
    $listaRequisitos = $_POST["codRequisito"];
    foreach ($listaRequisitos as $requisito) {
        $fetch = selecionarWHERE("disciplina", array('ID'), "CODIGO =  '$requisito' AND id_curso = $idCurso LIMIT 1");
        foreach ($fetch as $f) {
            $idRequisito = $f['ID'];
        }
        alterar("disciplina", array("requisitada" => 1), "ID = $idRequisito");
        $sucesso = inserir("requisito", array('id_disciplina' => $idDisciplina, 'id_requisito' => $idRequisito, 'id_curso' => $idCurso));
        print $sucesso;
    }
} else {
    $sucesso = inserir("requisito", array('id_disciplina' => $idDisciplina, 'id_requisito' => 0, 'id_curso' => $idCurso));
    print $sucesso;
    //alterar("disciplina", array("requisitoCadastrado" => 1), "ID = $idDisciplina");
}
//$codCurso = $_POST["codCurso"];



