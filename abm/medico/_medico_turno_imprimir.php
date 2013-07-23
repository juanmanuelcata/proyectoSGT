<?php

// Prueba de impresion
require('../../imprimir/fpdf/fpdf.php');
include_once './../../fragmentos/_conectDb.php';

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

$header = array('Paciente', 'DNI', 'fecha', 'Hora');
$pdf = new PDF();
$pdf->AddPage();



$db = conectaDb();
$c1 = 0;
foreach ($_GET as $n) {
    if ($c1 >= 0) {
        $c2 = 0;
        $consulta = 'Select nombre, apellido, dni, fecha, hora from turno inner join paciente on (turno.id_pac = paciente.idpaciente) where idturno = "' . $n . '"';
        $res = $db->query($consulta);
        if ($res) {
            $arr = $res->fetch(PDO::FETCH_ASSOC);
                $paciente = $arr['nombre'].' '.$arr['apellido'];
                $arr['nombre'] = $paciente;
                unset($arr['apellido']);
                $matriz [$c1] = ($arr);
        }
    }
    $c1++;
}

$con = 'select nombre, apellido from turno inner join medico on (turno.id_med = medico.idmedico) where idturno = "' . $n . '"';
$aux = $db->query($con);
$arr1 = $aux->fetch(PDO::FETCH_ASSOC);
        
$medico = $arr1['nombre'].' '.$arr1['apellido'];
$pdf->SetFont('Arial', 'B', 15);
$pdf->Cell(40, 8, 'Turnos de ' . $medico . '', 0);
$pdf->Ln(20);
$pdf->BasicTable($header, $matriz);
$pdf->Output();
?>
