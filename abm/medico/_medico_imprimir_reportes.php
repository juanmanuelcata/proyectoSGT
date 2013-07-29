 <script>console.log('llego1');</script> 

<?php

// Prueba de impresion
require('../../Imprimir/fpdf/fpdf.php');

class PDF extends FPDF {

    //Tabla simple
    function BasicTable($header, $data) {
        // Cabecera
        $this->SetFont('Arial', 'B', 10);
        foreach ($header as $col)
            $this->Cell(35, 8, utf8_decode($col), 1);
        $this->Ln();
        //    Datos
        $this->SetFont('Arial', '', 10);
        foreach ($data as $row) {
            foreach ($row as $col)
                $this->Cell(35, 8, utf8_decode($col), 1);
            $this->Ln();
        }
    }

}

if ($_GET['code']== 1) {
    
   ?> <script>console.log('llego2');</script> <?php 
    $header = array('Medico', 'Cantidad de turnos', '% de turnos');
    $pdf = new PDF();
    $pdf->AddPage();


    include_once './../../fragmentos/_conectDb.php';
    $db = conectaDb();
    $c1 = 0;
    
    foreach ($_GET as $n) {
        $consulta = "select * from medico where idmedico = '" . $n ."'";
    $result = $db->query($consulta);
    $valor = $result->fetch(PDO::FETCH_ASSOC);
        if ($c1 >= 0) {
            $c2 = 0;

            $con = 'select * from medico inner join turno on (medico.idmedico = turno.id_med) where medico.idmedico = ' . $n . '';
            $result2 = $db->query($con);
            $cant = $result2->rowCount();

            $conAux = 'select * from turno';
            $resultAux = $db->query($conAux);
            $cantAux = $resultAux->rowCount();
            if ($cantAux > 0)
                $porcentaje = ($cant * 100) / $cantAux;
            else
                $porcentaje = ($cant * 100) / 1;
            $porcentaje = round($porcentaje * 100) / 100; //esto es para redondear a 2 decimales

            $medico = $valor['nombre'] . ' ' . $valor['apellido'];

            $matriz[$c1][$c2] = $medico;
            $c2++;
            $matriz[$c1][$c2] = $cant;
            $c2++;
            $matriz[$c1][$c2] = $porcentaje;
        }
        $c1++;
    }
} elseif ($_GET['code'] == '2') {
    
} elseif ($_GET['code'] == '3') {
    
}


$pdf->SetFont('Arial', 'B', 15);
$pdf->Cell(40, 8, utf8_decode('Turnos por médico'), 0);
$pdf->Ln(20);
$pdf->BasicTable($header, $matriz);
$pdf->Output();
?>
