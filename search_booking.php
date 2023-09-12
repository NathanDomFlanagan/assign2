<!-- 
  Student Information:
  Name: Nathan Flanagan
  ID: 20122140

  File: search_booking.php

  Description:
  This PHP script retrieves bookings from a MySQL database based on a provided reference number or fetches unassigned bookings within a specific time range, 
  and returns the results as a JSON response.

-->

<?php
// Establish a connection to the MySQL database
require_once("../../conf/settings.php");

// Retrieve the reference number from the request
$referenceNumber = $_POST["referenceNumber"];

// Create a new database connection
$conn = new mysqli($host, $user, $password, $dbname);
// Check the connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL query based on the reference number
if (empty($referenceNumber)) {
  // If reference number is empty, fetch unassigned bookings within 2 hours from the current time
  $sql = "SELECT * FROM bookings WHERE pickup_date = CURDATE() AND pickup_time <= CURTIME() + INTERVAL 2 HOUR";
} else {
  // If reference number is provided, fetch the booking with the matching reference number
  $sql = "SELECT * FROM bookings WHERE booking_number = '$referenceNumber'";
}

// Execute the query
$result = $conn->query($sql);

// Prepare the response array
$bookings = array();

if ($result->num_rows > 0) {
  // Iterate over the result and add each booking to the response array
  while ($row = $result->fetch_assoc()) {
    $booking = array(
        "booking_number" => $row["booking_number"],
        "customer_name" => $row["customer_name"],
        "phone_number" => $row["phone_number"],
        "pickup_suburb" => $row["suburb"], 
        "destination_suburb" => $row["destination_suburb"], 
        "pickup_date" => $row["pickup_date"],
        "pickup_time" => $row["pickup_time"],
        "status" => $row["assignment_status"] 
    );
      

    $bookings[] = $booking;
  }
}

// Close the database connection
$conn->close();

// Send the response as JSON
header("Content-Type: application/json");
echo json_encode($bookings);
?>
