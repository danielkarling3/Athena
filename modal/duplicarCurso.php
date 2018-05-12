<?php
include_once '../classes/BD/crudPDO.php';
$idCurso = $_POST["idCurso"];

$fetch = selecionar("periodo", array('id', 'nome'));
?>
<script>
    var nomeNovo;
    var idNovo;
    function novaCopia() {
        var id = $("#idCurso").val();
        var nome = $("#nomeNovo").val();
        var codigo = $("#codigoNovo").val();
        var semanas = $("#semanasNovo").val();
        var cargaHoraria = $("#cargaHorariaNovo").val();
        var idPeriodo = $("#idPeriodoNovo").val();
        $.ajax({
            type: 'GET',
            url: "inserirCursoCopia.php",
            data: {nome: nome, codigo: codigo, semanas: semanas, cargaHoraria: cargaHoraria, idPeriodo: idPeriodo}

        }).done(function (data) {
            
            if (data !== "erro") {
                nomeNovo = nome;
                idNovo = data;
                $("#dados").hide();
                $("#importarDisciplinas").show();
            } else {
                alert("erro");
            }
        });
    }
    function  importarDisciplinas() {
        var id = $("#idCurso").val();
        $.ajax({
            type: 'POST',
            url: "importarDisciplinas.php",
            data: {idCurso: id, idCopia: idNovo, nomeCopia: nomeNovo}

        }).done(function (data) {
            alert(data);
        });
    }
</script>

<center>
    <div id="copia"  >

        <label>Ao criar uma cópia do curso, você estará criando um curso novo com as disciplinas já existentes.<br>
            Porém não serão copiadas informações de alunos, horários e pré-requisitos.<br>
            As disciplinas novas não terão nenhum vínculo com as antigas, apenas o mesmo código.
        </label>
        <br>
        <div id="dados">
            Nome do Novo Curso<br><input name="nomeNovo" class="text-uppercase text-warning text-center"  type="text" id="nomeNovo" value = ""><br>
            Código do Novo Curso<br><input class="text-warning text-uppercase text-center" name="codigoNovo" type="text" id="codigoNovo" value = ""><br>
            <h4>N° de Semanas por Semestre</h4>
            <input class="text-primary text-center" name="semanasNovo" type="number" id="semanasNovo" value = "0">
            <h4>Carga Horária</h4>
            <input class="text-primary text-center" name="cargaHorariaNovo" type="number" id="cargaHorariaNovo" value = "0">


            <h4>Turno</h4>
            <select required="true" class='bg-warning text-uppercase btn-default btn-lg' style="border: white;" name="idPeriodo[]" id="idPeriodoNovo" size="4">
                <?php
                foreach ($fetch as $f) {
                    echo "<option class='text-uppercase text-primary ' value='" . $f['id'] . "'>" . $f['nome'] . "</option>";
                }
                ?>

            </select>
            <input name="idCurso"   type="hidden" id="idCurso" value ="<?php echo $idCurso; ?>">


            <br>
            <button id="novoCurso" onclick="novaCopia()">Cadastrar</button>
        </div>
        <button hidden="true" id="importarDisciplinas" onclick="importarDisciplinas()">Importar Disciplinas</button>
    </div>
</center>

