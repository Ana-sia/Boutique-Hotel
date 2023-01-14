<?php
//used for assigning  a room number to each booking


$db = mysqli_connect('localhost', 'root', '', 'homewoodhotel');
$booking_id = $_POST['booking_id'];
$room_number = $_POST['room_number'];

// Retrieve the room type for the booking with the given id
$query = "SELECT rooms.type FROM bookings INNER JOIN rooms ON bookings.room_id = rooms.id WHERE bookings.id = '$booking_id'";
$result = mysqli_query($db, $query);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$room_type = $row['type'];

// Check if the room number falls within the correct range for the room type
if (($room_type == 'twin' && $room_number >= 1 && $room_number <= 10) ||

    ($room_type == 'double' && $room_number >= 11 && $room_number <= 20) ||
    
    ($room_type == 'deluxe' && $room_number >= 21 && $room_number <= 30)) {
  // Update the room_number column in the bookings table for the specified booking id
  mysqli_query($db, "UPDATE bookings SET room_number = '$room_number' WHERE id = '$booking_id'");
  
  header("location: manageBookings.php");
} 

else {
  header("location: manageBookings.php?error=Invalid room number. Use: 1-10 - TWIN, 11-20 - DOUBLE, 21-30 - DELUXE. ");
}
?>
