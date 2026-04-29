<?php
require_once '../dompdf-master/dompdf-master/autoload.inc.php';

use Dompdf\Dompdf;

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

// Build HTML
$html = "<h2>Invoice</h2>";
$html .= "<p>Order ID: {$order['orderID']}</p>";
$html .= "<p>Name: {$order['userName']}</p>";

$html .= "<table border='1' cellpadding='5'>
<tr><th>Product</th><th>Qty</th><th>Price</th></tr>";

while ($i = $items->fetch_assoc()) {
    $html .= "<tr>
        <td>{$i['proName']}</td>
        <td>{$i['quantity']}</td>
        <td>{$i['price']}</td>
    </tr>";
}

$html .= "</table>";
$html .= "<h3>Total: ₹{$order['totalAmt']}</h3>";

// Generate PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->render();

// Download
$dompdf->stream("invoice_$orderID.pdf", ["Attachment" => true]);