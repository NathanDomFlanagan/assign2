<!-- 
  Student Information:
  Name: Nathan Flanagan
  ID: 20122140

  File: assign_booking.php

  Description:
  Updates the assignment status of a booking in a MySQL database and returns a confirmation message in JSON format.

-->

<?php
// Establish a connection to the MySQL database
require_once("../../conf/settings.php");

// Retrieve the booking number from the request
$bookingNumber = $_POST["bookingNumber"];

// Create a new database connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Update the status of the booking with the matching booking number to "assigned"
$sql = "UPDATE bookings SET assignment_status = 'assigned' WHERE booking_number = '$bookingNumber'";

if ($conn->query($sql) === TRUE) {
  // Return a confirmation message
  echo json_encode(["message" => "Congratulations! Booking request " . $bookingNumber . " has been assigned!"]);
} else {
  echo json_encode(["message" => "Error updating record: " . $conn->error]);
}

// Close the database connection
$conn->close();
?>
