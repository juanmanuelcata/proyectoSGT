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
                    <th>Elegir <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Elegir para impresión" data-content="Oprima sobre cada Paciente para seleccionarlo, o utilice los botones de Marcar/Desmarcar todos.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                    <th>Paciente <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Paciente" data-content="Oprima sobre este campo para ordenar la lista por el atributo Nombre y Apellido de cada Paciente. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                    <th>Cantidad de Turnos <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Cantidad de Turnos" data-content="Oprima sobre este campo para ordenar la lista por la cantidad de Turnos que le fueron asignados a cada Paciente. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                    <th>% de Turnos <button class="btn btn-mini" onclick="return false;" data-original-title="Campo % de Turnos" data-content="Oprima sobre este campo para ordenar la lista por el porcentaje de Turnos que le fueron asignados a cada Paciente (sobre el total de Turnos asignados). Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                            <i class="icon-question-sign"></i>
                        </button></th>
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
    <button class="btn btn-mini" onclick="return false;" data-original-title="Opciones de marcado" data-content="Oprima 'Marcar todos' para seleccionar todos los Pacientes visualizados u oprima 'Desmarcar todos' para desmarcar todos los pacientes que estén visualizados.">
        <i class="icon-question-sign"></i>
    </button>
    <input type="hidden" name="code" value="a"/>
    <button type="submit" class="btn btn-success offset1">Imprimir</button>
    <button class="btn btn-mini" onclick="return false;" data-original-title="Imprimir" data-content="Seleccione los Pacientes que desee imprimir haciendo click sobre el campo 'Elegir' de cada uno o utilizando el botón de 'Marcar todos'. Una vez hecho esto oprima el botón 'Imprimir' y se abrirá una nueva ventana con un documento pdf, el cual podrá imprimir utilizando las opciones del navegador que esté usando.">
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
