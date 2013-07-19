<?php
$db = conectaDb();
$consulta = "SELECT * from medico";
$result = $db->query($consulta);
?>


<legend>Listado de Médicos</legend>
<form class="form-horizontal" name="form" action="./medico/_medico_imprimir.php" method="GET" target="_blank">    
    <div class="control-group">
        <table id="tabla1" class="table table-striped">
            <thead>
                <tr>
                    <th>elegir</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Modificar</th>
                    <th>Licencias</th>
                    <th>Detalle</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($result as $valor) {
                    echo '<tr>
                <td><input type="checkbox" name="' . $valor['idmedico'] . '" value="' . $valor['idmedico'] . '" id="' . $valor['idmedico'] . '"></td>
                <td>' . $valor['nombre'] . '</td>
                <td>' . $valor['apellido'] . '</td>
                <td><a href="./medico.php?code=m&id=' . $valor['idmedico'] . '"><i class="icon-cog"></i></a></td>
                <td><a href="./medico.php?code=li&id=' . $valor['idmedico'] . '"><i class="icon-plane"></i></a></td>    
                <td><a href="./medico.php?code=d&id=' . $valor['idmedico'] . '" TARGET="_blank"><i class=" icon-eye-open"></i></a></td>
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
</script>