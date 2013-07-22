<?php
if (isset($_POST['nombre'])) {
    $db = conectaDb();


    $nombre_med = $_POST['nombre'];
    $apellido_med = $_POST['apellido'];
    $dni = $_POST['dni'];
    $matricula = $_POST['matricula'];
    $mail = $_POST['mail'];
    $tel = $_POST['tel'];
    $consulta = "SELECT * from medico where (dni = '$dni')";
    $result = $db->query($consulta);
    if ($result->rowCount() > 0) {
        echo ' <div class="alert alert-error">  
                    <a class="close" data-dismiss="alert">×</a>  
                    <h4><strong>Error!</strong><br>
                    El médico: ' . $nombre_med . ' ya se encuentra registrado.</h4>  
                </div>';
    } else {
        $consulta = "INSERT INTO medico (dni, matricula, nombre, apellido, mail, telefono) 
                    VALUES ('$dni','$matricula','$nombre_med', '$apellido_med','$mail', '$tel')";
        if ($db->query($consulta)) {
            $fechita = date('Y-m-d H:i:s');
            $detalle = 'Alta del medico "' . $nombre_med . '"';
            $user = $_SESSION['usuario']['user'];
            $id2 = $db->lastInsertId("seq_name");
            $log = "INSERT INTO log ( fecha, usuario, detalle, tabla, idafectado)              
              VALUES ('$fechita', '$user', '$detalle', 'medico', '$id2' )";
            $db->query($log);
            echo '<div class="alert alert-success">  
                    <a class="close" data-dismiss="alert">×</a>  
                    <h4><strong>Muy Bien!</strong><br>
                    Se incerto correctamente el médico: ' . $nombre_med . '.</h4>  
                </div>';



            //alta medico-especialidad
            $esp = $_POST['esp_select'];
            $consulta1 = 'SELECT idespecialidad FROM especialidad WHERE nombre = "' . $esp . '"';
            $conidesp = $db->query($consulta1);
            $arridesp = $conidesp->fetch(PDO::FETCH_ASSOC);
            $idesp = $arridesp['idespecialidad'];
            $consulta2 = 'SELECT idmedico FROM medico WHERE dni = ' . $dni . '';
            $conidmed = $db->query($consulta2);
            $arridmed = $conidmed->fetch(PDO::FETCH_ASSOC);
            $idmed = $arridmed['idmedico'];
            $consulta = "INSERT INTO med_esp (id_med, id_esp) VALUES ('$idmed', '$idesp')";
            if (!$db->query($consulta))
                print ("Error al conectase a la base de datos");
            else




            /* Agregamos los horarios para un medico */
                $rs = $db->query("SELECT MAX(idmedico) as id FROM medico");
            $arr = $rs->fetch(PDO::FETCH_ASSOC);
            $id = $arr['id'];

            $fechita = date('Y-m-d H:i:s');
            $detalle = 'Alta del horario par el medico"' . $nombre_med . '"';
            $user = $_SESSION['usuario']['user'];
            $log = "INSERT INTO log ( fecha, usuario, detalle, tabla, idafectado)              
                        VALUES ('$fechita', '$user', '$detalle', 'horario', '$id2' )";
            $db->query($log);




            if (isset($_POST['horario'])) {
                foreach ($_POST['horario'] as $horarioMedico) {
                    $dia = $horarioMedico['dia'];
                    $desde = $horarioMedico['desde'];
                    $hasta = $horarioMedico['hasta'];
                    $cant = $hasta - $desde;
                    $d = date_create($desde);
                    $inter = new DateInterval('PT30M');

                    #echo "voy a entrar con " . $dia . ' ' . $desde . ' ' . $hasta;
                    #die();

                    for ($f = 1; $f <= $cant * 2; $f++) {

                        $newhorario = 'INSERT INTO horario (dia, desde, hasta, id_med)
                                VALUES ("' . $dia . '","' . date_format($d, "H:i:s") . '","' . date_format($d->add($inter), "H:i:s") . '", "' . $id . '")';

                        $db->query($newhorario);
                    }
                }
            }

            if (isset($_POST['os_select'])) {
                foreach ($_POST['os_select'] as $os) {
                    $consulta = 'SELECT idos FROM os WHERE "' . $os['nombre'] . '" = nombre ';
                    
                    $conidos = $db->query($consulta);
                    $arridos = $conidos->fetch(PDO::FETCH_ASSOC);
                    $idos = $arridos['idos'];
                    
                    $newOs = "INSERT INTO med_os (id_os, id_med)
                                VALUES ('$idos', '$idmed')";

                    $db->query($newOs);
                }
            }
        }
    }
}
?>

<form class="form-horizontal" name="formi" method="POST" action="/abm/medico.php?code=a">
    <fieldset>
        <legend>Agregar una nuevo Medico.</legend>
        <label>Ingrese los datos personales del medico:</label>
        <div class="control-group">
            <div class="controls">             
                <label>Nombre</label>
                <input type="text" class="input-xlarge" id="nombre" name="nombre" placeholder="Nombre" maxlength="20" onkeypress="return soloLetras(event);">
                <label>Apellido</label>
                <input type="text" class="input-xlarge" id="apellido" name="apellido" placeholder="Apellido" maxlength="20" onkeypress="return soloLetras(event);">
                <label>DNI</label>
                <input type="text" class="input-xlarge" id="dni" name="dni" placeholder="12345678" maxlength="8" onkeypress="return justNumbers(event);">
                <label>Matrícula</label>
                <input type="text" class="input-xlarge" id="matricula" name="matricula" placeholder="12345678" maxlength="8" onkeypress="return justNumbers(event);">
                <label>Correo electrónico</label>
                <input type="text" class="input-xlarge" id="mail" name="mail" placeholder="nombre@servidor.com">
                <label>Teléfono</label>
                <input type="text" class="input-xlarge" id="tel" name="tel" placeholder="Teléfono" maxlength="10" onkeypress="return justNumbers(event);">
                <label>Especialidad</label>
                <?php
                $datab = conectaDb();
                $consulta = "SELECT * FROM especialidad where activa = 1";
                $result = $datab->query($consulta);
                if (!$result)
                    print ("<p>error en la consulta<p>");
                else
                    
                    ?>
                <select tabindex="12" class="select-xlarge" name="esp_select" >
                    <?php
                    foreach ($result as $valor)
                        echo '<option>' . $valor['nombre'] . '</option>';
                    ?>
                </select>
                <input type="hidden" name="code" value="a"/><br><br> 
            </div>
        </div>
    </fieldset>


    <!-- Bitácora del gordo: Acá comienza la exploración por el fantástico mundo de insertar obras sociales al médico -->


    <fieldset>

        <div id="obrasSociales">

        </div>

        <button class="btn btn-success" onClick="agregarObraSocial();
                        return false;">Agregar Obra Social </button>

    </fieldset>


    <!-- Fín bitácora del gordo  (MIRA NESTOR PUSE ASENTOS COMO TE GUSTA) -->


    <legend>Horarios del medico</legend>
    <fieldset>

        <div id="grillahoraria">

        </div>


        <button class="btn btn-success" onClick="agregarHorarioMedico();
                        return false;">Agregar Horario </button>


        <input type="submit" class="btn btn-success"  onClick="return veriformuMed();" value="Guardar Medico ">
    </fieldset>

</form>

<script type="text/javascript">
                    var numeroHorario = 1;
                    var numeroOs = 1;

                    function agregarHorarioMedico()
                    {
                        $.ajax({
                            url: 'medico/horario.php',
                            type: 'POST',
                            data: {
                                numeroHorario: numeroHorario++
                            },
                            success: function(data) {
                              console.warn(numeroHorario);
                                $('#grillahoraria').append(data);
                            }
                        });
                    }

                    function agregarObraSocial()
                    {
                        $.ajax({
                            url: 'medico/addOs.php',
                            type: 'POST',
                            data: {
                                numeroOs: numeroOs++
                            },
                            success: function(data) {
                                $('#obrasSociales').append(data);
                            }
                        });
                    }

                    function borrarHorario(numeroDiv)
                    {
                        $('#horario_div_' + numeroDiv).remove();
                    }

                    function borrarOs(numeroDiv)
                    {
                        $('#os_div_' + numeroDiv).remove();
                    }


</script>