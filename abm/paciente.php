<?php
include_once('../sesion/login.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>SGT2</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="Sudo Soft" content="">
        <link href="./../css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="./../datatables/css/bootstrap.css" rel="stylesheet">
        <link href="./../datatables/css/jquery.dataTables_themeroller.css" rel="stylesheet">
        <link href="./../css/propio.css" rel="stylesheet" media="screen">
        <link rel="stylesheet" type="text/css" href="./../css/menu.css" />
        <link rel="shortcut icon" href="./../img/favicon.ico" type="image/x-icon"/> 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />   

        <script type="text/javascript" src="./../js/validacion.js"></script>
        <script type="text/javascript" src="./../datatables/js/jquery.js"></script>
        <script type="text/javascript" src="./../datatables/js/jquery.dataTables.js"></script>   
        <script type="text/javascript" src="./../js/bootstrap-alert.js"></script>

        <script type="text/javascript" src="./../js/bootstrap-tooltip.js"></script>
        <script type="text/javascript" src="./../js/bootstrap-popover.js"></script>

    </head>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.table').dataTable({
                "sScrollY": 200,
                "bJQueryUI": true,
                "sScrollX": "100%",
                "sScrollXInner": "110%",
                "sPaginationType": "full_numbers",
                "oLanguage": {
                    "sLengthMenu": 'Mostrar de a <select>' +
                            '<option value="10">10</option>' +
                            '<option value="20">20</option>' +
                            '<option value="30">30</option>' +
                            '<option value="40">40</option>' +
                            '<option value="50">50</option>' +
                            '<option value="-1">Todo</option>' +
                            '</select> filas'
                }
            });
        });
    </script>
    <body>

        <div class="row-fluid">
            <div class="span12">
                <img SRC="./../img/imagenSuper.png" id="cabe1">
            </div>
        </div>        
        <div class="row-fluid">
            <div class="span12">
                <div class="row-fluid">
                    <div class="span2">
                        <?php include_once '../fragmentos/_menu.php'; ?>
                    </div>
                    <div class="span9">
                        <?php
                        if (isset($_GET['code'])) {
                            include_once './../fragmentos/_conectDb.php';
                            if ($_GET['code'] == 'a') {
                                include_once('./paciente/_paciente_alta.php');
                            } else {
                                if ($_GET['code'] == 'l') {
                                    include_once('./paciente/_paciente_listado.php');
                                } else {
                                    if ($_GET['code'] == 'm') {
                                        include_once('./paciente/_paciente_modificar.php');
                                    } else {
                                        if ($_GET['code'] == 'r') {
                                            include_once('./paciente/_paciente_reportes.php');
                                        }
                                    }
                                }
                            }
                        }
                                ?>
                    </div>                
                </div>
                <br><br><br>
            </div>
        </div>
        <script>
            //            ESTA ES LA LIÑITA MAGICA
            $(".btn").popover({trigger: "hover"});
        </script>
    </body>
</html>