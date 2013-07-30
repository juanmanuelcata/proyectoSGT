<?php
$db = conectaDb();
$consulta = "select * from paciente";
$result = $db->query($consulta);
?>
<legend>Turnos por paciente</legend>
<form class="form-horizontal" name="form1" action="./paciente/_paciente_imprimir_reporte.php" method="GET" target="_blank">
    <div class="control-group">
        <table id="tabla1" class="table table-striped">
            <thead>
                <tr>
                    <th>Elegir</th>
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
                    if ($cantAux > 0)
                        $porcentaje = ($cant * 100) / $cantAux;
                    else
                        $porcentaje = ($cant * 100) / 1;
                    $porcentaje = round($porcentaje * 100) / 100; //esto es para redondear a 2 decimales

                    $paciente = $valor['nombre'] . ' ' . $valor['apellido'];
                    ?>
                    <tr>
                        <td><input type="checkbox" name="<?php echo $valor['idpaciente'] ?>" value="<?php echo $valor['idpaciente'] ?>" id="<?php echo $valor['idpaciente'] ?>"></td>
                        <td><?php echo $paciente ?></td>
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
