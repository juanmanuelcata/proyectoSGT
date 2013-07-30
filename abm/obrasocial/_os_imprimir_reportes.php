<?php

require('../../Imprimir/fpdf/fpdf.php');

include_once './../../fragmentos/_conectDb.php';
$db = conectaDb();

class PDF extends FPDF {

    //Tabla simple
    function BasicTable($header, $data) {
        // Cabecera
        $this->SetFont('Arial', 'B', 10);
        foreach ($header as $col)
            $this->Cell(50, 8, utf8_decode($col), 1);
        $this->Ln();
        //    Datos
        $this->SetFont('Arial', '', 10);
        foreach ($data as $row) {
            foreach ($row as $col)
                $this->Cell(50, 8, utf8_decode($col), 1);
            $this->Ln();
        }
    }

}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 15);

if ($_GET['code'] == 'a') {
    $c1 = 0;
    $pdf->Cell(50, 8, utf8_decode('Pacientes por obra social'), 0);
    $header = array('Obra social', 'Cantidad de pacientes', '% de pacientes');
    foreach ($_GET as $n) {
        $c2 = 0;
        $consulta = "select nombre from os where idos = '" . $n . "'";
        $result = $db->query($consulta);
        if ($result->rowCount() > 0) {
            $res = $result->fetch(PDO::FETCH_ASSOC);

            $con = 'select * from os inner join pac_os on (os.idos = pac_os.id_os) where idos = ' . $n . '';
            $result2 = $db->query($con);
            $cant = $result2->rowCount();

            $conAux = 'select * from paciente';
            $resultAux = $db->query($conAux);
            $cantAux = $resultAux->rowCount();
            if ($cantAux > 0)
                $porcentaje = ($cant * 100) / $cantAux;
            else
                $porcentaje = ($cant * 100) / 1;

            $porcentaje = round($porcentaje * 100) / 100;

            $matriz[$c1][$c2] = $res['nombre'];
            $c2++;
            $matriz[$c1][$c2] = $cant;
            $c2++;
            $matriz[$c1][$c2] = $porcentaje;
        }
        $c1++;
    }
} elseif ($_GET['code'] == 'b') {
    $c1 = 0;
    $pdf->Cell(50, 8, utf8_decode('Médicos por obra social'), 0);
    $header = array('Obra social', 'Cantidad de médicos', '% de médicos');
    foreach ($_GET as $n) {
        $c2 = 0;
        $consulta = "select nombre from os where idos = '" . $n . "'";
        $result = $db->query($consulta);
        if ($result->rowCount() > 0) {
            $res = $result->fetch(PDO::FETCH_ASSOC);

            $con = 'select * from os inner join med_os on (os.idos = med_os.id_os) where idos = ' . $n . '';
            $result2 = $db->query($con);
            $cant = $result2->rowCount();

            $conAux = 'select * from medico';
            $resultAux = $db->query($conAux);
            $cantAux = $resultAux->rowCount();
            if ($cantAux > 0)
                $porcentaje = ($cant * 100) / $cantAux;
            else
                $porcentaje = ($cant * 100) / 1;
            $porcentaje = round($porcentaje * 100) / 100;

            $matriz[$c1][$c2] = $res['nombre'];
            $c2++;
            $matriz[$c1][$c2] = $cant;
            $c2++;
            $matriz[$c1][$c2] = $porcentaje;
        }
        $c1++;
    }
} elseif ($_GET['code'] == 'c') {
    $c1 = 0;
    $pdf->Cell(50, 8, utf8_decode('Turnos por obra social'), 0);
    $header = array('Obra social', 'Cantidad de turnos', '% de turnos');
    foreach ($_GET as $n) {
        $c2 = 0;
        $consulta = "select nombre from os where idos = '" . $n . "'";
        $result = $db->query($consulta);
        if ($result->rowCount() > 0) {
            $res = $result->fetch(PDO::FETCH_ASSOC);

            $con = 'select * from os inner join turno on (os.idos = turno.id_os) where idos = ' . $n . '';
                    $result2 = $db->query($con);
                    $cant = $result2->rowCount();

                    $conAux = 'select * from turno';
                    $resultAux = $db->query($conAux);
                    $cantAux = $resultAux->rowCount();
                    if ($cantAux > 0)
                        $porcentaje = ($cant * 100) / $cantAux;
                    else
                        $porcentaje = ($cant * 100) / 1;
                    $porcentaje = round($porcentaje * 100) / 100;

            $matriz[$c1][$c2] = $res['nombre'];
            $c2++;
            $matriz[$c1][$c2] = $cant;
            $c2++;
            $matriz[$c1][$c2] = $porcentaje;
        }
        $c1++;
    }
}

$pdf->Ln(20);
$pdf->BasicTable($header, $matriz);
$pdf->Output();
?>