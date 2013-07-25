<?php
$db = conectaDb();
$consulta = "select * from paciente";
$result = $db->query($consulta);
?>
<legend>Turnos por paciente</legend>
<form class="form-horizontal" name="form" action="#" method="GET" target="_blank">
    <div class="control-group">
        <table id="tabla1" class="table table-striped">
            <thead>
                <tr>
                    <th>Paciente</th>
                    <th>Cantidad de turnos</th>
                    <th>% de turnos</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $valor): ?>
                    <?php
                    $con = 'select * from paciente inner join turno on (paciente.idpaciente = turno.id_pac) where idpaciente = ' . $valor['idpaciente'] . '';
                    $result2 = $db->query($con);
                    $cant = $result2->rowCount();

                    $conAux = 'select * from turno';
                    $resultAux = $db->query($conAux);
                    $cantAux = $resultAux->rowCount();

                    $porcentaje = ($cant * 100) / $cantAux;
                    $porcentaje = round($porcentaje * 100) / 100; //esto es para redondear a 2 decimales
                    ?>
                    <tr>
                        <td><?php echo $valor['nombre'] ?></td>
                        <td><?php echo $cant ?></td>
                        <td><?php echo $porcentaje ?></td>
                    </tr>

                <?php endforeach; ?>

            </tbody>    
        </table>
    </div>
    <br>
    <!--        <a href="javascript:seleccionar_todo()">Marcar todos</a> | 
            <a href="javascript:deseleccionar_todo()">Desmarcar todos</a> 
            <button type="submit" class="btn btn-success offset1">Imprimir</button>-->
</form>