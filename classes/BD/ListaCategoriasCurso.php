<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BuscaCategoriasCurso
 *
 * @author danielkarling
 */
include_once URL . '/classes/CategoriaDados.php';

class ListaCategoriasCurso {

    private $categoriasCurso;
    private $nomeCategorias;

    public function __construct($codCurso) {

        $fetch = selecionarWHERE("disciplina JOIN curso ON disciplina.id_curso = curso.id", array('disciplina.categoria'), "curso.codigo = '$codCurso' GROUP BY disciplina.categoria");

        foreach ($fetch as $f) {
            $cat = $f["categoria"];
            $this->categoriasCurso[] = new CategoriaDados($cat);
        }
        if (!(empty($this->categoriasCurso))) {
            foreach ($this->categoriasCurso as $cat) {
                $this->nomeCategorias[] = $cat->getNome() . "";
            }
        }
    }

    public function getCategorias() {
        return $this->categoriasCurso;
    }

    public function getNomeCategorias() {


        return $this->nomeCategorias;
    }

}
