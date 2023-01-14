<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Invoice</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@600&family=Josefin+Slab:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    
    <main>

<?php
//sends the data from the booking form to the database, counts total price for the invoice

$db = mysqli_connect('localhost', 'root', '', 'homewoodhotel');

error_reporting(E_ERROR | E_PARSE); //report simple errors https://www.php.net/manual/en/function.error-reporting.php

$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$gender = $_POST['gender'];
$date_of_birth = $_POST['date-of-birth'];
$check_in = $_POST['check-in'];
$check_out = $_POST['check-out'];
$room_type = $_POST['room-type'];
$breakfast = $_POST['breakfast'];
$airport_pickup = $_POST['airport-pickup'];
$comment = $_POST['comment'];

// Check if there are available rooms of the selected type
$query = "SELECT available FROM room_inventory WHERE type = '$room_type'";
$result = mysqli_query($db, $query);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
if ($row['available'] <= 0) {
  // Check if there are any bookings with the same check-in or check-out date as the new booking
  $query = "SELECT COUNT(*) as count FROM bookings 
  WHERE ('$check_in' BETWEEN check_in AND check_out OR '$check_out' BETWEEN check_in AND check_out) 
  AND room_id = (SELECT id FROM rooms WHERE `type`='$room_type' LIMIT 1)";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
  if ($row['count'] >= 0) {
    echo "<p>Sorry, there are no available rooms of the selected type on the given dates.</p>";
    exit;
  }
}

$price = 0;
if (isset($_POST['breakfast'])) {
  $breakfast = 1;  // Set breakfast to true
} else {
  $breakfast = 0;  // Set breakfast to false
}
if (isset($_POST['airoport-pickup'])) {
  $airport_pickup = 1;  
} else {
  $airport_pickup = 0;  
}

mysqli_query($db, "INSERT INTO guests (`name`, phone, email, gender, date_of_birth) VALUES ('$name', '$phone', '$email', '$gender', '$date_of_birth')");
mysqli_query($db, "INSERT INTO rooms (`type`) VALUES ('$room_type')");


// total price
$num_days = (strtotime($check_out) - strtotime($check_in)) / 86400;
if ($room_type == 'double') {
  $price += 130 * $num_days;
} elseif ($room_type == 'twin') {
  $price += 150 * $num_days;
} elseif ($room_type == 'deluxe') {
  $price += 350 * $num_days;
}

if($breakfast == 1) {
  $price+=50*$num_days;
  $message1 = "Breakfast included";
}

if($airport_pickup == 1) {
  $price+=100;
  $message2 = "Please contact 800 00 800 to arrange your pick up time";
}

mysqli_query($db, "INSERT INTO bookings (guest_id, room_id, check_in, check_out, breakfast, airport_pickup,  comment) 
VALUES ((SELECT id FROM guests WHERE `name`='$name' AND phone='$phone' LIMIT 1),
        (SELECT id FROM rooms WHERE `type`='$room_type' LIMIT 1),
        '$check_in', '$check_out', '$breakfast', '$airport_pickup', '$comment')");



// Decrement the available room by 1 when booked successfully
mysqli_query($db, "UPDATE room_inventory SET available = available - 1 WHERE type='$room_type'");



$query = "UPDATE rooms SET price = $price ORDER BY id DESC LIMIT 1"; //update price for the latest booking
mysqli_query($db, $query);

//calls the script for sending the correct room and guest id to the "bookings" table, otherwise they are noy assigned correctly
// explanation in the Report

require 'assignCorrectId.php';



//mysqli_close($db);
?>

<p>YOUR RESERVATION HAS BEEN ACCEPTED</p>
<table>
<tr>
    <th>Thank you for your reservation!</th>
</tr>
<tr> <td>Name: <?php echo $name; ?></td></tr>
<tr><td>Room Type: <?php echo $room_type; ?></td></tr>
<tr> <td>Check In: <?php echo $check_in; ?></td></tr>
<tr><td>Check Out: <?php echo $check_out; ?></td></tr>
<tr><td>Total Price: <?php echo $price; ?></td></tr>
<tr><td> <?php echo $message1; ?></td></tr>
<tr><td> <?php echo $message2; ?></td></tr>
<tr>
    <th>You can complete your payment at the Reception Desk</th>
</tr>

</table>

</main>
<footer>
      <a href="homepage.html"><button>Back to homepage</button></a>
  </footer>
  </body>
</html>
