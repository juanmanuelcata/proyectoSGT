<?php
$db = conectaDb();
$consulta = "select * from os";
$result = $db->query($consulta);
?>

<legend>Pacientes por obra social</legend>
<form class="form-horizontal" name="form1" action="./obrasocial/_os_imprimir_reportes.php" method="GET" target="_blank">
    <div class="control-group">
        <table id="tabla1" class="table table-striped">
            <thead>
                <tr>
                    <th>Elegir</th>
                    <th>Obra Social</th>
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
                        <td><input type="checkbox" name="<?php echo $valor['idos'] ?>" value="<?php echo $valor['idos'] ?>" id="<?php echo $valor['idos'] ?>"></td>
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

<legend>Médicos por obra social</legend>
<form class="form-horizontal" name="form2" action="./obrasocial/_os_imprimir_reportes.php" method="GET" target="_blank">
    <div class="control-group">
        <table id="tabla2" class="table table-striped">
            <thead>
                <tr>
                    <th>Elegir</th>
                    <th>Obra Social</th>
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
                        <td><input type="checkbox" name="<?php echo $valor['idos'] ?>" value="<?php echo $valor['idos'] ?>" id="<?php echo $valor['idos'] ?>"></td>
                        <td><?php echo $valor['nombre'] ?></td>
                        <td><?php echo $cant ?></td>
                        <td><?php echo $porcentaje ?></td>
                    </tr>

                <?php endforeach; ?>

            </tbody>    
        </table>
    </div>
    <a href="javascript:seleccionar_todo2()">Marcar todos</a> | 
    <a href="javascript:deseleccionar_todo2()">Desmarcar todos</a> 
    <input type="hidden" name="code" value="b"/>
    <button type="submit" class="btn btn-success offset1">Imprimir</button>
</form>
<p><strong>Nota: </strong> un medico puede atender por mas de una obra social</p>


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


<br>

<?php
$result = $db->query($consulta);
?>

<legend>Turnos por obra social</legend>
<form class="form-horizontal" name="form3" action="./obrasocial/_os_imprimir_reportes.php" method="GET" target="_blank">
    <div class="control-group">
        <table id="tabla3" class="table table-striped">
            <thead>
                <tr>
                    <th>Elegir</th>
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
                        <td><input type="checkbox" name="<?php echo $valor['idos'] ?>" value="<?php echo $valor['idos'] ?>" id="<?php echo $valor['idos'] ?>"></td>
                        <td><?php echo $valor['nombre'] ?></td>
                        <td><?php echo $cant ?></td>
                        <td><?php echo $porcentaje ?></td>
                    </tr>

                <?php endforeach; ?>

            </tbody>    
        </table>
    </div>
    <br>
    <a href="javascript:seleccionar_todo3()">Marcar todos</a> | 
    <a href="javascript:deseleccionar_todo3()">Desmarcar todos</a> 
    <input type="hidden" name="code" value="c"/>
    <button type="submit" class="btn btn-success offset1">Imprimir</button>
</form>


<script>
    function seleccionar_todo3() {
        for (i = 0; i < document.form3.elements.length; i++)
            if (document.form3.elements[i].type == "checkbox")
                document.form3.elements[i].checked = 1
    }

    function deseleccionar_todo3() {
        for (i = 0; i < document.form3.elements.length; i++)
            if (document.form3.elements[i].type == "checkbox")
                document.form3.elements[i].checked = 0
    }

</script>