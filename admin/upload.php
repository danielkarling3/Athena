<?php

include_once '../classes/BD/crudPDO.php';

$idCurso = $_POST["idCurso"];

$fetch = selecionarWHERE("curso", array("codigo"), "id = '$idCurso'");
foreach ($fetch as $f) {
    $codCurso = $f["codigo"];
}

$uploaddir = './CSV/';

$uploadfile = $uploaddir . $_FILES['arquivo']['name'];

if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $uploadfile)) {

    $arquivo = basename($uploadfile);


    $row = 1;
    if (($handle = fopen("./CSV/$arquivo", "r")) !== FALSE) {
        $relatorioErro = "";

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

            //verifica primeiro item do cabecalho do CSV
            if (($row == 1) && ($data[0] != "NOME DO ALUNO") && ($data[1] != "MATRICULA DO ALUNO") && ($data[20] != "SEXO")) {

                echo "<script>alert('Arquivo Inválido! Por favor, selecione um arquivo no formato CSV');</script>";

                print "<script type = 'text/javascript'> location.href = './listarDisciplinas.php?codigo=" . $codCurso . "' </script>";
                die();
            }

            $num = count($data);
            $row++;


            $NOME_PESSOA = $data[0];
            $MATR_ALUNO = $data[1];


            $NUM_VERSAO = $data[2];
            $NOME_CURSO = $data[3];
            $COD_CURSO = $data[4];
            $ID_VERSAO_CURSO = $data[5];
            $ANO = $data[6];
            $COD_ATIV_CURRIC = $data[7];
            $NOME_ATIV_CURRIC = $data[8];
            $MEDIA_FINAL = $data[9];
            $DESCR_SITUACAO = strtoupper($data[10]);
            $PERIODO = $data[11];
            $ID_CURSO_ALUNO = $data[12];
            $SITUACAO_ITEM = $data[13];
            $CH_TEORICA = $data[14];
            $CH_PRATICA = $data[15];
            $TOTAL_CARGA_HORARIA = $data[16];
            $ANO_INGRESSO = $data[17];
            $FORMA_EVASAO = $data[18];
            $ANO_EVASAO = $data[19];
            $SEXO = $data[20];
            $dados = array("NOME_PESSOA" => $NOME_PESSOA, "MATR_ALUNO" => $MATR_ALUNO, "NUM_VERSAO" => $NUM_VERSAO, "NOME_CURSO" => $NOME_CURSO, "COD_CURSO" => $COD_CURSO, "ID_VERSAO_CURSO" => $ID_VERSAO_CURSO, "ANO" => $ANO, "COD_ATIV_CURRIC" => $COD_ATIV_CURRIC, "NOME_ATIV_CURRIC" => $NOME_ATIV_CURRIC, "MEDIA_FINAL" => $MEDIA_FINAL, "DESCR_SITUACAO" => $DESCR_SITUACAO, "PERIODO" => $PERIODO, "ID_CURSO_ALUNO" => $ID_CURSO_ALUNO, "SITUACAO_ITEM" => $SITUACAO_ITEM, "CH_TEORICA" => $CH_TEORICA, "CH_PRATICA" => $CH_PRATICA, "TOTAL_CARGA_HORARIA" => $TOTAL_CARGA_HORARIA, "ANO_INGRESSO" => $ANO_INGRESSO, "FORMA_EVASAO" => $FORMA_EVASAO, "ANO_EVASAO" => $ANO_EVASAO, "SEXO" => $SEXO, "id_curso" => $idCurso);

            $inseriu = TRUE;



            if ((numLinhasSelecionarWHERE("aproveitamento", array("NOME_PESSOA"), "NOME_PESSOA='$NOME_PESSOA' AND MATR_ALUNO = '$MATR_ALUNO' AND COD_CURSO = '$COD_CURSO' AND COD_ATIV_CURRIC = '$COD_ATIV_CURRIC' AND MEDIA_FINAL = '$MEDIA_FINAL'") == 0) && ($NOME_PESSOA != "NOME DO ALUNO")) {
                if ($MEDIA_FINAL > 100) {
                    $relatorioErro = $relatorioErro . " ERRO: Média Final $MEDIA_FINAL inválida, em  $NOME_ATIV_CURRIC de  $NOME_PESSOA ";
                } else {
                    $inseriu = inserir("aproveitamento", $dados);
                }
            }
            if ($inseriu == FALSE) {

                $relatorioErro = "<script>alert('Problema na inserção dos dados! " . $relatorioErro . "');</script>";

                print $relatorioErro;

                print "<script type = 'text/javascript'> location.href = './listarDisciplinas.php?codigo=" . $codCurso . "' </script>";
            }


            //}
        }
        if ($inseriu == TRUE) {

            $relatorioErro = "<script>alert('Relatóriox incluído com sucesso!  $relatorioErro ');</script>";

            echo $relatorioErro;
            print "<script type = 'text/javascript'> location.href = './listarDisciplinas.php?codigo=" . $codCurso . "' </script>";
        }
        fclose($handle);
    }


    unlink("./CSV/$arquivo");
} else {

    echo "<script>alert('Arquivo não enviado!');</script>";

    print "<script type = 'text/javascript'> location.href = './listarDisciplinas.php?codigo=" . $codCurso . "' </script>";
}
?>
