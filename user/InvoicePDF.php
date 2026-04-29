<?php
require_once __DIR__ . '/../TCPDF-main/TCPDF-main/tcpdf.php';
include '../config/db.php';

$orderID = $_GET['id'];

// Get order
$order = $conn->query("
    SELECT o.*, u.userName 
    FROM orders o
    JOIN users u ON o.userID = u.userID
    WHERE o.orderID = $orderID
")->fetch_assoc();

// Get items
$items = $conn->query("
    SELECT oi.*, p.proName 
    FROM orderItems oi
    JOIN products p ON oi.productID = p.productID
    WHERE oi.orderID = $orderID
");

// Create PDF
$pdf = new TCPDF();
$pdf->AddPage();

// Title
$pdf->SetFont('helvetica', 'B', 18);
$pdf->Cell(0, 10, 'PetCare Invoice', 0, 1, 'C');

$pdf->Ln(5);

// Customer Info
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 10, "Customer: {$order['userName']}", 0, 1);
$pdf->Cell(0, 10, "Order ID: {$orderID}", 0, 1);
$pdf->Cell(0, 10, "Date: {$order['orderDate']}", 0, 1);

$pdf->Ln(5);

// Table Header
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(80, 10, 'Product', 1);
$pdf->Cell(30, 10, 'Qty', 1);
$pdf->Cell(40, 10, 'Price', 1);
$pdf->Ln();

// Table Data
$pdf->SetFont('helvetica', '', 12);

while ($i = $items->fetch_assoc()) {
    $price = $i['quantity'] * $i['price'];

    $pdf->Cell(80, 10, $i['proName'], 1);
    $pdf->Cell(30, 10, $i['quantity'], 1);
    $pdf->Cell(40, 10, "₹" . $price, 1);
    $pdf->Ln();
}

$pdf->Ln(5);

// Total
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, "Total: ₹{$order['totalAmt']}", 0, 1, 'R');

// Output PDF
$pdf->Output("invoice_$orderID.pdf", 'I'); // I = open in browser
?>