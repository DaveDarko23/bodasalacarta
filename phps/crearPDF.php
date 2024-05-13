<?php
require 'fpdf/fpdf.php';

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 25);
        $this->Ln(20);
        $this->Cell(80);
        $this->Cell(30, 20, 'Bodas a la Carta', 0, 1, 'C');
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(80);
        $this->Ln(5);
    }

    function Content($summary, $costo, $address, $phone)
    {
        $this->SetFillColor(230, 230, 230);
        $this->SetFont('Arial', 'B', 12);
  
         // Detalles adicionales
         $this->SetFont('Arial', 'B', 12);
         $this->Cell(0, 5, 'Detalles de Compra:', 0, 1, 'L', 0);
         $this->SetFont('Arial', '', 10);
         $this->Cell(0, 5, "Direccion: $address", 0, 1, 'L', 0);
         $this->Cell(0, 5, "Telefono: $phone", 0, 1, 'L', 0);
         $this->Cell(0, 5, 'Fecha de Compra: ' . date("d-m-Y h:i:s"), 0, 1, 'L', 0);

        // Encabezados de la tabla
        $this->Cell(120, 10, "Servicio", 1, 0, 'C', 1);
        $this->Cell(40, 10, "Cantidad", 1, 0, 'C', 1);
        $this->Cell(30, 10, "Precio", 1, 1, 'C', 1);

        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(0); // Restablecer el color de texto a negro

        $cantidadTotal = 0;
        foreach ($summary as $producto) {
            $this->Cell(120, 10, utf8_decode($producto['nombre_producto']), 'B', 0, 'C', 0);
            $this->Cell(40, 10, $producto['cantidad'], 'B', 0, 'C', 0);
            $this->Cell(30, 10, '$' . $producto['precio'], 'B', 1, 'C', 0);
            $cantidadTotal += $producto['cantidad'];
        }
        // Total
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(120, 10, 'Total:', 'T', 0, 'R', 0);
        $this->Cell(40, 10, $cantidadTotal, 1, 0, 'C', 0);
        $this->Cell(30, 10, '$' . $costo, 1, 1, 'C', 0);       
    }
}

function generateContentPdf($summary, $costo, $address, $phone,$id)
{
    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->SetMargins(10, 10, 10);
    $pdf->SetAutoPageBreak(true, 20);
    $pdf->Content($summary, $costo, $address, $phone);
    $pdf->Output('F', "../pdf/" . $id . ".pdf");
}

?>
