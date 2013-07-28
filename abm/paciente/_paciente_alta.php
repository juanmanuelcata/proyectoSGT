<?php
if (isset($_GET['nombre'])) {
    $db = conectaDb();
    $nombre = $_GET['nombre'];
    $apellido = $_GET['apellido'];
    $dni = $_GET['dni'];
    $fechaNac = $_GET['fechaNac'];
    $localidad = $_GET['localidad'];
    $calle = $_GET['calle'];
    $altura = $_GET['altura'];
    $depto = $_GET['departamento'];
    $piso = $_GET['piso'];
    $mail = $_GET['mail'];
    $tel = $_GET['tel'];
    $os_select = $_GET['os_select'];
    $consulta = "SELECT * from paciente where (dni = '$dni')";
    $result = $db->query($consulta);
    if ($result->rowCount() > 0) {
        echo '<div class="alert alert-error">  
                <a class="close" data-dismiss="alert">×</a>  
                <strong><h4>Error!</h4> Ya existe un paciente con este DNI</strong>.  
             </div>';
    } else {
        $consulta = "INSERT INTO paciente (dni, nacimiento, nombre, apellido, localidad, calle, altura, mail, piso, depto, telefono)
                    VALUES ('$dni', '$fechaNac', '$nombre', '$apellido', '$localidad', '$calle', '$altura', '$mail', '$piso', '$depto', '$tel')";

        if ($db->query($consulta)) {
            $consulta2 = "SELECT idos, idpaciente from os, paciente where paciente.dni = '$dni' and os.nombre = '$os_select'";
            $tmp = $db->query($consulta2);
            $id = $db->lastInsertId("seq_name");
            $res = $tmp->fetch(PDO::FETCH_ASSOC);
            $idos = $res['idos'];
            $idpac = $res['idpaciente'];
            $consulta3 = "INSERT INTO pac_os (id_paciente, id_os) VALUES ('$idpac', '$idos')";
            if ($db->query($consulta3)) {
                $fechita = date('Y-m-d H:i:s');
                $detalle = 'Alta de paciente  "' . $dni . '"';
                $user = $_SESSION['usuario']['user'];
                $log = "INSERT INTO log ( fecha, usuario, detalle, tabla, idafectado)              
              VALUES ('$fechita', '$user', '$detalle', 'Paciente', '$id' )";
                $db->query($log);
                echo '<div class="alert alert-success">  
                    <a class="close" data-dismiss="alert">×</a>  
                    <strong><h4>Muy Bien! Se inserto correctamente el paciente: ' . $nombre . '</h4>.</strong>  
                 </div>';
            } else {
                echo 'fallo la os valores $idpac =' . $idpac . ' y $idos = ' . $idos . ' consulta= ' . $consulta3 . '';
            }
        } else {
            echo '<div class="alert alert-success">  
                    <a class="close" data-dismiss="alert">×</a>  
                    <strong><h4>Ocurrio un error al conectarse con la base de datos.</h4>Por favor comuniquese con su administrador.</strong>  
                 </div>';
        }
    }
}
?>
<form class="form-horizontal" name="formi" action="/abm/paciente.php" method="GET">
    <fieldset>
        <legend>Agregar una nuevo paciente.</legend>
        <div class="control-group">
            <div class="controls">
                <label>Nombre*</label>
                <input type="text" tabindex="1" class="input-xlarge" id="nombre" name="nombre" placeholder="Nombre" maxlength="20" onkeypress="return soloLetras(event);">
                <button class="btn" onclick="return false;" data-original-title="Nombre del paciente" data-content="Ingrese el nombre del paciente. No se permiten números. Es obligatorio.">
                    <i class="icon-question-sign"></i>
                </button>
                <label>Apellido*</label>
                <input type="text" tabindex="2" class="input-xlarge" id="apellido" name="apellido" placeholder="Apellido" maxlength="20" onkeypress="return soloLetras(event);">
                <button class="btn" onclick="return false;" data-original-title="Apellido del paciente" data-content="Ingrese el apellido del paciente. No se permiten números. Es obligatorio.">
                    <i class="icon-question-sign"></i>
                </button>
                <label>DNI*</label>
                <input type="text" tabindex="3" class="input-xlarge" id="dni" name="dni" placeholder="DNI" maxlength="8" onkeypress="return justNumbers(event);">
                <button class="btn" onclick="return false;" data-original-title="DNI del paciente" data-content="Ingrese el DNI del paciente. Solo se permiten caracteres numéricos. Es obligatorio.">
                    <i class="icon-question-sign"></i>
                </button>                
                <label>Fecha de nacimiento*</label>
                <input type="date" tabindex="4" class="input-xlarge" id="fechaNac" name="fechaNac" onkeypress="return justFecha(event);">
                <button class="btn" onclick="return false;" data-original-title="Fecha de nacimiento del paciente" data-content="Increse la fecha de nacimiento del paciente utilizando solo caracteres numéricos. Puede también utilizar la flecha hacia abajo para desplegar el calendario y oprimiendo sobre el día correspondiente al mes y año que esten visualizados. Puede optar por seleccionar un campo de la fecha (dia, mes o año) haciendo click sobre el mismo y con las flechas hacia arriba y abajo escribir la fecha deseada. Es obligatorio.">
                    <i class="icon-question-sign"></i>
                </button>                
                <label>Localidad*</label>
                <input type="text" tabindex="5" class="input-xlarge" id="localidad" name="localidad" placeholder="Localidad"  maxlength="20">
                <button class="btn" onclick="return false;" data-original-title="Localidad del paciente" data-content="Ingrese el nombre de la localidad en la que vive el paciente (Ej: Tolosa). Es obligatorio.">
                    <i class="icon-question-sign"></i>
                </button>                  
                <label>Calle*</label>
                <input type="text" tabindex="6" class="input-xlarge" id="calle" name="calle" placeholder="Calle" maxlength="20">
                <button class="btn" onclick="return false;" data-original-title="Calle en la que vive el paciente" data-content="Ingrese el nombre o número de la calle en la que vive el paciente. Es obligatorio.">
                    <i class="icon-question-sign"></i>
                </button>
                <label>Altura*</label>
                <input type="text" tabindex="7" class="input-xlarge" id="altura" name="altura"  placeholder="Número" maxlength="20" onkeypress="return justNumbers(event);">
                <button class="btn" onclick="return false;" data-original-title="Altura en la que vive el paciente" data-content="Ingrese el número de la casa/altura de la vivienda del paciente. Es obligatorio.">
                    <i class="icon-question-sign"></i>
                </button>                  
                <label>Piso</label>
                <input type="text" tabindex="8" class="input-xlarge" id="piso" name="piso"  placeholder="Piso" maxlength="2" onkeypress="return justNumbers(event);">
                <button class="btn" onclick="return false;" data-original-title="Piso en el que vive el paciente" data-content="Ingrese el piso en el que vive el paciente. Agregar en el caso de que viva en un departamento. El máximo de dígitos es 2.">
                    <i class="icon-question-sign"></i>
                </button>
                <label>Departamento</label>
                <input type="text" tabindex="9" class="input-xlarge" id="depto" name="departamento"  placeholder="Departamento">
                <button class="btn" onclick="return false;" data-original-title="Departamento en el que vive el paciente" data-content="Ingrese el departamento en el que vive el paciente. Agregar en el caso de que viva en un departamento.">
                    <i class="icon-question-sign"></i>
                </button>
                <label>Correo electrónico*</label>
                <input type="text" tabindex="10" class="input-xlarge" id="mail" name="mail" placeholder="nombre@servidor.com" maxlength="50">
                <button class="btn" onclick="return false;" data-original-title="E-mail del paciente" data-content="Ingrese el e-mail del paciente. Por ejemplo: 'cuenta@gmail.com'. Es obligatorio.">
                    <i class="icon-question-sign"></i>
                </button>
                <label>Teléfono*</label>
                <input type="text" tabindex="11" class="input-xlarge" id="tel" name="tel" placeholder="Teléfono" maxlength="10" onkeypress="return justNumbers(event);">
                <button class="btn" onclick="return false;" data-original-title="Teléfono del paciente" data-content="Ingrese el teléfono del paciente. Solo se permiten números. La cantidad máxima de dígitos es 10. Es obligatorio.">
                    <i class="icon-question-sign"></i>
                </button>
                <label>Obra social</label>
                <?php
                $datab = conectaDb();
                $consulta = "SELECT * FROM os where activo = 1";
                $result = $datab->query($consulta);
                if (!$result)
                    print ("<p>error en la consulta<p>");
                else
                    
                    ?>
                <select tabindex="12" class="select-xlarge" name="os_select" >                    

                    <?php
                    foreach ($result as $valor)
                        if ($valor['nombre'] == 'Ninguna')
                            echo '<option Selected="Selected">' . $valor['nombre'] . '</option>';
                        else
                            echo '<option>' . $valor['nombre'] . '</option>';
                    ?>

                </select>
                <button class="btn" onclick="return false;" data-original-title="Obra social del paciente" data-content="Despliegue la lista haciendo click sobre el campo; luego seleccione de la lista la obra social del paciente.">
                    <i class="icon-question-sign"></i>
                </button>  
                <input type="hidden" name="code" value="a"/><br><br> 
                <button tabindex="13" type="submit" onclick="return veriformuPaciente()" class="btn btn-success">Guardar</button>
                <button tabindex="14" type="reset" class="btn btn-success">Borrar</button>

            </div>
        </div>
    </fieldset>
</form>
