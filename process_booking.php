<!-- 
  Student Information:
  Name: Nathan Flanagan
  ID: 20122140

  File: process_booking.php

  Description:
  This PHP script handles the processing of a booking form submission, stores the booking details in a MySQL database, 
  generates a unique booking reference number, and returns a confirmation message with the booking details.

-->

<?php

// Establish a connection to the MySQL database
require_once("../../conf/settings.php");

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) 
{
  die("Connection failed: " . $conn->connect_error);
}

// Retrieve the booking details from the POST request
$cname = $_POST['cname'];
$phone = $_POST['phone'];
$unumber = $_POST['unumber'];
$snumber = $_POST['snumber'];
$stname = $_POST['stname'];
$sbname = $_POST['sbname'];
$dsbname = $_POST['dsbname'];
$date = $_POST['date'];
$time = $_POST['time'];

// Generate a unique booking reference number
$bookingNumber = generateBookingNumber($conn);

// Generate the booking date and time
$bookingDateTime = date("Y-m-d H:i:s");

// Set the initial assignment status
$assignmentStatus = "unassigned";

// Prepare the SQL statement with parameter binding
$sql = "INSERT INTO bookings (booking_number, customer_name, phone_number, unit_number, street_number, street_name, suburb, destination_suburb, pickup_date, pickup_time, assignment_status, booking_datetime)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssssssss", $bookingNumber, $cname, $phone, $unumber, $snumber, $stname, $sbname, $dsbname, $date, $time, $assignmentStatus, $bookingDateTime);

if ($stmt->execute()) 
{
  // Format the pickup date
  $formattedDate = date("d/m/Y", strtotime($date));
  
  // Return the confirmation message
  $confirmationMessage = "<br>Thank you for your booking!<br>
                          Booking reference number: $bookingNumber<br>
                          Pickup time: $time<br>
                          Pickup date: $formattedDate";

  echo $confirmationMessage;
} else 
{
  echo "Error: " . $stmt->error;
}

// Close the prepared statement and the database connection
$stmt->close();
$conn->close();

// Function to generate a unique booking reference number
function generateBookingNumber($conn) 
{
  $sql = "SELECT MAX(booking_id) AS max_booking_id FROM bookings";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $maxBookingId = $row['max_booking_id'];

  $bookingNumber = "BRN" . str_pad($maxBookingId + 1, 5, '0', STR_PAD_LEFT);

  return $bookingNumber;
}
?>
