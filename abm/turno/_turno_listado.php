<?php
require_once('../fragmentos/Dia.php');
if (isset($_GET['idpaciente'])) {
    $db = conectaDb();
//tomamos variables
    $idpaciente = $_GET['idpaciente'];
    $idmedico = $_GET['idmedico'];
    $fecha = new Dia($_GET['fecha']);
    $idhorario = $_GET['horario'];
    $nombre = $_GET['nombre'];
    $apellido = $_GET['apellido'];

//busco la hora del idhorario

    $consultaPorHorario = "select * from horario where id = '$idhorario'";
    $consul = $db->query($consultaPorHorario);
    $aux = $consul->fetch(PDO::FETCH_ASSOC);
    $horario = $aux['desde'];


//busco el id de la os

    $consultaPorOS = "select id_os from pac_os where id_paciente = '$idpaciente'";
    $resu = $db->query($consultaPorOS);
    $aux = $resu->fetch(PDO::FETCH_ASSOC);
    $idos = $aux['id_os'];
//usuario que dio el alta del turno
    $responsable = $_SESSION['usuario']['id'];
//insercion de turno
    $auxx = new DateTime($fecha->getDia());
    $fechaYanki = $auxx->format('Y-m-d');
    $consultaInsertarTurno = "insert into turno (id_pac, id_med, fecha, hora, id_os, responsable ) 
                                         value ('$idpaciente', '$idmedico', '" . $fechaYanki . "', '$horario', '$idos', '$responsable')";

    $result = $db->query($consultaInsertarTurno);
    if ($result) {
        echo '<div class="alert alert-success">  
                    <a class="close" data-dismiss="alert">×</a>  
                    <strong><h4>El turno se dio de alta correctamente</h4>.</strong>  
                 </div>';
    } else {
        echo '<div class="alert alert-error">  
                <a class="close" data-dismiss="alert">×</a>  
                <strong><h4>Error!</h4> Error al conectarse a la base de datos</strong>.  
             </div>';
    }

    $inhabilitarHorarioDisponible = "update horario set activo=0 where id='$idhorario'";
    $result = $db->query($inhabilitarHorarioDisponible);
}
$db = conectaDb();
$consulta = "SELECT idturno, turno.fecha fecha, turno.hora hora, turno.estado estado,
    idpaciente, paciente.dni dni, paciente.nombre pnombre, paciente.apellido papellido, 
    idmedico, medico.idmedico idmedico, medico.nombre mnombre, medico.apellido mapellido, os.nombre osnombre, 
    idusuario, usuario.nombre unombre, usuario.apellido uapellido, 
    especialidad.nombre esp from turno inner join
    paciente on ( idpaciente = id_pac) inner join medico on (turno.id_med = idmedico)
    inner join os on (idos = id_os) inner join usuario on
    (idusuario = responsable) inner join med_esp on (med_esp.id_med = idmedico)
    inner join especialidad on (idespecialidad = med_esp.id_esp) ";

$result = $db->query($consulta);
if ($result->rowCount() == 0) {
    print ('<p>No hay turnos</p>');
}
?>


<legend>Listado de Turnos</legend>
<form class="form-horizontal" name="form" id="form1" action="./turno/_turno_imprimir.php" method="GET" target="_blank">
    <div class="control-group">
        <table id="tabla1" class="table table-striped">
            <thead>
                <tr>
                    <th>Elegir <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Elegir para impresión" data-content="Oprima sobre cada turno para seleccionarlo, o utilice los botones de Marcar o Desmarcar todos.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                    <th>Paciente <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Paciente" data-content="Oprima sobre este campo para ordenar la lista por el atributo Paciente (nombre y apellido) al que está asignado el turno. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                    <th>DNI <button class="btn btn-mini" onclick="return false;" data-original-title="Campo DNI" data-content="Oprima sobre este campo para ordenar la lista por el atributo DNI del paciente al que está asignado el turno. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                    <th>Medico <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Médico" data-content="Oprima sobre este campo para ordenar la lista por el atributo Médico (nombre y apellido) al que está asignado el turno. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                    <th>Especia. <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Especialidad" data-content="Oprima sobre este campo para ordenar la lista por el atributo Especialidad del médico al que está asignado el turno. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                    <th>Fecha <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Fecha" data-content="Oprima sobre este campo para ordenar la lista por el atributo Fecha del turno. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                    <th>Horario <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Horario" data-content="Oprima sobre este campo para ordenar la lista por el atributo Horario (del inicio) del turno. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                    <th>Confirm. <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Confirmado" data-content="Oprima sobre el botón 'Confirmar' para marcar un turno como confirmado, en el caso de que un paciente asista a la consulta.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                    <th>Cancel. <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Cancelado" data-content="Oprima sobre el botón 'Cancelar' para marcar un turno como cancelado, en el caso de que un paciente no asista a la consulta o la cancele previamente.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                    <th>Respons. <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Responsable" data-content="Oprima sobre este campo para ordenar la lista por el atributo Responsable (nombre y apellido) del usuario que asignó el turno. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $valor): ?>
                    <?php
                    if ($valor['estado'] != 'cancelado'):

                        $idmedico = $valor['idmedico'];
                        $hora = $valor['hora'];
                        $fecha = $valor['fecha'];
                        $dia = new Dia($fecha);
                        $dianom = $dia->getNombre();
                        $con = "select id from horario where dia = '$dianom' and desde = '$hora' and id_med = '$idmedico'";
                        $aux = $db->query($con);
                        $array1 = $aux->fetch(PDO::FETCH_ASSOC);
                        $idhorario = $array1['id'];
                        ?>
                        <tr>
                            <td><input type="checkbox" name="<?php echo $valor['idturno'] ?>" value="<?php echo $valor['idturno'] ?>" id="<?php echo $valor['idturno'] ?>"></td>
                            <td><?php echo $valor['pnombre'] . ' ' . $valor['papellido'] ?></td>
                            <td><?php echo $valor['dni'] ?></td>
                            <td><?php echo $valor['mnombre'] . ' ' . $valor['mapellido'] ?></td>
                            <td><?php echo $valor['esp'] ?></td>
                            <td><?php echo $valor['fecha'] ?></td>
                            <td><?php echo $valor['hora'] ?></td>
                            <?php if ($valor['estado'] == 'pendiente'): ?>
                                <td><button id="<?php echo $idhorario ?>" name="conf <?php echo $valor['idturno'] ?>"
                                            value="<?php echo $valor['idturno'] ?>" class="btn btn-success" onclick="return false;" >
                                        Confirmar</button></td>
                                <td><button id="<?php echo $idhorario ?>" name="canc<?php echo $valor['idturno'] ?>"
                                            value="<?php echo $valor['idturno'] ?>"  class="btn btn-danger" onclick="return false;" >
                                        Cancelar</button></td>                    
                            <?php else: ?>
                                <td><button id="conf<?php echo $valor['idturno'] ?>" name="conf <?php echo $valor['idturno'] ?>"
                                            value="<?php echo $idhorario ?>" disabled="" class="btn btn-success" onclick="return false;" >
                                        Confirmar</button></td>
                                <td><button id="<?php echo $idhorario ?>" name="canc<?php echo $valor['idturno'] ?>"
                                            value="<?php echo $valor['idturno'] ?>" disabled="" class="btn btn-danger" onclick="return false;" >
                                        Cancelar</button></td>  
                            <?php endif; ?>
                            <td><?php echo $valor['unombre'] . ' ' . $valor['uapellido'] ?></td></tr> 
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>    
        </table>
    </div>
    <br>
    <a href="javascript:seleccionar_todo()">Marcar todos</a> | 
    <a href="javascript:deseleccionar_todo()">Desmarcar todos</a>
    <button class="btn btn-mini" onclick="return false;" data-original-title="Opciones de marcado" data-content="Oprima 'Marcar todos' para seleccionar todos los turnos visualizados u oprima 'Desmarcar todos' para desmarcar todos los turnos que estén visualizados.">
        <i class="icon-question-sign"></i>
    </button>
    <button type="submit" class="btn btn-success offset1">Imprimir</button>
    <button class="btn btn-mini" id='ayuda' onclick="return false;" data-original-title="Imprimir" data-content="Seleccione los turnos que desee imprimir haciendo click sobre el campo 'Elegir' de cada uno o utilizando el botón de 'Marcar todos'. Una vez hecho esto oprima el botón 'Imprimir' y se abrirá una nueva ventana con un documento pdf el cual podrá imprimir utilizando las opciones del navegador que esté usando.">
        <i class="icon-question-sign"></i>
    </button>
</form>

<script>
                        $('.btn-success').click(function() {
                            $(this).parent().parent().find('.btn').prop('disabled', 'disabled');
                            $.ajax({
                                url: 'turno/_conf_canc.php',
                                type: 'POST',
                                data: {
                                    idturno: $(this).val(),
                                    ok: 1
                                },
                                success: function(data) {
                                    var datos = eval('(' + data + ')');

                                    /* ahora usas datos como si fuera un objeto */

                                    switch (datos.resultado) {
                                        case 1:
                                            alert('Confirmación exitosa.');
                                            break;
                                        case 2:
                                            alert('Falla en la confirmacion.');
                                            break;
                                    }
                                }
                            });
                        });
                        $('.btn-danger').click(function() {
                            $(this).parent().parent().remove();
                            $.ajax({
                                url: 'turno/_conf_canc.php',
                                type: 'POST',
                                data: {
                                    idturno: $(this).val(),
                                    ok: 0,
                                    idhorario: $(this).attr('id')
                                },
                                success: function(data) {
                                    var datos = eval('(' + data + ')');

                                    /* ahora usas datos como si fuera un objeto */

                                    switch (datos.resultado) {
                                        case 3:
                                            alert('Cancelación exitosa.');
                                            break;
                                        case 4:
                                            alert('Falla en la cancelacion.');
                                            break;
                                    }
                                }
                            });
                        });


                        function seleccionar_todo() {
                            for (i = 0; i < document.form.elements.length; i++)
                                if (document.form.elements[i].type == "checkbox")
                                    document.form.elements[i].checked = 1
                        }

                        function deseleccionar_todo() {
                            for (i = 0; i < document.form.elements.length; i++)
                                if (document.form.elements[i].type == "checkbox")
                                    document.form.elements[i].checked = 0
                        }
</script>
