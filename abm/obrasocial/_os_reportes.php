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
                    <th>Elegir <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Elegir para impresión" data-content="Oprima sobre cada Reporte para seleccionarlo, o utilice los botones de Marcar o Desmarcar todos.">
                                    <i class="icon-question-sign"></i>
                                </button></th>
                    <th>Obra Social <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Obra Social" data-content="Oprima sobre este campo para ordenar la lista por el nombre de la Obra Social. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                                    <i class="icon-question-sign"></i>
                                </button></th>
                    <th>Cantidad de Pacientes <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Cantidad de Pacientes" data-content="Oprima sobre este campo para ordenar la lista por la cantidad de Pacientes que están afiliados a la cada Obra Social. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                                    <i class="icon-question-sign"></i>
                                </button></th>
                    <th>% de Pacientes <button class="btn btn-mini" onclick="return false;" data-original-title="Campo % de Pacientes" data-content="Oprima sobre este campo para ordenar la lista por el porcentaje de Pacientes que están afiliados a la cada Obra Social. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                                    <i class="icon-question-sign"></i>
                                </button</th>
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
    <button class="btn btn-mini" onclick="return false;" data-original-title="Opciones de marcado" data-content="Oprima 'Marcar todos' para seleccionar todos los Reportes visualizados u oprima 'Desmarcar todos' para desmarcar todos los Médicos que estén visualizados.">
        <i class="icon-question-sign"></i>
    </button>
    <input type="hidden" name="code" value="a"/>
    <button type="submit" class="btn btn-success offset1">Imprimir</button>
    <button class="btn btn-mini" onclick="return false;" data-original-title="Imprimir" data-content="Seleccione los Reportes que desee imprimir haciendo click sobre el campo 'Elegir' de cada uno o utilizando el botón de 'Marcar todos'. Una vez hecho esto oprima el botón 'Imprimir' y se abrirá una nueva ventana con un documento pdf, el cual podrá imprimir utilizando las opciones del navegador que esté usando.">
        <i class="icon-question-sign"></i>
    </button>
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
                    <th>Elegir <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Elegir para impresión" data-content="Oprima sobre cada Reporte para seleccionarlo, o utilice los botones de Marcar o Desmarcar todos.">
                                    <i class="icon-question-sign"></i>
                                </button></th>
                    <th>Obra Social <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Obra Social" data-content="Oprima sobre este campo para ordenar la lista por el nombre de la Obra Social, teniendo en cuenta que un Médico puede atender por más de una Obra Social. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                                    <i class="icon-question-sign"></i>
                                </button></th>
                    <th>Cantidad de Médicos <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Cantidad de Médicos" data-content="Oprima sobre este campo para ordenar la lista por la cantidad de Médicos que atienden por una Obra Social, teniendo en cuenta que un Médico puede atender por más de una Obra Social. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                                    <i class="icon-question-sign"></i>
                                </button></th>
                    <th>% de Médicos <button class="btn btn-mini" onclick="return false;" data-original-title="Campo % de Médicos" data-content="Oprima sobre este campo para ordenar la lista por el porcentaje de Médicos que atienden por una Obra Social, teniendo en cuenta que un Médico puede atender por más de una Obra Social. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                                    <i class="icon-question-sign"></i>
                                </button></th>
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
    <button class="btn btn-mini" onclick="return false;" data-original-title="Opciones de marcado" data-content="Oprima 'Marcar todos' para seleccionar todos los Reportes visualizados u oprima 'Desmarcar todos' para desmarcar todos los Médicos que estén visualizados.">
        <i class="icon-question-sign"></i>
    </button>
    <input type="hidden" name="code" value="b"/>
    <button type="submit" class="btn btn-success offset1">Imprimir</button>
    <button class="btn btn-mini" onclick="return false;" data-original-title="Imprimir" data-content="Seleccione los Reportes que desee imprimir haciendo click sobre el campo 'Elegir' de cada uno o utilizando el botón de 'Marcar todos'. Una vez hecho esto oprima el botón 'Imprimir' y se abrirá una nueva ventana con un documento pdf, el cual podrá imprimir utilizando las opciones del navegador que esté usando.">
        <i class="icon-question-sign"></i>
    </button>
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
                    <th>Elegir <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Elegir para impresión" data-content="Oprima sobre cada Reporte para seleccionarlo, o utilice los botones de Marcar o Desmarcar todos.">
                                    <i class="icon-question-sign"></i>
                                </button></th>
                    <th>Obra Social <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Obra Social" data-content="Oprima sobre este campo para ordenar la lista por el nombre de la Obra Social. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                                    <i class="icon-question-sign"></i>
                                </button></th>
                    <th>Cantidad de Turnos <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Cantidad de Turnos" data-content="Oprima sobre este campo para ordenar la lista por la cantidad de Turnos que están asignados a un Médico que trabaja para una Obra Social, teniendo en cuenta que un Médico puede atender por más de una Obra Social. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                                    <i class="icon-question-sign"></i>
                                </button></th>
                    <th>% de Turnos <button class="btn btn-mini" onclick="return false;" data-original-title="Campo % de Turnos" data-content="Oprima sobre este campo para ordenar la lista por el porcentaje de Turnos que están asignados a un Médico que trabaja para una Obra Social, teniendo en cuenta que un Médico puede atender por más de una Obra Social. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                                    <i class="icon-question-sign"></i>
                                </button></th>
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
    <button class="btn btn-mini" onclick="return false;" data-original-title="Opciones de marcado" data-content="Oprima 'Marcar todos' para seleccionar todos los Reportes visualizados u oprima 'Desmarcar todos' para desmarcar todos los Médicos que estén visualizados.">
        <i class="icon-question-sign"></i>
    </button>
    <input type="hidden" name="code" value="c"/>
    <button type="submit" class="btn btn-success offset1">Imprimir</button>
    <button class="btn btn-mini" onclick="return false;" data-original-title="Imprimir" data-content="Seleccione los Reportes que desee imprimir haciendo click sobre el campo 'Elegir' de cada uno o utilizando el botón de 'Marcar todos'. Una vez hecho esto oprima el botón 'Imprimir' y se abrirá una nueva ventana con un documento pdf, el cual podrá imprimir utilizando las opciones del navegador que esté usando.">
        <i class="icon-question-sign"></i>
    </button>
    <br><br><br>
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