<?php

include_once '../classes/ListarDisciplinas.php';

$nomeCurso = $_GET["nome"];
$codCurso = $_GET["codigo"];
$semanas = $_GET["semanas"];


session_start();
$id_usuario = $_SESSION["usuario"]['id'];



$num = numLinhasSelecionarWHERE("curso", array("id"), "codigo = $codCurso");


if ($num == 0) {
    inserir("curso", array("nome" => $nomeCurso, "codigo" => $codCurso, "semanas" => $semanas, "id_usuario" => $id_usuario));
    print "<script type = 'text/javascript'> location.href = './listarDisciplinas.php?nome=$nomeCurso&codigo=$codCurso' </script>";
}
else{
    print "<script>alert('código duplicado'); location.href = 'index.php';</script>";
}