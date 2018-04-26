<?php
include_once './modal.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Recomendações de Disciplinas</title>
        <link href="./css/bootstrap.min.css" rel="stylesheet">

        <link href="./css/Athena.css" rel="stylesheet">

        <script src="./js/jquery-3.2.0.min.js"></script>
        <script src="./js/bootstrap.min.js"></script>
        <script type="text/javascript">

            var order = 'rec';
            function atualizar() {
                $.ajax({
                    type: 'POST',
                    url: "listaRecomendacao.php",
                    data: {order: order}
                }).done(function (data) {
                    $("#lista").html(data);
                });
            }

            function ordenaRec() {
                order = 'rec';
                atualizar();
            }
            function ordenaColisao() {
                order = 'colisao';
                atualizar();
            }


            //mostra div com os horarios
            function mostrar(cod) {
                var idButton = "#btnHorarios" + cod;
                var idDiv = "#divHorarios" + cod;
                $(idButton).hide();
                $(idDiv).show();
            }

            //esconde div com os horarios
            function esconder(cod) {
                var idButton = "#btnHorarios" + cod;
                var idDiv = "#divHorarios" + cod;
                $(idButton).show();
                $(idDiv).hide();
            }

            //mostra div que contem as disciplinas com colisoes de horarios
            function mostrarColisao(cod) {
                var idButton = "#btnColisao" + cod;
                var idDiv = "#divColisao" + cod;
                if ($(idButton).val() === "MOSTRAR") {
                    $(idButton).val("ESCONDER");
                    $(idButton).html("ESCONDER");
                    $(idDiv).show();
                } else {
                    $(idButton).val("MOSTRAR");
                    $(idButton).html("MOSTRAR");
                    $(idDiv).hide();
                }

            }

            //muda classe bootstrap das disciplinas com colisao ao colocar o mouse sobre
            function iluminarColisao(div) {
                var idDiv = "#divColisao" + div;
                var html = $(idDiv).html() + "";
                var colisaoStr = html.replace(/^\s+|\s+$/g, "");
                var listaColisao = new Array();
                listaColisao = colisaoStr.split("<br>");
                console.log(listaColisao);
                for (var i = 0; i < ((listaColisao.length) - 1); i++) {
                    $("#" + listaColisao[i]).addClass("alert-danger");
                    $("#" + listaColisao[i] + "nome").addClass("alert-danger");
                }



            }

            //muda classe bootstrap das disciplinas com colisao ao retirar o mouse
            function desiluminaColisao(div) {
                var idDiv = "#divColisao" + div;
                var html = $(idDiv).html() + "";
                var colisaoStr = html.replace(/^\s+|\s+$/g, "");
                var listaColisao = new Array();
                listaColisao = colisaoStr.split("<br>");
                console.log(listaColisao);
                for (var i = 0; i < ((listaColisao.length) - 1); i++) {
                    $("#" + listaColisao[i]).removeClass("alert-danger");
                    $("#" + listaColisao[i] + "nome").removeClass("alert-danger");
                }

            }

            function mostrarInfo() {
                if ($("#btnInfo").val() === "mostrar") {
                    $("#btnInfo").val(0);
                    $("#btnInfo").val("ocultar");
                    $("#info").show();
                } else {
                    $("#btnInfo").val("ocultar");
                    $("#btnInfo").val("mostrar");
                    $("#info").hide();
                }
            }


            var sumHorasTotais = 0;

            //verifica os choques de horarios automaticamente ao selecionar uma disciplina
            //removendo estes da selecao e atualizando as horas de estudo extra classe
            function verificaChoqueHorario(index) {
                var divColisao = "#divColisao" + index;
                var codColisoes = $(divColisao).html() + "";
                codColisoes = codColisoes.replace(/^\s+|\s+$/g, "");
                var listaColisao = new Array();
                listaColisao = codColisoes.split("<br>");
                //deseleciona as disciplias com choque
                for (var i = 0; i < ((listaColisao.length) - 1); i++) {
                    var buttonName = listaColisao[i] + "btn";
                    var btnSelecionarId = $(document.getElementsByName(buttonName)).attr("id");
                    var btnSelecionarVal = $("#" + btnSelecionarId).val();
                    var horasName = listaColisao[i] + "horas";
                    var idHoras = $(document.getElementsByName(horasName)).attr("id");
                    if (btnSelecionarVal === "retirar") {
                        alert("Colisão de Horário com: " + listaColisao[i]);
                        $("#" + btnSelecionarId).html("+");
                        $("#" + btnSelecionarId).removeClass();
                        $("#" + btnSelecionarId).addClass("btn btn-sm btn-success hidden-print");
                        $("#" + btnSelecionarId).val("somar");

                        $("#" + listaColisao[i]).removeClass("alert-info");


                        $("#" + listaColisao[i] + "nome").removeClass("alert-info");
                        //para nao imprimir
                        var nameImport = listaColisao[i] + "import";
                        //console.log(nameImport);
                        var idImport = $(document.getElementsByName(nameImport)).attr("id");
                        //console.log(idImport);
                        
                        var nameHoras = listaColisao[i] + "horas";
                        //console.log(nameImport);
                        var idHoras = $(document.getElementsByName(nameHoras)).attr("id");
                        console.log(idHoras);
                        
                        
                        $("#" + idHoras).addClass("hidden-print");
                        $("#" + idImport).addClass("hidden-print");
                        $("#" + listaColisao[i] + "nome").addClass("hidden-print");
                        var horas2 = parseInt($("#" + idHoras).html());
                        sumHorasTotais = sumHorasTotais - horas2;
                    }
                }

            }

            //seleciona as disicpinas escolhidas pelo usuario
            function selecionar(index, horas) {
                var idLinha = "#linha" + index;
                var idName = index;
                var codCodigo = $(document.getElementsByName(idName)).attr("id");

                var intHoras = parseInt(horas);
                var id = "#" + index + "btn";

                //adiciona na lista de selecao
                if ($(id).val() === "somar") {
                    sumHorasTotais = sumHorasTotais + intHoras;
                    $(id).html("-");
                    $(id).removeClass();
                    $(id).addClass("btn btn-sm btn-danger hidden-print");
                    $(id).val("retirar");
                    $("#" + codCodigo).addClass("alert-info");

                    //para imprimir
                    $("#" + codCodigo + "nome").removeClass("hidden-print");
                    
                    $("#" + index + "horas").removeClass("hidden-print");
                    $("#" + index + "import").removeClass("hidden-print");
                    $("#" + codCodigo + "nome").addClass("alert-info");

                    //verifica choques automaticamente
                    verificaChoqueHorario(index);

                }
                // retira da lista de selecao    
                else {

                    sumHorasTotais = sumHorasTotais - intHoras;
                    $(id).html("+");
                    $(id).removeClass();
                    $(id).addClass("btn btn-sm btn-success hidden-print");
                    $(id).val("somar");

                    $("#" + codCodigo).removeClass("alert-info");

                    //para nao imprimir
                    $("#" + codCodigo + "nome").addClass("hidden-print");
                    
                    $("#" + index + "horas").addClass("hidden-print");
                    $("#" + index + "import").addClass("hidden-print");
                    $("#" + codCodigo + "nome").removeClass("alert-info");

                }
                console.log(sumHorasTotais);
                var str = "<label style='width: 180px; 'class='panel panel-primary bg-info'> ESTIMATIVA DE<br>" +
                        sumHorasTotais +
                        " HORAS DE DEDICAÇÃO <br> SEMANAL</label>";
                //atualiza html com informacao das horas totais de estudo extracasse
                $("#horasTotais").html(str);

            }

            function verCoReuisitos(name) {
                var id = $(document.getElementsByName(name)).attr("id");
                var cod = $("#" + id).html();
                //cod = cod.replace(/^\s+|\s+$/g, "");
                $.ajax({
                    type: 'POST',
                    url: "modal/coRequisitos.php",
                    data: {codigo: cod}
                }).done(function (data) {
                    $("#cabecalhoModal").html("<center><h3 class='text-primary'>Pré-requisito de:</h3></center>");
                    $("#corpoModal").html(data);


                });
                $('#modal').modal('show');

            }

            function modalAjuda(i) {

                if (i === 8) {
                    $("#modal").modal('hide');

                } else {
                    var url = "modal/ajuda" + i + ".php";

                    $.ajax({
                        url: url
                    }).done(function (data) {
                        $("#corpoModal").html(data);

                    });
                    $('#modal').modal('show');
                }

            }
            function imprimir(){
                print();
                
            }

        </script>
    </head>
    <?php
    $grr = $_POST["grr"];
    $idCurso = $_POST["idCurso"];
    require_once './Recomendacao.php';
    $recomendacao = new Recomendacao($grr, $idCurso);

    $recomendacao->start();
    ?>

    <body class="Athena_background_two">

        <div class="row">

            <div class="col col-lg-2 col-xs-2 hidden-print" >
                <center>
                    <div class="navbar navbar-fixed-top"   style="margin-right: 80%">

                        <div class="navbar-header">
                            <br>
                            <br>
                            <div id ="menu" class="nav navbar-left ">
                                <ul class="nav navbar-left" style="margin-left: 10px;" >
                                    <li>
                                        <img id="imagem" src="img/logoAthena.png" height="140px" width="135px">
                                    </li>
                                    <li style="margin-top: 10px;"> <div id='horasTotais'>
                                            <label style='width: 180px; 'class='panel panel-primary bg-info'> ESTIMATIVA DE<br>
                                                HORAS DE DEDICAÇÃO <br> SEMANAL</label>
                                        </div>
                                    </li>
                                    <li style="margin-top: 10px;"><button class="btn-primary btn-lg hidden-print" style="width: 180px;" data-toggle="modal" data-target="#modalDifs">DIFICULDADE</button></li>
                                    <li style="margin-top: 10px;"><button class="btn-primary btn-lg hidden-print" style="width: 180px;" data-toggle="modal" data-target="#modalMedias">MÉDIAS</button></li>

                                    <li  style="margin-top: 10px;"><button class="btn-primary btn-lg hidden-print" style="width: 180px;" onclick="modalAjuda(0)" >AJUDA</button></li>
                                    <li  style="margin-top: 10px;"><button class= "btn-lg Athena_button_book_large hidden-print" style="width: 180px;" onclick="imprimir()" > <img  id="imagem" src="img/printer2.svg" height="50px" width="105px"></button></li>
                                    <li  style="margin-top: 10px;"><button class="btn-lg Athena_button_book_large hidden-print" style="width: 180px;" onclick="window.location.href = 'index.php'">VOLTAR</button></li>


                                </ul>
                            </div>
                        </div>

                    </div>
                </center>
            </div>
            <div class="col col-lg-10 col-xs-10">
                <table class="table ">
                    <thead>
                        <tr class="text-center">
                            <th style="vertical-align:middle"  class="text-uppercase text-primary hidden-print"> Código </th>
                            <th style="vertical-align:middle" class="text-uppercase text-primary"> Disciplina </th>
                            <th style="vertical-align:middle"  class="text-uppercase text-primary hidden-print"> Escolher </th>
                            <th style="vertical-align:middle"  class="text-uppercase text-primary"> Recomendação</th>
                            <th class="text-uppercase text-primary"> Horas de Dedicação Semanal </th>
                            <th style="vertical-align:middle"   class="text-uppercase text-primary hidden-print"> Horários </th>
                            <th class="text-uppercase text-primary hidden-print"> Colisão de Horários </th>
                        </tr>
                    </thead>
                    <tbody id="lista">

                        <?php
                        $count = 0;
                        foreach ($recomendacao->getRecomendacaoFinal() as $rec) {
                            $c = $rec->getCodigo();
                            $h = $rec->getHorasDedicacao();
                            $count = $count + 1;
                            $countS = (string) ($count);
                            $idNome = $c . "nome";
                            $idHoras = $count . "horas";
                            $nameHoras = $c . "horas";
                            $idBtnSelecionar = $countS . "btn";
                            $nameBtnSelecionar = $c . "btn";
                            $idImport = $count . "import";
                            ?>

                            <tr class="text-center" id="<?php echo "linha" . $count; ?>"> 

                                <td name="<?php echo $count; ?>" id="<?php echo $c; ?>"  class="hidden-print"><?php echo $rec->getCodigo(); ?></td>
                                <td id="<?php echo $idNome ?>" class="text-success hidden-print" ><button class="btn-link" onclick="verCoReuisitos(<?php echo $count; ?>)"><?php echo $rec->getNome(); ?></button></td>

                                <td class="hidden-print"><button name="<?php echo $nameBtnSelecionar; ?>" id="<?php echo $idBtnSelecionar; ?>" class="btn btn-sm btn-success hidden-print" onclick="selecionar(<?php echo $count; ?>, <?php echo round($h, 0); ?>)" value="somar">+</button></td>

                                <td id="<?php echo $idImport ?>" name="<?php echo $c."import";?>" class="text-success hidden-print" ><?php echo round($rec->getImportancia(), 0) . "%"; ?></td>
                                <td id="<?php echo $idHoras; ?>" name="<?php echo $nameHoras; ?>"  class="text-success hidden-print"><?php echo round($rec->getHorasDedicacao(), 0); ?></td>

                                <td class="hidden-print">
                                    <?php
                                    $idButton = "btnHorarios" . $countS;
                                    $idDiv = "divHorarios" . $countS;
                                    ?>
                                    <button id="<?php echo $idButton; ?>" onmouseover="mostrar(<?php echo $countS; ?>)"  value="MOSTRAR">
                                        <img src="img/horario.png" height="35px" width="35px"/> 
                                    </button>

                                    <div  onmouseout="esconder(<?php echo $countS; ?>)" id="<?php echo $idDiv; ?>"  hidden="true">
                                        <?php
                                        foreach ($rec->getHorarios() as $h) {
                                            echo $h . "<br>";
                                        }
                                        ?>
                                    </div>
                                </td> 
                                <td class="text-danger hidden-print">
                                    <?php
                                    $idButtonColisao = "btnColisao" . $countS;
                                    $idDivColisao = "divColisao" . $countS;
                                    ?>

                                    <?php
                                    if (count($rec->getColisoes()) == 0) {
                                        ?>
                                        <div >
                                        </div>
                                        <?php
                                    } else {
                                        ?>

                                        <button id="<?php echo $idButtonColisao; ?>" class="btn btn-default" onclick="mostrarColisao(<?php echo $countS ?>)" value="MOSTRAR" >MOSTRAR</button>
                                        <?php
                                        $colisaoStr = "";
                                        foreach ($rec->getColisoes() as $col) {
                                            $colisaoStr = $colisaoStr . $col . ",";
                                        }
                                        ?>
                                        <div onmouseout="desiluminaColisao(<?php echo $countS; ?>)" onmouseover="iluminarColisao(<?php echo $countS; ?>)" id="<?php echo $idDivColisao; ?>" hidden="true" >
                                            <?php
                                            foreach ($rec->getColisoes() as $col) {
//                                            $fetch = selecionarWHERE("disciplina", array("NOME"), "CODIGO = '$col' LIMIT 1");
//                                            foreach ($fetch as $f) {
//                                                echo $f["NOME"] . ",<br> ";
//                                            }
                                                echo $col . "<br>";
                                            }
                                            ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>

                    </tbody>

                </table>

            </div>

        </div>
        <br>
        <br>
    <center>

        <div id="info"  class="panel panel-primary" style="margin-left: 18%; margin-right: 3%;"  hidden="true">
            <?php
            $strMsg = $recomendacao->getListaDificuldade()->listarStringCategorias(30);

            if (strlen($strMsg) == 0) {
                $recomendacao->setMensagem("Você está indo bem!");
            } else {
                $recomendacao->setMensagem("Atenção: se esforce mais em " . substr($strMsg, 0, -2));
            }

            $previsaoConclusaoAnosMax = 6;

            $totalHorasCursado = $recomendacao->getCargaCursada();
            $totalHorasCurso = $recomendacao->getCargaTotalCurso();
            $totalAnosCursados = $recomendacao->getAnosCursados();
            $mediaPorAno = $totalHorasCursado / $totalAnosCursados;

            $previsaoConclusao = ($totalHorasCurso - $totalHorasCursado) / $mediaPorAno;
            $previsaoConclusaoAnos = (int) ($previsaoConclusao);
            $previsaoConclusaoMeses = "";
            if (($previsaoConclusao - $previsaoConclusaoAnos ) > 0.5) {
                $previsaoConclusaoMeses = " e meio";
            }

            $ano = "";
            $strextra = "";

            if ($previsaoConclusaoAnos > 1) {
                $ano = " anos";
            } else {
                $ano = " ano";
            }
            if ($previsaoConclusaoAnos >= $previsaoConclusaoAnosMax) {
                $previsaoConclusaoAnos = $previsaoConclusaoAnosMax;
                $strextra = " ou mais";
            }


            echo "<h3 class='text-uppercase' >" . $recomendacao->getMensagem() . "</h3><br><br>";
            echo "<h4 class='text-uppercase'> Você já cursou $totalHorasCursado horas<br>";
            echo "continuando assim, a previsão de conclusão é de " . $previsaoConclusaoAnos . $ano .
            $previsaoConclusaoMeses . $strextra . " </h4>";
            ?>
        </div>
        <button id="btnInfo" class="btn btn-lg btn-primary text-uppercase hidden-print" onclick="mostrarInfo()" style="margin-left: 18%;" value="mostrar">Informações</button>
        <br>
        <br>

    </center>

</body>

<center>
    <div class = "modal fade" id = "modalDifs">
        <div class = "modal-lg bg-warning">
            <div class = "modal-content">
                <div class = "modal-header bg-warning">
                    <button type = "button" class = "close" data-dismiss = "modal"><span>×</span></button>
                    <h4 class = "modal-title text-info bg-warning">Dificuldade por Categoria</h4>
                </div>
                <div class = "modal-body bg-warning">
                    <center>

                        <?php
                        $recomendacao->getListaDificuldade()->imprimeDificuldades();
                        ?>

                    </center>
                </div>
                <div class="modal-footer bg-warning">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalMedias">
        <div class="modal-lg bg-warning">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                    <h4 class="modal-title text-info bg-warning">Percentuais de Aprovação e Médias</h4>
                </div>
                <div class="modal-body bg-warning">
                    <center>

                        <?php
//$recomendacao->getListaDificuldade()->imprimeDificuldades();
                        $recomendacao->getListaDificuldade()->imprimeMediaAprovacao();
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
</html>