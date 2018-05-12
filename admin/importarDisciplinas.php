<?php
$idCurso = $_POST['idCurso'];
$idCopia = $_POST['idCopia'];
$nomeCopia = $_POST['nomeCopia'];
include_once '../classes/BD/crudPDO.php';

$fetch = selecionarWHERE("disciplina", array('ID', 'CODIGO', 'NOME', 'categoria', 'curso', 'TOTAL_CARGA_HORARIA', 'requisitoCadastrado', 'requisitada', 'ativa'), "id_curso = $idCurso");
foreach ($fetch as $f) {
    
    inserir("disciplina", array('CODIGO'=>$f['CODIGO'],'NOME'=>$f['NOME'],'categoria'=>$f['categoria'],'curso'=>$nomeCopia,'TOTAL_CARGA_HORARIA'=>$f['TOTAL_CARGA_HORARIA'],'requisitoCadastrado'=>0,'requisitada'=>0,'ativa'=>$f['ativa'], 'id_curso'=>$idCopia));
    
   
}




echo "Disciplinas Importadas";

//LEMBRAR DE COLOCAR 0 EM REQUISITOS CADASTRADOS E REQUISITADA
//COLOCAR O ID DA COPIA
//alterar o codigo da disciplina
//print "importar disciplinas de $idCurso para $idCopia";



