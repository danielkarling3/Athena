<?php
require_once '../classes/BD/crudPDO.php';
$fetch = selecionarWHERE("horario", array('dia'), " 1 GROUP BY dia ORDER BY FIELD(dia, 'Segunda', 'Terca', 'Quarta', 'Quinta', 'Sexta', 'Sábado') ASC, dia ASC");
?>
<script type="text/javascript">
    function addHorario() {
        var diaSelecionado = $("#selectDia").val();
        var horario_inicio = $("#hora").val();
        $.ajax({
            type: "post",
            url: "../admin/inserirHorario.php",
            data: {dia: diaSelecionado, hora: horario_inicio}
        }).done(function (data) {

            $('#modal').modal('hide');
            atualizar();


        });

    }
    
</script>

<center>


    <h4>Dia da Semana</h4>
    <select id="selectDia" class="panel panel-primary text-primary" style="border: white;">
        <?php
        foreach ($fetch as $f) {
            $dia = $f['dia'];
            echo "<option class='text-uppercase text-primary text-center' value='$dia'>$dia</option>";
        }
        ?>
    </select>
    <br>
    <h4>Horário</h4><input  name="hora" class=" text-primary center-block "  type="time" id="hora" value = ""><br>
    <input type = "button" name = "submit" onclick="addHorario()" class = "btn btn-md btn-primary text-uppercase" value = "Adicionar">
    <br>


</center>