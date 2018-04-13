<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Athena: Sistema para Recomendação de Disciplinas</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/Athena.css" rel="stylesheet">
        

    </head>
    <body class="Athena_background_four" >

        <?php
        include './cabecalho.php';
        ?>


        <div class="row" style="margin-top: 5%;">



            <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4 col-xs-10 col-xs-offset-1">
                <div class="Athena_login" style=" margin-top: 5%;" >
                    <center>  
                        <div class="panel Athena_cabecalho" style="  margin-left: 5%; margin-right: 5%;">
                            <h3 >Ambiente de Consulta</h3>
                        </div>
                        <form  method="post" action="recommender.php">
                            <h4 class="text-uppercase" >GRR</h4>
                            <input style="color: black;" name="grr"  class="text-center"  type="text" id="grr" value = ""><br>

                            <br><input type="submit" name="submit" class="btn Athena_button_submit " value="Consultar">
                        </form>
                        <br>
                        <br>
                    </center>
                </div>
            </div>


            <div class=" col-sm-6 col-sm-offset-3 col-md-2 col-md-offset-1  col-lg-2 col-lg-offset-1 col-xs-10 col-xs-offset-1" style="margin-top: 2px;" >
                <div class="Athena_panel" >
                    <center>

                        <label>Ambiente de <br>Administração</label><br>
                        <button class="btn Athena_button_submit" onclick="window.location.href = 'admin/login.php'">Login</button>
                    </center>
                </div>
            </div>
            <br>
            <br>

        </div>





        <div class="col-lg-4 col-lg-offset-8 col-sm-4 col-sm-offset-8 col-md-4 col-md-offset-8 col-xs-4 col-xs-offset-8 " style="bottom: 4%;" >
            <center>
                <label>Desenvolvido por:<br>
                    <a style="color: black;" href="http://lattes.cnpq.br/3657386675052708">Daniel Antonio Karling</a></label>
            </center>
        </div>



    </body>




</html>
