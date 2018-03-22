<?php
session_start();
if ((isset($_SESSION['usuario']['logueado'])) && ($_SESSION['usuario']['logueado'] == 'si')) {
    header('Location: principal.php');
}
?>
<!-- -->
<!DOCTYPE html>
<html lang="es">
    <head>
        <title>SGT2</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="Sudo Soft" content="">
        <link href="./css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="./css/propio.css" rel="stylesheet" media="screen">
        <link href="./css/bootstrap.css" rel="stylesheet">
        <link href="./css/index.css" rel="stylesheet">        
        <link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon"/> 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 

    </head>
    <body>
        <div class="row-fluid">
            <div class="span12" id="cabecera2">
                <img SRC="./img/imagenSuper.png" id="cabe1">
            </div>
        </div>  
        <div class="container">
            <div class="content">
                <div class="row">
                    <div class="login-form">
                        <h2>Bienvenido a SGT</h2>
                        <form name="entrar" action="./sesion/paso.php" method="POST">
                            <?php
                            include_once './fragmentos/login_logfail.php';
                            ?>         
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="http://code.jquery.com/jquery.js"></script>
        <script src="./js/bootstrap.min.js"></script>
    </body>
</html>
