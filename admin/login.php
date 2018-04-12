<?php
include './modal.php';
?>

<html >
    <head>
        <meta charset="UTF-8">
        <title id="titulo" >Login</title>
        <link href="../css/bootstrap.css" rel="stylesheet">
        <link href="../css/Athena.css" rel="stylesheet">

        <script src="../js/jquery-3.2.0.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function () {
                $.ajax({
                    url: "verificarLogin.php",
                }).done(function (data) {
                    if (data === 'logado') {
                        alert('Você já está logado');
                        location.href = './index.php';
                    }
                });
            });

            function atualizar() {
                $.ajax({
                    url: "verificarLogin.php",
                }).done(function (data) {
                    if (data === 'logado') {
                        alert('Você já está logado');
                        location.href = './index.php';
                    }

                    location.reload();
                });
            }

            function login() {
                var user = $('#usuario').val();
                var senha = $('#senha').val();
                var novaSenha = $('#novaSenha').val();
                var novaSenha2 = $('#novaSenha2').val();
                if (novaSenha !== novaSenha2) {
                    alert("senhas não conferem");
                } else {
                    $.ajax({
                        type: 'POST',
                        url: "fazerLogin.php",
                        data: {user: user, senha: senha, novaSenha: novaSenha}
                    }).done(function (data) {
                        if (data === 'erro') {
                            alert('você não possui acesso ' + user);

                        } else {
                            alert('Seja bem vindo ' + user);

                            location.href = './index.php';

                        }

                    });
                }

            }
            function alterarSenha() {
                $("#divNova").show();
                $("#btnAlterar").hide();


            }

            function modalNovoUsuario() {

                $('#modal').modal('hide');
                $.ajax({
                    url: "../modal/novoUsuarioModal.php",
                }).done(function (data) {

                    $("#corpoModal").html(data);
                });
                $('#modal').modal('show');

            }
            function menuNovoUsuario() {

                //$('#modal').modal('hide');
                $.ajax({
                    url: "../modal/novoUsuarioModal.php",
                }).done(function (data) {
                    $("#btnCadastras").hide();
                    $("#btnLogar").show();
                    $("#menu").html(data);
                });
                //$('#modal').modal('show');

            }

            function inserirUsuario() {
                var nome = $('#nomeModal').val();
                var email = $('#emailModal').val();
                var senha = $('#senhaModal').val();
                var novaSenha = $('#novaSenhaModal').val();
                if (senha !== novaSenha || novaSenha === '') {
                    alert('senhas não conferem');
                } else {
                    if (nome === '') {
                        alert('Digite um nome');
                    } else {
                        $.ajax({
                            type: 'POST',
                            url: "novoUsuario.php",
                            data: {nome: nome, email: email, senha: senha, novaSenha: novaSenha}
                        }).done(function (data) {
                            $("#modal").hide();
                            location.href = './index.php';

                        });
                    }
                }
            }

        </script>
    </head>

    <body class="Athena_background">


        <?php
        include '../cabecalho.php';
        ?>

        <div class="row ">
            <div class="col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2 col-xs-12">
                <div id="menu" class="Athena_login " style="margin-left: 30%; margin-right: 30%;  margin-top: 5%;">
                    <div class="panel Athena_cabecalho" style="margin-left: 15%; margin-right: 15%;">
                        <center>
                            <h3>Ambiente de Administração</h3>
                        </center>
                    </div>
                    <center>
                        USUÁRIO:<br><input style="color: black;"  class="text-center" type="text" id="usuario"/><br>
                        <br>
                        SENHA:<br><input style="color: black;"  class="text-center" type="password" id="senha" /><br>
                        <br>
                        <div  hidden="true" id='divNova'>

                            NOVA SENHA:<br><input style="color: black;" class="text-center" id='novaSenha' type="password" />
                            <br>
                            <br>
                            REPITA NOVA SENHA:<br><input style="color: black;"  class="text-center" id='novaSenha2' type="password" />
                            <br>
                            <br>
                        </div>

                        <button class="btn btn-sm Athena_button_submit"  onclick="login()">ACESSAR</button>

                        <br>
                        <br>
                        <div id="btnAlterar">
                            <button  onclick="alterarSenha()" class="btn Athena_button_book">ALTERAR SENHA</button>
                            <br>
                            <br>
                        </div>
                    </center>
                </div>
            </div>
            <div class="col-md-2 col-lg-2 col-xs-12" >
                <br>
                <br>
                <center>
                    <br>
                    <button id="btnCadastras" class="btn btn-lg Athena_button_dark_large"  onclick="menuNovoUsuario()">CADASTRE-SE</button>
                    <div id="btnLogar" hidden="true">
                        <button  class="btn btn-lg Athena_button_dark_large"  onclick="atualizar()" >LOGIN</button>
                    </div>
                </center>
            </div>
           
        </div>

        <div class="col-sm-3 col-sm-offset-9 col-md-3 col-md-offset-9 col-lg-3 col-lg-offset-9 " style="bottom: 4%;" >
            <center>
                <label>Desenvolvido por:<br>
                    <a style="color: black;" href="http://lattes.cnpq.br/3657386675052708">Daniel Antonio Karling</a></label>
            </center>
        </div>



    </body>




</html>