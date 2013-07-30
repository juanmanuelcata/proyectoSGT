<?php
$db = conectaDb();

$idmedico = $_GET['id'];

$consulta = "select * from turno inner join paciente on ( paciente.idpaciente = turno.id_pac) where turno.id_med = '$idmedico' and turno.estado != 'cancelado'";
$aux = $db->query($consulta);
?>


<legend>Listado de Turnos</legend>
<form class="form-horizontal" name="form" action="./medico/_medico_turno_imprimir.php" method="GET" target="_blank">    
    <div class="control-group">
        <table id="tabla1" class="table table-striped">
            <thead>
                <tr>
                    <th>Elegir <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Elegir para impresión" data-content="Oprima sobre cada Turno para seleccionarlo, o utilice los botones de Marcar o Desmarcar todos.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                    <th>Paciente <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Paciente" data-content="Oprima sobre este campo para ordenar la lista por el atributo Paciente (nombre y apellido) al que está asignado el turno. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                    <th>DNI <button class="btn btn-mini" onclick="return false;" data-original-title="Campo DNI" data-content="Oprima sobre este campo para ordenar la lista por el atributo DNI del paciente al que está asignado el turno. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                    <th>Fecha <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Fecha" data-content="Oprima sobre este campo para ordenar la lista por el atributo Fecha del turno. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                    <th>Hora <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Horario" data-content="Oprima sobre este campo para ordenar la lista por el atributo Hora (del inicio) del turno. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($aux as $valor) {
                    $paciente = $valor['nombre'].' '.$valor['apellido'];
                    echo '<tr>
                <td><input type="checkbox" name="' . $valor['idturno'] . '" value="' . $valor['idturno'] . '" id="' . $valor['idturno'] . '"></td>
                <td>' . $paciente . '</td>
                <td>' . $valor['dni'] . '</td>
                <td>' . $valor['fecha'] . '</td>
                <td>' . $valor['hora'] . '</td>  
                </tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
    <br> 
    <a href="javascript:seleccionar_todo()">Marcar todos</a> | 
    <a href="javascript:deseleccionar_todo()">Desmarcar todos</a> 
    <button class="btn btn-mini" id='ayuda' onclick="return false;" data-original-title="Opciones de marcado" data-content="Oprima 'Marcar todos' para seleccionar todos los turnos visualizados u oprima 'Desmarcar todos' para desmarcar todas los turnos que estén visualizados.">
        <i class="icon-question-sign"></i>
    </button>
    <button type="submit" class="btn btn-success offset1">Imprimir</button>
    <button class="btn btn-mini" onclick="return false;" data-original-title="Imprimir" data-content="Seleccione los turnos que desee imprimir haciendo click sobre el campo 'Elegir' de cada uno o utilizando el botón de 'Marcar todos'. Una vez hecho esto oprima el botón 'Imprimir' y se abrirá una nueva ventana con un documento pdf el cual podrá imprimir utilizando las opciones del navegador que esté usando.">
        <i class="icon-question-sign"></i>
    </button>
</form>

<script>
    function seleccionar_todo() {
        for (i = 0; i < document.form.elements.length; i++)
            if (document.form.elements[i].type == "checkbox")
                document.form.elements[i].checked = 1
    }

    function deseleccionar_todo() {
        for (i = 0; i < document.form.elements.length; i++)
            if (document.form.elements[i].type == "checkbox")
                document.form.elements[i].checked = 0
    }

    function abrir(url) {
        open(url, '', 'top=100,left=100,width=800,height=600');
    }

    function verificarLicencia() {
        fecha_actual = new Date();
        // NO HACE FALTA fecha_actual = document.write(fecha_actual.getDate() + "/" + (fecha_actual.getMonth() +1) + "/" + fecha_actual.getFullYear());
        alert(fecha_actual);
    }

</script>
