<?php

include_once '../classes/BD/crudPDO.php';


$codCurso = $_POST["codCurso"];

$idCurso = $_POST["idCurso"];


if ((file_exists("../ModuloEspecialista/req" . $codCurso . ".pl"))) {
    unlink("../ModuloEspecialista/req" . $codCurso . ".pl");
}
$fp = fopen("../ModuloEspecialista/req" . $codCurso . ".pl", "a");

fwrite($fp, "possibilidades(R,L):-
	base(L),
	podeCursar(R).

base([Cab|Cauda]):-
	assert(disciplina(Cab)),
	assert(cursada(Cab)),	
	base(Cauda),!.
	
base(Cab):-
	assert(disciplina(Cab)),
	assert(cursada(Cab)),!.
	
base([]):-!.

podeCursar(R):- findall(X,requisito(X),Lista),
		naoCursou(R,Lista).

naoCursou([],[]):-!.

naoCursou([],[X]):-
	disciplina(X),!.

naoCursou([X],[X]):-
	not(disciplina(X)),!.


naoCursou(R,[Cab|Cauda]):-
	disciplina(Cab),
	naoCursou(R,Cauda),!.

naoCursou([Cab|R],[Cab|Cauda]):-
	not(disciplina(Cab)),
	naoCursou(R,Cauda),!.	
	
verLista([]).

verLista([Cab|Cauda]):-
	write(Cab),nl,
	verLista(Cauda),!.

verLista(X):- write(X).
");


$fetch = listarRequisitosCodigo($idCurso);


if ((file_exists("../ModuloEspecialista/qtdReq" . $codCurso . ".pl"))) {
   
    unlink("../ModuloEspecialista/qtdReq" . $codCurso . ".pl");
}
if (!empty($fetch[0]['disciplina'])) {
    $disciplinaAnterior = $fetch[0]['disciplina'];
    alterar("disciplina", array("requisitoCadastrado" => 1), "CODIGO = '$disciplinaAnterior'");
    fwrite($fp, "\nrequisito('" . $disciplinaAnterior . "'):-\n");
    foreach ($fetch as $f) {

        if ($disciplinaAnterior != $f['disciplina']) {

            alterar("disciplina", array("requisitoCadastrado" => 1), "CODIGO = '$disciplinaAnterior'");
            $disciplinaAnterior = $f['disciplina'];
            fwrite($fp, "true.\n\nrequisito('" . $f['disciplina'] . "'):-\n");
        }
        alterar("disciplina", array("requisitada" => 1), "CODIGO = '" . $f['requisito'] . "'");
        fwrite($fp, "disciplina('" . $f['requisito'] . "'),\n");
        fwrite($fp, "requisito('" . $f['requisito'] . "'),\n");
    }
    fwrite($fp, "true.");
}

//cadastrados sem requisitos
$fetch3 = selecionarWHERE("requisito", array('id_disciplina'), "id_requisito = 0 AND id_curso = $idCurso");
foreach ($fetch3 as $f3) {
    $fetch4 = selecionarWHERE("disciplina", array('CODIGO'), "ID = '" . $f3['id_disciplina'] . "' LIMIT 1");
    foreach ($fetch4 as $f4) {
        $codigo = $f4['CODIGO'];
    }
    // echo " cadastrado sem requisito " . $f3['id_disciplina'];
    fwrite($fp, "\n\nrequisito('" . $codigo . "'):-\n");
    fwrite($fp, "true.");

    alterar("disciplina", array("requisitoCadastrado" => 1), "CODIGO = '" . $codigo . "'");
    
}

//nao cadastrei
$fetch2 = selecionarWHERE("disciplina", array('CODIGO', 'ID'), "requisitoCadastrado = 0 AND id_curso = $idCurso");
foreach ($fetch2 as $f2) {

    fwrite($fp, "\n\nrequisito('" . $f2['CODIGO'] . "'):-\n");
    fwrite($fp, "true.");

    //echo " sem cadastrar " . $f2['ID'];
    alterar("disciplina", array("requisitoCadastrado" => 1), "CODIGO = '" . $f2['CODIGO'] . "'");
    inserir("requisito", array('id_disciplina' => $f2['ID'], 'id_requisito' => 0, 'id_curso' => $idCurso));
}




fclose($fp);


//escrevendo no arquivo de quantidade de requisitos

if (!(file_exists("../ModuloEspecialista/qtdReq" . $codCurso . ".pl"))) {
    $fp2 = fopen("../ModuloEspecialista/qtdReq" . $codCurso . ".pl", "a");
    fwrite($fp2, "		  
exige(X, Y):- requisitoDireto(Y, X).
exige(X, Z):- requisitoDireto(Y, X), exige(Y, Z).

requisito(X, Y) :- exige(Y, X).

count([],0).
count([_|T],Acc):- count(T,Acc2), Acc is 1+Acc2. 

retiraRepetidos([],[]):-!.
retiraRepetidos([X],[X]):-!.
retiraRepetidos([H|T],T2):- member(H,T), retiraRepetidos(T,T2),!.
retiraRepetidos([H|T],[H|T2]):- not(member(H,T)), retiraRepetidos(T,T2).

countReq(X,Acc):- findall(Y,(requisito(X,Y)),L),retiraRepetidos(L,LUnique),  count(LUnique,Acc).\n");
} else {
    $fp2 = fopen("../ModuloEspecialista/qtdReq" . $codCurso . ".pl", "a");
}
foreach ($fetch as $f) {
    fwrite($fp2, "\n\nrequisitoDireto('" . $f['requisito'] . "', X) :- X = '" . $f['disciplina'] . "'. \n");
    alterar("disciplina", array("requisitada" => 1), "ID = " . $f['requisito']);
}

fclose($fp2);
//
//print "<script>alert('Requisitos Cadastrados');</script>";
echo "Requisitos Cadastrados";
