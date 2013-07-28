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
                    <th>Elegir <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Elegir" data-content="Oprima sobre cada paciente para seleccionarlo, o utilice los botones de Marcar/Desmarcar todos.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                    <th>DNI <button class="btn btn-mini" onclick="return false;" data-original-title="Campo DNI" data-content="Oprima sobre este campo para ordenar la lista por el atributo DNI. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                    <th>Nombre <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Nombre" data-content="Oprima sobre este campo para ordenar la lista por el atributo Nombre. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                    <th>Apellido <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Apellido" data-content="Oprima sobre este campo para ordenar la lista por el atributo Apellido. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                    <th>Nuevo Turno <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Nuevo Turno" data-content="Oprima sobre el ícono de la cruz correspondiente al paciente al que desee agregar un turno.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                    <th>Modificar <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Modificar" data-content="Oprima sobre el ícono del engranaje correspondiente al paciente para ver y modificar la información del mismo.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                    <th>Detalle <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Detalle" data-content="Oprima sobre el ícono del ojo correspondiente al paciente que desee ver toda la información del mismo. Se abrirá en una pequeña ventana.">
                            <i class="icon-question-sign"></i>
                        </button></th>
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
        <button class="btn btn-mini" id='ayuda' onclick="return false;" data-original-title="Opciones de marcado" data-content="Oprima 'Marcar todos' para seleccionar todos los pacientes visualizados u oprima 'Desmarcar todos' para desmarcar todos los pacientes que estén visualizados.">
        <i class="icon-question-sign"></i>
    </button>
    <button type="submit" class="btn btn-success offset1">Imprimir</button>
    <button class="btn btn-mini" onclick="return false;" data-original-title="Imprimir" data-content="Seleccione los pacientes que desee imprimir haciendo click sobre el campo 'Elegir' de cada uno o utilizando el botón de 'Marcar todos'. Una vez hecho esto oprima el botón 'Imprimir' y se abrirá una nueva ventana con un documento pdf el cual podrá imprimir utilizando las opciones del navegador que esté usando.">
        <i class="icon-question-sign"></i>
    </button>
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