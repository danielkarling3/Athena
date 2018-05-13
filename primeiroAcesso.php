<html >
    <head>
        <meta charset="UTF-8">
        <title id="titulo" >Primeiro Acesso</title>
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/Athena.css" rel="stylesheet">

        <script src="js/jquery-3.2.0.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script>
           function definirADM(){
               var user = $("#ADM").val();
               var senha = $("#senha").val();
               $.ajax({
                        type: 'POST',
                        url: "definirADM.php",
                        data: {user: user, senha: senha}
                }).done(function (data) {
                        alert(data);
                        location.href = 'index.php';
                    
                });
           }
        </script>
    </head>

    <body class="Athena_background">


        <?php
        include 'cabecalho.php';
        ?>

        <div class="row ">
            <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4 col-xs-8 col-xs-offset-2">
                <div id="menu" class="Athena_login "  style=" margin-top: 5%;">
                    <div class="panel Athena_cabecalho" style="margin-left: 5%; margin-right: 5%;">
                        <center>
                            <h3>Administrador do Sistema</h3>
                        </center>
                    </div>
                    <center>
                        ADMINISTRADOR:<br><input style="color: black;"  class="text-center" type="text" id="ADM"/><br>
                        <br>
                        SENHA:<br><input style="color: black;"  class="text-center" type="password" id="senha" /><br>
                        <br>
                        
                        <button class="btn btn-sm Athena_button_submit"  onclick="definirADM()">Definir</button>

                        <br>
                        <h4>Login do Responsável pela Área Restrita.</h4>
                        <h5>Esse login só pode ser definido uma vez.</h5>
                        <br>
                        
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