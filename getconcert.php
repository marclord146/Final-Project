<?php
include 'dbconfig.php';

//Count total number of concert events
$totalStmt = $conn->prepare("SELECT COUNT(*) as total FROM event WHERE Category='Concert'");
$totalStmt->execute();
$result = $totalStmt->get_result();
$row = $result->fetch_assoc();
$totalConcerts = $row['total'];

$page = isset($_GET['page']) ? $_GET['page'] : 1;// Get the current page number from the URL query parameters. If not set, default to 1.
$itemsPerPage = 8; //Number of concert tickets to display per page.
$offset = ($page - 1) * $itemsPerPage; // Calculate the offset for the SQL query based on the current page number

$stmt = $conn->prepare("SELECT * FROM event WHERE Category='Concert' LIMIT ?, ?"); //SQL query to get all concerts from event table. The LIMIT clause is used to specify the maximum number of rows to retrieve, with placeholders for the offset and item count
$stmt->bind_param("ii", $offset, $itemsPerPage); // Bind the values of the offset and item count to the placeholders in the prepared SQL query. The "ii" parameter type specifies that both values are integers
$stmt->execute();// Execute SQL query

$concert = $stmt->get_result(); //Get Result of SQL 
$totalPages = ceil($totalConcerts / $itemsPerPage);// Calculate the total number of pages based on the total number of concerts and the items per page


?>