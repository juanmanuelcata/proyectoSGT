<?php
include_once('../../sesion/login.php');
include_once './../../fragmentos/_conectDb.php';
$db = conectaDb();

$consulta = "select * from medico";
$result = $db->query($consulta);


$fechaInic = $_POST['fechaInic'];
$fechaFin = $_POST['fechaFin'];
?>
<div id="banana1">
    <table id="tabla2" class="table table-striped">
        <thead>
            <tr>
                <th>Médico</th>
                <th>Turnos cancelados</th>
                <th>% de turnos</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($result as $valor): ?>
                <?php
                if ($fechaFin == NULL) {
                    $con = "SELECT * 
                        FROM medico
                       INNER JOIN turno ON ( medico.idmedico = turno.id_med ) 
                       WHERE idmedico =  '" . $valor['idmedico'] . "'
                        AND fecha >=  '" . $fechaInic . "' and estado = 'cancelado' ";
                } elseif ($fechaInic == NULL) {
                    $con = "SELECT * 
                        FROM medico
                       INNER JOIN turno ON ( medico.idmedico = turno.id_med ) 
                       WHERE idmedico =  '" . $valor['idmedico'] . "'
                        AND fecha <=  '" . $fechaFin . "' and estado = 'cancelado' ";
                } else {
                    $con = "SELECT * 
                        FROM medico
                       INNER JOIN turno ON ( medico.idmedico = turno.id_med ) 
                       WHERE idmedico =  '" . $valor['idmedico'] . "'
                        AND fecha >=  '" . $fechaInic . "' AND fecha <= '" . $fechaFin . "' and estado = 'cancelado' ";
                }
                $result2 = $db->query($con);
                $cant = $result2->rowCount();

                if ($fechaFin == NULL) {
                    $conAux = "SELECT * 
                        FROM medico
                       INNER JOIN turno ON ( medico.idmedico = turno.id_med ) 
                       WHERE idmedico =  '" . $valor['idmedico'] . "'
                        AND fecha >=  '" . $fechaInic . "'";
                } elseif ($fechaInic == NULL) {
                    $conAux = "SELECT * 
                        FROM medico
                       INNER JOIN turno ON ( medico.idmedico = turno.id_med ) 
                       WHERE idmedico =  '" . $valor['idmedico'] . "'
                        AND fecha <=  '" . $fechaFin . "'";
                } else {
                    $conAux = "SELECT * 
                        FROM medico
                       INNER JOIN turno ON ( medico.idmedico = turno.id_med ) 
                       WHERE idmedico =  '" . $valor['idmedico'] . "'
    AND fecha >=  '" . $fechaInic . "' AND fecha <= '" . $fechaFin . "'";
                }
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
                    <td><?php echo $medico ?></td>
                    <td><?php echo $cant ?></td>
                    <td><?php echo $porcentaje ?></td>
                </tr>

<?php endforeach; ?>



        </tbody>    
    </table>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#tabla2').dataTable({
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