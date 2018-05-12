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

                    if (codRequisitos.options[i].selected == true) {
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
                $.ajax({
                    type: 'POST',
                    url: "reqProlog.php",
                    data: {codCurso: codCurso, idCurso: "<?php echo $idCurso; ?>"},
                }).done(function (data) {
                    alert(data);
                    atualizar();

                });

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
                    $("#requisitos").show();
                    $("#titulo").show();
                    $("#btnMostrar").val('OCULTAR');
                    //$("#btnMostrar").html('OCULTAR');
                    //$("#formulario").removeClass();
                    //$("#formulario").addClass("col-lg-6");
                    $("#formulario").hide();

                    // $("#divRequisitos").removeClass();
                    //$("#divRequisitos").addClass("col-lg-6");

                } else {
                    $("#requisitos").hide();
                    $("#titulo").hide();
                    $("#btnMostrar").val('MOSTRAR');
                    //$("#btnMostrar").html('LISTA DE REQUISITOS');
                    //$("#formulario").removeClass();
                    //$("#formulario").addClass("col-lg-8");

                    $("#formulario").show();
                    //$("#divRequisitos").removeClass();
                    //$("#divRequisitos").addClass("col-lg-2");

                }

            }

        </script>

    </head>
    <body class="Athena_modal">



        <div class="row">
            <div id="formulario"  >
                <center>
                    <div >


                        <br>
                        <br>
                        <form id="lista" class="container-fluid center-block" >
                            <div class="panel panel-primary" style="margin-left: 10%; margin-right: 10%">
                                <h4 class="text-info">DISCIPLINA</h4>
                                <select  id="selectDisciplina" class="btn  text-uppercase text-info text-center" name="codDisciplina">

                                    <!--                ajax-->

                                </select>
                                <br>
                                <br>
                            </div>
                            <div class="panel panel-primary " style="margin-left: 10%; margin-right: 10%">
                                <h4 class="text-info" >REQUISITOS</h4>
                                <select   class="text-uppercase text-info " style="border: white" name="codRequisito[]" id="selectRequisitos" size="12" multiple >

                                    <!--                ajax-->

                                </select>
                                <input class="text-success" name="codCurso" type="hidden" id="codCurso" value = "<?php echo $codCurso; ?>">
                                <input class="text-success" name="nomeCurso" type="hidden" id="nomeCurso" value = "<?php echo $nomeCurso; ?>">
                                <input class="text-success" name="idCurso" type="hidden" id="idCurso" value = "<?php echo $idCurso; ?>">
                                <br>
                                <br>
                                <input type="button" class="btn Athena_button_book" onclick="salvar()" name="submit" class="alert-success" value="ADICIONAR">
                                <br>
                                <br>
                            </div>
                        </form>
                        <button class="btn btn-success" onclick="cadastrar()">SALVAR ALTERAÇÕES</button>
                        <br>
                        <br>
                        <button type="button" class="btn btn-default" onclick="window.location.href = '../admin/listarDisciplinas.php?codigo=<?php echo $codCurso; ?>'"> Voltar</button>


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
