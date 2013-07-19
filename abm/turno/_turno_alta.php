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
} else {
  if (isset($_GET['id'])) {
    $db = conectaDb();
    $idpaciente = $_GET['id'];
    $consulta = 'SELECT * FROM paciente where idpaciente = "' . $idpaciente . '"';
    $tmp = $db->query($consulta);
    $res = $tmp->fetch(PDO::FETCH_ASSOC);
    $nombre = $res['nombre'];
    $apellido = $res['apellido'];
  } else {
    echo "Estas llamando al alta de turno desde un lugar incorrecto.";
    die();
  }
}
?>

<form class="form-horizontal" name="formi" action="./turno.php?code=a" method="GET">
  <fieldset>
    <legend><h3>Agregar una nuevo turno.</h3></legend>
    <div class="control-group">
      <div class="controls">
        <legend><h4>Paciente</h4></legend>
        <input type="text" tabindex="1" readonly="readonly" class="input-medium"
               id="nombre" name="nombre" placeholder="Nombre" maxlength="20" value="<?php echo '' . $nombre . ' ' . $apellido . '.'; ?>">
        <br><br>
        <legend><h4>Médico</h4></legend>
        <label>Especialidad</label>
        <?php
        $datab = conectaDb();
        $consulta = "SELECT * FROM especialidad where activa = 1";
        $result = $datab->query($consulta);
        if (!$result)
          print ("<p>error en la consulta<p>");
        else
          
          ?>
        <select tabindex="12" class="select-xlarge" id="select_especialidades" name="esp_select" >
          <option value="-1">Seleccione una especialidad</option>
          <?php
          foreach ($result as $valor)
            if ($valor['nombre'] == 'Ninguna')
              echo '<option Selected="Selected">' . $valor['nombre'] . '</option>';
            else
              echo '<option value="' . $valor['idespecialidad'] . '">' . $valor['nombre'] . '</option>';
          ?>
        </select>

        <select id="select_medicos" name="idmedico">
          <option value="-1">Seleccione un médico</option>

        </select>

        <label>Seleccione un Horario</label>

        <select id="select_dia" name="fecha">
          <option value="-1">Seleccione un Día</option>

        </select>
        <select id="select_horario" name="horario">
          <option value="-1">Seleccione un Horario</option>

        </select>


        <input type="hidden" name="nombre" value="<?php echo $nombre ?>"/>
        <input type="hidden" name="apellido" value="<?php echo $apellido ?>"/>
        <input type="hidden" name="code" value="a"/><br><br>
        <input type="hidden" name="idpaciente" value="<?php echo $idpaciente ?>"/><br><br> 
        <button tabindex="13" type="submit" onclick="return veriformuPaciente()" class="btn btn-success">Guardar</button>
        <button tabindex="14" type="reset" class="btn btn-success">Borrar</button>

      </div>
    </div>
  </fieldset>
</form>    

<script>
          $().ready(function() {
            $('#select_especialidades').change(function() {
              $.ajax({
                url: 'turno/obtener_medicos_por_especialidad.php',
                type: 'POST',
                data: {
                  idEspecialidad: $(this).val()
                },
                success: function(data) {
                  $('.option1').remove();
                  $('#select_medicos').append(data);
                }
              });
            });

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


          });
</script>
