<?php
$db = conectaDb();

$idmedico = $_GET['id'];

$consulta = "select * from turno inner join paciente on ( paciente.idpaciente = turno.id_pac) where turno.id_med = '$idmedico'";
$aux = $db->query($consulta);
?>


<legend>Listado de Turnos</legend>
<form class="form-horizontal" name="form" action="./medico/_medico_turno_imprimir.php" method="GET" target="_blank">    
    <div class="control-group">
        <table id="tabla1" class="table table-striped">
            <thead>
                <tr>
                    <th>Elegir</th>
                    <th>Paciente</th>
                    <th>DNI</th>
                    <th>Fecha</th>
                    <th>Hora</th>
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
    <button type="submit" class="btn btn-success offset1">Imprimir</button>
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
