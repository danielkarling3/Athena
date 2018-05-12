<?php

include_once '../classes/Horario.php';
include_once '../classes/ListarHorarios.php';

//$nomeCurso = $_POST["nomeCurso"];
//$codCurso = $_POST["codCurso"];]




$listHora = new ListarHorarios();

$listaHorarios = $listHora->getHorarios();

$horarioAnterior = "";
$arrayClass = array('text-info', 'text-primary');
$i = 0;
$class = $arrayClass[$i];
foreach ($listaHorarios as $horario) {
    if ($horarioAnterior != $horario->getDia()) {
        $horarioAnterior = $horario->getDia();

        $i = ($i + 1) % 2;
        $class = $arrayClass[$i];
    }
    echo "<label class='$class'  id='idHorario'>" . $horario->getDia() . " - " . $horario->getHora() . "</label>"
    . "<button style='margin-left: 5px;' class='btn btn-default btn-sm' onclick='apagar(" . $horario->getId() . ")'>Apagar</button><br>";
}
