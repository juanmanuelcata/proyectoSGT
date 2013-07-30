<?php
$db = conectaDb();
$consulta = "select * from especialidad";
$result = $db->query($consulta);
?>

<legend>Médicos por Especialidad</legend>
<form class="form-horizontal" name="form1" action="./especialidad/_especialiad_imprimir_reportes.php" method="GET" target="_blank">
    <div class="control-group">
        <table id="tabla1" class="table table-striped">
            <thead>
                <tr>
                    <th>Elegir <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Elegir para impresión" data-content="Oprima sobre cada Reporte para seleccionarlo, o utilice los botones de Marcar o Desmarcar todos.">
                                    <i class="icon-question-sign"></i>
                                </button></th>
                    <th>Especialidad <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Especialidad" data-content="Oprima sobre este campo para ordenar la lista por el nombre de la Especialidad. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                                    <i class="icon-question-sign"></i>
                                </button></th>
                    <th>Cantidad de Médicos <button class="btn btn-mini" onclick="return false;" data-original-title="Campo cantidad de Médicos" data-content="Oprima sobre este campo para ordenar la lista por la cantidad de Médicos que están capacitados en una Especialidad. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                                    <i class="icon-question-sign"></i>
                                </button></th>
                    <th>% de Médicos <button class="btn btn-mini" onclick="return false;" data-original-title="Campo % de Médicos" data-content="Oprima sobre este campo para ordenar la lista por el porcentaje de Médicos que están capacidatos en una Especialidad. El porcentaje de Médicos es sobre el total de Médicos. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                                    <i class="icon-question-sign"></i>
                                </button></th>
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

<legend>Turnos por Especialidad</legend>
<form class="form-horizontal" name="form2" action="./especialidad/_especialiad_imprimir_reportes.php" method="GET" target="_blank">
    <div class="control-group">
        <table id="tabla2" class="table table-striped">
            <thead>
                <tr>
                    <th>Elegir <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Elegir para impresión" data-content="Oprima sobre cada Reporte para seleccionarlo, o utilice los botones de Marcar o Desmarcar todos.">
                                    <i class="icon-question-sign"></i>
                                </button></th>
                    <th>Especialidad <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Especialidad" data-content="Oprima sobre este campo para ordenar la lista por el nombre de la Especialidad. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                                    <i class="icon-question-sign"></i>
                                </button></th>
                    <th>Cantidad de Turnos <button class="btn btn-mini" onclick="return false;" data-original-title="Campo cantidad de Turnos" data-content="Oprima sobre este campo para ordenar la lista por la cantidad de Turnos que están asignados a un Médico que posee una Especialidad. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                                    <i class="icon-question-sign"></i>
                                </button></th>
                    <th>% de Turnos <button class="btn btn-mini" onclick="return false;" data-original-title="Campo % de Turnos" data-content="Oprima sobre este campo para ordenar la lista por el porcentaje de Turnos que están asignados a un Médico que posee una Especialidad. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                                    <i class="icon-question-sign"></i>
                                </button></th>
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
    <button class="btn btn-mini" onclick="return false;" data-original-title="Opciones de marcado" data-content="Oprima 'Marcar todos' para seleccionar todos los Reportes visualizados u oprima 'Desmarcar todos' para desmarcar todos los Médicos que estén visualizados.">
        <i class="icon-question-sign"></i>
    </button>
    <input type="hidden" name="code" value="b"/>
    <button type="submit" class="btn btn-success offset1">Imprimir</button>
    <button class="btn btn-mini" onclick="return false;" data-original-title="Imprimir" data-content="Seleccione los Reportes que desee imprimir haciendo click sobre el campo 'Elegir' de cada uno o utilizando el botón de 'Marcar todos'. Una vez hecho esto oprima el botón 'Imprimir' y se abrirá una nueva ventana con un documento pdf, el cual podrá imprimir utilizando las opciones del navegador que esté usando.">
        <i class="icon-question-sign"></i>
    </button>
    <br><br><br>
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