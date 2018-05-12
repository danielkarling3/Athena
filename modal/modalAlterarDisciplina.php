

<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once '../classes/BD/crudPDO.php';
$idCurso = $_POST["idCurso"];
$idDsciplina = $_POST["idDsciplina"];

$fetch = selecionarWHERE("disciplina", array("ID", "CODIGO", "NOME", "categoria", "TOTAL_CARGA_HORARIA", "ativa"), "ID='$idDsciplina' LIMIT 1");
foreach ($fetch as $f) {

    $codigo = $f["CODIGO"];
    $nome = $f["NOME"];
    $categoria = $f["categoria"];
    $ch = $f["TOTAL_CARGA_HORARIA"];
    $idDisciplina = $f["ID"];

    $ativa = $f["ativa"];
}
require_once '../classes/BD/crudPDO.php';
$fetch2 = selecionarWhere('disciplina', array('categoria'), "id_curso = $idCurso GROUP BY categoria")
?>
<script type="text/javascript">

    function inputNovaCategoriaAlterar() {
        $("#divSelectCategoriaALT").hide(400);
        $("#divNovaCategoriaALT").show(400);


    }
    function selecionarCategoriaAlterar() {
        $("#divSelectCategoriaALT").show(400);
        $("#divNovaCategoriaALT").hide(400);
        $("#categoriaDiscALT").val("");
    }



    function disciplinaAlterada() {
        var nome = document.getElementById("nomeALT").value;
        var codigo = document.getElementById("codigoALT").value;
        //var categoria = document.getElementById("categoriaALT").value;
        var ch = document.getElementById("chALT").value;
        var ativa = document.getElementById("ativaALT").checked;
        var idCurso = document.getElementById("idCursoALT").value;
        var idDisciplina = document.getElementById("idDisciplinaALT").value;

        var categoriaInput = document.getElementById("categoriaDiscALT").value;
        var categoriaSelect = $("#selectCategoriaALT").val();
        var categoria = "";
        if (categoriaInput === "") {
            categoria = categoriaSelect;
        } else {
            categoria = categoriaInput;
        }

        if (ativa === true) {
            ativa = 1;

        } else {
            ativa = 0;

        }

        $.ajax({
            type: 'POST',
            url: "alterarDisciplina.php",
            data: {nome: nome, codigo: codigo, ch: ch, categoria: categoria, ativa: ativa, idCurso: idCurso, idDisciplina: idDisciplina},
        }).done(function (data) {
            if (data != 1) {
                alert(data);
            }

            atualizar();
            $("#modal").modal("hide");

        });


    }

</script>

<center>
  <label class="text-uppercase">Alterar Disciplina</label>
    <br>
    <br>
    NOME<br><input name="nome" class="text-primary  text-center"  type="text" id="nomeALT" value = "<?php echo $nome; ?>">
    <input class="text-primary  text-center" name="codigo" type="hidden" id="codigoALT" value = "<?php echo $codigo; ?>"><br>
    <br>
    CARGA HORÁRIA<br><input class="text-primary  text-center" name="ch" type="number" id="chALT" value = "<?php echo $ch; ?>" ><br> 
    <br>

    <div class="panel panel-primary Athena_modal"style="margin-left: 25%; margin-right: 25%;">
        <label>CATEGORIA</label><button onclick="alert('Categorias são como temáticas: em um curso as diferentes categorias dividem as disciplinas por semelhanças nos conteúdos.');" class="btn btn-sm btn-link">?</button>
        <br>


        <div id='divSelectCategoriaALT' hidden="true">
            <select id="selectCategoriaALT" class="panel panel-primary text-primary" style="border: white;">
                <?php
                foreach ($fetch2 as $f) {
                    $categoriaOption = $f['categoria'];
                    echo "<option class='text-uppercase text-primary text-center' value='$categoriaOption'>$categoriaOption</option>";
                }
                ?>
            </select>
            <br>
            <button id="btnNovaCategoria" class="btn btn-md Athena_button_submit" onclick="inputNovaCategoriaAlterar()">NOVA</button>
            <br>
            <br>
        </div>

        <div id="divNovaCategoriaALT" >

            <input class="text-primary center-block" name="categoria" type="text" id="categoriaDiscALT" value = "<?php echo $categoria; ?>">
            <br>
            <button id="btnSelectCategoria" class="btn btn-md Athena_button_submit" onclick="selecionarCategoriaAlterar()">LISTAR</button>
            <br>
            <br>
        </div>
    </div>

    
    ATIVA <br><input class="text-primary  text-center" name="ativa" type="checkbox" id="ativaALT" value = "1" <?php if ($ativa != 0) echo "checked" ?> ><br> 

    <input name="idCurso" class="text-primary center-block "  type="hidden" id="idCursoALT" value ="<?php echo $idCurso; ?>">
    <input name="idDisciplina" class="text-primary center-block "  type="hidden" id="idDisciplinaALT" value ="<?php echo $idDisciplina; ?>">
    <br>
<!--        <input type="submit" name="submit" class="alert-success" value="Alterar">-->
    <input type="button" onclick="disciplinaAlterada()"  class="btn btn-md btn-primary" value="Alterar">

</center>



