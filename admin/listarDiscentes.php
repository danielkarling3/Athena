<?php
include_once '../classes/ListarDisciplinas.php';
include_once '../classes/BD/crudPDO.php';
include_once './modal.php';




$codCurso = $_GET["codigo"];


$existe = numLinhasSelecionarWHERE("curso", array("ID"), "codigo = '$codCurso'");
if ($existe == 0) {

    echo "<script>alert('Curso não encontrado');</script>";
    print "<script type = 'text/javascript'> location.href = './index.php' </script>";
    die();
}
$id_curso = "";
$fetch = selecionarWHERE("curso", array("id", "visivel"), "codigo = '" . $codCurso . "' limit 1;");
foreach ($fetch as $f) {
    $id_curso = $f["id"];
    $visivel_curso = $f["visivel"];
}
$listDisciplinas = new ListarDisciplinas($id_curso);
$fetch = selecionarWHERE("curso", array("nome"), "id= '$id_curso' LIMIT 1");
foreach ($fetch as $f) {
    $nomeCurso = $f["nome"];
}
?>

<html >
    <head >
        <meta charset="UTF-8">
        <title><?php echo $codCurso . " - " . $nomeCurso; ?></title>
        <link href="../css/tcc.css" rel="stylesheet">
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/Athena.css" rel="stylesheet">

        <script src="../js/jquery-3.2.0.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script type="text/javascript">
//            angular.module('Disciplina', []).controller('MeuController', function ($scope) {
//                $scope.nomeDisciplina = '';
//
//                $scope.novoNome = '';
//                $scope.novoCodigo = '';
//                $scope.novaCH;
//                $scope.novaAtiva;
//
//                $scope.form = false;
//
//
//            });
            function novaDisciplinaModal() {
                $.ajax({
                    type: 'POST',
                    url: "../modal/novaDisciplinaModal.php",
                    data: {idCurso: <?php echo $id_curso; ?>}
                }).done(function (data) {

                    $("#corpoModal").html(data);


                });
                $('#modal').modal('show');

            }


            function  verificarLogado() {
                $.ajax({
                    type: 'POST',
                    url: "verificarLoginCurso.php",
                    data: {idCurso: <?php echo $id_curso; ?>}
                }).done(function (data) {
                    if (data === 'erro') {
                        alert('Você não está logado');
                        location.href = './login.php';
                    }

                });
            }

            $(document).ready(function () {


                $.ajax({
                    url: "verificarLogin.php"
                }).done(function (data) {
                    if (data === 'erro') {
                        alert('Você não está logado');
                        location.href = './login.php';
                    } else {
                        atualizar();
                    }
                });



            });


            function inserirHistorico() {

                $.ajax({
                    type: 'POST',
                    url: "verificarLoginCurso.php",
                    data: {idCurso: <?php echo $id_curso; ?>}
                }).done(function (data) {
                    if (data === "logado") {
                        $('#modalListarCursos').modal('hide');
                        $.ajax({
                            type: 'POST',
                            url: "../modal/lerCSV.php",
                            data: {idCurso: <?php echo $id_curso; ?>}
                        }).done(function (data) {

                            $("#corpoModal").html(data);


                        });
                        $('#modal').modal('show');

                    } else {
                        alert(data);
                        location.href = './login.php';
                    }
                });



            }
            function pesquisar() {
                verificarLogado();
                atualizar();

            }

            function atualizar() {

                var nome = document.getElementById("nomeDigitado").value;
                var idCurso = document.getElementById("idCurso").value;
                //var nome = "daniel";
                //$nome = document.corpo.linha.aler-warning.nome;
                $.ajax({
                    type: 'POST',
                    url: "../ajax/listarDiscentesAjax.php",
                    data: {idCurso: idCurso, nome: nome},
                }).done(function (data) {

                    $("#corpoLista").html(data);

                });
                $.ajax({
                    type: 'POST',
                    url: "../ajax/corpoModalListarCursosAjax.php",
                    data: {idUsuario: <?php echo $_SESSION["usuario"]['id'] ?>}
                }).done(function (data) {

                    $("#corpoModalListaCursos").html(data);

                });

                if (<?php echo $visivel_curso; ?> === 1) {
                    $("#btnDesativar").html("Desativar o Curso");
                    $("#btnDesativar").addClass("bg-danger");
                } else {
                    $("#btnDesativar").html("Ativar o Curso");
                    $("#btnDesativar").removeClass("bg-danger");
                    $("#btnDesativar").addClass("bg-success");
                }
            }


            function compartilhar(idCurso) {
                //$("#modalListarCursos").modal('hide');
                $.ajax({
                    type: 'POST',
                    url: "../ajax/listarUsuariosAjax.php",
                    data: {idCurso: idCurso, idUsuario: <?php echo $_SESSION["usuario"]['id'] ?>}

                }).done(function (data) {
                    $("#corpoModalListaCursos").html(data);
                    //$("#modal").modal('show');

                });

            }


            function  finalizarCompartilhamento(idCurso, idConvidado) {

                $.ajax({
                    type: 'POST',
                    url: "compartilhar.php",
                    data: {idCurso: idCurso, idConvidado: idConvidado}

                }).done(function (data) {
                    $("#modalListarCursos").modal('hide');
                    alert(data);
                    atualizar();

                });


            }
            function alterarImagem(num) {
                verificarLogado();
                if (num === 1) {
                    document.getElementById('imagem').src = 'img/nova.png';

                } else if (num === 2) {
                    document.getElementById('imagem').src = 'img/curso3.png';

                } else if (num === 3) {
                    document.getElementById('imagem').src = 'img/historico.png';

                } else if (num === 4) {
                    document.getElementById('imagem').src = 'img/voltar.png';

                } else if (num === 5) {
                    document.getElementById('imagem').src = 'img/livro2.png';

                } else if (num === 6) {
                    document.getElementById('imagem').src = 'img/nova.png';

                } else if (num === 7) {
                    document.getElementById('imagem').src = 'img/nova.png';

                } else if (num === 0) {
                    document.getElementById('imagem').src = 'img/logo.png';

                }
            }

            function listaCompartilhado() {
                $.ajax({
                    type: 'POST',
                    url: "../modal/modalListaCompartilhado.php",
                    data: {idCurso: <?php echo $id_curso; ?>}

                }).done(function (data) {
                    $("#corpoModal").html(data);
                    $('#modal').modal('show');



                });

            }

            function descompartilhar(idConvidado) {
                $.ajax({
                    type: 'POST',
                    url: "descompartilhar.php",
                    data: {idConvidado: idConvidado, idCurso: <?php echo $id_curso; ?>}

                }).done(function (data) {

                    $('#modal').modal('hide');
                    alert(data);
                    atualizar();



                });

            }
            function desativar() {
                if ($("#btnDesativar").html() === "Desativar o Curso") {

                    $.ajax({
                        type: 'POST',
                        url: "../ajax/desativarCurso.php",
                        data: {idCurso: <?php echo $id_curso; ?>, inserir: 0}

                    }).done(function (data) {
                        if (data === "erro") {
                            alert("Erro");
                        } else {
                            $("#btnDesativar").removeClass("bg-danger");
                            $("#btnDesativar").addClass("bg-success");
                            $("#btnDesativar").html("Ativar o Curso");
                        }
                    });
                } else {

                    $.ajax({
                        type: 'POST',
                        url: "../ajax/desativarCurso.php",
                        data: {idCurso: <?php echo $id_curso; ?>, inserir: 1}

                    }).done(function (data) {
                        if (data === "erro") {
                            alert("Erro");
                        } else {

                            $("#btnDesativar").removeClass("bg-success");
                            $("#btnDesativar").addClass("bg-danger");
                            $("#btnDesativar").html("Desativar o Curso");
                        }
                    });
                }

            }

            function admin() {
                $("#divAreaRestrita").show(500);
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
                        $("#divAreaRestrita").hide(600);
                        $('#ADM').val('');
                        $('#senhaADM').val('');
                        $("#btnAdmin").show(600);
                        $("#divAdmin").hide(300);
                        $("#opcoesRestritas").show(300);
                    } else {
                        alert("Bem vindo, administrador do Sistema Athena ");
                        $("#divAreaRestrita").hide(300);
                        $("#listaDisciplinas").hide(300);

                        $("#divDeletarCurso").show(300);

                    }

                });
            }

            function deletarHistoricos() {
                $.ajax({
                    type: 'POST',
                    url: "../ajax/deletarHistoricos.php",
                    data: {idCurso: <?php echo $id_curso; ?>}
                }).done(function (data) {
                    alert(data);
                    $('#modal').modal('hide');
                    $("#divAreaRestrita").hide(300);

                    $("#btnAdmin").show(600);
                    atualizar();

                });
            }

            function deletarHistoricosModal() {

                $("#corpoModal").html("<center><h4>Deseja Realmente Deletar Todas os Históricos dos Alunos?</h4><br><button class='btn btn-danger' onclick='deletarHistoricos();'>SIM</button></center>");

                $('#modal').modal('show');
            }
            function deletarCurso() {

                $("#corpoModal").html("<center><h4>Essa Ação é Definitiva</h4><br><button class='btn btn-danger' onclick='confirmarDeletarCurso();'>CONFIRMAR</button></center>");

                $('#modal').modal('show');
            }

            function confirmarDeletarCurso() {

                $.ajax({
                    type: 'POST',
                    url: "../ajax/deletarCurso.php",
                    data: {idCurso: <?php echo $id_curso; ?>}
                }).done(function (data) {
                    alert(data);
                    if (data === 'sucesso') {
                        $('#modal').modal('hide');
                        location.href = "index.php";
                    }

                });

            }
            function divDeletarCurso() {
                $("#divAdmin").show(300);
                $("#opcoesRestritas").hide(300);
            }

        </script>

    </head>

    <body class="Athena_background_three">

        <div class="row">
            <div class="col-lg-2">
                <center>
                    <div  class="navbar navbar-fixed-top" style="margin-right: 80%">

                        <div class="navbar-header">

                            <div id ="menu" class="nav navbar-left ">
                                <ul class="nav navbar-left" style="margin-top: 10px; margin-left: 10px;" >

                                    <li>
                                        <img id="imagem" src="img/logo.png" height="140px" width="135px">
                                    </li>

                                    <li>
                                        <label class="text-uppercase">Pesquisar: </label> 
                                        <br><input type="text" class="text-warning"name="nomeDigitado" id="nomeDigitado" onkeyup="pesquisar()"/>
                                        <br> <input type="hidden" name="idCurso" id="idCurso" value="<?php echo $id_curso; ?>"/>
                                    </li>

                                    <li class=" dropdown" style="margin-right: 10px; ">
                                        <br>
                                        <a  onmouseover="alterarImagem(1)" onmouseout="alterarImagem(0)" href="#" class="dropdown-toggle btn-primary btn-lg" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Disciplinas <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <center>

                                                <div>
                                                    <!--                                                    <br>
                                                                                                        <li ><button class="dropdown-toggle btn-primary" data-toggle="modal" data-target="#mostrarDisciplinas">Mostrar Disciplinas</button></li>-->
                                                    <br>
                                                    <!--                                                    <li><button class="dropdown-toggle btn-primary" data-toggle="modal" data-target="#modalDisciplina">Nova Disciplina</button></li>-->
                                                    <li><button onmouseover="alterarImagem(6)" onmouseout="alterarImagem(0)" class="dropdown-toggle btn-primary" onclick="novaDisciplinaModal()">Nova Disciplina</button></li>
                                                    <br>
                                                    <li><button onmouseover="alterarImagem(7)" onmouseout="alterarImagem(0)" class="dropdown-toggle btn-primary" type="button" onclick="window.location.href = '../requisitos/cadastrarRequisitos.php?idCurso=<?php echo $id_curso; ?>&codigo=<?php echo $codCurso; ?>&nomeCurso=<?php echo $nomeCurso; ?>'"> Cadastrar Requisitos</button></li>

                                                </div>
                                            </center>
                                        </ul>
                                    </li>

                                    <li class=" dropdown" style="margin-right: 10px; ">
                                        <br>
                                        <a  onmouseover="alterarImagem(2)" onmouseout="alterarImagem(0)" href="#" class="dropdown-toggle btn-primary btn-lg" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Curso <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <center>


                                                <li onmouseover="alterarImagem(2)" onmouseout="alterarImagem(0)" style="margin-top: 10px;"><button type="button" class="dropdown-toggle btn-primary" data-toggle="modal" data-target="#modalListarCursos">Listar Cursos</button></li>

                                                <li onmouseover="alterarImagem(2)" onmouseout="alterarImagem(0)" style="margin-top: 10px;"><button type="button" class="dropdown-toggle btn-primary" onclick="listaCompartilhado()"> Compartilhado</button></li>
                                            </center>
                                        </ul>
                                    </li>


<!--                                    <li style="margin-top: 10px;"><button type="button" class="btn-primary  btn-lg" onclick="window.location.href = 'lerCSV.php?idCurso=<?php echo $id_curso; ?>'"> Inserir Histórico</button></li>-->
                                    <li onmouseover="alterarImagem(3)" onmouseout="alterarImagem(0)" style="margin-top: 10px;"><button type="button" class="btn-primary  btn-lg" onclick="inserirHistorico()"> Inserir Histórico</button></li>

                                    <li onmouseover="alterarImagem(5)" onmouseout="alterarImagem(0)" style="margin-top: 10px;"><button type="button" class="bg-primary  btn-lg" onclick="window.location.href = 'listarDisciplinas.php?codigo=<?php echo $codCurso; ?>'">Listar Disciplinas</button></li>
                                    <!--                                    ocultar curso-->
                                    <li onmouseover="alterarImagem(2)" onmouseout="alterarImagem(0)" style="margin-top: 10px;"><button type="button" id="btnDesativar" class="btn-lg"  onclick="desativar()">Desativar o Curso</button></li>
                                    <!--                                    ocultar curso-->                                    

                                    <li onmouseover="alterarImagem(4)" onmouseout="alterarImagem(0)" style="margin-top: 10px;"><button type="button" class="bg-info  btn-lg" onclick="window.location.href = 'index.php'"> Voltar</button></li>
                                    <br>

                                </ul>

                            </div>
                        </div>

                    </div>
                </center>
            </div>


            <div  class="col-lg-10">
                <br><br><br>
                <?php
                include_once 'btnAreaRestrita.php';
                ?>
                <br>
                <br>
                <center>

                    <?php
                    include_once 'areaRestrita.php';
                    ?>
                    <div id="divDeletarCurso" hidden="true">

                        <label>Deseja Deletar o Curso e Todas as Informações?</label>
                        <button class="btn btn-default" onclick="deletarCurso()">
                            Confirmar
                        </button>

                    </div>
                </center>
                <br>
                <div id="listaDisciplinas" >




                    <table class="table" >
                        <thead>
                            <tr>
                                <th>ID</th><th>Nome</th><th>Matrícula</th><th>Ano</th><th>Atividade Curricular</th><th>Media Final</th><th>Situação</th><th>Período</th><th>Carga Horária Total</th><th>Ano Ingresso</th><th>Forma Evasão</th><th>Ano Evasão</th><th>Sexo</th>
                            </tr> 
                        </thead>
                        <tbody id="corpoLista" >


                            <!--                            ajax-->

                        </tbody>
                    </table>  

                </div>
                <br>
                <br>
                <center>
            </div>
        </div>
        <div class="row">

        </div>







        <div class="modal fade" id="modalListarCursos">

            <center>
                <div class="modal-lg Athena_modal">
                    <div class="modal-content">
                        <div class="modal-header Athena_modal">
                            <button type="button" class="close" data-dismiss="modal" onclick="atualizar()"><span>×</span></button>
                            <h4 class="modal-title text-info Athena_modal">Selecionar Curso</h4>
                        </div>
                        <div id="corpoModalListaCursos" class="modal-body Athena_modal">
                            <center>




                            </center>
                        </div>
                        <div class="Athena_modal_fother">
                            <button type="button" class="btn btn-default" data-dismiss="modal" onclick="atualizar()">Fechar</button>
                            <br>
                            <br>
                        </div>
                    </div>
                </div>
            </center>
        </div>




        <div class="modal fade" id="mostrarDisciplinas">

            <center>
                <div class="modal-lg">
                    <div class="modal-content">
                        <div class="modal-header Athena_modal">
                            <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                            <h4 class="modal-title Athena_modal">Disciplinas</h4>
                        </div>
                        <div class="modal-body Athena_modal">
                            <center>
                                <table class="table Athena_modal" >
                                    <tr  class = "Athena_modal ">
                                        <th>Código</th><th>Alterar</th><th>Nome</th><th>Categoria</th><th>Carga Horária</th><th>Horários</th>              
                                    </tr> 


                                </table>  
                            </center>
                        </div>
                        <div class="Athena_modal_fother">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
        </div>





</html>



