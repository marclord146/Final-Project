<?php
include 'dbconfig.php'; //Database connection

//Count total number of sports events
$totalStmt = $conn->prepare("SELECT COUNT(*) as total FROM event WHERE Category='Sporting Event'");
$totalStmt->execute();
$result = $totalStmt->get_result();
$row = $result->fetch_assoc();
$totalSports = $row['total'];

$page = isset($_GET['page']) ? $_GET['page'] : 1;// Get the current page number from the URL query parameters. If not set, default to 1.
$itemsPerPage = 8; //Number of concert tickets to display per page.
$offset = ($page - 1) * $itemsPerPage; // Calculate the offset for the SQL query based on the current page number

$stmt = $conn->prepare("SELECT * FROM event WHERE Category='Sporting Event' LIMIT ?, ?"); //SQL query to get all sports events from event table. The LIMIT clause is used to specify the maximum number of rows to retrieve, with placeholders for the offset and item count
$stmt->bind_param("ii", $offset, $itemsPerPage); // Bind the values of the offset and item count to the placeholders in the prepared SQL query. The "ii" parameter type specifies that both values are integers
$stmt->execute();// Execute SQL query

$sport = $stmt->get_result(); //Get Result of SQL 
$totalPages = ceil($totalSports / $itemsPerPage);// Calculate the total number of pages based on the total number of sports events and the items per page
?>