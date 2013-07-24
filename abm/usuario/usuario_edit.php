<?php
include_once('../../sesion/login.php');
include_once('../../fragmentos/_conectDb.php');
if ($_SESSION['usuario']['admin'] == '1') {
    
}
else
    header('Location: /index.php?er=2');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>SGT2</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="Sudo Soft" content="">
        <link href="./../../css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="./../../datatables/css/bootstrap.css" rel="stylesheet">
        <link href="./../../datatables/css/jquery.dataTables_themeroller.css" rel="stylesheet">
        <link href="./../../css/propio.css" rel="stylesheet" media="screen">
        <link rel="stylesheet" type="text/css" href="./../../css/menu.css" />
        <link rel="shortcut icon" href="./../../img/favicon.ico" type="image/x-icon"/> 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
        <script type="text/javascript" src="./../../js/validacion.js"></script>
        <script type="text/javascript" src="./../../datatables/js/jquery.js"></script>
        <script type="text/javascript" src="./../../datatables/js/jquery.dataTables.js"></script>   
        <script type="text/javascript" src="./../../js/bootstrap-alert.js"></script>
    </head>
    <body>
        <div class="row-fluid">
            <div class="span12">
                <img SRC="./../../img/imagenSuper.png" id="cabe1">
            </div>
        </div>        
        <div class="row-fluid">
            <div class="span12">
                <div class="row-fluid">
                    <div class="span10 offset1">
                        <?php
// OK es una variable de flag que se activa cuando se guarda el formulario
                        $db = conectaDb();
                        $id = $_GET['id'];
                        $consulta = 'SELECT * from usuario where (idusuario = "' . $id . '") ';
                        $result = $db->query($consulta);
                        $a = $result->fetch(PDO::FETCH_ASSOC);
                        if (isset($_GET['ok'])) {
                            $user = $_GET['username'];
                            $dni = $_GET['dni'];
                            $nombre = $_GET['nombre'];
                            $apellido = $_GET['apellido'];
                            $mail = $_GET['mail'];
                            $consulta = 'SELECT * from usuario where (dni = "' . $dni . '") and idusuario != "' . $id . '" ';
                            $result = $db->query($consulta);
                            if (($result->rowCount() == 0)) {
                                $consulta = 'update usuario set dni = "' . $dni . '", nombre="' . $nombre . '", apellido="' . $apellido . '", mail="' . $mail . '" where idusuario = "' . $id . '"';
                                if ($db->query($consulta)) {
                                    $id2 = $db->lastInsertId("seq_name");
                                    $fechita = date('Y-m-d H:i:s');
                                    $detalle = 'Modificacion del usuario  "' . $dni . '"';
                                    $user = $_SESSION['usuario']['user'];
                                    $log = "INSERT INTO log ( fecha, usuario, detalle, tabla, idafectado)              
              VALUES ('$fechita', '$user', '$detalle', 'Usuario', '$id2' )";
                                    $db->query($log);
                                    echo '<div class="alert alert-success">  
                    <a class="close" data-dismiss="alert">×</a>  
                    <strong><h4>Muy Bien! Se modifico correctamente el paciente: ' . $nombre . '</h4>.</strong>  
                 </div>';
                                } else {
                                    echo '<div class="alert alert-success">  
                    <a class="close" data-dismiss="alert">×</a>  
                    <strong><h4>Ocurrio un error al conectarse con la base de datos.</h4>Por favor comuniquese con su administrador.</strong>  
                 </div>';
                                }
                            } else {
                                echo '<div class="alert alert-error">  
                <a class="close" data-dismiss="alert">×</a>  
                <strong><h4>Error!</h4> Ya existe un paciente con este DNI</strong>.  
             </div>';
                            }
                        }
                        $consulta = 'SELECT * from usuario where (idusuario = "' . $id . '") ';
                        $result = $db->query($consulta);
                        $a = $result->fetch(PDO::FETCH_ASSOC);
                        ?>



                        <form class="form-horizontal" name="formi" action="./usuario_edit.php" method="GET">
                            <fieldset>
                                <legend>Modificación de paciente</legend>
                                <div class="control-group">
                                    <div class="controls">
                                        <label>Nuevo usuario</label>
                                        <input value="<?php echo $a['user'] ?>" type="text" class="input-xlarge" id="user" name="username">
                                        <label>Nuevo nombre</label>
                                        <input value="<?php echo $a['nombre'] ?>" type="text" class="input-xlarge" id="nombre" name="nombre" onkeypress="return soloLetras(event);">
                                        <label>Nuevo apellido</label>
                                        <input value="<?php echo $a['apellido'] ?>" type="text" class="input-xlarge" id="apellido" name="apellido" onkeypress="return soloLetras(event);">
                                        <label>Nuevo DNI</label>
                                        <input value="<?php echo $a['dni'] ?>" type="text" class="input-xlarge" id="dni" name="dni" maxlength="8" onkeypress="return justNumbers(event);">
                                        <label>Nuevo correo electrónico</label>
                                        <input value="<?php echo $a['mail'] ?>" type="text" class="input-xlarge" id="mail" name="mail">
                                        <label>Nueva contraseña</label>
                                        <input value="<?php echo $a['clave'] ?>" type="password" class="input-xlarge" id="pass" name="clave_nue">
                                        <label>Repita nueva contraseña</label>
                                        <input value="<?php echo $a['clave'] ?>" type="password" class="input-xlarge" id="pass2" name="clave_nue2">
                                        <?php if ($a['admin'] == 1): ?>
                                            <label class="radio">
                                                <br>
                                                <input type="radio" name="activa" id="option1" value="1" checked>
                                                <p>Admin</p>
                                                <input type="radio" name="activa" id="option2" value="0">
                                                <p>Usuario</p>
                                            </label>  
                                        </div>;
                                    <?php else: ?>
                                        <label class="radio">
                                            <br>
                                            <input type="radio" name="activa" id="option1" value="1" >
                                            <p>Admin</p>
                                            <input type="radio" name="activa" id="option2" value="0" checked>
                                            <p>Usuario</p>
                                        </label>  
                                    </div>
                                <?php endif; ?>
                                <div class="form-actions">
                                    <input type="hidden" name="ok" value="1"/>
                                    <input type="hidden" name="id" value="<?php echo "$id" ?>"/>
                                    <button type="submit" onclick="return veriformuUsr();" class="btn btn-success">Guardar cambios</button>
                                    <button type="reset" class="btn btn-success">Reiniciar</button>

                                </div>
                                </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>                
                </div>
            </div>
        </div>
    </body>
</html>

