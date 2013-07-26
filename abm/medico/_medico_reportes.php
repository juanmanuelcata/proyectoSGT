<?php
$db = conectaDb();
$consulta = "select * from medico";
$result = $db->query($consulta);
?>
<legend>Turnos por médico</legend>
<form class="form-horizontal" name="form" action="#" method="GET" target="_blank">
    <div class="control-group">
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

                    $porcentaje = ($cant * 100) / $cantAux;
                    $porcentaje = round($porcentaje * 100) / 100; //esto es para redondear a 2 decimales
                    
                    $medico = $valor['nombre'].' '.$valor['apellido'];
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
    <br>
    <!--        <a href="javascript:seleccionar_todo()">Marcar todos</a> | 
            <a href="javascript:deseleccionar_todo()">Desmarcar todos</a> 
            <button type="submit" class="btn btn-success offset1">Imprimir</button>-->
</form>