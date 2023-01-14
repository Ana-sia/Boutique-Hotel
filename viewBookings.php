<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Hotel Booking</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@600&family=Josefin+Slab:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <header>
      <h1>Review bookings:</h1>
    </header>

<?php

// checks if there are any reservations for the chosen period of time, returnes the information about them 

if (isset($_POST['start_date']) && isset($_POST['end_date'])) {
  $start_date = $_POST['start_date'];
  $end_date = $_POST['end_date'];
}
$db = mysqli_connect('localhost', 'root', '', 'homewoodhotel');
$query = "SELECT bookings.*, guests.name as guest_name, rooms.type as room_type FROM bookings
          INNER JOIN guests ON bookings.guest_id = guests.id
          INNER JOIN rooms ON bookings.room_id = rooms.id
          WHERE (check_in BETWEEN '$start_date' AND '$end_date') OR (check_out BETWEEN '$start_date' AND '$end_date')";
$result = mysqli_query($db, $query);

$counter = 1;
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

  // displays the infotmation about each booking
 
  echo "<table>";
  echo "<tr>";
  echo "<th>Booking: $counter</th>";
  echo "</tr>";
  echo "<tr><td>Booking ID: " . $row['id'] . "</td></tr>";
  echo "<tr><td>Guest Name: " . $row['guest_name'] . "</td></tr>>";
  echo "<tr><td>Room Type: " . $row['room_type'] . "</td></tr>";
  echo "<tr><td>Check-in: " . $row['check_in'] . "</td></tr>";
  echo "<tr><td>Check-out: " . $row['check_out'] . "</td></tr>";
  if ($row['breakfast'] == 0) {
    echo "<tr><td>Breakfast: No</td></tr>";
  } else {
    echo "<tr><td>Breakfast: Yes</td></tr>";
  }
  if ($row['airport_pickup'] == 0) {
    echo "<tr><td>Transfer: No</td></tr>";
  } else {
    echo "<tr><td>Transfer: Yes</td></tr>";
  }
  echo "<tr><td>Comment: " . $row['comment'] . "</td></tr>";
  echo "</table>";
  $counter++;
  }
?>

    <button class="blue"><a href="staffmenu.html">Back</a></button>
    <button class="blue"><a href="manageBookings.php">Manage Bookings</a></button>
</body>
</html>