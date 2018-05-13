<?php
include_once '../modal.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title id="titulo">Cadastrar Requisitos</title>
        <?php
        $idCurso = $_GET["idCurso"];
        $nomeCurso = $_GET["nomeCurso"];
        $codCurso = $_GET["codigo"];
        ?>
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/Athena.css" rel="stylesheet">

        <script src="../js/jquery-3.2.0.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $.ajax({
                    url: "../admin/verificarLogin.php"
                }).done(function (data) {
                    if (data === 'erro') {
                        alert('Você não está logado');
                        location.href = '../admin/login.php';
                    } else {
                        atualizar();
                    }
                });
            });
            function  verificarLogado() {
                $.ajax({
                    type: 'POST',
                    url: "../admin/verificarLoginCurso.php",
                    data: {idCurso: <?php echo $idCurso; ?>}
                }).done(function (data) {
                    if (data === 'erro') {
                        alert('Você não está logado:' + data);
                        location.href = '../admin/login.php';
                    }
                });
            }
            var order = "disciplina";
            function atualizar() {
                verificarLogado();
                $.ajax({
                    type: "post",
                    url: "../ajax/cadastrarRequisitoListaDisciplinaAjax.php",
                    data: {idCurso: "<?php echo $idCurso; ?>"}
                }).done(function (data) {
                    $("#selectDisciplina").html(data);
                });
                $.ajax({
                    type: "post",
                    url: "../ajax/cadastrarRequisitoListaRequisitoAjax.php",
                    data: {idCurso: "<?php echo $idCurso; ?>"}
                }).done(function (data) {
                    $("#selectRequisitos").html(data);
                });
                $.ajax({
                    type: "post",
                    url: "../ajax/requisitosAjax.php",
                    data: {idCurso: "<?php echo $idCurso; ?>", order: order}
                }).done(function (data) {
                    $("#requisitos").html(data);
                });
            }
            function apagarRequisito(id) {
                $.ajax({
                    type: "post",
                    url: "../ajax/apagarRequisito.php",
                    data: {id: id}
                }).done(function (data) {
                    atualizar();
                });
            }
            function salvar() {
                var codRequisitos = document.getElementById("selectRequisitos");
                var codCurso = document.getElementById("codCurso").value;
                var codDisciplina = $("#selectDisciplina").find(":selected").val();
                var codRequisitosSelecionados = Array();
                for (var i = 0; i < (codRequisitos.length); i = i + 1) {
                    if (codRequisitos.options[i].selected === true) {
                        codRequisitosSelecionados.push((codRequisitos[i].value));
                    }
                }
                $.ajax({
                    type: 'POST',
                    url: "../ajax/gravarRequisito.php",
                    data: {idCurso: <?php echo $idCurso; ?>, codRequisito: codRequisitosSelecionados, codCurso: codCurso, codDisciplina: codDisciplina}
                }).done(function (data) {
                   
                    atualizar();
                });
            }





            function cadastrar() {
                var codCurso = document.getElementById("codCurso").value;

                $("#cadastrar").html("AGUARDE.....");
                $("#cadastrar").attr('disabled', true);
                $("#add").attr('disabled', true);
                $("#voltar").attr('disabled', true);
                $("#titulo").html("CARREGANDO... AGUARDE");

                setTimeout(function () {

                    $.ajax({
                        type: 'POST',
                        url: "reqProlog.php",
                        async: false,
                        data: {codCurso: codCurso, idCurso: "<?php echo $idCurso; ?>"},
                    }).done(function (data) {
                        alert(data);

                        $("#cadastrar").html("SALVAR ALTERAÇÕES");
                        $("#cadastrar").attr('disabled', false);
                        $("#voltar").attr('disabled', false);
                        $("#add").attr('disabled', false);
                        $("#titulo").html("Cadastrar Requisitos");

                        atualizar();
                    });

                }, 500);

            }


            function excluirTodos(id) {
                $.ajax({
                    type: 'POST',
                    url: "excluirReq.php",
                    data: {idCurso: id}
                }).done(function (data) {
                    alert(data);
                    atualizar();
                    mostrarRequisitos();
                });
            }
            function mostrarRequisitos() {
                if ($("#btnMostrar").val() === 'MOSTRAR') {
                    $("#requisitos").show(500);
                    $("#titulo").show();
                    $("#btnMostrar").val('OCULTAR');
                    //$("#btnMostrar").html('OCULTAR');
                    //$("#formulario").removeClass();
                    //$("#formulario").addClass("col-lg-6");
                    $("#formulario").hide();
                    // $("#divRequisitos").removeClass();
                    //$("#divRequisitos").addClass("col-lg-6");
                } else {
                    $("#requisitos").hide(500);
                    $("#titulo").hide();
                    $("#btnMostrar").val('MOSTRAR');
                    //$("#btnMostrar").html('LISTA DE REQUISITOS');
                    //$("#formulario").removeClass();
                    //$("#formulario").addClass("col-lg-8");
                    $("#formulario").show(500);
                    //$("#divRequisitos").removeClass();
                    //$("#divRequisitos").addClass("col-lg-2");
                }
            }
            function mostraAjuda(i) {
                if (i === 1) {
                    $("#ajuda").html("<h5>Segure CTRL para selecionar mais de uma disciplina<h5>");
                } else {
                    $("#ajuda").html("<h5><br></h5>");
                }

            }

            function mostrarAjudaRequisitos(i) {
                $("#ajuda3").hide();
                if (i === 1) {
                    $("#ajudaRequisito").attr("disabled", true);
                    $("#ajuda1").show(500);
                } else
                if (i === 2) {
                    
                    $("#ajudaRequisito").attr("disabled", true);
                    $("#ajuda1").hide(200);
                    $("#ajuda2").show(700);
                } else if (i === 3) {
                
                    $("#ajudaRequisito").attr("disabled", true);
                    $("#ajuda2").hide(200);
                    $("#ajuda3").show(700);
                }else{
                    
                    $("#ajudaRequisito").attr("disabled", false);
                }

            }

            function modalAjuda(i) {

                if (i === 3) {
                    $("#modal").modal('hide');

                } else {
                    var url = "../modal/ajudaReq" + i + ".php";

                    $.ajax({
                        url: url
                    }).done(function (data) {
                        $("#corpoModal").html(data);

                    });
                    if (i === 0) {

                        $("#modal").css("width", 600);
                        $("#modal").css("margin-left", 200);


                    } else if (i === 1) {
                        $("#modal").css("margin-top", 30);
                        $("#modal").css("margin-left", 550);
                    }
                    $('#modal').modal('show');
                }

            }
        </script>

    </head>
    <body class="Athena_modal">

        <div class="row">

            <div id="formulario"  >
                <center>
                    <div style="margin-left: 90%; padding-right: 2px; padding-top: 2px;"><button id="ajudaRequisito" onclick="mostrarAjudaRequisitos(1)" class="btn btn-sm btn-danger">AJUDA</button></div>
                    <div >
                        <div class="panel panel-primary " hidden="true" id="ajuda1">
                            <label class="text-info">
                                Algumas disciplina podem depender de conteúdos de outras, <br>
                                necessitando que o aluno aprenda conceitos específicos antes de cursar-las.
                                <br>
                                Neste caso, devemos cadastrar os requisitos das disciplinas.
                            </label>
                            <br>
                            <button onclick="mostrarAjudaRequisitos(2)" class="btn btn-sm btn-danger">Próximo</button>
                        </div>
                        <br>
                        <br>
                        <div id="lista" class="container-fluid center-block" >

                            <div class="panel panel-primary" style="margin-left: 10%; margin-right: 10%">

                                <h4 class="text-info">DISCIPLINA</h4>
                                <select  id="selectDisciplina" class="btn  text-uppercase text-info text-center" name="codDisciplina">

                                    <!--                ajax-->

                                </select>
                                <br>
                                <br>
                                <div hidden="true" id="ajuda2">
                                    <label class="panel panel-collapse text-info">
                                        Aqui você deve selecionar a disciplina que depende de conteúdos abordados em outras
                                    </label>
                                    <button onclick="mostrarAjudaRequisitos(3)" class="btn btn-sm btn-danger">Próximo</button>
                                    <br>
                                </div>
                            </div>

                            <div class="panel panel-primary " style="margin-left: 10%; margin-right: 10%">
                                <h4 class="text-info" >REQUISITOS</h4>
                                <select onmouseover="mostraAjuda(1)" onmouseout="mostraAjuda(0)" class="text-uppercase text-info " style="border: white" name="codRequisito[]" id="selectRequisitos" size="12" multiple >

                                    <!--                ajax-->

                                </select>
                                <input class="text-success" name="codCurso" type="hidden" id="codCurso" value = "<?php echo $codCurso; ?>">
                                <input class="text-success" name="nomeCurso" type="hidden" id="nomeCurso" value = "<?php echo $nomeCurso; ?>">
                                <input class="text-success" name="idCurso" type="hidden" id="idCurso" value = "<?php echo $idCurso; ?>">
                                <br>
                                <br>
                                <div id="ajuda" class="text-primary"><h5><br></h5></div>
                                <input type="button" id="add"  class="btn Athena_button_book" onclick="salvar()" name="submit" class="alert-success" value="ADICIONAR">
                                <br>
                                <br>

                                <div hidden="true" id="ajuda3">
                                    <label class="panel panel-collapse text-info">
                                        E aqui você seleciona todas as disciplinas que apresentam conteúdos requisitados pela primeira
                                    </label>
                                    <button onclick="mostrarAjudaRequisitos(4)" class="btn btn-sm btn-danger">Fim</button>
                                </div>
                            </div>
                        </div>
                        <button id="cadastrar" class="btn btn-success" onclick="cadastrar()">SALVAR ALTERAÇÕES</button>
                        <br>
                        <br>
                        <button id="voltar" type="button" class="btn btn-default" onclick="window.location.href = '../admin/listarDisciplinas.php?codigo=<?php echo $codCurso; ?>'"> Voltar</button>


                    </div>


                </center>
            </div>


            <div id="divRequisitos" style="margin-top: 10px;  margin-left: 10%;" >


                <center>

                    <div class="navbar navbar-fixed-top" style="margin-top: 20%; margin-left: 100%; margin-right: 1px;"  >

                        <button id="btnMostrar" class="nav navbar-right btn btn-md btn-default" value="MOSTRAR" style="transform: rotate(270deg);" onclick="mostrarRequisitos()">LISTA DE REQUISITOS</button>
                    </div>
                    <br>
                </center>
                <h4 hidden="true" id="titulo" class="text-uppercase text-info">Requisitos Cadastrados</h4>

                <div  hidden="true" id="requisitos">

                    <!--                    ajax-->



                </div>


            </div>
        </div>


    </body>



</html>