<?php
include_once('../sesion/login.php');
?>
<!DOCTYPE html>

<html>
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
    <script type="text/javascript">

        $(document).ready(function() {
            $('.table').dataTable({
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
</head>
<body>      
    <div class="row-fluid">
        <div class="span12" id="cabecera2">
            <img SRC="./../img/imagenSuper.png" id="cabe1">
        </div>
    </div>    
    <div class="row-fluid">
        <div class="span12">
            <div class="row-fluid">
                <div class="span2">
                    <?php include_once './../fragmentos/_menu.php'; ?>
                </div>
                <div class="span9">
                    <?php
                    if (isset($_GET['code'])) {
                        include_once './../fragmentos/_conectDb.php';
                        if ($_GET['code'] == 'a')
                            include_once('./especialidad/_especialidad_alta.php');
                        else
                        if ($_GET['code'] == 'r')
                            include_once('./especialidad/_especialidad_reportes.php');
                        else
                        if ($_GET['code'] == 'b')
                            include_once('./especialidad/_especialidad_baja.php');
                        else
                        if ($_GET['code'] == 'l')
                            include_once('./especialidad/_especialidad_listar.php');
                        else
                            include_once('./especialidad/_especialidad_modificar.php');
                    }
                    ?>
                </div> 
            </div>
        </div>
    </div>
    <script>
        //            ESTA ES LA LIÑITA MAGICA
        $(".btn").popover({trigger: "hover"});
    </script>
</body>
</html>

