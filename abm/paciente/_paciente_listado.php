<?php
$db = conectaDb();
$consulta = "SELECT idpaciente, paciente.nombre pacnombre, ingreso, nacimiento, dni, apellido, localidad, altura, piso, depto, calle, mail, telefono, idpac_os, idos, os.nombre osnombre, activo from paciente, pac_os, os where paciente.idpaciente = pac_os.id_paciente and pac_os.id_os = os.idos";

$result = $db->query($consulta);
if ($result->rowCount() == 0) {
    print ('<p>No hay pacientes</p>');
}
?>


<legend>Listado de pacientes</legend>
<form class="form-horizontal" name="form" action="./paciente/_paciente_imprimir.php" method="GET" target="_blank">
    <div class="control-group">
        <table id="tabla1" class="table table-striped">
            <thead>
                <tr>
                    <th>Elegir</th>
                    <th>Nuevo Turno</th>
                    <th>Modificar</th>
                    <th>Detalle</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Obra Social</th>
                    <th>DNI</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($result as $valor) {
                    echo '<tr>
                <td><input type="checkbox" name="' . $valor['idpaciente'] . '" value="' . $valor['idpaciente'] . '" id="' . $valor['idpaciente'] . '"></td>
                <td><a href="./turno.php?code=a&id=' . $valor['idpaciente'] . '"><i class="icon-plus"></i></a></td>
                <td><a href="./paciente.php?code=m&id=' . $valor['idpaciente'] . '&os=' . $valor['osnombre'] . '"><i class="icon-cog"></i></a></td>
                <td><a href="./paciente.php?code=d&id=' . $valor['idpaciente'] . '" TARGET="_blank"><i class=" icon-list-alt"></i></a></td>
                <td>' . $valor['pacnombre'] . '</td>
                <td>' . $valor['apellido'] . '</td>';
                    if ($valor['activo'] == 1)
                        echo '<td>' . $valor['osnombre'] . '</td>';
                    else
                        echo '<td><p style="color: #FF0000">' . $valor['osnombre'] . '</p></td>';
                    echo '<td>' . $valor['dni'] . '</td></tr>';
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
</script>