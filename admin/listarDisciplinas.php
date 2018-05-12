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

<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $codCurso . " - " . $nomeCurso; ?></title>
        <link href="../css/tcc.css" rel="stylesheet">
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/Athena.css" rel="stylesheet">

        <script src="../js/jquery-3.2.0.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/angular.min.js"></script>
        <script type="text/javascript">

            $(document).ready(function () {

                $.ajax({
                    url: "verificarLogin.php"
                }).done(function (data) {
                    if (data === 'erro') {
                        //alert(data);
                        alert('Você não está logado');
                        location.href = './login.php';
                    } else {
                        atualizar();

                    }
                });



            });


            function  verificarLogado() {
                $.ajax({
                    type: 'POST',
                    url: "verificarLoginCurso.php",
                    data: {idCurso: <?php echo $id_curso; ?>}
                }).done(function (data) {
                    if (data === 'erro') {
                        alert('Você não está logado:' + data);
                        location.href = './login.php';
                    }

                });
            }


            function pesquisar() {
                verificarLogado();
                atualizar();

            }


            confirmarDeletar = function (id) {
                verificarLogado();
                $.ajax({
                    type: 'POST',
                    url: "../modal/modalConfirmarDeletar.php",
                    data: {idDisciplina: id}
                }).done(function (data) {

                    $("#corpoModal").html(data);


                });
                $('#modal').modal('show');


            };
            deletarDisciplina = function (id) {
                verificarLogado();

                $("#modal").modal('hide');
                $.ajax({
                    type: 'POST',
                    url: "../ajax/excluirDisciplinaAjax.php",
                    data: {id: id}
                }).done(function (data) {
                    if (data !== 'sucesso') {
                        alert(data);

                    } else {
                        atualizar();

                    }
                });
            };
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

            function inputNovaCategoria() {
                $("#divSelectCategoria").hide(400);
                $("#divNovaCategoria").show(400);


            }
            function selecionarCategoria() {
                $("#divSelectCategoria").show(400);
                $("#divNovaCategoria").hide(400);
                $("#categoriaD").val("");



            }

            function inserirDisciplina() {
                var nome = document.getElementById("nomeD").value;
                var codigo = document.getElementById("codigoD").value;
                var ch = document.getElementById("chD").value;
//                var ativa = document.getElementById("ativaD").value;
                var categoriaInput = document.getElementById("categoriaD").value;
                var categoriaSelect = $("#selectCategoria").val();
                var categoria = "";
                if (categoriaInput === "") {
                    categoria = categoriaSelect;
                } else {
                    categoria = categoriaInput;
                }

                var idCurso = document.getElementById("idCurso").value;

                if (codigo === "") {
                    alert('Campo CODIGO não pode estar vazio');
                } else {

                    $.ajax({
                        type: 'POST',
                        url: "inserirDisciplina.php",
                        data: {nome: nome, codigo: codigo, ch: ch, categoria: categoria, idCurso: idCurso},
                    }).done(function (data) {
                        if (data !== "sucesso") {
                            alert(data);
                        }
                        atualizar();
                        $("#modal").modal("hide");

                    });
                }

            }


            function alterarDisciplina(idDisciplina) {
                verificarLogado();
                $.ajax({
                    type: 'POST',
                    url: "../modal/modalAlterarDisciplina.php",
                    data: {idCurso: <?php echo $id_curso; ?>, idDsciplina: idDisciplina}
                }).done(function (data) {

                    $("#corpoModal").html(data);


                });
                $('#modal').modal('show');



            }
            function alterarCurso(id) {
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


            function atualizar() {

                var nome = document.getElementById("nomeDigitado").value;
                var idCurso = document.getElementById("idCurso").value;
                //var nome = "daniel";
                //$nome = document.corpo.linha.aler-warning.nome;
                $.ajax({
                    type: 'POST',
                    url: "../ajax/listarDisciplinasAjax.php",
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
            function ativar(id, ativo) {
                verificarLogado();
                $.ajax({
                    type: 'POST',
                    url: "ativarDisciplina.php",
                    data: {id: id, ativo: ativo}
                }).done(function (data) {

                    atualizar();


                });



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
                    document.getElementById('imagem').src = 'img/aluno2.png';

                } else if (num === 6) {
                    document.getElementById('imagem').src = 'img/nova.png';

                } else if (num === 7) {
                    document.getElementById('imagem').src = 'img/nova.png';

                } else if (num === 0) {
                    document.getElementById('imagem').src = 'img/logo.png';


                }
            }
            
            
            function duplicarCurso() {
                $.ajax({
                    type: 'POST',
                    url: "../modal/duplicarCurso.php",
                    data: {idCurso: <?php echo $id_curso; ?>}

                }).done(function (data) {
                    

                    $('#modal').modal('show');
                    $("#corpoModal").html(data);



                });


            }
            


        </script>

    </head>

    <body class="Athena_background_three">

        <div class="row">
            <div class="col-lg-2 col-xs-2">
                <center>
                    <div  class="navbar navbar-fixed-top"  ng-hide="form"  style="margin-right: 80%">

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

                                                <li onmouseover="alterarImagem(2)" onmouseout="alterarImagem(0)" style="margin-top: 10px;"><button type="button" class="dropdown-toggle btn-primary" onclick="duplicarCurso()"> Criar Cópia</button></li>
                                            </center>
                                        </ul>
                                    </li>

<!--                                    <li style="margin-top: 10px;"><button type="button" class="btn-primary  btn-lg" onclick="window.location.href = 'lerCSV.php?idCurso=<?php echo $id_curso; ?>'"> Inserir Histórico</button></li>-->
                                    <li onmouseover="alterarImagem(3)" onmouseout="alterarImagem(0)" style="margin-top: 10px;"><button type="button" class="btn-primary  btn-lg" onclick="inserirHistorico()"> Inserir Histórico</button></li>

                                    <li onmouseover="alterarImagem(5)" onmouseout="alterarImagem(0)" style="margin-top: 10px;"><button type="button" class="bg-primary  btn-lg" onclick="window.location.href = 'listarDiscentes.php?codigo=<?php echo $codCurso; ?>'">Listar Discentes</button></li>
                                    <!--                                    ocultar curso-->
                                    <li onmouseover="alterarImagem(2)" onmouseout="alterarImagem(0)" style="margin-top: 10px;"><button type="button" id="btnDesativar" class="btn-lg"  onclick="desativar()">Desativar o Curso</button></li>
                                    <!--                                    ocultar curso-->                                    
                                    <li onmouseover="alterarImagem(4)" onmouseout="alterarImagem(0)" style="margin-top: 10px;"><button type="button" class="bg-info  btn-lg" onclick="window.location.href = 'index.php'"> Voltar</button></li>
                                    <li id="ajuda"></li>

                                    <br>

                                </ul>

                            </div>
                        </div>

                    </div>
                </center>
            </div>


            <div  class="col-lg-10 col-xs-10">
                <br><br><br>
                <div id="listaDisciplinas" >


                    <table class="table"  >
                        <thead>
                            <tr>
                                <th>Código</th><th>Nome</th><th>Categoria</th><th>Carga Horária</th><th>Horários</th><th>Ativo</th><th>Deletar</th>
                            </tr> 
                        </thead>
                        <tbody id="corpoLista" class = "">

                            <!--                            ajax-->

                        </tbody>
                    </table>  

                </div>
                <br>
                <br>
            </div>
        </div>



    </body>





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





</html>



