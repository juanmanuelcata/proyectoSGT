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
          <th>Elegir</th>
          <th>Paciente</th>
          <th>DNI</th>
          <th>Medico</th>
          <th>Especialidad</th>
          <th>Fecha</th>
          <th>Horario</th>
          <th>Confirmado</th>
          <th>Cancelado</th>
          <th>Responsable</th>
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
  <button type="submit" class="btn btn-info offset1">Imprimir</button>
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
                              case 5:
                                alert('reseteo bien.');
                                break;
                              case 6:
                                alert('no reseteo.');
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