<?php
$db = conectaDb();
$consulta = "select * from medico";
$result = $db->query($consulta);
?>
<legend>Turnos por Médico</legend>
<label>Fecha inicio</label>
<input class="fecha" type="date" tabindex="1" class="input-large" id="fechaInic" name="fechaInic">
<button class="btn btn-mini" onclick="return false;" data-original-title="Fecha de inicio del intervalo" data-content="Increse la fecha de inicio del intervalo en el que desee ver los reportes, utilizando solo caracteres numéricos. Puede también utilizar la flecha hacia abajo para desplegar el calendario y oprimiendo sobre el día correspondiente al mes y año que esten visualizados. Puede optar por seleccionar un campo de la fecha (dia, mes o año) haciendo click sobre el mismo y con las flechas hacia arriba y abajo escribir la fecha deseada. Puede borrar una fecha con 'x'.">
    <i class="icon-question-sign"></i>
</button>
<br><br>
<label>Fecha fin</label>
<input class="fecha" type="date" tabindex="2" class="input-large" id="fechaFin" name="fechaFin" onkeypress="return justFecha(event);">
<button class="btn btn-mini" onclick="return false;" data-original-title="Fecha de fin del intervalo" data-content="Increse la fecha de fin del intervalo en el que desee ver los reportes, utilizando solo caracteres numéricos. Puede también utilizar la flecha hacia abajo para desplegar el calendario y oprimiendo sobre el día correspondiente al mes y año que esten visualizados. Puede optar por seleccionar un campo de la fecha (dia, mes o año) haciendo click sobre el mismo y con las flechas hacia arriba y abajo escribir la fecha deseada. Puede borrar una fecha con 'x'.">
    <i class="icon-question-sign"></i>
</button>
<br><br>
<form class="form-horizontal" name="form1" action="./medico/_medico_imprimir_reportes.php" method="GET" target="_blank">
    <div class="control-group">
        <div id="manzana">
            <div id="banana">
                <table id="tabla1" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Elegir <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Elegir para impresión" data-content="Oprima sobre cada Reporte para seleccionarlo, o utilice los botones de Marcar o Desmarcar todos.">
                                    <i class="icon-question-sign"></i>
                                </button></th>
                            <th>Médico <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Médico" data-content="Oprima sobre este campo para ordenar la lista por el Nombre y Apellido del Médico. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                                    <i class="icon-question-sign"></i>
                                </button></th>
                            <th>Cantidad de turnos <button class="btn btn-mini" onclick="return false;" data-original-title="Campo cantidad de turnos" data-content="Oprima sobre este campo para ordenar la lista por la cantidad de turnos asignados a cada Médico. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                                    <i class="icon-question-sign"></i>
                                </button></th>
                            <th>% de turnos <button class="btn btn-mini" onclick="return false;" data-original-title="Campo % de turnos" data-content="Oprima sobre este campo para ordenar la lista por el porcentaje de turnos asignados a cada Médico. El porcentaje de turnos es sobre el total global de turnos asignados. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                                    <i class="icon-question-sign"></i>
                                </button></th>
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
                                <td><input type="checkbox" name="<?php echo $valor['idmedico'] ?>" value="<?php echo $valor['idmedico'] ?>" id="<?php echo $valor['idmedico'] ?>"></td>
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
    <a href="javascript:seleccionar_todo1()">Marcar todos</a> |
    <a href="javascript:deseleccionar_todo1()">Desmarcar todos</a>
    <button class="btn btn-mini" onclick="return false;" data-original-title="Opciones de marcado" data-content="Oprima 'Marcar todos' para seleccionar todos los Reportes visualizados u oprima 'Desmarcar todos' para desmarcar todos los Médicos que estén visualizados.">
        <i class="icon-question-sign"></i>
    </button>
    <input type="hidden" name="code" value="1"/>
    <button type="submit" class="btn btn-success offset1">Imprimir</button>
    <button class="btn btn-mini" id='ayuda' onclick="return false;" data-original-title="Imprimir" data-content="Seleccione los Reportes que desee imprimir haciendo click sobre el campo 'Elegir' de cada uno o utilizando el botón de 'Marcar todos'. Una vez hecho esto oprima el botón 'Imprimir' y se abrirá una nueva ventana con un documento pdf, el cual podrá imprimir utilizando las opciones del navegador que esté usando.">
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
<label>Fecha inicio</label>
<input class="fecha1" type="date" tabindex="1" class="input-large" id="fechaInic1" name="fechaInic1">
<button class="btn btn-mini" onclick="return false;" data-original-title="Fecha de inicio del intervalo" data-content="Increse la fecha de inicio del intervalo en el que desee ver los reportes, utilizando solo caracteres numéricos. Puede también utilizar la flecha hacia abajo para desplegar el calendario y oprimiendo sobre el día correspondiente al mes y año que esten visualizados. Puede optar por seleccionar un campo de la fecha (dia, mes o año) haciendo click sobre el mismo y con las flechas hacia arriba y abajo escribir la fecha deseada. Puede borrar una fecha con 'x'.">
    <i class="icon-question-sign"></i>
</button>
<br><br>
<label>Fecha fin</label>
<input class="fecha1" type="date" tabindex="2" class="input-large" id="fechaFin1" name="fechaFin1">
<button class="btn btn-mini" onclick="return false;" data-original-title="Fecha de fin del intervalo" data-content="Increse la fecha de fin del intervalo en el que desee ver los reportes, utilizando solo caracteres numéricos. Puede también utilizar la flecha hacia abajo para desplegar el calendario y oprimiendo sobre el día correspondiente al mes y año que esten visualizados. Puede optar por seleccionar un campo de la fecha (dia, mes o año) haciendo click sobre el mismo y con las flechas hacia arriba y abajo escribir la fecha deseada. Puede borrar una fecha con 'x'.">
    <i class="icon-question-sign"></i>
</button>
<br><br>
<form class="form-horizontal" name="form2" action="./medico/_medico_imprimir_reportes.php" method="GET" target="_blank">
    <div class="control-group">
        <div id="manzana1">
            <div id="banana1">
                <table id="tabla2" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Elegir <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Elegir para impresión" data-content="Oprima sobre cada Reporte para seleccionarlo, o utilice los botones de Marcar o Desmarcar todos.">
                                    <i class="icon-question-sign"></i>
                                </button></th>
                            <th>Médico <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Médico" data-content="Oprima sobre este campo para ordenar la lista por el Nombre y Apellido del Médico. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                                    <i class="icon-question-sign"></i>
                                </button></th>
                            <th>Turnos cancelados <button class="btn btn-mini" onclick="return false;" data-original-title="Campo cantidad de turnos cancelados" data-content="Oprima sobre este campo para ordenar la lista por la cantidad de turnos cancelados de cada Médico. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                                    <i class="icon-question-sign"></i>
                                </button></th>
                            <th>% de turnos <button class="btn btn-mini" onclick="return false;" data-original-title="Campo % de turnos" data-content="Oprima sobre este campo para ordenar la lista por el porcentaje de turnos asignados a cada Médico. El porcentaje de turnos es sobre el total de turnos asignados a cada Médico. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                                    <i class="icon-question-sign"></i>
                                </button></th>
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
                                <td><input type="checkbox" name="<?php echo $valor['idmedico'] ?>" value="<?php echo $valor['idmedico'] ?>" id="<?php echo $valor['idmedico'] ?>"></td>
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
    <a href="javascript:seleccionar_todo2()">Marcar todos</a> | 
    <a href="javascript:deseleccionar_todo2()">Desmarcar todos</a>
    <button class="btn btn-mini" onclick="return false;" data-original-title="Opciones de marcado" data-content="Oprima 'Marcar todos' para seleccionar todos los Reportes visualizados u oprima 'Desmarcar todos' para desmarcar todos los Médicos que estén visualizados.">
        <i class="icon-question-sign"></i>
    </button>
    <input type="hidden" name="code" value="2"/>
    <button type="submit" class="btn btn-success offset1">Imprimir</button>
    <button class="btn btn-mini" id='ayuda' onclick="return false;" data-original-title="Imprimir" data-content="Seleccione los Reportes que desee imprimir haciendo click sobre el campo 'Elegir' de cada uno o utilizando el botón de 'Marcar todos'. Una vez hecho esto oprima el botón 'Imprimir' y se abrirá una nueva ventana con un documento pdf, el cual podrá imprimir utilizando las opciones del navegador que esté usando.">
        <i class="icon-question-sign"></i>
    </button>
</form>

<div><strong>Nota: </strong>el porcentaje de turnos cancelados es sobre el total del turnos del médico</div>
<br><br>
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


<?php
$conhorarios = "select id, nombre, apellido, dia, min(desde) desde, max(hasta) hasta, id_med from horario inner join medico on (horario.id_med = medico.idmedico) group by id_med, dia";
$result = $db->query($conhorarios);
?>

<legend>Medicos por banda horaria</legend>
<label>Horario inicio</label>
<select class="hora" name="horario1" id="horario1" onchange="return verifHorario();">
    <option selected="selected">Elija un horario</option>
    <?php
    for ($i = 8; $i < 20; $i++) {
        echo "<option value=\"$i:00:00\">$i:00</option>";
    }
    ?>
</select>
<br><br>
<label>Horario fin</label>
<select class="hora" name="horario2" id="horario2" onchange="return verifHorario();">
    <option selected="selected">Elija un horario</option>
    <?php
    for ($i = 8; $i < 20; $i++) {
        echo "<option value=\"$i:00:00\">$i:00</option>";
    }
    ?>
</select>
<form class="form-horizontal" name="form3" action="./medico/_medico_imprimir_reportes.php" method="GET" target="_blank">
    <div class="control-group">
        <br><br>
        <div id="manzana2">
            <div id="banana2">
                <table id="tabla3" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Elegir <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Elegir para impresión" data-content="Oprima sobre cada Reporte para seleccionarlo, o utilice los botones de Marcar o Desmarcar todos.">
                                    <i class="icon-question-sign"></i>
                                </button></th>
                            <th>Médico <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Médico" data-content="Oprima sobre este campo para ordenar la lista por el Nombre y Apellido del Médico. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                                    <i class="icon-question-sign"></i>
                                </button></th>
                            <th>Día <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Día" data-content="Oprima sobre este campo para ordenar la lista por el atributo Día de la consulta. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                            <th>Desde <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Desde" data-content="Oprima sobre este campo para ordenar la lista por la hora de inicio de la consulta. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                            <th>Hasta <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Hasta" data-content="Oprima sobre este campo para ordenar la lista por la hora de finalización de la consulta. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($result as $valor): ?> 
                            <?php $medico = $valor['nombre'] . ' ' . $valor['apellido']; ?>
                            <tr>
                                <td><input type="checkbox" name="<?php echo $valor['id'] ?>" value="<?php echo $valor['id'] ?>" id="<?php echo $valor['id'] ?>"></td>
                                <td><?php echo $medico ?></td>
                                <td><?php echo $valor['dia'] ?></td>    
                                <td><?php echo $valor['desde'] ?></td>
                                <td><?php echo $valor['hasta'] ?></td>    
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div
    <br>
    <a href="javascript:seleccionar_todo3()">Marcar todos</a> | 
    <a href="javascript:deseleccionar_todo3()">Desmarcar todos</a>
    <button class="btn btn-mini" onclick="return false;" data-original-title="Opciones de marcado" data-content="Oprima 'Marcar todos' para seleccionar todos los Reportes visualizados u oprima 'Desmarcar todos' para desmarcar todos los Médicos que estén visualizados.">
        <i class="icon-question-sign"></i>
    </button>
    <input type="hidden" name="code" value="3"/>
    <button type="submit" class="btn btn-success offset1">Imprimir</button>
    <button class="btn btn-mini" id='ayuda' onclick="return false;" data-original-title="Imprimir" data-content="Seleccione los Reportes que desee imprimir haciendo click sobre el campo 'Elegir' de cada uno o utilizando el botón de 'Marcar todos'. Una vez hecho esto oprima el botón 'Imprimir' y se abrirá una nueva ventana con un documento pdf, el cual podrá imprimir utilizando las opciones del navegador que esté usando.">
        <i class="icon-question-sign"></i>
    </button>
    <!--los br's son para que se vea el botón de ayuda-->
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

    function verifHorario() {
        var horario1 = $('#horario1').val();
        var horario2 = $('#horario2').val();
        var a = horario1.split(':');   //separa el tring del horario hh:mm:ss por el caracter ":"
        var b = horario2.split(':');//separa el tring del horario hh:mm:ss por el caracter ":"
        var hr1 = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]); //pasa el hroario a segundos
        var hr2 = (+b[0]) * 60 * 60 + (+b[1]) * 60 + (+b[2]); //pasa el hroario a segundos
        if ((hr1 != null) || (hr2 != null)) {
            if (hr2 < hr1) {
                alert('ERROR. intervalos incorrectos');
                return false;
            }
        }
    }

    $().ready(function() {
        $('.hora').change(function() {
            $.ajax({
                url: 'medico/obtener_medicos_por_banda_horaria.php',
                type: 'POST',
                data: {
                    hora1: $('#horario1').val(),
                    hora2: $('#horario2').val()
                },
                success: function(data) {
                    $('#banana2').remove();
                    $('#manzana2').append(data);
                }
            });
        });
    });
</script>