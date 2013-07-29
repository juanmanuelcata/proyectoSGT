<?php
$db = conectaDb();
$consulta = "select * from medico";
$result = $db->query($consulta);
?>
<legend>Turnos por médico</legend>
<form class="form-horizontal" name="form" action="#" method="GET" target="_blank">
    <div class="control-group">
        <label>Fecha inicio</label>
        <input class="fecha" type="date" tabindex="1" class="input-large" id="fechaInic" name="fechaInic">           
        <br><br>
        <label>Fecha fin</label>
        <input class="fecha" type="date" tabindex="2" class="input-large" id="fechaFin" name="fechaFin" onkeypress="return justFecha(event);">
        <br><br>
        <div id="manzana">
            <div id="banana">
                <table id="tabla1" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Médico</th>
                            <th>Cantidad de turnos</th>
                            <th>% de turnos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($result as $valor): ?>
                            <?php
                            $con = 'select * from medico inner join turno on (medico.idmedico = turno.id_med) where idmedico = ' . $valor['idmedico'] . '';
                            $result2 = $db->query($con);
                            $cant = $result2->rowCount();

                            $conAux = 'select * from turno';
                            $resultAux = $db->query($conAux);
                            $cantAux = $resultAux->rowCount();
                            if ($cantAux > 0)
                                $porcentaje = ($cant * 100) / $cantAux;
                            else
                                $porcentaje = ($cant * 100) / 1;
                            $porcentaje = round($porcentaje * 100) / 100; //esto es para redondear a 2 decimales

                            $medico = $valor['nombre'] . ' ' . $valor['apellido'];
                            ?>
                            <tr>
                                <td><?php echo $medico ?></td>
                                <td><?php echo $cant ?></td>
                                <td><?php echo $porcentaje ?></td>
                            </tr>

                        <?php endforeach; ?>

                    </tbody>    
                </table>
            </div>
        </div>
    </div>
    <br>
    <!--        <a href="javascript:seleccionar_todo()">Marcar todos</a> | 
            <a href="javascript:deseleccionar_todo()">Desmarcar todos</a> 
            <button type="submit" class="btn btn-success offset1">Imprimir</button>-->
</form>

<script>

            $().ready(function() {

                $('.fecha').change(function() {
                    $.ajax({
                        url: 'medico/obtener_turnos_por_cambio_fecha.php',
                        type: 'POST',
                        data: {
                            fechaInic: $('#fechaInic').val(),
                            fechaFin: $('#fechaFin').val()
                        },
                        success: function(data) {

                            $('#banana').remove();
                            $('#manzana').append(data);
                        }
                    });
                });
            });

</script>


<?php $result = $db->query($consulta); ?>

<legend>Turnos cancelados</legend>
<form class="form-horizontal" name="form" action="#" method="GET" target="_blank">
    <div class="control-group">
        <label>Fecha inicio</label>
        <input class="fecha1" type="date" tabindex="1" class="input-large" id="fechaInic1" name="fechaInic1">           
        <br><br>
        <label>Fecha fin</label>
        <input class="fecha1" type="date" tabindex="2" class="input-large" id="fechaFin1" name="fechaFin1">
        <br><br>
        <div id="manzana1">
            <div id="banana1">
                <table id="tabla2" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Médico</th>
                            <th>Turnos cancelados</th>
                            <th>% de turnos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($result as $valor): ?>
                            <?php
                            $con = 'select * from medico inner join turno on (medico.idmedico = turno.id_med) where idmedico = ' . $valor['idmedico'] . ' and estado = "cancelado"';
                            $result2 = $db->query($con);
                            $cant = $result2->rowCount();

                            $conAux = 'select * from medico inner join turno on (medico.idmedico = turno.id_med) where idmedico = ' . $valor['idmedico'] . '';
                            $resultAux = $db->query($conAux);
                            $cantAux = $resultAux->rowCount();
                            if ($cantAux > 0)
                                $porcentaje = ($cant * 100) / $cantAux;
                            else
                                $porcentaje = ($cant * 100) / 1;
                            $porcentaje = round($porcentaje * 100) / 100; //esto es para redondear a 2 decimales

                            $medico = $valor['nombre'] . ' ' . $valor['apellido'];
                            ?>
                            <tr>
                                <td><?php echo $medico ?></td>
                                <td><?php echo $cant ?></td>
                                <td><?php echo $porcentaje ?></td>
                            </tr>

                        <?php endforeach; ?>

                    </tbody>    
                </table>
            </div>
        </div>
    </div>
    <br>
    <!--        <a href="javascript:seleccionar_todo()">Marcar todos</a> | 
            <a href="javascript:deseleccionar_todo()">Desmarcar todos</a> 
            <button type="submit" class="btn btn-success offset1">Imprimir</button>-->
</form>

<script>

            $().ready(function() {

                $('.fecha1').change(function() {
                    $.ajax({
                        url: 'medico/obtener_turnos_cancelados.php',
                        type: 'POST',
                        data: {
                            fechaInic: $('#fechaInic1').val(),
                            fechaFin: $('#fechaFin1').val()
                        },
                        success: function(data) {
                            $('#banana1').remove();
                            $('#manzana1').append(data);
                        }
                    });
                });
            });

</script>