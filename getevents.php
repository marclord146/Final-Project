<?php

// Connect to database
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "eventsystem";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Retrieve events from database
$sql = "SELECT Event_ID, Event_Name, Date, Venue, Time, Price, Category, Description, Image FROM event";
$result = $conn->query($sql);

// Format events for FullCalendar
$events = array();
while($row = $result->fetch_assoc()) {
  $event = array();
  $event['id'] = $row['Event_ID'];
  $event['title'] = $row['Event_Name'];
  $event['start'] = $row['Date'] . 'T' . $row['Time'];
  $event['end'] = $row['Date'] . 'T' . $row['Time'];
  $event['description'] = $row['Description'];
  $event['venue'] = $row['Venue'];
  $event['price'] = $row['Price'];
  $event['image'] = $row['Image'];
  $events[] = $event;
}

// Return events in JSON format
echo json_encode($events);

// Close database connection
$conn->close();

?>
