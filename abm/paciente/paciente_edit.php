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
$consulta = 'SELECT * from paciente where (idpaciente = "' . $id . '") ';
$result = $db->query($consulta);
$os = $_GET['os'];
$a = $result->fetch(PDO::FETCH_ASSOC);
if (isset($_GET['ok'])) {
    $dni = $_GET['dni'];
    $fecha = $_GET['fecha'];
    $nombre = $_GET['nombre'];
    $apellido = $_GET['apellido'];
    $localidad = $_GET['localidad'];
    $calle = $_GET['calle'];
    $altura = $_GET['altura'];
    $piso = $_GET['piso'];
    $departamento = $_GET['departamento'];
    $mail = $_GET['mail'];
    $tel = $_GET['tel'];
    $consulta = 'SELECT * from paciente where (dni = "' . $dni . '") and idpaciente != "' . $id . '" ';
    $result = $db->query($consulta);
    if (($result->rowCount() == 0)) {
        $consulta = 'update paciente set dni = "' . $dni . '", nacimiento="' . $fecha . '", nombre="' . $nombre . '", apellido="' . $apellido . '", localidad="' . $localidad . '", calle="' . $calle . '", altura="' . $altura . '", mail="' . $mail . '", telefono="' . $tel . '", piso="' . $piso . '", depto="' . $departamento . '" where idpaciente = "' . $id . '"';
        $consulta2 = "select * from os where nombre = '$os'";
        $re = $db->query($consulta2);
        $b = $re->fetch(PDO::FETCH_ASSOC);
        $up = 'update pac_os set id_os = ' . $b['idos'] . ' where id_paciente =' . $id . '';
        if ($db->query($up) && $db->query($consulta)) {
            $id2 = $db->lastInsertId("seq_name");
            $fechita = date('Y-m-d H:i:s');
            $detalle = 'Modificacion del paciente  "' . $dni . '"';
            $user = $_SESSION['usuario']['user'];
            $log = "INSERT INTO log ( fecha, usuario, detalle, tabla, idafectado)              
              VALUES ('$fechita', '$user', '$detalle', 'Paciente', '$id2' )";
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
$consulta = 'SELECT * from paciente where (idpaciente = "' . $id . '") ';
$result = $db->query($consulta);
$os = $_GET['os'];
$a = $result->fetch(PDO::FETCH_ASSOC);
?>



<form class="form-horizontal" name="formi" action="./paciente_edit.php" method="GET">
    <fieldset>
        <legend>Modificación de paciente</legend>
        <div class="control-group">
            <div class="controls">
                <label>Nuevo nombre</label>
                <input value="<?php echo $a['nombre'] ?>" type="text" class="input-xlarge" id="nombre" name="nombre" onkeypress="return soloLetras(event);">
                <label>Nuevo apellido</label>
                <input value="<?php echo $a['apellido'] ?>" type="text" class="input-xlarge" id="apellido" name="apellido" onkeypress="return soloLetras(event);">
                <label>Nuevo DNI</label>
                <input value="<?php echo $a['dni'] ?>" type="text" class="input-xlarge" id="dni" name="dni" maxlength="8" onkeypress="return justNumbers(event);">
                <label>Nueva Fecha de nacimiento</label>
                <input  value="<?php echo $a['nacimiento'] ?>"type="date" class="input-xlarge" id="fechaNac" name="fecha" onkeypress="return justFecha(event);">
                <label>Nueva localidad</label>
                <input value="<?php echo $a['localidad'] ?>" type="text" class="input-xlarge" id="localidad" name="localidad">
                <label>Nueva calle</label>
                <input value="<?php echo $a['calle'] ?>" type="text" class="input-xlarge" id="calle" name="calle">
                <label>Nueva altura</label>
                <input value="<?php echo $a['altura'] ?>" type="text" class="input-xlarge" id="altura" name="altura" onkeypress="return justNumbers(event);">
                <label>Nuevo piso</label>
                <input value="<?php echo $a['piso'] ?>" type="text" class="input-xlarge" id="piso" name="piso" onkeypress="return justNumbers(event);">
                <label>Nuevo departamento</label>
                <input value="<?php echo $a['depto'] ?>"type="text" class="input-xlarge" id="depto" name="departamento">
                <label>Nuevo correo electrónico</label>
                <input value="<?php echo $a['mail'] ?>" type="text" class="input-xlarge" id="mail" name="mail">
                <label>Nuevo teléfono</label>
                <input value="<?php echo $a['telefono'] ?>" type="text" class="input-xlarge" id="tel" name="tel" maxlength="10" onkeypress="return justNumbers(event);">
                <label>Nueva obra social</label>
                <?php
                $datab = conectaDb();
                $consulta = "SELECT * FROM os where activo = 1";
                $result = $datab->query($consulta);
                if (!$result)
                    print ("<p>error en la consulta<p>");
                else
                    
                    ?>
                <select class="select-xlarge" name="os" >
                    <?php
                    foreach ($result as $valor)
                        if ($valor['nombre'] == $os) {
                            echo '<option selected="selected">' . $valor['nombre'] . '</option>';
                        } else {
                            echo '<option>' . $valor['nombre'] . '</option>';
                        }
                    ?>
                </select>
                <div class="form-actions">
                    <input type="hidden" name="code" value="m"/>
                    <input type="hidden" name="ok" value="1"/>
                    <input type="hidden" name="id" value="<?php echo "$id" ?>"/>
                    <button type="submit" onclick="return veriformuPacienteMod()" class="btn btn-success">Guardar cambios</button>
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

