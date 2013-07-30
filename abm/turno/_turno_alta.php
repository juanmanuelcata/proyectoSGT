<?php
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
?>
<form class="form-horizontal" name="formi" action="./turno.php" method="GET">
    <fieldset>
        <legend><h3>Agregar una nuevo Turno</h3></legend>
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
                <button class="btn btn-mini" onclick="return false;" data-original-title="Especialidad del Médico" data-content="Despliegue la lista de Especialidades haciendo click sobre el campo a la izquierda, luego seleccione de la lista la Especialidad del Médico al que se le desea asignar un Turno.">
                    <i class="icon-question-sign"></i>
                </button>

                <select id="select_medicos" name="idmedico">
                    <option value="-1">Seleccione un Médico</option>

                </select>
                <button class="btn btn-mini" onclick="return false;" data-original-title="Médico" data-content="Despliegue la lista de Médicos haciendo click sobre el campo a la izquierda, luego seleccione de la lista el Médico al que se le desea asignar un Turno.">
                    <i class="icon-question-sign"></i>
                </button>


                <label>Seleccione un Horario</label>

                <select id="select_dia" name="fecha">
                    <option value="-1">Seleccione un Día</option>

                </select>
                <button class="btn btn-mini" onclick="return false;" data-original-title="Día de la consulta" data-content="Despliegue la lista de Días de la semana en los que atiende el Médico haciendo click sobre el campo a la izquierda, luego seleccione de la lista el Día al que se le desea asignar un Turno.">
                    <i class="icon-question-sign"></i>
                </button>

                <select id="select_horario" name="horario">
                    <option value="-1" class="option3">Seleccione un Horario</option>

                </select>
                <button class="btn btn-mini" onclick="return false;" data-original-title="Horario de la consulta" data-content="Despliegue la lista de Horarios disponibles del Médico el día seleccionado haciendo click sobre el campo a la izquierda, luego seleccione de la lista el Horario al que se le desea asignar un Turno.">
                    <i class="icon-question-sign"></i>
                </button>


                <input type="hidden" name="nombre" value="<?php echo $nombre ?>"/>
                <input type="hidden" name="apellido" value="<?php echo $apellido ?>"/>
                <input type="hidden" name="code" value="l"/><br><br>
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
