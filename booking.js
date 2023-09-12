// Student Information:
// Name: Nathan Flanagan
// ID: 20122140

// File: booking.js

// Description:
// The JavaScript code handles the submission of the booking form, sends the form data to the server using AJAX, and displays the confirmation message received from the server.

// Get the booking form element
const bookingForm = document.getElementById("bookingForm");

// Add event listener for form submission
bookingForm.addEventListener("submit", function (event) {
  event.preventDefault(); // Prevent the default form submission

  // Get the form data
  const formData = new FormData(bookingForm);

  // Create and configure the XMLHttpRequest object
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "process_booking.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  // Set up the callback function when the request is complete
  xhr.onload = function () {
    if (xhr.status === 200) {
      // Display the confirmation message
      const confirmationDiv = document.getElementById("confirmation");
      confirmationDiv.innerHTML = xhr.responseText;
    }
  };

  // Convert the form data to a URL-encoded string
  const encodedFormData = Array.from(formData)
    .map(
      (entry) =>
        `${encodeURIComponent(entry[0])}=${encodeURIComponent(entry[1])}`
    )
    .join("&");

  // Send the form data to the server
  xhr.send(encodedFormData);
});
