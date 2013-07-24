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
                    <th>DNI</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Nuevo Turno</th>
                    <th>Modificar</th>
                    <th>Detalle</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $valor): ?>         
               <tr>
                <td><input type="checkbox" name="<?php echo $valor['idpaciente'] ?>" value="<?php echo $valor['idpaciente'] ?>" id="<?php echo $valor['idpaciente'] ?>"></td>
                <td><?php echo $valor['dni'] ?></td>
                <td><?php echo $valor['pacnombre'] ?></td>
                <td><?php echo $valor['apellido'] ?></td>
                <td><a href="./turno.php?code=a&id=<?php echo $valor['idpaciente'] ?>"><i class="icon-plus"></i></a></td>
                <td><a href="./paciente.php?code=m&id=<?php echo $valor['idpaciente'] ?>&os=<?php echo $valor['osnombre'] ?>"><i class="icon-cog"></i></a></td>
                <td><a href="javascript:abrir('./paciente/_ver_detalle.php?id=<?php echo $valor['idpaciente']?>&os=<?php echo $valor['osnombre']?>')"><i class=" icon-eye-open"></i></a></td> 
                </tr>
                
                <?php endforeach;?>
                
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
                document.form.elements[i].checked = 1;
    }

    function deseleccionar_todo() {
        for (i = 0; i < document.form.elements.length; i++)
            if (document.form.elements[i].type == "checkbox")
                document.form.elements[i].checked = 0;
    }
        function abrir(url) {
        open(url, '', 'top=100,left=100,width=800,height=600');
    }
</script>