<?php

include_once '../classes/ListarDisciplinas.php';

$nomeCurso = $_GET["nome"];
$codCurso = $_GET["codigo"];
$semanas = $_GET["semanas"];
$carga = $_GET["cargaHoraria"];

$idPeriodos = $_GET['idPeriodo'];
$idPeriodo = $idPeriodos[0];

session_start();
$id_usuario = $_SESSION["usuario"]['id'];



$num = numLinhasSelecionarWHERE("curso", array("id"), "codigo = $codCurso");


if ($num == 0) {
    inserir("curso", array("nome" => $nomeCurso, "codigo" => $codCurso, "semanas" => $semanas, "cargaHoraria" => $carga,"id_usuario" => $id_usuario, "id_periodo" => $idPeriodo));
    print "<script type = 'text/javascript'> location.href = './listarDisciplinas.php?nome=$nomeCurso&codigo=$codCurso' </script>";
}
else{
    print "<script>alert('código duplicado'); location.href = 'index.php';</script>";
}