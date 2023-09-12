CREATE TABLE bookings (
  booking_id INT AUTO_INCREMENT PRIMARY KEY,
  booking_number VARCHAR(10) NOT NULL,
  customer_name VARCHAR(50) NOT NULL,
  phone_number VARCHAR(12) NOT NULL,
  unit_number VARCHAR(10),
  street_number VARCHAR(10) NOT NULL,
  street_name VARCHAR(50) NOT NULL,
  suburb VARCHAR(50),
  destination_suburb VARCHAR(50),
  pickup_date DATE NOT NULL,
  pickup_time TIME NOT NULL,
  assignment_status VARCHAR(20) NOT NULL,
  booking_datetime DATETIME NOT NULL
);
