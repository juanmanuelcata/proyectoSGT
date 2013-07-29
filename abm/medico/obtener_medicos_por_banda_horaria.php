<?php
include_once('../../sesion/login.php');
include_once './../../fragmentos/_conectDb.php';
$db = conectaDb();

$consulta = "select * from medico";
$result2 = $db->query($consulta);


$hora1 = $_POST['hora1'];
$hora2 = $_POST['hora2'];
?>
<div id="banana2">
    <table id="tabla3" class="table table-striped">
        <thead>
            <tr>
                <th>Médico</th>
                <th>día</th>
                <th>Desde</th>
                <th>Hasta</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ((($hora1 != NULL) && ($hora1 != 'Elija un horario')) && (($hora2 != NULL) && ($hora2 != 'Elija un horario'))) {
                $conhorarios = "select nombre, apellido, dia, min(desde) desde, max(hasta) hasta, id_med from horario inner join medico on (horario.id_med = medico.idmedico)
                        where desde >= '$hora1' and hasta <= '$hora2' group by id_med, dia";
                $result2 = $db->query($conhorarios);
            } else {
                $conhorarios = "select nombre, apellido, dia, min(desde) desde, max(hasta) hasta, id_med from horario inner join medico on (horario.id_med = medico.idmedico) group by id_med, dia";
                $result2 = $db->query($conhorarios);
            }
            foreach ($result2 as $valor2) {

                $medico = $valor2['nombre'] . ' ' . $valor2['apellido'];
                echo '<tr>
                                        <td>' . $medico . '</td>
                                        <td>' . $valor2['dia'] . '</td>    
                                        <td>' . $valor2['desde'] . '</td>
                                        <td>' . $valor2['hasta'] . '</td>    
                </tr>';
            }
            ?>
        </tbody>
    </table>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#tabla3').dataTable({
            "sScrollY": 200,
            "bScrollCollapse": true,
            "sScrollX": "100%",
            "sScrollXInner": "110%",
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "oLanguage": {
                "sLengthMenu": 'Display <select>' +
                        '<option value="10">10</option>' +
                        '<option value="20">20</option>' +
                        '<option value="30">30</option>' +
                        '<option value="40">40</option>' +
                        '<option value="50">50</option>' +
                        '<option value="-1">Todo</option>' +
                        '</select> records'
            }
        });
    });
</script>