<?php
include_once '../classes/BD/crudPDO.php';
include_once './modal.php';

$idDisciplina = $_GET["idDisciplina"];
if (!empty($_GET["codigo"])) {
    $codCurso = $_GET["codigo"];
}
$hora = "";
$horarios = selecionarWHERE("disciplina, horario, disc_horario", array("disciplina.NOME", "horario.hora_inicio", "horario.dia"), "disciplina.ID = '" . $idDisciplina . "' AND disc_horario.id_disciplina = disciplina.ID AND horario.id_horario = disc_horario.id_horario");
foreach ($horarios as $h) {
    $hora = $hora . $h["dia"] . " " . $h["hora_inicio"] . " - ";

    //$nome = $h["NOME"];
}
//echo $nome."<br>";
?>
<link href="../css/bootstrap.min.css" rel="stylesheet">
<link href="../css/Athena.css" rel="stylesheet">
<script src="../js/jquery-3.2.0.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $.ajax({
            type: "post",
            url: "../ajax/listarHorariosAjax.php",
            data: {idDisciplina: "<?php echo $idDisciplina; ?>"}
        }).done(function (data) {
            $("#idHorarios").html(data);


        });
    });

    function atualizar() {
        $.ajax({
            type: "post",
            url: "../ajax/listarHorariosAjax.php",
            data: {idDisciplina: "<?php echo $idDisciplina; ?>"}
        }).done(function (data) {
            $("#idHorarios").html(data);

        });

    }

    function novoHorario() {
        $.ajax({
            url: "../modal/novoHorarioModal.php"
        }).done(function (data) {
            $("#corpoModal").html(data);


        });
        $('#modal').modal('show');
    }
    function mostraAjuda(i) {
        if (i === 1) {
            $("#ajuda").html("<h5>Segure CTRL para selecionar mais de um horário<h5>");
        } else {
            $("#ajuda").html("<h5><br></h5>");
        }

    }
    function admin() {
        $("#loginAdmin").show(500);
        $("#btnAdmin").hide(600);

    }
    function logarAdmin() {
        var user = $('#ADM').val();
        var senha = $('#senhaADM').val();
        $.ajax({
            type: 'POST',
            url: "verificarLoginADM.php",
            data: {user: user, senha: senha}
        }).done(function (data) {
            if (data !== "sucesso") {
                alert('você não possui acesso ' + user);
                $("#loginAdmin").hide(600);
                $('#ADM').val('');
                $('#senhaADM').val('');
            } else {
                alert("Bem vindo, administrador do Sistema Athena ");
                $("#loginAdmin").hide(300);
                $("#horarioDisciplina").hide(300);
                 $("#novo").hide(300);
                $("#deletarHorario").show(300);
                $("#lista").hide(300);
                $.ajax({
                    type: 'POST',
                    url: "../ajax/listarHorariosDeletar.php"
                }).done(function (data2) {
                    $("#deletarHorario").html(data2);

                });
            }

        });
    }
    function apagar(id) {
        $.ajax({
            type: 'POST',
            url: "apagarHorario.php",
            data: {id: id}
        }).done(function (data) {

            if (data !== "sucesso") {
                alert(data);
            } else {
                $.ajax({
                    type: 'POST',
                    url: "../ajax/listarHorariosDeletar.php"
                }).done(function (data2) {
                    $("#deletarHorario").html(data2);
                });

            }
        });
    }




</script>

<body class="Athena_background_two">
<center>
    <br>
    <div style="margin-left: 90%; padding-right: 2px; padding-top: 2px;"><button id="btnAdmin" onclick="admin()" class="btn btn-sm btn-default">Área Restrita</button></div>
    <br>
    <div id="loginAdmin" class="panel panel-primary" hidden="true">
        <br>
        ADMINISTRADOR:<br><input style="color: black;"  class="text-center" type="text" id="ADM"/><br>
        <br>
        SENHA:<br><input style="color: black;"  class="text-center" type="password" id="senhaADM" /><br>
        <br>
        <button class="btn btn-primary" onclick="logarAdmin()">OK</button>
        <br>
        <br>
    </div>
    <div id="deletarHorario" hidden="true">


    </div>

    <div id="horarioDisciplina" class="panel panel-primary" style="margin-left: 15%; margin-right: 15%;">
        <h4>
            <?php echo $hora; ?>
        </h4>
</center>
<br>
<?php ?>
<center>
    <form id="lista" class="container-fluid center-block" name="horarios" method="post" action="cadastrarHorarios.php">

        <h4>Horários</h4>

        <h5>Os horários já cadastrados serão apagados</h5>
        <div id="ajuda">
            <h5><br></h5>
        </div>
        <br>
        <select onmousemove="mostraAjuda(1)" onmouseout="mostraAjuda(0)" id="idHorarios" class="panel panel-primary" style="padding-left: 3%; padding-right: 3%;" name="idHorario[]" size="15" multiple >

            <!--                ajax-->

        </select>
        <input class="text-success" name="idDisciplina" type="hidden" id="idDisciplina" value = "<?php echo $idDisciplina; ?>">
        <input class="text-success" name="codigo" type="hidden" id="codigo" value = "<?php echo $codCurso; ?>">
        <br>
        <br>
        <input type="submit" name="submit" class="btn btn-lg Athena_button_dark_large" value="Cadastrar">
    </form>
    <br>
    <button id="novo" class="btn btn-md Athena_button_submit" onclick="novoHorario()">NOVO HORÁRIO</button>

    <button class="btn btn-md Athena_button_book" type="button" onclick="window.location.href = 'listarDisciplinas.php?codigo=<?php echo $codCurso; ?>'"> Voltar</button>
</center>
</body>


