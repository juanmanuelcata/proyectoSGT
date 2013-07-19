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
                      $direccion = "'./medico.php?code=d&id=" . $valor["idmedico"] . "'";
                    echo '<tr>
                <td><input type="checkbox" name="' . $valor['idmedico'] . '" value="' . $valor['idmedico'] . '" id="' . $valor['idmedico'] . '"></td>
                <td>' . $valor['nombre'] . '</td>
                <td>' . $valor['apellido'] . '</td>
                <td><a href="./medico.php?code=m&id=' . $valor['idmedico'] . '"><i class="icon-cog"></i></a></td>
                <td><a href="./medico.php?code=li&id=' . $valor['idmedico'] . '"><i class="icon-plane"></i></a></td>    
                <td><a href="javascript:abrir('. $direccion. ')"><i class=" icon-eye-open"></i></a></td>
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

<button class="btn btn-danger" onclick="javascript:verificarLicencia();">Fecha Actual!!!</button> 

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
        open(url,'','top=300,left=300,width=800,height=600') ; 
    } 
    
    function verificarLicencia(){
    fecha_actual = new Date('2013-07-31');
    // NO HACE FALTA fecha_actual = document.write(fecha_actual.getDate() + "/" + (fecha_actual.getMonth() +1) + "/" + fecha_actual.getFullYear());
    alert(fecha_actual);
}
    
</script>