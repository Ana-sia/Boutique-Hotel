<!DOCTYPE html>
<html lang="en">
<head>
<title>Booking managment system</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@600&family=Josefin+Slab:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>Booking managment system:</h1>
  </header>
  <script>
      // Get the error message from the query string
      const error = new URLSearchParams(window.location.search).get('error');
      // If there is an error message, display it
      if (error) {
        document.body.innerHTML += `<div class="error-message">${error}</div>`;
      }
    </script>
    <style>
      .error-message {
    position: absolute;
    top: 85%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: rgba(255, 255, 255);
    color: rgb(148, 71, 71);
    padding: 20px;
    border-radius: 5px;
    font-size: larger;
    font-weight: bold;
    text-align: center;
    
  }
      </style>
  <table>
  <tr>
    <th>Booking ID</th>
    <th>Guest</th>
    <th>Room Type</th>
    <th>Room Number</th>
    <th>Total Price</th>
    <th>Check-in</th>
    <th>Check-out</th>
    <th>Breakfast</th>
    <th>Comment</th>
  </tr>
  <?php
   
   //sends information from the database to the table to be displayed

    // Connect to the database
    $db = mysqli_connect('localhost', 'root', '', 'homewoodhotel');

    // Query the bookings table
    $query = "SELECT bookings.id AS booking_id, guests.name, rooms.type, rooms.id AS room_id, rooms.price, bookings.check_in, bookings.check_out, bookings.breakfast, bookings.comment, bookings.room_number FROM rooms
    INNER JOIN bookings ON bookings.room_id=rooms.id INNER JOIN guests ON bookings.guest_id=guests.id";

$result = mysqli_query($db, $query);

// Loop through the rows and display the information in a table
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
  echo "<tr>";
  echo "<td>" . $row['booking_id'] . "</td>";
  echo "<td>" . $row['name'] . "</td>";
  echo "<td>" . $row['type'] . "</td>";
  echo "<td>" . $row['room_number'] . "</td>";
  //echo "<td>" . $row['room_id'] . "</td>";
  echo "<td>" . $row['price'] . "</td>";
  echo "<td>" . $row['check_in'] . "</td>";
  echo "<td>" . $row['check_out'] . "</td>";
  if ($row['breakfast'] == 0) {
    echo "<td>No</td>";
  } else {
    echo "<td>Yes</td>";
  }
  echo "<td>" . $row['comment'] . "</td>";
  echo "</tr>";
}

    mysqli_close($db);
  ?>
</table>
</table>
<p>Match the guest's preferences with a room of the chosen type:</p>
<form action="assignRoomNumber.php" method="POST">
  <label for="booking_id">Booking ID:</label>
  <input type="text" name="booking_id" id="booking_id" required>
  <label for="room_number">Room Number:</label>
  <input type="text" name="room_number" id="room_number" required><br>
  <input type="submit" value="Save">
</form>
        
<button class="blue"><a href="staffmenu.html">Back to the menu</a></button>
  </body>
<footer>
 
</footer>
</html>