<?php
$db = conectaDb();
$consulta = "select * from especialidad";
$result = $db->query($consulta);
?>

<legend>Médicos por especialidad</legend>
<form class="form-horizontal" name="form1" action="./especialidad/_especialiad_imprimir_reportes.php" method="GET" target="_blank">
    <div class="control-group">
        <table id="tabla1" class="table table-striped">
            <thead>
                <tr>
                    <th>Elegir</th>
                    <th>Especialidad</th>
                    <th>Cantidad de médicos</th>
                    <th>% de médicos</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $valor): ?>
                    <?php
                    $con = 'select * from especialidad inner join med_esp on (especialidad.idespecialidad = med_esp.id_esp) where idespecialidad = ' . $valor['idespecialidad'] . '';
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
                        <td><input type="checkbox" name="<?php echo $valor['idespecialidad'] ?>" value="<?php echo $valor['idespecialidad'] ?>" id="<?php echo $valor['idespecialidad'] ?>"></td>
                        <td><?php echo $valor['nombre'] ?></td>
                        <td><?php echo $cant ?></td>
                        <td><?php echo $porcentaje ?></td>
                    </tr>

                <?php endforeach; ?>

            </tbody>    
        </table>
    </div>
    <br>
    <a href="javascript:seleccionar_todo1()">Marcar todos</a> | 
    <a href="javascript:deseleccionar_todo1()">Desmarcar todos</a>
    <input type="hidden" name="code" value="a"/>
    <button type="submit" class="btn btn-success offset1">Imprimir</button>
</form>

<script>
    function seleccionar_todo1() {
        for (i = 0; i < document.form1.elements.length; i++)
            if (document.form1.elements[i].type == "checkbox")
                document.form1.elements[i].checked = 1
    }

    function deseleccionar_todo1() {
        for (i = 0; i < document.form1.elements.length; i++)
            if (document.form1.elements[i].type == "checkbox")
                document.form1.elements[i].checked = 0
    }
</script>



<?php
$result = $db->query($consulta);
?>

<legend>Turnos por especialidad</legend>
<form class="form-horizontal" name="form2" action="./especialidad/_especialiad_imprimir_reportes.php" method="GET" target="_blank">
    <div class="control-group">
        <table id="tabla2" class="table table-striped">
            <thead>
                <tr>
                    <th>Elegir</th>
                    <th>Especialidad</th>
                    <th>Cantidad de turnos</th>
                    <th>% de turnos</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($result as $valor):

                    $con = 'select * from especialidad inner join med_esp on (especialidad.idespecialidad = med_esp.id_esp) inner join turno 
                      on (med_esp.id_med = turno.id_med) where idespecialidad = ' . $valor['idespecialidad'] . '';
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
                        <td><input type="checkbox" name="<?php echo $valor['idespecialidad'] ?>" value="<?php echo $valor['idespecialidad'] ?>" id="<?php echo $valor['idespecialidad'] ?>"></td>
                        <td><?php echo $valor['nombre'] ?></td>
                        <td><?php echo $cant ?></td>
                        <td><?php echo $porcentaje ?></td>
                    </tr>

                <?php endforeach; ?>

            </tbody>    
        </table>
    </div>
    <br>
    <a href="javascript:seleccionar_todo2()">Marcar todos</a> | 
    <a href="javascript:deseleccionar_todo2()">Desmarcar todos</a>
    <input type="hidden" name="code" value="b"/>
    <button type="submit" class="btn btn-success offset1">Imprimir</button>
</form>

<script>
    function seleccionar_todo2() {
        for (i = 0; i < document.form2.elements.length; i++)
            if (document.form2.elements[i].type == "checkbox")
                document.form2.elements[i].checked = 1
    }

    function deseleccionar_todo2() {
        for (i = 0; i < document.form2.elements.length; i++)
            if (document.form2.elements[i].type == "checkbox")
                document.form2.elements[i].checked = 0
    }

</script>