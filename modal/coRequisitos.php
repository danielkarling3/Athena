<?php

require_once '../classes/BD/crudPDO.php';

$codigo = $_POST['codigo'];

$fetchDisciplina = selecionarWHERE("disciplina", array('NOME', 'TOTAL_CARGA_HORARIA'), "CODIGO = '$codigo' LIMIT 1");




$sql = "SELECT disciplina.NOME, disciplina.CODIGO FROM (SELECT requisito.id_disciplina, requisito.id_requisito FROM disciplina JOIN requisito ON disciplina.ID = requisito.id_requisito WHERE disciplina.CODIGO = '$codigo') as t1 JOIN disciplina ON t1.id_disciplina = disciplina.ID";
$conn = DataBase::getInstance()->getDb();


$stmt = $conn->prepare($sql);

($stmt->execute());

$fetch = $stmt->fetchAll();
echo "<center>";
echo "<table class='table table-hover text-center bg-warning'>";
echo "</center>";

echo "<thead>";
echo "<tr>"
 . "<th class='bg-success text-center' >CODIGO</th>"
 . "<th class='bg-success text-center'>NOME</th>"
 . "</tr>";

echo "</thead>";
echo "<tbody>";
foreach ($fetch as $f) {
    echo "<tr class='text-center text-success'>"
    . "<td>" . $f['CODIGO'] . "</td>"
    . "<td>" . $f['NOME'] . "</td>"
    . "</tr>";
}
echo "</tbody>";
echo "</table><br><br>";

foreach ($fetchDisciplina as $disc) {
    echo "<label class='text-primary'>Carga Horária Total da Disciplina:  " . $disc['TOTAL_CARGA_HORARIA'] . " horas</label>";
}


