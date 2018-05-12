<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once '../classes/BD/crudPDO.php';


//$data = json_decode(file_get_contents("php://input"));
//$nome = mysql_real_escape_string($data->nome);
//$codigo = mysql_real_escape_string($data->codigo);
//$categoria = mysql_real_escape_string($data->categoria);
//$ch = mysql_real_escape_string($data->CH);
//$codCurso = mysql_real_escape_string($data->codCurso);
//$nomeCurso = mysql_real_escape_string($data->nomeCurso);
//
//


$nome = $_POST["nome"];
$codigo = $_POST["codigo"];
$categoria = $_POST["categoria"];
$ch = $_POST["ch"];
$idCurso = $_POST["idCurso"];
$ativa = 1;


$num = numLinhasSelecionarWHERE("disciplina", array('ID'), "CODIGO = '$codigo' AND id_curso = $idCurso");

if ($num > 0) {
    print "Código duplicado";
} else {

    if (inserir("disciplina", array("CODIGO" => $codigo, "NOME" => $nome, "categoria" => $categoria, "TOTAL_CARGA_HORARIA" => $ch, "id_curso" => $idCurso, "requisitoCadastrado" => 0, "ativa" => $ativa))) {
        print "sucesso";
    } else {
        print "erro na inserção";
    }
}

