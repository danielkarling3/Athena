
<html>
    <head>
        <meta charset="UTF-8">
        <title id="titulo" >Administração</title>
        <link href="../css/bootstrap.css" rel="stylesheet">
        <link href="../css/Athena.css" rel="stylesheet">

        <script src="../js/jquery-3.2.0.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>

        <script src="../js/angular.min.js" type="text/javascript"></script>

        <script type="text/javascript">
//            angular.module('listarCursos', []).controller('Controller', function ($scope) {
//
//                $scope.codCurso = '';
//                $scope.nomeCurso = '';
//
//            });


            function novoCurso() {
                verificarLogado();

                $.ajax({
                    url: "../modal/novoCursoModal.php",
                }).done(function (data) {

                    $("#corpoModal").html(data);


                });
                $('#modal').modal('show');

            }
            $(document).ready(function () {
                $.ajax({
                    url: "verificarLogin.php",
                }).done(function (data) {
                    if (data === 'erro') {
                        alert('Você não está logado');
                        location.href = './login.php';
                    }
                });

            });
        </script>
        <?php
        session_start();
        $nomeUsuario = $_SESSION["usuario"]['nome'];
        $id_usuario = $_SESSION["usuario"]['id'];
        ?>
        <script>
            function alterarCurso(id) {
                //desaparecer o modal listar 
                verificarLogado();
                $('#modalListarCursos').modal('hide');
                $.ajax({
                    type: 'POST',
                    url: "../modal/modalAlterarCurso.php",
                    data: {idCurso: id}
                }).done(function (data) {

                    $("#corpoModal").html(data);
                });
                $('#modal').modal('show');
            }
            function logout() {
                $.ajax({
                    type: 'POST',
                    url: "logout.php",
                }).done(function (data) {

                    location.href = './login.php';
                });
            }

            function  verificarLogado() {
                $.ajax({
                    url: "verificarLogin.php"
                }).done(function (data) {
                    if (data === 'erro') {
                        alert('Você não está logado');
                        location.href = './login.php';
                    }

                });
            }

            function compartilhar(idCurso) {
                $('#modalListarCursos').modal('hide');
                $.ajax({
                    type: 'POST',
                    url: "../ajax/listarUsuariosAjax.php",
                    data: {idCurso: idCurso, idUsuario: <?php echo $_SESSION["usuario"]['id'] ?>}

                }).done(function (data) {
                    $("#corpoModal").html(data);
                    $('#modal').modal('show');

                });

            }

            function  finalizarCompartilhamento(idCurso, idConvidado) {
                $("#modal").modal('hide');
                $.ajax({
                    type: 'POST',
                    url: "compartilhar.php",
                    data: {idCurso: idCurso, idConvidado: idConvidado}

                }).done(function (data) {
                    $("#corpoModal").html(data);
                    alert(data);
                    atualizar();

                });


            }
            function alterarImagem(num) {
                verificarLogado();
                if (num === 1) {
                    document.getElementById('imagem').src = 'img/voltar.png';

                } else if (num === 0) {
                    document.getElementById('imagem').src = 'img/logo.png';

                }
            }


        </script>




    </head>

    <body class="Athena_background">


        <?php
        include '../cabecalho.php';
        ?>


        <div class="row" style="margin-top: 5%;">

            <div class="col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3 col-xs-12">
                <div class="Athena_login" style="margin-left: 20%; margin-right: 20%;  margin-top: 2%;" >
                    <center>
                        <div class="panel Athena_cabecalho" style="background-color: rgba(11,1,1,0.5);   margin-left: 15%; margin-right: 15%;">
                            <h3 >Ambiente de Administração</h3>
                        </div>


                        <button onmouseover="alterarImagem(2)" onmouseout="alterarImagem(4)" class="btn Athena_button_submit" onclick="novoCurso()">Cadastrar Curso</button>
                        <br><br>

                        <button onmouseover="alterarImagem(2)" onmouseout="alterarImagem(4)" class="btn Athena_button_submit" data-toggle="modal" onmouseover="verificarLogado()" data-target="#modalListarCursos">Visualizar Curso</button>
                        <br>
                        <br>

                    </center>
                </div>
            </div>


            <div class="col-md-3 col-lg-3 col-xs-12" style="margin-top: 2px;" >
                <div class="Athena_panel" >
                    <center>
                        <img id="imagem" src="img/logo.png" height="80" width="80">
                        <br>
                        <br>
                        <label id="user" class="text-uppercase"><?php echo $nomeUsuario; ?></label>
                        <br>
                        <br>
                        <button onmouseover="alterarImagem(1)" onmouseout="alterarImagem(0)" id='logout' class="btn Athena_button_red_large" onclick="logout()">LOGOUT</button>
                    </center>
                </div>
            </div>

        </div>

        <?php
        include_once './modal.php';
        include_once '../classes/ListarCursos.php';
        $listCursos = new ListarCursos($id_usuario);
        ?>



    <center>
        <div ng-controller="Controller" class="modal modal-dismiss" id="modalListarCursos">
            <div class="modal-lg bg-warning">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                        <h4 id="tituloModal" class="modal-title bg-warning">Selecionar Curso: </h4>
                    </div>

                    <div class="modal-body bg-warning">
                        <center>

                            <?php
                            $listCursos->listar();
                            ?>

                        </center>
                    </div>
                    <div class="modal-footer bg-warning">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>



    </center>
</body>



</html>