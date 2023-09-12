// Student Information:
// Name: Nathan Flanagan
// ID: 20122140

// File: admin.js

// Description:
// This file represents the Admin JavaScript code for CabsOnline.

document.addEventListener("DOMContentLoaded", function () {
  // Retrieve necessary elements from the DOM
  const bookingSearchForm = document.getElementById("bookingSearchForm");
  const bookingTable = document.getElementById("bookingTable");

  // Event listener for form submission
  bookingSearchForm.addEventListener("submit", function (event) {
    event.preventDefault();
    const referenceNumber = document
      .getElementById("referenceNumber")
      .value.trim();
    searchBooking(referenceNumber);
  });

  // Function to search bookings based on reference number
  function searchBooking(referenceNumber) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "search_booking.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
      if (xhr.status === 200) {
        const response = JSON.parse(xhr.responseText);
        displayBookings(response);
      }
    };

    xhr.send("referenceNumber=" + encodeURIComponent(referenceNumber));
  }

  // Function to display bookings in the table
  function displayBookings(bookings) {
    const tableBody = bookingTable.getElementsByTagName("tbody")[0];
    tableBody.innerHTML = "";

    for (let i = 0; i < bookings.length; i++) {
      const booking = bookings[i];

      // Create table row and cells for each booking property
      const row = document.createElement("tr");
      const bookingRefCell = document.createElement("td");
      bookingRefCell.textContent = booking.bookingRef;
      row.appendChild(bookingRefCell);

      const customerNameCell = document.createElement("td");
      customerNameCell.textContent = booking.customerName;
      row.appendChild(customerNameCell);

      const phoneCell = document.createElement("td");
      phoneCell.textContent = booking.phone;
      row.appendChild(phoneCell);

      const pickupSuburbCell = document.createElement("td");
      pickupSuburbCell.textContent = booking.pickupSuburb;
      row.appendChild(pickupSuburbCell);

      const destinationSuburbCell = document.createElement("td");
      destinationSuburbCell.textContent = booking.destinationSuburb;
      row.appendChild(destinationSuburbCell);

      const pickupDateTimeCell = document.createElement("td");
      pickupDateTimeCell.textContent = booking.pickupDateTime;
      row.appendChild(pickupDateTimeCell);

      const statusCell = document.createElement("td");
      statusCell.textContent = booking.status;
      row.appendChild(statusCell);

      const assignCell = document.createElement("td");
      if (booking.status === "unassigned") {
        const assignButton = document.createElement("button");
        assignButton.textContent = "Assign";
        assignButton.addEventListener("click", function () {
          assignBooking(booking.bookingRef);
        });
        assignCell.appendChild(assignButton);
      }
      row.appendChild(assignCell);

      tableBody.appendChild(row);
    }
  }

  // Function to assign a booking to a driver
  function assignBooking(bookingRef) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "assign_booking.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
      if (xhr.status === 200) {
        const response = JSON.parse(xhr.responseText);
        displayConfirmation(response.message);
        updateBookingStatus(bookingRef, "assigned");
      }
    };

    xhr.send("bookingRef=" + encodeURIComponent(bookingRef));
  }

  // Function to update the status of a booking in the table
  function updateBookingStatus(bookingRef, status) {
    const statusCell = document.querySelector(
      `#bookingTable tr[data-booking-ref="${bookingRef}"] td.status`
    );
    if (statusCell) {
      statusCell.textContent = status;
    }
  }

  // Function to display a confirmation message
  function displayConfirmation(message) {
    alert(message);
  }
});
