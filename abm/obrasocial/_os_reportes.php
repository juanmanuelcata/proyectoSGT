
<?php
$db = conectaDb();
$consulta = "select * from os";
$result = $db->query($consulta);
?>
<legend>Pacientes por obra social</legend>
<form class="form-horizontal" name="form" action="#" method="GET" target="_blank">
    <div class="control-group">
        <table id="tabla1" class="table table-striped">
            <thead>
                <tr>
                    <th>OS</th>
                    <th>Cantidad de pacientes</th>
                    <th>% de pacientes</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $valor): ?>
                    <?php
                    $con = 'select * from os inner join pac_os on (os.idos = pac_os.id_os) where idos = ' . $valor['idos'] . '';
                    $result2 = $db->query($con);
                    $cant = $result2->rowCount();

                    $conAux = 'select * from paciente';
                    $resultAux = $db->query($conAux);
                    $cantAux = $resultAux->rowCount();
                    if ($cantAux > 0)
                        $porcentaje = ($cant * 100) / $cantAux;
                    else
                        $porcentaje = ($cant * 100) / 1;
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


<?php
$result = $db->query($consulta);
?>

<legend>Médicos por obra social</legend>
<form class="form-horizontal" name="form" action="#" method="GET" target="_blank">
    <div class="control-group">
        <table id="tabla2" class="table table-striped">
            <thead>
                <tr>
                    <th>OS</th>
                    <th>Cantidad de médicos</th>
                    <th>% de médicos</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $valor): ?>
                    <?php
                    $con = 'select * from os inner join med_os on (os.idos = med_os.id_os) where idos = ' . $valor['idos'] . '';
                    $result2 = $db->query($con);
                    $cant = $result2->rowCount();

                    $conAux = 'select * from medico';
                    $resultAux = $db->query($conAux);
                    $cantAux = $resultAux->rowCount();
                    if ($cantAux > 0)
                        $porcentaje = ($cant * 100) / $cantAux;
                    else
                        $porcentaje = ($cant * 100) / 1;
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
    <!--    <a href="javascript:seleccionar_todo()">Marcar todos</a> | 
        <a href="javascript:deseleccionar_todo()">Desmarcar todos</a> 
        <button type="submit" class="btn btn-success offset1">Imprimir</button>-->
</form>
<p><strong>Nota: </strong> un medico puede atender por mas de una obra social</p>

<br>

<?php
$result = $db->query($consulta);
?>

<legend>Turnos por obra social</legend>
<form class="form-horizontal" name="form" action="#" method="GET" target="_blank">
    <div class="control-group">
        <table id="tabla3" class="table table-striped">
            <thead>
                <tr>
                    <th>Obra Social</th>
                    <th>Cantidad de turnos</th>
                    <th>% de turnos</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $valor): ?>
                    <?php
                    $con = 'select * from os inner join turno on (os.idos = turno.id_os) where idos = ' . $valor['idos'] . '';
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
    <!--    <a href="javascript:seleccionar_todo()">Marcar todos</a> | 
        <a href="javascript:deseleccionar_todo()">Desmarcar todos</a> 
        <button type="submit" class="btn btn-success offset1">Imprimir</button>-->
</form>