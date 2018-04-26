<?php



/**
 * Description of BuscaCategoriaDados
 *
 * @author danielkarling
 */


include_once 'config.php';

include_once URL.'/classes/CategoriaDados.php';
include_once URL.'/classes/BD/DataBase.php';

class ListaCategoriasDados {

    public $categorias;
    public $nomeCategorias;
    public $qtdDiscCursadas;

    public function __construct($grr, $idCurso) {

        try {
            $conn = DataBase::getInstance()->getDb();
            $sql = "

SELECT a.perc, a.media, a.categoria, b.qtd FROM
(SELECT SUM(dadosCategoria.perc) as perc,SUM(dadosCategoria.media) as media, dadosCategoria.categoria FROM(SELECT ROUND(SUM(dados.qtd) * SUM(dados.percUnit)) AS perc, 0 AS media, dados.categoria FROM (SELECT COUNT(*) AS qtd, 0 AS percUnit, d.CATEGORIA FROM aproveitamento a JOIN disciplina d ON d.CODIGO = a.COD_ATIV_CURRIC WHERE a.DESCR_SITUACAO = 'APROVADO' AND a.MATR_ALUNO = '$grr' GROUP BY d.CATEGORIA UNION SELECT 0 AS qtd, 100/COUNT(*) AS percUnit, d.CATEGORIA FROM aproveitamento a  JOIN disciplina d ON d.CODIGO = a.COD_ATIV_CURRIC WHERE a.DESCR_SITUACAO <> 'MATRICULA' AND a.MATR_ALUNO = '$grr' GROUP BY d.CATEGORIA) AS dados GROUP BY dados.categoria UNION SELECT 0 AS perc, ROUND(AVG(a.MEDIA_FINAL)) AS media, d.categoria FROM aproveitamento a JOIN disciplina d ON d.CODIGO = a.COD_ATIV_CURRIC WHERE a.DESCR_SITUACAO <> 'MATRICULA' AND a.MATR_ALUNO = '$grr' GROUP BY d.CATEGORIA) AS dadosCategoria GROUP  BY  dadosCategoria.categoria) AS a 
 JOIN 

(
SELECT categoria , COUNT(disciplina.categoria) as qtd FROM disciplina JOIN aproveitamento ON disciplina.CODIGO = aproveitamento.COD_ATIV_CURRIC WHERE aproveitamento.MATR_ALUNO = '$grr' AND aproveitamento.id_curso = $idCurso GROUP BY disciplina.categoria) as b ON a.categoria = b.categoria;";


            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $fetch = $stmt->fetchAll();

            foreach ($fetch as $f) {
                $cat = $f["categoria"];
                $med = $f["media"];
                $perc = $f["perc"];
                $qtd = $f["qtd"];
                $categoria = new CategoriaDados($cat);
                $categoria->setQtd($qtd);
                $categoria->setMediaFinal($med);
                $categoria->setPercentAprovacao($perc);
                $this->categorias[] = $categoria;
                
            }
        } catch (Exception $e) {
            echo $e;
        }

        foreach ($this->categorias as $cat) {
            $this->nomeCategorias[] = $cat->getNome() . "";
        }
    }

    public function getCategorias() {
        return $this->categorias;
    }

    public function getNomeCategorias() {
        return $this->nomeCategorias;
    }

}
