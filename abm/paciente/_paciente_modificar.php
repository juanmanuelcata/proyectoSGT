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
            $detalle = 'Modificación del Paciente  "' . $dni . '"';
            $user = $_SESSION['usuario']['user'];
            $log = "INSERT INTO log ( fecha, usuario, detalle, tabla, idafectado)              
              VALUES ('$fechita', '$user', '$detalle', 'Paciente', '$id2' )";
            $db->query($log);
            echo '<div class="alert alert-success">  
                    <a class="close" data-dismiss="alert">×</a>  
                    <strong><h4>Muy Bien! Se modificó correctamente el Paciente: ' . $nombre . '</h4>.</strong>  
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
                <strong><h4>Error!</h4> Ya existe un Paciente con este DNI</strong>.  
             </div>';
    }
}
$consulta = 'SELECT * from paciente where (idpaciente = "' . $id . '") ';
$result = $db->query($consulta);
$os = $_GET['os'];
$a = $result->fetch(PDO::FETCH_ASSOC);
?>



<form class="form-horizontal" name="formi" action="./paciente.php" method="GET">
    <fieldset>
        <legend>Modificación de Paciente</legend>
        <div class="control-group">
            <div class="controls">
                <?php echo '<h4>Usted está modificando el Paciente: ' . $a['nombre'] . '</h4>' ?>
                <br>
                <label>Nuevo nombre</label>
                <input value="<?php echo $a['nombre'] ?>" type="text" class="input-xlarge" id="nombre" name="nombre" onkeypress="return soloLetras(event);">
                <button class="btn btn-mini" onclick="return false;" data-original-title="Modificar el nombre del Paciente" data-content="Ingrese el nuevo nombre del Paciente para modificarlo.">
                    <i class="icon-question-sign"></i>
                </button>
                <label>Nuevo apellido</label>
                <input value="<?php echo $a['apellido'] ?>" type="text" class="input-xlarge" id="apellido" name="apellido" onkeypress="return soloLetras(event);">
                <button class="btn btn-mini" onclick="return false;" data-original-title="Modificar el apellido del Paciente" data-content="Ingrese el nuevo apellido del Paciente para modificarlo.">
                    <i class="icon-question-sign"></i>
                </button>
                <label>Nuevo DNI</label>
                <input value="<?php echo $a['dni'] ?>" type="text" class="input-xlarge" id="dni" name="dni" maxlength="8" onkeypress="return justNumbers(event);">
                <button class="btn btn-mini" onclick="return false;" data-original-title="Modificar el DNI del Paciente" data-content="Ingrese el nuevo DNI del médico para modificarlo. Solo se permiten caracteres numéricos. La cantidad máxima de dígitos es 8.">
                    <i class="icon-question-sign"></i>
                </button>
                <label>Nueva Fecha de nacimiento</label>
                <input  value="<?php echo $a['nacimiento'] ?>"type="date" class="input-xlarge" id="fechaNac" name="fecha" onkeypress="return justFecha(event);">
                <button class="btn btn-mini" onclick="return false;" data-original-title="Modificar la fecha de nacimiento del Paciente" data-content="Increse la nueva fecha de nacimiento del Paciente utilizando solo caracteres numéricos para modificarla. Puede también utilizar la flecha hacia abajo para desplegar el calendario y oprimiendo sobre el día correspondiente al mes y año que esten visualizados. Puede optar por seleccionar un campo de la fecha (dia, mes o año) haciendo click sobre el mismo y con las flechas hacia arriba y abajo escribir la fecha deseada.">
                    <i class="icon-question-sign"></i>
                </button>  
                <label>Nueva localidad</label>
                <input value="<?php echo $a['localidad'] ?>" type="text" class="input-xlarge" id="localidad" name="localidad">
                <button class="btn btn-mini" onclick="return false;" data-original-title="Modificar la localidad del Paciente" data-content="Ingrese el nuevo nombre de la localidad en la que vive el Paciente para modificarla. Por ej: Tolosa.">
                    <i class="icon-question-sign"></i>
                </button>   
                <label>Nueva calle</label>
                <input value="<?php echo $a['calle'] ?>" type="text" class="input-xlarge" id="calle" name="calle">
                <button class="btn btn-mini" onclick="return false;" data-original-title="Modificar la calle en la que vive el Paciente" data-content="Ingrese el nombre o número de la nueva calle en la que vive el Paciente para modificarla.">
                    <i class="icon-question-sign"></i>
                </button>
                <label>Nueva altura</label>
                <input value="<?php echo $a['altura'] ?>" type="text" class="input-xlarge" id="altura" name="altura" onkeypress="return justNumbers(event);">
                <button class="btn btn-mini" onclick="return false;" data-original-title="Moficiar la altura en la que vive el Paciente" data-content="Ingrese el nuevo número de la casa/altura de la vivienda del Paciente para modificarla. Solo se permiten caracteres numéricos.">
                    <i class="icon-question-sign"></i>
                </button>   
                <label>Nuevo piso</label>
                <input value="<?php echo $a['piso'] ?>" type="text" class="input-xlarge" id="piso" name="piso" onkeypress="return justNumbers(event);">
                <button class="btn btn-mini" onclick="return false;" data-original-title="Modificar el piso en el que vive el Paciente" data-content="Ingrese el nuevo piso en el que vive el Paciente (caso de que viva en un departamento) para modificarlo. Solo se permiten caracteres numéricos.">
                    <i class="icon-question-sign"></i>
                </button>
                <label>Nuevo departamento</label>
                <input value="<?php echo $a['depto'] ?>"type="text" class="input-xlarge" id="depto" name="departamento">
                <button class="btn btn-mini" onclick="return false;" data-original-title="Modificar el departamento en el que vive el Paciente" data-content="Ingrese el nuevo departamento en el que vive el Paciente (en el caso de que viva en un departamento) para modificarlo.">
                    <i class="icon-question-sign"></i>
                </button>
                <label>Nuevo correo electrónico</label>
                <input value="<?php echo $a['mail'] ?>" type="text" class="input-xlarge" id="mail" name="mail">
                <button class="btn btn-mini" onclick="return false;" data-original-title="Modificar el E-mail del Paciente" data-content="Ingrese el nuevo e-mail del Paciente para modificarlo. Por ejemplo: 'cuenta@gmail.com'.">
                    <i class="icon-question-sign"></i>
                </button>
                <label>Nuevo teléfono</label>
                <input value="<?php echo $a['telefono'] ?>" type="text" class="input-xlarge" id="tel" name="tel" maxlength="10" onkeypress="return justNumbers(event);">
                <button class="btn btn-mini" onclick="return false;" data-original-title="Modifciar el teléfono del Paciente" data-content="Ingrese el nuevo teléfono del Paciente para modificarlo. Solo se permiten caracteres numéricos.">
                    <i class="icon-question-sign"></i>
                </button>
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
                <button class="btn btn-mini" onclick="return false;" data-original-title="Modificar la Obra Oocial del Paciente" data-content="Despliegue la lista haciendo click sobre el campo; luego seleccione de la lista la nueva obra social del Paciente para modificarla.">
                    <i class="icon-question-sign"></i>
                </button>
                <!--la saque el div-->
                <!--<div class="form-actions">-->
                    <br><br><input type="hidden" name="code" value="m"/>
                    <input type="hidden" name="ok" value="1"/>
                    <input type="hidden" name="id" value="<?php echo $id ?>"/>
                    <button type="submit" onclick="return veriformuPacienteMod()" class="btn btn-success">Guardar cambios</button>
                    <button type="reset" class="btn btn-success">Reiniciar</button>
                <!--</div>-->
                
        </div>
    </fieldset>
</form>