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
                    $("#btnCadastrar").hide();
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
            <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4 col-xs-8 col-xs-offset-2">
                <div id="menu" class="Athena_login "  style=" margin-top: 5%;">
                    <div class="panel Athena_cabecalho" style="margin-left: 5%; margin-right: 5%;">
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

            <div class=" col-sm-6 col-sm-offset-3 col-md-2 col-md-offset-1  col-lg-2 col-lg-offset-1 col-xs-10 col-xs-offset-1" style="margin-top: 20px;" >
                <div class="Athena_panel" >
                    <center>

                        <label>Ambiente de <br>Consulta</label><br>
                        <button id="btnCadastras" class="btn btn-lg Athena_button_submit"  onclick="window.location.href = '../index.php'">Acessar</button>

                    </center>
                </div>
            </div>
        </div>

        <div class="row" >
            <center>
                <br>
                <button id="btnCadastrar" class="btn btn-lg Athena_button_dark_large"  onclick="menuNovoUsuario()">CADASTRE-SE</button>
                <div id="btnLogar" hidden="true">
                    <button  class="btn btn-lg Athena_button_dark_large"  onclick="atualizar()" >LOGIN</button>
                </div>
            </center>
        </div>



        <div class="col-lg-4 col-lg-offset-8 col-sm-4 col-sm-offset-8 col-md-4 col-md-offset-8 col-xs-4 col-xs-offset-8 " style="bottom: 4%;" >
            <center>
                <label>Desenvolvido por:<br>
                    <a style="color: black;" href="http://lattes.cnpq.br/3657386675052708">Daniel Antonio Karling</a></label>
            </center>
        </div>



    </body>




</html>