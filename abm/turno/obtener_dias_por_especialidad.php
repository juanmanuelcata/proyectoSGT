<?php
include_once('../../sesion/login.php');
include_once './../../fragmentos/_conectDb.php';
require_once('./../../fragmentos/Dia.php');
$db = conectaDb();
$esp_nombre = $_POST['esp'];
//notar que uso los mismos nombres de variables pero para cada uno le agrego un numero
//especialidad es 1, medico es 2, dia es 3 y horario 4;
?>
<div id="segundo">
    <?php
    $consulta1 = "SELECT * FROM especialidad where activa = 1";
    $res1 = $db->query($consulta1);
    foreach ($res1 as $valor1)
        if ($valor1['idespecialidad'] == $esp_nombre) {
            $idesp1 = $valor1['idespecialidad'];
        }

    $consulta2 = 'select idmedico, nombre, apellido
                  from medico 
                  where idmedico in (select id_med
                                      from med_esp 
                                      where id_esp = "' . $idesp1 . '")';

    $res2 = $db->query($consulta2);
    ?>

    <?php if ($res2->rowCount() > 0): ?>


        <!-- select de especialidad -->
        <select tabindex="12" class="select-xlarge" id="select_especialidades" name="esp_select" >
            <?php
            $idesp1;
            $consulta1 = "SELECT * FROM especialidad where activa = 1";
            $res1 = $db->query($consulta1);
            foreach ($res1 as $valor1)
                if ($valor1['idespecialidad'] == $esp_nombre) {
                    $idesp1 = $valor1['idespecialidad'];
                    echo '<option value="' . $valor1['idespecialidad'] . '" Selected="Selected">' . $valor1['nombre'] . '</option>';
                }
                else
                    echo '<option value="' . $valor1['idespecialidad'] . '">' . $valor1['nombre'] . '</option>';
            ?>
        </select>
        <button class="btn btn-mini" onclick="return false;" data-original-title="Especialidad del Médico" data-content="Despliegue la lista de Especialidades haciendo click sobre el campo a la izquierda, luego seleccione de la lista la Especialidad del Médico al que se le desea asignar un Turno.">
            <i class="icon-question-sign"></i>
        </button>
        <?php
//intentando encontrar el orden adecuado para generar el primer horairo disponible
//deberia averiguar todos los medicos de la especialidad
//obtener para cada medico los dias y dentro de cada dia guardar el minimo
//tener en cuenta que dia es menor a cual con un arreglo...(?)

        $consulta2 = 'select idmedico, nombre, apellido
                  from medico 
                  where idmedico in (select id_med
                                      from med_esp 
                                      where id_esp = "' . $idesp1 . '")';
        //tengo todos los medicos de la especialidad elegida
        $res2 = $db->query($consulta2);
        $dia_min = new Dia('31-12-2100');
        $oDia;
        $hs_min = '22:00:00';
        $id_hs_min;
        $hs_elegido;
        $id_med_min;
        $id_med_min;
        $nom_med_min;
        $ape_med_min;
        //para cada medico reviso

        foreach ($res2 as $valor2) {
            //dias del medico actual
            $conaux2 = 'select dia from horario where (id_med  = "' . $valor2['idmedico'] . '") group by dia ';
            $aux2 = $db->query($conaux2);
            foreach ($aux2 as $valaux2) {
                $auxi = new Dia($valaux2['dia']);
                //reviso el minimo de los dias            
                if ($auxi->getDia() <= $dia_min) {
                    $dia_nom = $auxi->getNombre();
                    //obtengo los horarios del dia actual del medico actual
                    $consulta3 = 'select id, min(desde) desde, min(hasta) hasta, dia, id_med
                                    from horario where (id_med  = "' . $valor2['idmedico'] . '") 
                                        and (dia = "' . $dia_nom . '") and (activo = 1)';
                    $res3 = $db->query($consulta3);
                    foreach ($res3 as $valaux3) {
                        //reviso el horario minimo de ese dia
                        if ($valaux3['desde'] <= $hs_min) {
                            $dia_min = $auxi->getDia();
                            $dia_nom = $auxi->getNombre();
                            $oDia = new Dia($valaux2['dia']);
                            $hs_min = $valaux3['desde'];
                            $id_hs_min = $valaux3['id'];
                            $id_med_min = $valor2['idmedico'];
                            $nom_med_min = $valor2['nombre'];
                            $ape_med_min = $valor2['apellido'];
                        }
                    }
                }
            }
        }
        ?>
        <?php // de aca para abajo es lo que hay en turno alta y deberia imitarlo...   ?>

        <!-- select de medicos -->

        <?php
        $consulta4 = 'select idmedico, nombre, apellido
                  from medico 
                  where idmedico in (select id_med
                                      from med_esp 
                                      where id_esp = "' . $idesp1 . '")';
        $res4 = $db->query($consulta4);
        ?>
        <select id="select_medicos" name="idmedico">
            <?php
            foreach ($res4 as $valor4) {
                if ($valor4['idmedico'] == $id_med_min) {
                    echo '<option class="option1" value="' . $id_med_min . '" selected="selected">' . $nom_med_min . ' ' . $ape_med_min . '</option>';
                } else {
                    echo '<option class="option1" value="' . $valor4['idmedico'] . '">' . $valor4['nombre'] . ' ' . $valor4['apellido'] . '</option>';
                }
            }
            ?>
        </select>
        <button class="btn btn-mini" onclick="return false;" data-original-title="Médico" data-content="Despliegue la lista de Médicos haciendo click sobre el campo a la izquierda, luego seleccione de la lista el Médico al que se le desea asignar un Turno.">
            <i class="icon-question-sign"></i>
        </button>


        <br><br>
        <!-- select de dia -->
        <select id="select_dia" name="fecha">

            <!--aca comienza la locura de los dias para el medico-->

            <!--aca termina esa locura tan limaada-->
            <option class="option2" name="fecha" value="<?php echo $oDia->getNombre() ?>">
                <?php echo $oDia->getNombre() . '--' . $oDia->getDia() ?></option>



        </select>
        <button class="btn btn-mini" onclick="return false;" data-original-title="Día de la consulta" data-content="Despliegue la lista de Días de la semana en los que atiende el Médico haciendo click sobre el campo a la izquierda, luego seleccione de la lista el Día al que se le desea asignar un Turno.">
            <i class="icon-question-sign"></i>
        </button>


        <!-- select de horarios -->
        <select id="select_horario" name="horario">
            <option class="option3" name="horario" value="<?php echo $id_hs_min; ?>"><?php echo $hs_min; ?></option>  

        </select>
        <button class="btn btn-mini" onclick="return false;" data-original-title="Horario de la consulta" data-content="Despliegue la lista de Horarios disponibles del Médico el día seleccionado haciendo click sobre el campo a la izquierda, luego seleccione de la lista el Horario al que se le desea asignar un Turno.">
            <i class="icon-question-sign"></i>
        </button>

    <?php else: ?>
        <div class="alert alert-error">  
            <a class="close" data-dismiss="alert">×</a>  
            <strong><h4>Error!</h4> No hay ningún médico que atienda en esta especialidad<br>
                Por favor seleccione otra especialidad</strong>.  
        </div>
        <select tabindex="12" class="select-xlarge" id="select_especialidades" name="esp_select" >
            <?php
            $idesp1;
            $consulta1 = "SELECT * FROM especialidad where activa = 1";
            $res1 = $db->query($consulta1);
            foreach ($res1 as $valor1)
                if ($valor1['idespecialidad'] == $esp_nombre) {
                    $idesp1 = $valor1['idespecialidad'];
                    echo '<option value="' . $valor1['idespecialidad'] . '" Selected="Selected">' . $valor1['nombre'] . '</option>';
                }
                else
                    echo '<option value="' . $valor1['idespecialidad'] . '">' . $valor1['nombre'] . '</option>';
            ?>
        </select>
        <button class="btn btn-mini" onclick="return false;" data-original-title="Especialidad del Médico" data-content="Despliegue la lista de Especialidades haciendo click sobre el campo a la izquierda, luego seleccione de la lista la Especialidad del Médico al que se le desea asignar un Turno.">
            <i class="icon-question-sign"></i>
        </button>
        <select id="select_medicos" name="idmedico">
            <option value="-1">Seleccione un Médico</option>

        </select>
        <button class="btn btn-mini" onclick="return false;" data-original-title="Médico" data-content="Despliegue la lista de Médicos haciendo click sobre el campo a la izquierda, luego seleccione de la lista el Médico al que se le desea asignar un Turno.">
            <i class="icon-question-sign"></i>
        </button>
        <br><br>

        <select id="select_dia" name="fecha">
            <option value="-1">Seleccione un Día</option>

        </select>
        <button class="btn btn-mini" onclick="return false;" data-original-title="Día de la consulta" data-content="Despliegue la lista de Días de la semana en los que atiende el Médico haciendo click sobre el campo a la izquierda, luego seleccione de la lista el Día al que se le desea asignar un Turno.">
            <i class="icon-question-sign"></i>
        </button>

        <select id="select_horario" name="horario">
            <option value="-1" class="option3">Seleccione un horario</option>

        </select>
        <button class="btn btn-mini" onclick="return false;" data-original-title="Horario de la consulta" data-content="Despliegue la lista de Horarios disponibles del Médico el día seleccionado haciendo click sobre el campo a la izquierda, luego seleccione de la lista el Horario al que se le desea asignar un Turno.">
            <i class="icon-question-sign"></i>
        </button>


    <?php endif; ?>

</div>
<script>
//                    $().ready(function() {
//                        $('#select_especialidades').change(function() {
//                            $.ajax({
//                                url: 'turno/obtener_medicos_por_especialidad.php',
//                                type: 'POST',
//                                data: {
//                                    idEspecialidad: $(this).val()
//                                },
//                                success: function(data) {
//                                    $('.option1').remove();
//                                    $('#select_medicos').append(data);
//                                }
//                            });
//                        });
//                        });

//                      nuevo
        $('#select_especialidades').change(function() {
            $.ajax({
                url: 'turno/obtener_dias_por_especialidad.php',
                type: 'POST',
                data: {
                    esp: $(this).val()
                },
                success: function(data) {
                    $('#segundo').remove();
                    $('#primero').append(data);
                }
            });
        });
//                      fin nuevo


        $('#select_medicos').change(function() {
            $.ajax({
                url: 'turno/obtener_dias_por_medico.php',
                type: 'POST',
                data: {
                    idMedico: $(this).val()
                },
                success: function(data) {
                    $('.option2').remove();
                    $('#select_dia').append(data);
                }
            });
        });

        $('#select_dia').change(function() {
            $.ajax({
                url: 'turno/obtener_horario_por_dia.php',
                type: 'POST',
                data: {
                    dia: $(this).val(),
                    med: $('#select_medicos').val()
                },
                success: function(data) {
                    $('.option3').remove();
                    $('#select_horario').append(data);
                }
            });
        });



</script>