<?php
include_once('.../../../../sesion/login.php');
include_once '.../../../../fragmentos/_conectDb.php';

$db = conectaDb();
$id = $_GET['id'];

if (isset($_GET['desde'])) {
    $desde = $_GET['desde'];
    $hasta = $_GET['hasta'];
    $dia = $_GET['dia'];

    $d = date_create($desde);

    $cant = $hasta - $desde;
    $inter = new DateInterval('PT30M');

    for ($f = 1; $f <= $cant * 2; $f++) {
        $t = date_format($d, "H:i:s");
        $borrarHorario = "delete from horario where dia = '" . $dia . "' and desde='$t' and id_med = '$id'";

        $d->add($inter);

        $db->query($borrarHorario);
    }
}

if (isset($_POST['horario'])) {
    foreach ($_POST['horario'] as $horarioMedico) {
        $dia = $horarioMedico['dia'];
        $desde = $horarioMedico['desde'];
        $hasta = $horarioMedico['hasta'];
        $cant = $hasta - $desde;
        $d = date_create($desde);
        $inter = new DateInterval('PT30M');

        $superposicion = "select id from horario where dia ='$dia' and desde >= '$desde' and hasta <= '$hasta'";
        $super = $db->query($superposicion);
        if ($super->rowCount() == 0) {

            for ($f = 1; $f <= $cant * 2; $f++) {

                $newhorario = 'INSERT INTO horario (dia, desde, hasta, id_med)
                                VALUES ("' . $dia . '","' . date_format($d, "H:i:s") . '","' . date_format($d->add($inter), "H:i:s") . '", "' . $id . '")';

                $db->query($newhorario);
            }
        }else{
            echo ' <div class="alert alert-error">  
                    <a class="close" data-dismiss="alert">×</a>  
                    <h4><strong>Error!</strong><br>
                    El horario del dia: ' . $horarioMedico['dia'] . ' se superpone con otro horario.</h4>  
                </div>';
        }
    }
}

$consulta = "select id, dia, min(desde) desde, max(hasta) hasta, id_med from horario inner join medico on (id_med = '$id') group by id_med, dia";
$result = $db->query($consulta);
?>

<div class="control-group">
    <form class="form-horizontal" name="formi" method="POST" action="./medico.php?code=hsmod&id=<?php echo $id ?>">
        <table id="tabla1" class="table table-striped">
            <thead>
                <tr>
                    <th>Dia <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Día" data-content="Oprima sobre este campo para ordenar la lista por el atributo Día de la consulta. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                        <i class="icon-question-sign"></i>
                    </button></th>
                    <th>Desde <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Desde" data-content="Oprima sobre este campo para ordenar la lista por la hora de inicio de la consulta. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                        <i class="icon-question-sign"></i>
                    </button></th>
                    <th>Hasta <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Hasta" data-content="Oprima sobre este campo para ordenar la lista por la hora de finalización de la consulta. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                        <i class="icon-question-sign"></i>
                    </button></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
<?php foreach ($result as $valor): ?>
                    <tr>
                        <td><?php echo $valor['dia'] ?></td>
                        <td><?php echo $valor['desde'] ?></td>
                        <td><?php echo $valor['hasta'] ?></td>
                        <td><a class="btn btn-danger" href="./medico.php?code=hsmod&id=<?php echo $id ?>&desde=<?php echo $valor['desde'] ?>&hasta=<?php echo $valor['hasta'] ?>&dia=<?php echo $valor['dia'] ?>">Eliminar</a></td>
                    </tr>
<?php endforeach; ?>
            </tbody>
        </table>
        <br><br><br>
        <fieldset>

            <div id="grillahoraria">

            </div>


            <button class="btn btn-success" onClick="agregarHorarioMedico();
                    return false;">Agregar Horario </button>
            <button class="btn btn-mini" onclick="return false;" data-original-title="Horarios de atención del Médico" data-content="Oprima sobre el botón 'Agregar Horario' para desplegar el formulario. Si desea agregar un nuevo horario de atencion oprímalo nuevamente. Para eliminar un horario oprima sobre el icono cerrar ('x').">
                <i class="icon-question-sign"></i>
            </button>

        </fieldset>
        <br><br><input type="submit" class="btn btn-success" id="guardar" value="Guardar cambios">
        <a href="../abm/medico.php?code=m&id=<?php echo $id ?>" class="btn btn-success">Volver</a>
        <button class="btn btn-mini" onclick="return false;" data-original-title="Volver" data-content="Oprima sobre volver para regresar al 'modificar' del Médico. Debe volver para continuar con la modificación del Médico. Recuerde guardar los cambios que haya realizado oprimiendo el botón 'Guardar cambios'.">
            <i class="icon-question-sign"></i>
        </button>
    </form>
</div>

<script>
                var numeroHorario = 0;
                var cantHorarios = 0;

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

                function borrarHorario(numeroDiv)
                {
                    $('#horario_div_' + numeroDiv).remove();
                    cantHorarios = $('#grillahoraria').find('div').length;
                    if (cantHorarios == 0)
                        numeroHorario = 0;

                }
</script>