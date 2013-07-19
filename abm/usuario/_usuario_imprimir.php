<?php

// Prueba de impresion
require('../../imprimir/fpdf/fpdf.php');

class PDF extends FPDF {
  //Tabla simple
  function BasicTable($header, $data) {
    // Cabecera
    $this->SetFont('Arial', 'B', 10);
    foreach ($header as $col)
      $this->Cell(38, 8, $col, 1);
    $this->Ln();
    //    Datos
    $this->SetFont('Arial', '', 10);
    foreach ($data as $row) {
      foreach ($row as $col)
       $this->Cell(38, 8, utf8_decode($col), 1);
      $this->Ln();
    }
  }

}
$header = array('User', 'Nombre', 'Apellido', 'DNI', 'E-mail');
$pdf = new PDF();
$pdf->AddPage();


include_once './../../fragmentos/_conectDb.php';
$db = conectaDb();
$c1 = 0;
foreach ($_GET as $n) {
  if ($c1 >= 0) {
    $c2 = 0;
    $consulta = 'Select user, nombre, apellido, dni, mail from usuario where idusuario = "' . $n . '"';
    $res = $db->query($consulta);
    if ($res) {
      $arr = $res->fetch(PDO::FETCH_ASSOC);
      $matriz [$c1] = ($arr);     
    }
  }
  $c1++;
}
$pdf->SetFont('Arial', 'B', 15);
$pdf->Cell(40, 8, 'Usuarios', 0);
$pdf->Ln(20);
$pdf->BasicTable($header, $matriz);
$pdf->Output();
?>
