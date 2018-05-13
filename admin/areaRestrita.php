<?php
$id_usuario = $_SESSION["usuario"]['id'];
$user = selecionarWHERE("usuario", array('nome', 'email'), "id = $id_usuario");
foreach ($user as $u) {
    $nomeUser = $u['nome'];
    $emailUser = $u['email'];
}
?>
<script>
    function alterarNome() {
        $("#novoNome").show(500);
        $("#novoEmail").hide(500);


    }

    function alterarEmail() {

        $("#novoEmail").show(500);
        $("#novoNome").hide(500);


    }
    function gravarNovoEmail() {
        var novoEmail = $("#inputNovoEmail").val();
        $.ajax({
            type: 'POST',
            url: "alterarEmail.php",
            data: {emailUser: novoEmail, idUser: <?php echo $id_usuario; ?>}
        }).done(function (data) {
            alert(data);
            if (data === 'sucesso') {

                $("#novoEmail").hide(500);
            }
        });

    }
    function gravarNovoNome() {
        var novoNome = $("#inputNovoNome").val();
        $.ajax({
            type: 'POST',
            url: "alterarNome.php",
            data: {nomeUser: novoNome, idUser: <?php echo $id_usuario; ?>}
        }).done(function (data) {
            alert(data);
            if (data === 'sucesso') {
                $("#novoNome").hide(500);
            }

        });
    }
    function opcoesUsuario() {
        var divVisible = $("#opcoesUsuario").is(":visible");
        if (divVisible) {
            $("#opcoesUsuario").hide(400);
        } else {
            $("#opcoesUsuario").show(400);
        }

    }

    function opcoesAvancadas() {
        var divVisible = $("#opcoesAvancadas").is(":visible");
        if (divVisible) {
            $("#opcoesAvancadas").hide(400);
        } else {
            $("#opcoesAvancadas").show(400);
        }

    }
    function fecharAreaRestrita() {
        $("#btnAdmin").show(600);
        $("#divAdmin").hide(300);
        $("#opcoesRestritas").show(300);
        $("#divAreaRestrita").hide(500);
        $("#btnAdmin").show(600);
    }

</script>
<div id="divAreaRestrita" class="panel panel-primary" hidden="true">

    <br>
    <div id="divAdmin" hidden="true">
        ADMINISTRADOR:<br><input style="color: black;"  class="text-center" type="text" id="ADM"/><br>
        <br>
        SENHA:<br><input style="color: black;"  class="text-center" type="password" id="senhaADM" /><br>
        <br>
        <button class="btn btn-primary" onclick="logarAdmin()">OK</button>
        <br>
        <br>
    </div>
    <div id="opcoesRestritas">
        <br>

        <br>
        <label onclick="opcoesUsuario()" class="btn alert-info text-uppercase">Informações de Usuário</label>

        <br>
        <div class="panel panel-primary" style="margin-left: 30%; margin-right: 30%;">
            <div id="opcoesUsuario" hidden="true">

                <br>

                <button class="btn btn-default" onclick="alterarEmail()">
                    Alterar e-mail
                </button>
                <br>
                <div id="novoEmail" hidden="true">
                    <input id="inputNovoEmail" type="text" value="<?php echo $emailUser; ?>">
                    <button id="btnAlterarEmail" class="btn btn-sm btn-info" onclick="gravarNovoEmail()">OK</button>

                </div>
                <br>
                <button class="btn btn-default" onclick="alterarNome()">
                    Alterar nome
                </button>
                <br>
                <div id="novoNome"  hidden="true">

                    <input id="inputNovoNome" type="text" value="<?php echo $nomeUser; ?>">
                    <button id="btnAlterarNome" class="btn btn-sm btn-info" onclick="gravarNovoNome()">OK</button>
                </div>
                <br>
            </div>
        </div>

        <br>
        <label onclick="opcoesAvancadas()" class="btn alert-info text-uppercase">Opções Avançadas</label>

        <br>
        <div class="panel panel-primary" style="margin-left: 30%; margin-right: 30%;">
            <div id="opcoesAvancadas" hidden="true">
                <br>
                <button class="btn btn-default" onclick="divDeletarCurso()">
                    Deletar o Curso
                </button>
                <br>
                <br>

                <button class="btn btn-default" onclick="deletarHistoricosModal()">
                    Deletar Histórico dos Alunos
                </button>
                <br>
                
            <br>
            </div>
        </div>

    </div>
    <br>
    <button onclick="fecharAreaRestrita()" class="btn btn-md alert-danger">Fechar</button>
    <br>
</div>

