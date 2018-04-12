<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->



<html>
    <head>
        <meta charset="UTF-8">
        <title>Athena: Sistema para Recomendação de Disciplinas</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/Athena.css" rel="stylesheet">

    </head>
    <body class="Athena_background" >

        <?php
        include './cabecalho.php';
        ?>


        <div class="row" style="margin-top: 5%;">
            <div class="col-lg-3 col-xs-3">

            </div>


            <div class="col-lg-4 col-xs-4 Athena_login" style="margin-left: 8%; ">
                <center>  
                    <div class="panel Athena_cabecalho" style="background-color: rgba(11,1,1,0.5);   margin-left: 15%; margin-right: 15%;">
                        <h3 >Ambiente de Consulta</h3>
                    </div>
                    <form id="categorias" class="container-fluid " name="possibilidades" method="post" action="recommender.php">
                        <h4 class="text-uppercase" >GRR</h4>
                        <input style="color: black;" name="grr"  class="text-center"  type="text" id="grr" value = ""><br>

                        <br><input type="submit" name="submit" class="btn Athena_button_submit " value="Consultar">
                    </form>
                    <br>
                    <br>
                </center>
            </div>


            <div class="Athena_panel col-lg-2 col-xs-2" >
                <center>

                    <label>Ambiente de <br>Administração</label><br>
                    <button class="btn Athena_button_submit" onclick="window.location.href = 'admin/login.php'">Login</button>
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
