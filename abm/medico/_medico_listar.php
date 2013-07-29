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
                    <th>Elegir <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Elegir" data-content="Oprima sobre cada médico para seleccionarlo, o utilice los botones de Marcar o Desmarcar todos.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                    <th>Nombre <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Nombre" data-content="Oprima sobre este campo para ordenar la lista por el atributo Nombre. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                    <th>Apellido <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Apellido" data-content="Oprima sobre este campo para ordenar la lista por el atributo Apellido. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                    <th>Modificar <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Modificar" data-content="Oprima sobre el ícono del engranaje correspondiente al médico que desee modificar. Se abrirá en una pequeña ventana.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                    <th>Licencias <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Licencias" data-content="Oprima sobre el ícono del avión correspondiente al médico que desee ver y/o modificar la lista de licencias. Se abrirá en una pequeña ventana.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                    <th>Turnos <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Turnos" data-content="Oprima sobre el ícono del papel correspondiente al médico que desee ver y/o modificar la lista de turnos asignados al mismo.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                    <th>Detalle <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Detalle" data-content="Oprima sobre el ícono del ojo correspondiente al médico que desee ver y/o modificar toda la información del mismo. Se abrirá en una pequeña ventana.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $valor) : ?>
                    <?php $direccion = "'./medico/_ver_detalle.php?id=" . $valor["idmedico"] . "'";
                    $direccion2 = "'./medico/_medico_licencia.php?code=li&id=" . $valor['idmedico'] . "'";
                    ?>
                    <tr>
                        <td><input type="checkbox" name="' . $valor['idmedico'] . '" value="' . $valor['idmedico'] . '" id="' . $valor['idmedico'] . '"></td>
                        <td><?php echo $valor['nombre'] ?></td>
                        <td><?php echo $valor['apellido'] ?></td>
                        <td><a href="./medico.php?code=m&id=<?php echo $valor['idmedico'] ?>"><i class="icon-cog"></i></a></td>
                        <td><a href="javascript:abrir(<?php echo $direccion2 ?>)"><i class="icon-plane"></i></a></td>
                        <td><a href="./medico.php?code=tli&id=<?php echo $valor['idmedico'] ?>"><i class="icon-file"</i></a></td>
                        <td><a href="javascript:abrir(<?php echo $direccion ?>)"><i class=" icon-eye-open"></i></a></td>
                    </tr>
<?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <br> 
    <a href="javascript:seleccionar_todo()">Marcar todos</a> | 
    <a href="javascript:deseleccionar_todo()">Desmarcar todos</a>
    <button class="btn btn-mini" onclick="return false;" data-original-title="Opciones de marcado" data-content="Oprima 'Marcar todos' para seleccionar todos los médicos visualizados u oprima 'Desmarcar todos' para desmarcar todos los médicos que estén visualizados.">
        <i class="icon-question-sign"></i>
    </button>
    <button type="submit" class="btn btn-success offset1">Imprimir</button>
    <button class="btn btn-mini" id='ayuda' onclick="return false;" data-original-title="Imprimir" data-content="Seleccione los médicos que desee imprimir haciendo click sobre el campo 'Elegir' de cada uno o utilizando el botón de 'Marcar todos'. Una vez hecho esto oprima el botón 'Imprimir' y se abrirá una nueva ventana con un documento pdf el cual podrá imprimir utilizando las opciones del navegador que esté usando.">
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
