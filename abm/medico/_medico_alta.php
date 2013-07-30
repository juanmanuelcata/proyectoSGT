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
                    El Médico: ' . $nombre_med . ' ya se encuentra registrado.</h4>  
                </div>';
    } else {
        $consulta = "INSERT INTO medico (dni, matricula, nombre, apellido, mail, telefono) 
                    VALUES ('$dni','$matricula','$nombre_med', '$apellido_med','$mail', '$tel')";
        if ($db->query($consulta)) {
            $fechita = date('Y-m-d H:i:s');
            $detalle = 'Alta del Médico "' . $nombre_med . '"';
            $user = $_SESSION['usuario']['user'];
            $id2 = $db->lastInsertId("seq_name");
            $log = "INSERT INTO log ( fecha, usuario, detalle, tabla, idafectado)              
              VALUES ('$fechita', '$user', '$detalle', 'medico', '$id2' )";
            $db->query($log);
            echo '<div class="alert alert-success">  
                    <a class="close" data-dismiss="alert">×</a>  
                    <h4><strong>Muy Bien!</strong><br>
                    Se insertó correctamente el Médico: ' . $nombre_med . '.</h4>  
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
            $detalle = 'Alta del horario par el Médico"' . $nombre_med . '"';
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
        <legend>Agregar un nuevo Médico</legend>
        <!--<label>Ingrese los datos personales del Médico:</label>-->
        <div class="control-group">
            <div class="controls">             
                <label>Nombre</label>
                <input type="text" class="input-xlarge" id="nombre" name="nombre" placeholder="Nombre" maxlength="20" onkeypress="return soloLetras(event);">
                <button class="btn btn-mini" onclick="return false;" data-original-title="Nombre del Médico" data-content="Ingrese el nombre del Médico que desee agregar a la base de datos. No se permite ingresar números. La cantidad máxima de caracteres es 20.">
                    <i class="icon-question-sign"></i>
                </button>        
                <label>Apellido</label>
                <input type="text" class="input-xlarge" id="apellido" name="apellido" placeholder="Apellido" maxlength="20" onkeypress="return soloLetras(event);">
                <button class="btn btn-mini" onclick="return false;" data-original-title="Apellido del Médico" data-content="Ingrese el apellido del Médico que desee agregar a la base de datos. No se permite ingresar números. La cantidad máxima de caracteres es 20.">
                    <i class="icon-question-sign"></i>
                </button>                
                <label>DNI</label>
                <input type="text" class="input-xlarge" id="dni" name="dni" placeholder="12345678" maxlength="8" onkeypress="return justNumbers(event);">
                <button class="btn btn-mini" onclick="return false;" data-original-title="DNI del Médico" data-content="Ingrese el DNI del Médico que desee agregar a la base de datos. Solo se permiten caracteres numéricos. La cantidad máxima de dígitos es 8.">
                    <i class="icon-question-sign"></i>
                </button>                
                <label>Matrícula</label>
                <input type="text" class="input-xlarge" id="matricula" name="matricula" placeholder="12345678" maxlength="8" onkeypress="return justNumbers(event);">
                <button class="btn btn-mini" onclick="return false;" data-original-title="Matrícula del Médico" data-content="Ingrese la matrícula del Médico que desee agregar a la base de datos. Solo se permiten caracteres numéricos. La cantidad máxima de dígitos es 8.">
                    <i class="icon-question-sign"></i>
                </button>   
                <label>Correo electrónico</label>
                <input type="text" class="input-xlarge" id="mail" name="mail" placeholder="nombre@servidor.com">
                <button class="btn btn-mini" onclick="return false;" data-original-title="E-mail del Médico" data-content="Ingrese el e-mail del Médico que desee agregar a la base de datos. Por ejemplo: 'cuenta@gmail.com'.">
                    <i class="icon-question-sign"></i>
                </button>
                <label>Teléfono</label>
                <input type="text" class="input-xlarge" id="tel" name="tel" placeholder="Teléfono" maxlength="10" onkeypress="return justNumbers(event);">
                <button class="btn btn-mini" onclick="return false;" data-original-title="Teléfono del Médico" data-content="Ingrese el teléfono del Médico que desee agregar a la base de datos. Solo se permiten caracteres numéricos. La cantidad máxima de dígitos es 10. Es obligatorio.">
                    <i class="icon-question-sign"></i>
                </button>
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
                <button class="btn btn-mini" onclick="return false;" data-original-title="Especialidad del Médico" data-content="Oprima sobre la especialidad del Médico. Para abrir la lista de especialidades oprima sobre el campo que está a la izquierda o sobre la flecha hacia abajo. Una vez desplegada seleccione la correspondiente especialidad.">
                    <i class="icon-question-sign"></i>
                </button>
                <input type="hidden" name="code" value="a"/><br><br> 

<!--            </div>
        </div>
    </fieldset>-->


    <!-- Bitácora del gordo: Acá comienza la exploración por el fantástico mundo de insertar obras sociales al médico -->
    <control->
    <legend>Obras sociales del Médico</legend>
    <fieldset>
        
        <div id="obrasSociales">

        </div>

        <button class="btn btn-success" onClick="agregarObraSocial();
                        return false;">Agregar Obra Social </button>
        <button class="btn btn-mini" onclick="return false;" data-original-title="Obra/s social/es del Médico" data-content="Oprima sobre el botón 'Agregar Obra Social' para desplegar el formulario. Si desea agregar otra obra social oprímalo nuevamente. Para eliminar una obra social oprima sobre el icono cerrar ('x').">
            <i class="icon-question-sign"></i>
        </button>

    </fieldset>


    <!-- Fín bitácora del gordo (MIRA NESTOR PUSE ASENTOS COMO TE GUSTA) -->


    <legend>Horarios del Médico</legend>
    <fieldset>

        <div id="grillahoraria">

        </div>


        <button class="btn btn-success" onClick="agregarHorarioMedico();
                        return false;">Agregar Horario </button>
                    <button class="btn btn-mini" onclick="return false;" data-original-title="Horarios de atención del Médico" data-content="Oprima sobre el botón 'Agregar Horario' para desplegar el formulario. Si desea agregar un nuevo horario de atencion oprímalo nuevamente. Para eliminar un horario oprima sobre el icono cerrar ('x').">
            <i class="icon-question-sign"></i>
        </button>


        <br><br><input type="submit" class="btn btn-success" id="guardar" onClick="return veriformuMed();" value="Guardar">
                <button tabindex="14" type="reset" class="btn btn-success">Borrar</button>
    </fieldset>

    <!--LE AGREGuÉ ESTOS TRES (div div y fieldset) para ver si se alineaba todo en el centro...cualquier cosa estan comentados mas arriba-->
    </div>
        </div>
    </fieldset>
    <!--estos trs de arriba-->
</form>

<script type="text/javascript">
                    var numeroHorario = 0;
                    var numeroOs = 0;
                    var cantHorarios = 0;
                    var cantOs = 0;

                    $('#guardar').click(function() {
                        cantHorarios = $('#grillahoraria').find('div').length;
                    });

                    function agregarHorarioMedico()
                    {
                        $.ajax({
                            url: 'medico/horario.php',
                            type: 'POST',
                            data: {
                                numeroHorario: ++numeroHorario
                            },
                            success: function(data) {
                                $('#grillahoraria').append(data);
                                cantHorarios = $('#grillahoraria').find('div').length;
                            }
                        });
                    }

                    function agregarObraSocial()
                    {
                        $.ajax({
                            url: 'medico/addOs.php',
                            type: 'POST',
                            data: {
                                numeroOs: ++numeroOs
                            },
                            success: function(data) {
                                $('#obrasSociales').append(data);
                                cantOs = $('#obrasSociales').find('div').length;
                            }
                        });
                    }

                    function borrarHorario(numeroDiv)
                    {
                        $('#horario_div_' + numeroDiv).remove();
                        cantHorarios = $('#grillahoraria').find('div').length;
                        if (cantHorarios == 0)
                            numeroHorario = 0;

                    }

                    function borrarOs(numeroDiv)
                    {
                        $('#os_div_' + numeroDiv).remove();
                        cantOs = $('#obrasSociales').find('div').length;
                        if (cantOs == 0)
                            numeroOs = 0;
                    }


</script>
