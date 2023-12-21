<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include "dbconfig.php";
require 'tcpdf/tcpdf.php';
require 'phpqrcode/qrlib.php';
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

// Get the order ID from the form submission
$order_id = $_POST['order_id'];

// Retrieve the order and order items from the database using the order ID

// Retrieve the order from the database using the order ID
$orderQuery = "SELECT * FROM orders WHERE Order_ID = ?";
$orderStmt = $conn->prepare($orderQuery);
$orderStmt->bind_param("i", $order_id);
$orderStmt->execute();
$orderResult = $orderStmt->get_result();

// Check if the order exists
if ($orderResult->num_rows === 0) {
    echo 'Failed to retrieve order.';
    exit;
}

$order = $orderResult->fetch_assoc();

// Retrieve the order items from the database using the order ID
$orderItemsQuery = "
    SELECT oi.*, e.Venue, e.Date, e.Time
    FROM order_items oi
    JOIN event e ON oi.Event_ID = e.Event_ID
    WHERE oi.Order_ID = ?
";
$orderItemsStmt = $conn->prepare($orderItemsQuery);
$orderItemsStmt->bind_param("i", $order_id);
$orderItemsStmt->execute();
$orderItemsResult = $orderItemsStmt->get_result();

// Check if the order items exist
if ($orderItemsResult->num_rows === 0) {
    echo 'Failed to retrieve order items.';
    exit;
}

$orderItems = [];
while ($row = $orderItemsResult->fetch_assoc()) {
    $orderItems[] = $row;
}

// Generate the ticket HTML for each order item
$ticketHTML = '';

// Loop through each order item and generate the ticket HTML
foreach ($orderItems as $item) {
    $imagePath = isset($item['Image']) ? 'media/' . $item['Image'] : '';
    $eventName = isset($item['Event_Name']) ? $item['Event_Name'] : '';
    $eventDate = isset($item['Date']) ? $item['Date'] : '';
    $eventTime = isset($item['Time']) ? date('g:i A', strtotime($item['Time'])) : '';
    $venue = isset($item['Venue']) ? $item['Venue'] : '';
    $qrCodeData = isset($order['QR_Code']) ? $order['QR_Code'] : '';

// Generate the QR code image using PHP QR Code library
$qrCodePath = 'media/qrcode.png';  // Provide the desired path to save the QR code image
QRcode::png($order_id, $qrCodePath, QR_ECLEVEL_L, 6);  // Use the order ID as the data for the QR code

// Read the QR code image as binary data
$qrCodeDataBinary = file_get_contents($qrCodePath);

// Update the order items in the database with the QR code
$updateQuery = "UPDATE order_items SET QRcode = ? WHERE Order_ID = ?";
$updateStmt = $conn->prepare($updateQuery);
$updateStmt->bind_param("si", $qrCodeDataBinary, $order_id);

// Execute the update statement
$updateStmt->execute();

// Check if the update was successful
if ($updateStmt->affected_rows === -1) {
    echo 'Failed to update order items with QR code: ';
    exit;
}

// Close the prepared statement
$updateStmt->close();

    // Get the quantity of tickets
    $quantity = isset($item['Quantity']) ? $item['Quantity'] : 1;

    // Generate multiple tickets based on the quantity
    for ($i = 0; $i < $quantity; $i++) {
        // Append the ticket HTML for each order item
        $ticketHTML .= '
        <div class="ticket">
            <div class="ticket-left">
                <img width="150" height="150" src="'. $imagePath .'" >
            </div>
            <div class="ticket-center">
                <h1>TTickets.com</h1>
                <p>'. $eventName .'</p>
                <p>'. $eventDate .' '. $eventTime .'</p> 
                <p>'. $venue .'</p>
                <p>'. $order['Name'] .'</p>
            </div>
            <div class="ticket-right">
                <img src="'. $qrCodePath .'" width="150" height="150" alt="QR Code">
            </div>
        </div>
        ';
    }

}

// Load the ticket PDF template
$ticketTemplate = '
<!DOCTYPE html>
<html>
<head>
    <title>E-Ticket Template</title>
    <style>
        .ticket {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: space-between; /* Align items horizontally */
            align-items: center; /* Align items vertically */
        }
      
        .ticket-left {
            text-align: center;
            flex: 1; /* Take 1/3 of the available space */
        }
      
        .ticket-center {
            text-align: center;
            flex: 1; /* Take 1/3 of the available space */
        }
      
        .ticket-right {
            text-align: center;
            flex: 1; /* Take 1/3 of the available space */
        }
      
        h1 {
            font-size: 24px;
            margin-top: 0;
        }
      
        p {
            font-size: 16px;
            margin-bottom: 10px;
        }
      
        .qr-code {
            margin-top: 20px;
            text-align: center;
            /* Add styling for the QR code, e.g., width, height, background color, etc. */
        }
      
        .ticket-left img {
            width: 100%;
            max-width: 300px; /* Adjust the width as needed */
            margin-top: 10px;
        }
    </style>
</head>
<body>
    ' . $ticketHTML . '
</body>
</html>
';

// Create the ticket PDF using TCPDF
$pdf = new TCPDF('P', 'mm', 'Letter', true, 'UTF-8', false);
$pdf->SetAutoPageBreak(true, 10);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);
$pdf->writeHTML($ticketTemplate, true, false, true, false, '');

// Output the PDF as a string
$ticketPdf = $pdf->Output('ticket.pdf', 'S');

// Prepare email parameters
$to = $order['Email'];
$subject = 'Your E-Ticket';
$from = 'drummie301@gmail.com';

// Create a PHPMailer instance
$mail = new PHPMailer(true);

// Set SMTP configuration
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com'; // Set your SMTP host
$mail->SMTPAuth = true;
$mail->Username = 'drummie301@gmail.com'; // Set your SMTP username
$mail->Password = 'gvklgxpjxgwuqdnd'; // Set your SMTP password
$mail->SMTPSecure = 'tls';
$mail->Port = 587; // Set your SMTP port

// Set email parameters
$mail->setFrom($from);
$mail->addAddress($to);
$mail->Subject = $subject;
$mail->isHTML(true);
$mail->Body = '<h1>Your E-Ticket</h1><p>Please find your e-ticket attached.</p>';
$mail->addStringAttachment($ticketPdf, 'ticket.pdf');

// Send the email
if ($mail->send()) {
    header('Location:successemail.php');
} else {
    echo 'Failed to send e-tickets.';
}

?>


