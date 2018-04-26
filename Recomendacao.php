<?php

require_once 'classes/BD/ListaCategoriasDados.php';
require_once 'classes/BD/DiscCursadasAluno.php';
require_once 'classes/BD/BuscaCategoriaDisc.php';
require_once 'classes/BD/crudPDO.php';
require_once 'classes/Disciplina.php';
require_once './classes/Curso.php';
require_once 'classes/BD/ListaCategoriasCurso.php';
require_once './classes/BD/BuscaHorariosDisc.php';
require_once './classes/Dificuldades.php';

class Recomendacao {

    private $grr = "";
    private $idCurso;
    private $recomendacaoFinal = array();
    private $listaDificuldade = array();
    private $mensagem = "";
    private $anoEntrada = 0;
    private $anoMaximo = 0;
    private $cargaCursada = 0;
    private $cargaTotalCurso = 0;
    private $anosCursados = 0;

    function __construct($grr, $idCurso) {
        $this->grr = $grr;
        $this->idCurso = $idCurso;
        $this->horasCursadas();
    }

    function getListaDificuldade() {
        return $this->listaDificuldade;
    }

    function getRecomendacaoFinal() {
        return $this->recomendacaoFinal;
    }

    function setListaDificuldade($listaDificuldade) {
        $this->listaDificuldade = $listaDificuldade;
    }

    function setRecomendacaoFinal($recomendacaoFinal) {
        $this->recomendacaoFinal = $recomendacaoFinal;
    }

    function getMensagem() {
        return $this->mensagem;
    }

    function setMensagem($mensagem) {
        $this->mensagem = $mensagem;
    }

    function getCargaTotalCurso() {
        return $this->cargaTotalCurso;
    }

    function getAnosCursados() {
        return $this->anosCursados;
    }

    function setAnosCursados($anosCursados) {
        $this->anosCursados = $anosCursados;
    }

    function horasCursadas() {
        $fetch = selecionarWHERE("aproveitamento", array("MIN(ANO) as entrada", "MAX(ANO) as atual"), "MATR_ALUNO = '" . $this->grr . "'");
        foreach ($fetch as $f) {
            $this->setAnoEntrada($f['entrada']);
            $this->setAnoMaximo($f['atual']);
        }

        $fetch2 = selecionarWHERE("aproveitamento JOIN disciplina ON aproveitamento.COD_ATIV_CURRIC = disciplina.CODIGO", array("SUM(disciplina.TOTAL_CARGA_HORARIA) as cursada"), "aproveitamento.DESCR_SITUACAO = 'Aprovado' AND aproveitamento.MATR_ALUNO = '" . $this->grr . "'");
        foreach ($fetch2 as $f) {
            $this->setCargaCursada($f["cursada"]);
        }
        $qtdAnos = numLinhasSelecionarWHERE("aproveitamento", array("ANO"), "MATR_ALUNO = '$this->grr' GROUP BY ANO");
        $this->setAnosCursados($qtdAnos);
    }

    function getAnoEntrada() {
        return $this->anoEntrada;
    }

    function getAnoMaximo() {
        return $this->anoMaximo;
    }

    function setAnoEntrada($anoEntrada) {
        $this->anoEntrada = $anoEntrada;
    }

    function setAnoMaximo($anoMaximo) {
        $this->anoMaximo = $anoMaximo;
    }

    function getCargaCursada() {
        return $this->cargaCursada;
    }

    function setCargaCursada($cargaCursada) {
        $this->cargaCursada = $cargaCursada;
    }

    //calcula dificuldade nas categorias 
    public function calculaDificuldade($categoria) {
        $media = $categoria->getMediaFinal() . "";
        $percApr = $categoria->getPercentAprovacao() . "";
        $qtdDiscCursadas = $categoria->getQtd();
        //comando .jar, arquivo fuzzy, media, aprovacao, qtdade de disciplina cursada
        $comando = "java -jar ModuloEspecialista/Dificuldade.jar ModuloEspecialista/Dificuldade.fcl $media $percApr $qtdDiscCursadas";
        $saida = exec($comando, $saida);
        return $saida;
    }

    //verifica disciplinas que podem ser matriculadas a partir dos pre requisitos ja cursados
    public function calculaPossibilidades($strTermo, $arquivoRequisitoCurso) {
        //comando .jar, arquivo Prolog, string disciplinas cursadas
        $strExec = "java -jar ModuloEspecialista/Possibilidade.jar $arquivoRequisitoCurso \"$strTermo\"";
        $saida2 = exec($strExec, $saida2);

        $tamanho = strlen($saida2);
        $possibilidades = substr($saida2, 1, $tamanho - 2);
        $arrayPoss = explode(", ", $possibilidades);
        return $arrayPoss;
    }

    //calcula as importancias das possibilidades de matricula, baseado na dificuldade, qtdade de requisicoes ...
    public function calculaImportancias($arrayPossibilidades, $arrayCategorias, $arrayDificuldades, $arquivoQTDRequisitoCurso, $numeroSemanas, $idPeriodo) {
        $recomendacao = array();
        foreach ($arrayPossibilidades as $possibilidade) {
            $catDisc = new BuscaCategoriaDisc($possibilidade);
            $catPos = $catDisc->getCategoria();
            for ($index = 0; $index < count($arrayCategorias); $index++) {

                if ($arrayCategorias[$index]->getNome() == $catPos) {
                    $this->importancia($recomendacao, $arrayDificuldades[$index], $arrayCategorias[$index], $possibilidade, $arquivoQTDRequisitoCurso, $numeroSemanas, $idPeriodo);
                }
            }
        }
        return $recomendacao;
    }

    //calcula a importancia da disciplina, chamada pela funcao calculaImportancias()
    public function importancia(&$recomendacao, $dificuldade, $categoria, $possibilidade, $arquivoQTDRequisitoCurso, $numeroSemanas, $idPeriodo) {

        $pAprov = $categoria->getPercentAprovacao();
        $mFinal = $categoria->getMediaFinal();
        //comando .jar, possibilidade, dificuldade, arquivo Fuzzy, arquivo Prolog
        $comando = "java -jar ModuloEspecialista/ImportanciaDisc.jar $possibilidade $dificuldade ModuloEspecialista/ImportanciaDisc.fcl $arquivoQTDRequisitoCurso";

        $saida2 = exec($comando, $saida2);

        $disciplina = selecionarWHERE("disciplina", array("NOME", "ativa"), "CODIGO = '$possibilidade'");
        $nome = "";
        $ativa = 0;
        foreach ($disciplina as $d) {
            $nome = $d["NOME"];
            $ativa = $d["ativa"];
        }
        $cargaHoraria = 0;
        $CH = selecionarWHERE("disciplina", array("TOTAL_CARGA_HORARIA"), "CODIGO = '$possibilidade'");
        foreach ($CH as $c) {
            $cargaHoraria = $c["TOTAL_CARGA_HORARIA"];
        }

        if ($ativa != "0") {
            $disc = new Disciplina($nome, $possibilidade, $saida2, $cargaHoraria, $pAprov, $mFinal, 0, $ativa);
            $horarios = new BuscaHorariosDisc($possibilidade);
            $disc->setHorarios($horarios->getHorarios());


//calcular as horas de dedicacao semanal

            if ($idPeriodo == 4) {

                $extra = (($disc->getCargaHoraria() / 1.5 )) / $numeroSemanas;
                if ($dificuldade <= 30) {
                    $fatorDificudade = $dificuldade / 26;
                } else
                    $fatorDificudade = $dificuldade / 29;
            }
            else {
                $extra = ($disc->getCargaHoraria() / 2 + $disc->getCargaHoraria()) / $numeroSemanas;
                if ($dificuldade <= 30) {
                    $fatorDificudade = $dificuldade / 25;
                } else
                    $fatorDificudade = $dificuldade / 27;
            }
            $disc->setHorasDedicacao($extra * $fatorDificudade);

            if ($disc != NULL) {
                $recomendacao[] = $disc;
            }
        }
    }

//funcao que inicia processo de recomendacao do objeto
    public function start() {

        $existe = numLinhasSelecionarWHERE("aproveitamento", array("ID"), "MATR_ALUNO = '$this->grr' AND id_curso = $this->idCurso");
        if ($existe == 0) {

            echo "<script>alert('GRR não encontrado');</script>";
            print "<script type = 'text/javascript'> location.href = './index.php' </script>";
            die();
        }

        $curso = new Curso();
        //antigo
        //$curso->buscarPorGRR($this->grr);
        
        //substituido por esta funcao
        $curso->buscaCursoPorId($this->idCurso);
        
        
        $this->cargaTotalCurso = $curso->getHorasTotal();
        $listaCategoriasDados = new ListaCategoriasDados($this->grr, $this->idCurso);
        $categorias = $listaCategoriasDados->getCategorias();

        $listaCategoriasCurso = new ListaCategoriasCurso($curso->getCodigo());
// $categoriasCurso = $listaCategoriasCurso->getCategorias();


        $difs = array();
// +++++++++++++++++++++++++++++++ CHAMA MODULO DIFICULDADE ++++++++++++++++++++++++++++++++++++
        foreach ($categorias as $cat) {
            $difs[] = $this->calculaDificuldade($cat);
        }


        $nomeCategorias = $listaCategoriasDados->getNomeCategorias();
        $nomeCategoiasCurso = $listaCategoriasCurso->getNomeCategorias();


//inserir categorias ainda nao cursadas na lista 
        if (!(empty($nomeCategoiasCurso))) {
            foreach ($nomeCategoiasCurso as $catCurso) {
                if ((in_array($catCurso, $nomeCategorias))) {
                    
                } else {

                    $novaCat = new CategoriaDados($catCurso);
                    $novaCat->setMediaFinal(100);
                    $novaCat->setPercentAprovacao(100);
                    $novaCat->setQtd(0);
                    $categorias[] = $novaCat;
                    $difs[] = 0;
                }
            }
        }


//cria tabela dificuldade por disciplina
        $this->listaDificuldade = new Dificuldades($categorias, $difs);



//lista de disciplinas cursadas pelo aluno
        $cursadas = new DiscCursadasAluno($this->grr);


//construcao da string para usar no prolog
        $strTermo = $cursadas->getTermo() . "";

//nome dinâmico do arquivo de requisitos do curso
        $arquivoRequisitoCurso = "ModuloEspecialista/req" . $curso->getCodigo() . ".pl";

// +++++++++++++++++++++++++++++++ CHAMA MODULO POSSIBILIDADE ++++++++++++++++++++++++++++++++++++
        $arrayPossibilidades = $this->calculaPossibilidades($strTermo, $arquivoRequisitoCurso);


//nome dinâmico do arquivo de requisitos do curso
        $arquivoQTDRequisitoCurso = "ModuloEspecialista/qtdReq" . $curso->getCodigo() . ".pl";


//calcula a importancia de todas possibilidades, junto com as horas de dedicacao semanal
// +++++++++++++++++++++++++++++++ CHAMA MODULO IMPORTANCIADISC ++++++++++++++++++++++++++++++++++++
        $recomendacao = $this->calculaImportancias($arrayPossibilidades, $categorias, $difs, $arquivoQTDRequisitoCurso, $curso->getSemanas(), $curso->getPeriodo());


////ordenar a lista de recomendacao
        usort($recomendacao, "Disciplina::ordenaDisciplinas");


        foreach ($recomendacao as $d) {
            $this->recomendacaoFinal[] = $d;
        }

//cria lista de colisao de horarios para cada disciplina
        for ($i = 0; $i < count($this->recomendacaoFinal); $i++) {
            $antigo = $this->recomendacaoFinal[$i]->getHorarios();
            foreach ($antigo as $h) {
                for ($i2 = $i + 1; $i2 < count($this->recomendacaoFinal); $i2++) {

                    if (in_array($h, $this->recomendacaoFinal[$i2]->getHorarios()) != FALSE) {

                        $this->recomendacaoFinal[$i2]->insereColisao($this->recomendacaoFinal[$i]->getCodigo());
                        $this->recomendacaoFinal[$i]->insereColisao($this->recomendacaoFinal[$i2]->getCodigo());
                    }
                }
            }
        }
//usort($recomendacao, "Disciplina::ordenaDisciplinasPorColisao");
    }

}
