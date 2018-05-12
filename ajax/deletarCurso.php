<?php

include_once '../classes/BD/crudPDO.php';
$idCurso = $_POST['idCurso'];
$fetch = selecionarWHERE("curso", array("codigo"), "id= '$idCurso'");

foreach ($fetch as $f) {
    $codCurso = $f["codigo"];
}

$i = deletar("aproveitamento", "id_curso = $idCurso");
if (!$i) {
    print "Erro ao deletar os históricos dos alunos";
} else {

    deletar("requisito", "id_curso = $idCurso");
    alterar("disciplina", array("requisitoCadastrado" => 0, "requisitada" => 0), "id_curso = '$idCurso'");

    $fetch = selecionarWHERE("disciplina", array('ID'), "id_curso =  $idCurso");
    foreach ($fetch as $f) {
        $idDisciplina = $f['ID'];
        deletar("disc_horario", "id_disciplina = $idDisciplina");
    }
    $i = deletar("disciplina", "id_curso =  $idCurso");
    if (!$i) {
        print "Erro ao deletar disciplinas";
    } else {
        deletar("compartilhado", "id_curso =  $idCurso");
        $i = deletar("curso", "id = $idCurso");

        if (!$i) {
            print("Erro ao deletar curso");
        } else {
            if ((file_exists("../ModuloEspecialista/req" . $codCurso . ".pl"))) {


                $sucesso = unlink("../ModuloEspecialista/req" . $codCurso . ".pl");
                unlink("../ModuloEspecialista/qtdReq" . $codCurso . ".pl");
            }
            print "sucesso";
        }
    }
}