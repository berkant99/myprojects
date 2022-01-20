

 <!DOCTYPE html>
 <html>
 <head>
 	<title>INVOICE</title>
 </head>
 <body>
 <?php 
 //include("header.php");
  session_start();

    require('fpdf/fpdf.php');
 $pdf = new FPDF('P','mm','A4');
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'Shopping Invoice',1,1,C);
$pdf->Cell(95,10,'',0,1);

$pdf->Cell(38,20,'Item ID',1,0);
$pdf->Cell(38,20,'Item Name',1,0);
$pdf->Cell(38,20,'Item Price',1,0);
$pdf->Cell(38,20,'Item Quantity',1,0);
$pdf->Cell(38,20,'Total Price',1,1);

if (isset($_SESSION['mycart'])) {

	$total = 0;
	
	foreach ($_SESSION['mycart'] as $key => $value) {
	
$pdf->Cell(38,20,$value['id'],1,0);
$pdf->Cell(38,20,$value['name'],1,0);
$pdf->Cell(38,20,$value['price'],1,0);
$pdf->Cell(38,20,$value['quantity'],1,0);
$pdf->Cell(38,20,"$ ".number_format($value['quantity'] * $value['price'], 2),1,1);
$total = $total + $value['quantity'] * $value['price'];
}


}

$pdf->Cell(40,20,'',0,1);

$pdf->Cell(40,20,'Total Price',1,0);
$pdf->Cell(150,20,"$ ".number_format($total,2),1,1,R);
$pdf->Output();

 ?>
 </body>
 </html>